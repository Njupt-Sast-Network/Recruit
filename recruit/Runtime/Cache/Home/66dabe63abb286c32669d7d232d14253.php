<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SAST首页</title>

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
      <div class="container" id="main">
      <!--logo图片-->
      <div class="logoImg">
      <img src="/images/logo.png" class="img-responsive center-block">
    </div>
      <!--信息填写界面导航-->
      <ul class="nav nav-tabs" id="tab-list" role="tablist">
        <li role="presentation" class="first">
          <a href="login.html" data-toggle="link" role="tab" aria-expanded="true" ><span>登陆</span></a>                                             <!--链接到登陆页面-->
        </li>
        <li role="presentation" class="active">
          <a href="reg.html" data-toggle="link" role="tab" aria-expanded="true" ><span>注册</span></a>
        </li>
        <li role="presentation" id="forgetKeyWord">
          <a href="#" data-toggle="link"><span>忘记密码</span></a>
        </li>
      </ul>

      <!--信息填写界面面板-->
      <div class="tab-content">
        
        <!--注册界面-->
        <div role="tabpannel" class="tab-pane active" id="sign-up">
          <form role="form">
            <div class="form-group">
              <input type="studentId" class="form-control" id="inputStudentId1" placeholder="学号" name="false">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="inputName1" placeholder="姓名" name="false">
            </div>
            <div class="form-group">
              <input type="passWord" class="form-control" id="inputPassWord1" placeholder="密码" name="false">
            </div>
            <div class="form-group">
              <input type="passWord" class="form-control" id="confirmPassWord1" placeholder="确认密码" name="false">
            </div>
            <div class="form-group" id="identifyingCode1">
              <input type="passWord" class="form-control" id="inputIdentifyingCode1" placeholder="验证码">
              <div id="identifyingPicture">
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
    <script src="/js/jquery-1.11.2.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <!--<script src="../../../../public/js/ajax.js"></script>-->
    <script>
    
    $(document).ready(function(){
      //array of judgement
    $("#login").click(function(){
      if(($("#inputStudentId").attr("name")=="true")&&($("#inputPassWord").attr("name")=="true")){
        $.ajax({  
                    type : "POST",  
                    url :"<?php echo U('Home/User/doLogin');?>",//待改
                    success :function(){
                        console.log('success1');
                    }
                });
      } else {
        alert("请正确输入信息");
      }
    });
    $("#reg").click(function(){
        if(($("#inputStudentId1").attr("name")=="true")&&($("#inputName1").attr("name")=="true")&&($("#inputPassWord1").attr("name")=="true")&&($("#confirmPassWord1").attr("name")=="true")){
          $.ajax({  
                    type : "POST",  
                    url :"<?php echo U('Home/User/doReg');?>",//待改
                    success :function(){
                        console.log('success2');
                    }
                });
        } else {
          if($("#inputStudentId1").attr("name")=="false"){
            alert("请正确输入学号");
          } else if($("#inputName1").attr("name")=="false"){
            alert("请正确输入姓名，2-4个汉字");
          } else if($("#inputPassWord1").attr("name")=="false"){
            alert("请正确输入密码，以字母或数字开头，长度在6-18之间，只能包含字符、数字和下划线。");
          } else {
            alert("两次输入密码不一致");
          }
        }
    });
     
//is input property id(login)
    $("#inputStudentId").blur(function(){
    var id = /^[BQ]+[0-9]{8}$/;
    if(!id.test($("#inputStudentId").val())){
        $("#inputStudentId").css("border-color","#8B0000");
        $("#inputStudentId").attr("name","false");
    } else {
        $("#inputStudentId").css("border-color","#66afe9");
        $("#inputStudentId").attr("name","true");
    }
});    
//is input property password(login)
    $("#inputPassWord").blur(function(){
    if($("#inputPassWord").val().length == 0){
        $("#inputPassWord").css("border-color","#8B0000");
        $("#inputPassWord").attr("name","false");
    } else {
        $("#inputPassWord").css("border-color","#66afe9");
        $("#inputPassWord").attr("name","true");
    }
}); 
//is input property id(reg)
$("#inputStudentId1").blur(function(){
  var id = /^[BQ]+[0-9]{8}$/;
    if(!id.test($("#inputStudentId1").val())){
        $("#inputStudentId1").css("border-color","#8B0000");
        $("#inputStudentId1").attr("name","false");
    } else {
        $("#inputStudentId1").css("border-color","#66afe9");
        $("#inputStudentId1").attr("name","true");
    }
});
//is input property name(reg)                             
$("#inputName1").blur(function(){
  if(!$("#inputName1").val()){
  $("#inputName1").attr("placeholder","姓名");
}
  var id = /[\u4e00-\u9fa5]{2,4}/;
    if(!id.test($("#inputName1").val())){
        $("#inputName1").css("border-color","#8B0000");
        $("#inputName1").attr("name","false");
    } else {
        $("#inputName1").css("border-color","#66afe9");
        $("#inputName1").attr("name","true");
    }
});
//is input property password(reg)
$("#inputPassWord1").blur(function(){
  if(!$("#inputPassWord1").val()){
  $("#inputPassWord1").attr("placeholder","密码");
}
  var id = /^[a-zA-Z0-9]\w{5,17}$/;
    if(!id.test($("#inputPassWord1").val())){
        $("#inputPassWord1").css("border-color","#8B0000");
        $("#inputPassWord1").attr("name","false");
    } else {
        $("#inputPassWord1").css("border-color","#66afe9");
        $("#inputPassWord1").attr("name","true");
    }
});
//is input property password again(reg)
$("#confirmPassWord1").blur(function(){
  var id = /^[a-zA-Z0-9]\w{5,17}$/;
    if(($("#inputPassWord1").val()==$("#confirmPassWord1").val())&&(id.test($("#inputPassWord1").val()))){
        $("#confirmPassWord1").css("border-color","#66afe9");
        $("#confirmPassWord1").attr("name","true");
    } else {
        $("#confirmPassWord1").css("border-color","#8B0000");
        $("#confirmPassWord1").attr("name","false");
    }
});
// prompt about name
$("#inputName1").focus(function(){
  $("#inputName1").attr("placeholder","2-4位汉字");
});
$("#inputPassWord1").focus(function(){
  $("#inputPassWord1").attr("placeholder","6-18位、字母或数字开头");
});


});
    </script>
  </body>
</html>