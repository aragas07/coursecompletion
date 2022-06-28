param = {
    required => 1,
  };

  $self->_param_typed($param);

  $self->_param_opt_or_req(
    $self->_param_labeled($param)
      || $self->_param_named($param)
      || $self->_param_variable($param)
      || $self->_unpacked_param($param)
  ) or ($err_ctx == $self->ppi and return)
    or $self->error($err_ctx);

  $self->_param_default($param);
  $self->_param_constraint_or_traits($param);

  $param = $self->create_param($param);

  return !$class_meth
      ? $param
      : wantarray
      ? ($param, $self->remaining_input)
      : $param;
}

sub _param_opt_or_req {
  my ($self, $param) = @_;

  return unless $param;

  if ($self->ppi->class eq 'PPI::Token::Operator') {
    my $c = $self->ppi->content;
    if ($c eq '?') {
      $param->{required} = 0;
      $self->consume_token;
    } elsif ($c eq '!') {
      $param->{required} = 1;
      $self->consume_token;
    }
  }
  return $param;

}

sub _param_constraint_or_traits {
  my ($self, $param) = @_;

  while ($self->_param_where($param) ||
         $self->_param_traits($param) ) {
    # No op;

  }
  return $param;
}

sub _param_where {
  my ($self, $param) = @_;

  return unless $self->ppi->isa('PPI::Token::LexSymbol')
             && $self->ppi->lex eq 'WHERE';

  $self->consume_token;

  $param->{constraints} ||= [];

  my $ppi = $self->ppi;

  $self->error($ppi, "Block expected after where")
    unless $ppi->class eq 'PPI::Token::Structure'
        && $ppi->content eq '{';

  # Go from token to block
  $ppi = $ppi->parent;

  $ppi->finish or $self->error($ppi, 
    "Runaway '" . $ppi->braces . "' in " . $self->_parsing_area(1), 1);

  push @{$param->{constraints}}, $ppi->content;

  $self->_set_ppi($ppi->finish);
  $self->consume_token;
  return $param;
}

sub _param_traits {
  my ($self, $param) = @_;
  return unless $self->ppi->isa('PPI::Token::LexSymbol')
             && $self->ppi->lex eq 'TRAIT';

  my $op = $self->consume_token->content;

  $self->error($self->ppi, "Error parsing parameter trait")
    unless $self->ppi->isa('PPI::Token::Word');

  $param->{param_traits} ||= [];

  push @{$param->{param_traits}}, [$op, $self->consume_token->content];
  return $param;
}

sub _param_labeled {
  my ($self, $param) = @_;

  return unless 
    $self->ppi->content eq ':' &&
    $self->ppi->next_token->isa('PPI::Token::Word');

  $self->consume_token;

  $self->error($self->ppi, "Invalid label")
    if $self->ppi->content =~ /[^-\w]/;

  $param->{named} = 1;
  $param->{required} = 0;
  $param->{label} = $self->consume_token->content;

  $self->assert_token('(');
  $self->_unpacked_param($param) 
    || $self->_param_variable($param)
    || $self->error($self->ppi);

  $self->assert_token(')');

  return $param;
}

sub _unpacked_param {
  my ($self, $param) = @_;

  return $self->bracketed('[', \&unpacked_array, $param) ||
         $self->bracketed('{', \&unpacked_hash, $param);
}

sub _param_named {
  my ($self, $param) = @_;

  return unless
    $self->ppi->content eq ':' &&
    $self->ppi->next_token->isa('PPI::Token::Symbol');

  $param->{required} = 0;
  $param->{named} = 1;
  $self->consume_token;

  my $err_ctx = $self->ppi;
  $param = $self->_param_variable($param);

  $self->error($err_ctx, "Arrays or hashes cannot be named")
    if $param->{sigil} ne '$';

  return $param;
}

sub _param_typed {
  my ($self, $param) = @_;

  my $tc = $self->tc
    or return;


  $tc = $self->type_constraint_class->new(
    ppi  => $tc,
    ( $self->has_type_constraint_callback
      ? (tc_callback => $self->type_constraint_callback)
      : ()
    ),
    ( $self->has_from_namespace
      ? ( from_namespace => $self->from_namespace )
      : ()
    ),
  );
  $param->{type_constraints} = $tc;

  return $param;
}
 
sub _param_default {
  my ($self, $param) = @_;

  return unless $self->ppi->content eq '=';

  $self->consume_token;

  $param->{default_value} =
    $self->_consume_if_isa(qw/
      PPI::Token::QuoteLike
      PPI::Token::Number
      PPI::Token::Quote
      PPI::Token::Symbol
      PPI::Token::Magic
      PPI::Token::ArrayIndex
    /) ||
    $self->bracketed('[') ||
    $self->bracketed('{') 
  or $self->error($self->ppi);
    
  $param->{default_value} = $param->{default_value}->content;
}


sub _param_variable {
  my ($self, $param) = @_;

  my $ppi = $self->ppi;
  my $class = $ppi->class;
  return unless $class eq 'PPI::Token::Symbol'
             || $class eq 'PPI::Token::Cast';

  if ($class eq 'PPI::Token::Symbol') {
    $ppi->symbol_type eq $ppi->raw_type or $self->error($ppi);

    $param->{sigil} = $ppi->raw_type;
    $param->{variable_name} = $self->consume_token->content;
  } else {
    $param->{sigil} = $self->consume_token->content;
  }

  return $param;
}

sub unpacked_hash {
  my ($self, $list, $param) = @_;

  my $params = [];
  while ($self->ppi->content ne '}') {
    my $errctx = $self->ppi;
    my $p = $self->param
      or $self->error($self->ppi);

    $self->error($errctx, "Cannot have positional parameters in an unpacked-array")
      if $p->sigil eq '$' && PositionalParam->check($p);
    push @$params, $p;

    last if $self->ppi->content eq '}';
    $self->assert_token(',');
  }
  $param->{params} = $params;
  $param->{sigil} = '$';
  $param->{unpacking} = 'Hash';
  return $param;
}

sub unpacked_array {
  my ($self, $list, $param) = @_;

  my $params = [];
  while ($self->ppi->content ne ']') {
    my $watermark = $self->ppi;
    my $param = $self->param
      or $self->error($self->ppi);

    $self->error($watermark, "Cannot have named parameters in an unpacked-array")
      if NamedParam->check($param);

    $self->error($watermark, "Cannot have optional parameters in an unpacked-array")
      unless $param->required;

    push @$params, $param;

    last if $self->ppi->content eq ']';
    $self->assert_token(',');
  }
  $param->{params} = $params;
  $param->{sigil} = '$';
  $param->{unpacking} = 'Array';
  return $param;
}

sub tc {
  my ($self, $required) = @_;

  my $ident = $self->_ident;

  $ident or ($required and $self->error($self->ppi)) or return;

  return $self->_tc_union(
    $self->bracketed('[', \&_tc_params, $ident)
      || $ident->clone
  );
}

# Handle parameterized TCs. e.g.:
# ArrayRef[Str]
# Dict[Str => Str]
# Dict["foo bar", Baz]
sub _tc_params {
  my ($self, $list, $tc) = @_;

  my $new = PPI::Statement::Expression::TCParams->new($tc->clone);

  return $new if $self->ppi->content eq '