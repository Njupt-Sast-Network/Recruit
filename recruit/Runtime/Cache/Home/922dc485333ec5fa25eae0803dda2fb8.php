<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>修改密码</title>

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
        <li class="nav-contain"><a href="http://localhost/index.php/Home/Index/changeInfo1">修改信息</a></li>
        <li class="nav-contain"><a href="http://localhost/index.php/Home/Index/changeDepartment">申请报名</a></li>
        <li class="nav-contain active"><a href="http://localhost/index.php/Home/Index/changePassword">修改密码</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

      <div class="container" id="main">
      
      <!--信息填写界面面板-->
      <div class="tab-content">
        <!-- 信息填写表单 -->
        <form>
            <div class="form-group">
                <label for="prepassword">原密码</label>
                <input type="password" class="form-control" id="prepassword" name="false">
            </div>
            <div class="form-group">
                <label for="newpassword">新密码</label>
                <input type="password" class="form-control" id="newpassword" name="false">
            </div>
            <div class="form-group">
                <label for="confirmpassword">确认密码</label>
                <input type="password" class="form-control" id="confirmpassword" name="false">
            </div>
            <button type="button" class="btn btn-default changepasswordbtn" id="changepassword">提交</button>
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
      //array of judgement
    $("#changepassword").click(function(){
        if(($("#prepassword").attr("name")=="true")&&($("#newpassword").attr("name")=="true")&&($("#confirmpassword").attr("name")=="true")){
          $.ajax({  
                    type : "POST",  
                    url :"<?php echo U('Home/User/doChangeDepartment');?>",
                    data:{
                      "prepassword":prepassword,
                      "newpassword":newpassword,
                      "confirmpassword":confirmpassword
                    },
                    success :function(back){
                        if(back.status == 1) {
                          location.reload();
                        } else {
                          alert(back.info);
                        }
                    },
                    error : function(){
                      console.log("异常");
                    }
                });
        } else {
          if($("#prepassword").attr("name")=="false"){
            alert("请正确输入原密码");
          } else if($("#newpassword").attr("name")=="false"){
            alert("请正确输入密码");
          } else if($("#confirmpassword").attr("name")=="false"){
            alert("密码格式不正确或两次密码不一致");
          }
        }
    });
       
//is input property password(prepassword)
    $("#prepassword").blur(function(){
    if($("#prepassword").val().length == 0){
        $("#prepassword").css("border-color","#8B0000");
        $("#prepassword").attr("name","false");
    } else {
        $("#prepassword").css("border-color","#66afe9");
        $("#prepassword").attr("name","true");
    }
}); 

//is input property password(newpassword)
$("#newpassword").focus(function(){
  $("#newpassword").attr("placeholder","6-18位、字母或数字开头");
});
$("#newpassword").blur(function(){
  if(!$("#newpassword").val()){
  $("#newpassword").attr("placeholder","6-18位、字母或数字开头");
}
  var id = /^[a-zA-Z0-9]\w{5,17}$/;
    if(!id.test($("#newpassword").val())){
        $("#newpassword").css("border-color","#8B0000");
        $("#newpassword").attr("name","false");
    } else {
        $("#newpassword").css("border-color","#66afe9");
        $("#newpassword").attr("name","true");
    }
});
//is input property password again(confirmpassword)
$("#confirmpassword").focus(function(){
  $("#confirmpassword").attr("placeholder","请再次输入密码");
});
$("#confirmpassword").blur(function(){
  var id = /^[a-zA-Z0-9]\w{5,17}$/;
    if(($("#newpassword").val()==$("#confirmpassword").val())&&(id.test($("#newpassword").val()))){
        $("#confirmpassword").css("border-color","#66afe9");
        $("#confirmpassword").attr("name","true");
    } else {
        $("#confirmpassword").css("border-color","#8B0000");
        $("#confirmpassword").attr("name","false");
    }
});

});
    </script>
  </body>
</html>