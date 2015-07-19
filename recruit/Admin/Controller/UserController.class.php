<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller {
    public function doLogin(){
        $identity = I("post.identity","");
        $map["username"] = I("post.username");
        $map["password"] = md5("spf".I("post.password"));
        switch ($identity) {
            case '1':
                $info = M("association_departments")->where($map)->find();
                if (!$info) {
                    $this->ajaxReturn(array("status" => 0, "info" => "用户名或密码错误"));
                }else{
                    unset($info["password"]);
                    session("identity","部门管理员");
                    session("departmentName",$info["departmentName"]);
                    session("associationName",$info["association"]);
                    $this->ajaxReturn(array("status" => 1, "data" => $info));
                }
                break;
            case '2':
                $info = M("association_list")->where($map)->find();
                if (!$info) {
                    $this->ajaxReturn(array("status" => 0, "info" => "用户名或密码错误"));
                }else{
                    unset($info["password"]);
                    session("identity","社团管理员");
                    session("associationName",$info["associationName"]);
                    $this->ajaxReturn(array("status" => 1, "data" => $info));
                }
                break;
            case '3':
                if ($map["username"] == "root" && $map["password"] == "e83e403a6ff7b6d4235d34d82edc896b") {
                    session("identity","超级管理员");
                    $this->ajaxReturn(array("status" => 1));
                }else{
                    $this->ajaxReturn(array("status" => 0, "info" => "用户名或密码错误"));
                }
            default:
                $this->ajaxReturn(array("status" => 0, "info" => "未选择身份"));
                break;
        }
    }
}