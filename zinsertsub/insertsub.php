<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/dist/img/dorsu.ico">
    <title>Insert alumni</title>
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../assets/dist/css/studstyle.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        
        <form action="insert.php" method="post" name="upload_excel" enctype="multipart/form-data">
            <div class="col-sm-12" style="border-bottom: 1px solid rgb(177,177,177)">
                <div style="width: 400px; margin:auto">
                    <div class="form-group row">
                        <label class="col-md-3 col-sm-label">Select File</label>
                        <div class="col-md-9">
                            <input type="file" name="file" accept=".csv" class="input-large">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label">Import data</label>
                        <div class="col-md-9">
                            <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" style="text-align: center">
                </div>
            </div>
        </form>
    </div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../assets/plugins/jquery/jquery.min.js"></script>
</body>
</html>