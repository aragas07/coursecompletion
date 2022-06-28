$(function(){
    var sfyfs = [], pfyfs = [],
    sfyss = [], pfyss = [],
    ssyfs = [], psyfs = [],
    ssyss = [], psyss = [],
    styfs = [], ptyfs = [],
    styss = [], ptyss = [],
    sfoyfs = [], pfoyfs = [],
    sfoyss = [], pfoyss = [],
    sfiyfs = [], pfiyfs = [],
    sfiyss = [], pfiyss = [];
    $("#fyfs").change(function(){
        shortcut('dfyfs','sfyfs','pfyfs','fyfs',sfyfs,pfyfs,$(this).val());
    })
    $("#fyss").change(function(){
        shortcut('dfyss','sfyss','pfyss','fyss',sfyss,pfyss,$(this).val());
    })
    $("#syfs").change(function(){
        shortcut('dsyfs','ssyfs','psyfs','syfs',ssyfs,psyfs,$(this).val());
    })
    $("#syss").change(function(){
        shortcut('dsyss','ssyss','psyss','syss',ssyss,psyss,$(this).val());
    })
    $("#tyfs").change(function(){
        shortcut('dtyfs','styfs','ptyfs','tyfs',styfs,ptyfs,$(this).val());
    })
    $("#tyss").change(function(){
        shortcut('dtyss','styss','ptyss','tyss',styss,ptyss,$(this).val());
    })
    $("#foyfs").change(function(){
        shortcut('dfoyfs','sfoyfs','pfoyfs','foyfs',sfoyfs,pfoyfs,$(this).val());
    })
    $("#foyss").change(function(){
        shortcut('dfoyss','sfoyss','pfoyss','foyss',sfoyss,pfoyss,$(this).val());
    })
    $("#fiyfs").change(function(){
        shortcut('dfiyfs','sfiyfs','pfiyfs','fiyfs',sfiyfs,pfiyfs,$(this).val());
    })
    $("#fiyss").change(function(){
        shortcut('dfiyss','sfiyss','pfiyss','fiyss',sfiyss,pfiyss,$(this).val());
    })

    var b=true;

    $("#submit").click(function(){
        var sfyfs = document.getElementsByClassName("sfyfs"),
        sfyss = document.getElementsByClassName("sfyss"),
        ssyfs = document.getElementsByClassName("ssyfs"),
        ssyss = document.getElementsByClassName("ssyss"),
        styfs = document.getElementsByClassName("styfs"),
        styss = document.getElementsByClassName("styss"),
        sfoyfs = document.getElementsByClassName("sfoyfs"),
        sfoyss = document.getElementsByClassName("sfoyss"),
        sfiyfs = document.getElementsByClassName("sfiyfs"),
        sfiyss = document.getElementsByClassName("sfiyss"),
        pfyfs = document.getElementsByClassName("pfyfs"),
        pfyss = document.getElementsByClassName("pfyss"),
        psyfs = document.getElementsByClassName("psyfs"),
        psyss = document.getElementsByClassName("psyss"),
        ptyfs = document.getElementsByClassName("ptyfs"),
        ptyss = document.getElementsByClassName("ptyss"),
        pfoyfs = document.getElementsByClassName("pfoyfs"),
        pfoyss = document.getElementsByClassName("pfoyss"),
        pfiyfs = document.getElementsByClassName("pfiyfs"),
        pfiyss = document.getElementsByClassName("pfiyss");
        for(var i = 0; i < sfyfs.length ;i++){
            submitCur(sfyfs[i].value,pfyfs[i].value,1,1);
        }
        for(var i = 0; i < sfyss.length ;i++){
            submitCur(sfyss[i].value,pfyss[i].value,1,2);
        }
        for(var i = 0; i < ssyfs.length ;i++){
            submitCur(ssyfs[i].value,psyfs[i].value,2,1);
        }
        for(var i = 0; i < ssyss.length ;i++){
            submitCur(ssyss[i].value,psyss[i].value,2,2);
        }
        for(var i = 0; i < styfs.length ;i++){
            submitCur(styfs[i].value,ptyfs[i].value,3,1);
        }
        for(var i = 0; i < styss.length ;i++){
            submitCur(styss[i].value,ptyss[i].value,3,2);
        }
        for(var i = 0; i < sfoyfs.length ;i++){
            submitCur(sfoyfs[i].value,pfoyfs[i].value,4,1);
        }
        for(var i = 0; i < sfoyss.length ;i++){
            submitCur(sfoyss[i].value,pfoyss[i].value,4,2);
        }
        for(var i = 0; i < sfiyfs.length ;i++){
            submitCur(sfiyfs[i].value,pfiyfs[i].value,5,1);
        }
        for(var i = 0; i < sfiyss.length ;i++){
            submitCur(sfiyss[i].value,pfiyss[i].value,5,2);
        }
        if(b) toastr.success("Curriculum successfully created!");
        else toastr.error("Sorry the curriculum you create are cracked");
        setTimeout(function(){
            location.href = "curnum.php?course="+$("#course").val();
        }, 1000);
    })

    loadCourse($("#course").val()); 

    function loadCourse(id){
        $.ajax({
            url: 'containers/query.php',
            type: 'post',
            data: {getcurnum: id},
            success: function(result){
                $("#coursenum").val(result);
            }
        })
    }

    function submitCur(subject,pre,year,sem){
        $.ajax({
            url: 'containers/query.php',
            type: 'post',
            data: {subject: subject, prere: pre, courseid: $("#course").val(), year: year, sem: sem, num:  $("#coursenum").val()},
            success: function(result){
                if(result == 'error') b=false;
            }
        })
    }
    function loadsubject(id){
        $.ajax({
            url: 'containers/query.php',
            type: 'post',
            data: {loadsubject: 'true'},
            success: function(result){
                $("."+id).empty().append(result);
            }
        })
    }
    function loadpre(id){
        $.ajax({
            url: 'containers/query.php',
            type: 'post',
            data: {getPre: 'true'},
            success: function(result){
                $("."+id).empty().append(result);
            }
        })
    }
    function reload(s,p,ys,subArray,preArray){
        $("."+s).each(function(index){
            $(this).change(function(){
                subArray[index] = $(this).val();
            }) 
        })
        $("."+p).each(function(index){
            $(this).change(function(){
                preArray[index] = $(this).val();
            }) 
        })

        setTimeout(function(){
            for(var i = 0; i < $("#"+ys).val() ;i++){
                if(subArray[i] == null) $("."+s).eq(i).val(0);
                else $("."+s).eq(i).val(subArray[i]);
                if(preArray[i] == null) $("."+p).eq(i).val(0);
                else $("."+p).eq(i).val(preArray[i]);
            }
        },100);
    }
    function loadElement(s,p){
        return '<div class="row mb-1"><div class="col-sm-9">'+
        '<select class="form-control '+s+' col-form-label"></select>'+
        '</div>'+
        '<div class="col-sm-3">'+
        '<select class="form-control '+p+' col-form-label"></select>'+
        '</div></div>';
    }
    function shortcut(d,s,p,f,sarr,parr,num){
        $("#"+d).empty();
        for($i = 0; $i < num ;$i++){
            $("#"+d).append(loadElement(s,p));
        }
        loadsubject(s);
        loadpre(p);
        reload(s,p,f,sarr,parr);
    }
})