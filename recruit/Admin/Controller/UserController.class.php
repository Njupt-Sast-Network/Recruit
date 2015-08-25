<?php
namespace Admin\Controller;

use Think\Controller;

class UserController extends Controller
{
    public function doLogin()
    {
        $identity = I("post.identity", "");
        $map["username"] = I("post.username");
        // $map["password"] = md5("spf" . I("post.password"));
        switch ($identity) {
            case '1': //部门管理员
                $info = M("association_departments")->where($map)->find();
                if ($info === null || password_verify(I('post.password'), $info['password']) === false) {
                    $this->ajaxReturn(array("status" => 0, "info" => "用户名或密码错误"));
                } else {
                    unset($info["password"]);
                    session("identity", "部门管理员");
                    session("departmentName", $info["departmentName"]);
                    session("associationName", $info["association"]);
                    $this->ajaxReturn(array("status" => 1, "data" => $info));
                }
                break;
            case '2': //社团管理员
                $info = M("association_list")->where($map)->find();
                if ($info === null || password_verify(I('post.password'), $info['password']) === false) {
                    $this->ajaxReturn(array("status" => 0, "info" => "用户名或密码错误"));
                } else {
                    unset($info["password"]);
                    session("identity", "社团管理员");
                    session("associationName", $info["associationName"]); //数据库里取出来的数据的字段名默认是全小写的，屡屡被坑  by sdygt
                    $this->ajaxReturn(array("status" => 1, "data" => $info));
                }
                break;
            case '3': //超级管理员
                if ($map["username"] == "root" && password_verify(I('post.password'),'$2y$09$ldE9qs0cjIAoDc1DPUuql.lG2HOEmY8C5fQvr.IakODCwT6cvFPaC')) {
                    session("identity", "超级管理员");
                    $this->ajaxReturn(array("status" => 1));
                } else {
                    $this->ajaxReturn(array("status" => 0, "info" => "用户名或密码错误"));
                }
            default:
                $this->ajaxReturn(array("status" => 0, "info" => "未选择身份"));
                break;
        }
    }
}
