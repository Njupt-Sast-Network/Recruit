<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SAST首页</title>

    <!-- Bootstrap -->
    <link href="../../../../public/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../../public/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="wrap">
      <div class="container" id="main">
      <!--logo图片-->
      <div class="logoImg">
      <img src="../../../../public/images/logo.png" class="img-responsive center-block">
    </div>
      <!--信息填写界面导航-->
      <ul class="nav nav-tabs" id="tab-list" role="tablist">
        <li role="presentation" class="active first">
          <a href="#sign-in" data-toggle="tab" role="tab" aria-expanded="true" ><span>登陆</span></a>
        </li>
        <li role="presentation">
          <a href="#sign-up" data-toggle="tab" role="tab" aria-expanded="true" ><span>注册</span></a>
        </li>
        <li role="presentation" id="forgetKeyWord">
          <a href="#" data-toggle="link"><span>忘记密码</span></a>
        </li>
      </ul>

      <!--信息填写界面面板-->
      <div class="tab-content">
        <!--登陆界面-->
        <div role="tabpannel" class="tab-pane active" id="sign-in">
          <form role="form">
            <div class="form-group">
              <input type="studentId" class="form-control" id="inputStudentId" placeholder="学号">
            </div>
            <div class="form-group">
              <input type="passWord" class="form-control" id="inputPassWord" placeholder="密码">
            </div>
          </form>
          <!--信息提交按钮-->
      <button type="button" class="btn btn-primary center-block" id="login">sign in</button>
        </div>
        <!--注册界面-->
        <div role="tabpannel" class="tab-pane" id="sign-up">
          <form role="form">
            <div class="form-group">
              <input type="studentId" class="form-control" id="inputStudentId" placeholder="学号">
            </div>
            <div class="form-group">
              <input type="passWord" class="form-control" id="inputName" placeholder="姓名">
            </div>
            <div class="form-group">
              <input type="passWord" class="form-control" id="inputPassWord" placeholder="密码">
            </div>
            <div class="form-group">
              <input type="passWord" class="form-control" id="confirmPassWord" placeholder="确认密码">
            </div>
            <div class="form-group" id="identifyingCode">
              <input type="passWord" class="form-control" id="inputIdentifyingCode" placeholder="验证码">
              <div>
              <img src="#" alt="验证码" title="看不清，换一张">
            </div>
            </div>
          </form>
          <!--信息提交按钮-->
      <button type="button" class="btn btn-primary center-block" id="reg">sign up</button>
        </div>
      </div>
    </div> <!-- /container -->
    </div>
    <div class="footer">
      <div class="container bottom">
      <p class="test-muted">&copy; 校科协</p>
    </div>
    </div>
    <script src="../../../../public/js/jquery-1.11.2.min.js"></script>
    <script src="../../../../public/js/bootstrap.min.js"></script>
    <!--<script src="js/ajax.js"></script>-->
    <script>
    $(document).ready(function(){
    $("#login").click(function(){
        $.ajax({  
                    type : "POST",  
                    url :"<?php echo U('Home/User/doLogin');?>",
                    success :function(){
                        alert('success1');
                    }
                });
    });
    $("#reg").click(function(){
        $.ajax({  
                    type : "POST",  
                    url :"<?php echo U('Home/User/doReg');?>",
                    success :function(){
                        alert('success2');
                    }
                });
    });
});                 
    </script>
  </body>
</html>