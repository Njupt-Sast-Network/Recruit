<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>修改信息</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="wrap">
      <!-- 导航栏 -->
      <nav class="navbar navbar-default navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <span class="navbar-brand">个人中心</span>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav second-nav">
        <li class="nav-contain"><a href="http://localhost/index.php/Home/Index/changeDepartment">申请报名</a></li>
        <li class="nav-contain active"><a href="http://localhost/index.php/Home/Index/changeInfo">修改信息</a></li>
        <li class="nav-contain"><a href="http://localhost/index.php/Home/Index/changePassword">修改密码</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

      <div class="container" id="main">
      
      <!--信息填写界面面板-->
      <div class="tab-content">
        <!-- 信息填写表单 -->
        <form class="form-horizontal">
            <div class="form-group">
                <label for="inputSex" class="col-sm-2 control-label">性别</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="" id="inputSex">
                </div>
            </div>
            <div class="form-group">
                <label for="inputBirth" class="col-sm-2 control-label">生日</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputBirth" placeholder="">
                    </div>
            </div>
            <div class="form-group">
                <label for="inputQQ" class="col-sm-2 control-label">QQ</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputQQ" placeholder="">
                    </div>
            </div>
            <div class="form-group">
                <label for="inputEmail" class="col-sm-2 control-label">邮箱</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputEmail" placeholder="">
                    </div>
            </div>
            <div class="form-group">
                <label for="inputTel" class="col-sm-2 control-label">电话</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputTel" placeholder="">
                    </div>
            </div>
            <div class="form-group">
                <label for="inputDorm" class="col-sm-2 control-label">宿舍</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputDorm" placeholder="">
                    </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" id="changeInfo">提交</button>
                </div>
            </div>
        </form>

      </div>
    </div> <!-- /container -->
    </div>
    <div class="footer">
      <div class="container bottom">
      <p class="test-muted">&copy; 校科协</p>
    </div>
    </div>
    <script src="/js/jquery-1.11.2.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <!--<script src="../../../../public/js/ajax.js"></script>-->
    <script>
        $(document).ready(function(){
          check();
          $("changeInfo").click(function(){
            //if()
          });
        });

        function check(){
          $("#inputSex").focus(function(){
            $("#inputSex").attr('placeholder','请输入性别');
          });
          $("#inputSex").blur(function(){
            if($("#inputSex").attr('placeholder') == '请输入性别'){
              $("#inputSex").attr('placeholder','');
            }
          });
          $("#inputBirth").focus(function(){
            $("#inputBirth").attr('placeholder','例如：1970-01-01');
          });
          $("#inputBirth").blur(function(){
            if($("#inputBirth").attr('placeholder') == '例如：1970-01-01'){
              $("#inputBirth").attr('placeholder','');
            }
          });
          $("#inputQQ").focus(function(){
            $("#inputQQ").attr('placeholder','请输入QQ号');
          });
          $("#inputQQ").blur(function(){
            if($("#inputQQ").attr('placeholder') == '请输入QQ号'){
              $("#inputQQ").attr('placeholder','');
            }
          });
          $("#inputEmail").focus(function(){
            $("#inputEmail").attr('placeholder','请输入邮箱');
          });
          $("#inputEmail").blur(function(){
            if($("#inputEmail").attr('placeholder') == '请输入邮箱'){
              $("#inputEmail").attr('placeholder','');
            }
          });
          $("#inputTel").focus(function(){
            $("#inputTel").attr('placeholder','请输入手机号');
          });
          $("#inputTel").blur(function(){
            if($("#inputTel").attr('placeholder') == '请输入手机号'){
              $("#inputTel").attr('placeholder','');
            }
          });
          $("#inputDorm").focus(function(){
            $("#inputDorm").attr('placeholder','例如：27#506-3');
          });
          $("#inputDorm").blur(function(){
            if($("#inputDorm").attr('placeholder') == '例如：27#506-3'){
              $("#inputDorm").attr('placeholder','');
            }
          });
        }

        function ajax(){
          var sex = $("#inputSex").val(),birth = $("#inputBirth").val(),QQ = $("#inputQQ").val(),
              Email = $("#inputEmail").val(),TEL = $("#inputTel").val(),dorm = $("#inputDorm").val();
          $.ajax({
            type : "POST",
            data : {
              "sex" : sex,
              "birth" : birth,
              "QQ" : QQ,
              "Email" : Email,
              "TEL" : TEL,
              "dorm" : dorm
            },
            url : "<?php echo U('Home/User/doChangeInfo');?>",
            dataType : "json",
            success : function(back){
              if(back.status == 1){
                location.reload();
              } else {
                alert(back.info);
              }
            },
            error : function(){
              alert("异常");
            }
          });
        }
    </script>
  </body>
</html>