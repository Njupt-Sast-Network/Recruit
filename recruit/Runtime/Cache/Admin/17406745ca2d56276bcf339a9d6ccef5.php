<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>新生录取</title>
    
  <style type="text/css">
    .btn2-margin{
        margin-left: -4px;
    }
    .container{
        margin-bottom: 20px;
        width: 100%!important;
    }
    .container .btn{
        float: right;margin-left: 10px;
    }
    .container .btn.btn-primary{
        float: left;
    }
    .table tr td{
            vertical-align: center;
    }
  </style>
<link rel="stylesheet" href="/css/bootstrap.min.css">

<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="/js/jquery-1.11.2.min.js"></script>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/comcss.css">
</head>
<body>
    <div class="div1">
        <h2>欢迎登录 <br>
        <span style="">njupt招新管理系统</span>
        </h2>
        <h5>您当前的身份为：<?php echo ($identity); ?></h5>
        <div>
            社团列表
            <select class="form-control" id="nowass">
                <?php if(is_array($associations)): $i = 0; $__LIST__ = $associations;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$as): $mod = ($i % 2 );++$i;?><option value="<?php echo ($as["associationname"]); ?>" <?php if ($as["associationname"] == $nowassociation) { echo "selected=selected"; } ?>><?php echo ($as["associationname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
        <div>
            部门列表
            <select class="form-control" id="nowdep">
                <?php if(is_array($departments)): $i = 0; $__LIST__ = $departments;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$de): $mod = ($i % 2 );++$i;?><option value="<?php echo ($de["id"]); ?>" association="<?php echo ($de["association"]); ?>"<?php if ($de["id"] == $nowdepartment) { echo "selected=selected"; } ?>><?php echo ($de["departmentname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="div2">
        <div class="container">
            <button type="button" class="btn btn-primary active">报名信息</button>
            <button type="button" class="btn btn-primary">管理社团</button>
            <button type="button" class="btn btn-primary">修改密码</button>
            <button type="button" class="btn btn-success">生成XLS</button>
            <button type="button" class="btn btn-danger">结束部门招新</button>
        </div>
        <form class="form-inline" >
            <div class="form-group">
                <label for="xuehao">学号</label>
                <input type="text" class="form-control" id="xuehao" placeholder=""  style="max-width:100px">
            </div>
            <div class="form-group">
                 <label for="name">姓名</label>
                 <input type="text" class="form-control" id="name" placeholder=""  style="max-width:100px"> 
            </div>
            <div class="form-group" style="margin-left:15px">
            <label for="firstvolunteer">第一志愿</label>
                <select class="form-control">
                      <option>请选择...</option>
                      <?php if(is_array($alldepartment)): $i = 0; $__LIST__ = $alldepartment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vap): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vap["id"]); ?>"><?php echo ($vap["departmentname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
            <div class="form-group" style="margin-left:20px">
                <label for="secondvolunteer">第二志愿</label>
                <select class="form-control">
                          <option>请选择...</option>
                          <?php if(is_array($alldepartment)): $i = 0; $__LIST__ = $alldepartment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vap): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vap["id"]); ?>"><?php echo ($vap["departmentname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
            <div class="form-group" style="margin-left:20px">
                <label for="state">录取状态</label>
                <select class="form-control">
                        <option>请选择...</option>
                        <option value="0">审核中</option>
                        <option value="-1">被第一部门拒绝</option>
                        <option value="-2">被第二部门拒绝</option>
                        <?php if(is_array($alldepartment)): $i = 0; $__LIST__ = $alldepartment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vap): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vap["departmentname"]); ?>"><?php echo ($vap["departmentname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
            <div class="form-group" style="margin-left:20px">
                <button id="shaixuan" class="btn btn-primary">筛选</button>
            </div>
        </form>
        
        <iframe src="/index.php/Admin/Index/recuritlist" id="recuritlist"  width="1000" align="center" height="200" name="win" onload="Javascript:SetWinHeight(this)" frameborder="0" scrolling="no" ></iframe>

    
    
             
    </div>
    <script type="text/javascript">
        $(document).on("change","#nowass,#nowdep",function(){
            var nowass = $("#nowass").val();
            var nowdep = $("#nowdep").val();
            location.href = "/index.php/Admin/Index/comctrl?nowassociation="+nowass+"&nowdepartment="+nowdep;
        });

        function SetWinHeight(obj) { 
            var ifm= document.getElementById("recuritlist");

        var subWeb = document.frames ? document.frames["recuritlist"].document : ifm.contentDocument;

            if(ifm != null && subWeb != null) {

            ifm.height = subWeb.body.scrollHeight;

            }
        } 

    </script>
</body>
</html>