<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>报名信息列表</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <script src="/js/jquery-1.11.2.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/comcss.css">
</head>
<body style="background-color: antiquewhite;">
    <table class="table table-hover table-bordered " style="margin-top:20px;">
        <thead>
            <tr>
            <!--奇葩用法，谨慎测试-->
              <th style="width:15%">学号</th>
              <th>姓名</th>
              <th>第一志愿</th>
              <th>第二志愿</th>
              <th>录取状态</th>
              <th>操作</th>
            </tr>
        </thead>
       <tbody>
       <tr>
            <td>B14090304</td>
            <td>孙爽</td>
            <td>办公室</td>
            <td>社团发展部</td>
            <td>审核中</td>
            <td>
                <button type="button" class="btn  btn-sm" >
                    录取
                </button> 
                <button type="button" class="btn  btn-primary btn-sm btn2-margin " >
                    信息
                </button> 
                 <button type="button" class="btn  btn-sm  btn2-margin">
                    拒绝
                </button>
            </td>
            </tr>

            <tr>
            <td>B14090304</td>
            <td>孙爽</td>
            <td>办公室</td>
            <td>社团发展部</td>
            <td>审核中</td>
            <td>
                <button type="button" class="btn  btn-sm" >
                    录取
                </button> 
                <button type="button" class="btn  btn-primary btn-sm btn2-margin " >
                    信息
                </button> 
                 <button type="button" class="btn  btn-sm  btn2-margin">
                    拒绝
                </button>
            </td>
            </tr>

            
            <tr>
            <td>B14090304</td>
            <td>孙爽</td>
            <td>办公室</td>
            <td>社团发展部</td>
            <td>审核中</td>
            <td>
                <button type="button" class="btn  btn-sm" >
                    录取
                </button> 
                <button type="button" class="btn  btn-primary btn-sm btn2-margin " >
                    信息
                </button> 
                 <button type="button" class="btn  btn-sm  btn2-margin">
                    拒绝
                </button>
            </td>
            </tr>

        </tbody>
    </table>

    <p> 共计 700个</p>
        <p>每页显示 <input type="text" class="" id="" placeholder=""  style="max-width:40px"> 当前页   <button type="button" class="btn btn-primary btn-sm" >—</button>  <input type="text" class="" id="" placeholder=""  style="max-width:40px">           /<span>70</span>
                            <button type="button" class="btn btn-primary btn-sm">+</button> </p>
</body>
</html>