<?php
/**
 * Created by PhpStorm.
 * User: Huangdie
 * Date: 2015/4/19
 * Time: 19:18
 */

use Common\Model\StudentBasicInfoModel;

function getStuInfo()
{
    $xh = I('session.xh', '');
    if (!$xh) {
        header('Location: ' . U('Home/Index/login'));
        die();
    }
    $stuinfo = new StudentBasicInfoModel();
    return $stuinfo->getStudentInfoByXh($xh);
}

// 检测输入的验证码是否正确，$code为用户输入的验证码字符串
function checkVerifyCode($code, $id = '')
{
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}

function isAPIMode(){
	if(I('post.api_token') === $_ENV['api_token']){
		return true;
	}
	return false;
}

function doAPILogin(){
	$map["xh"] = I('post.api_xh', '');
	$studentinfo = M("student_basic_info")->where($map)->find();
	if ($studentinfo === null || password_verify(I('post.api_password'), $studentinfo['password']) === false) {
		$this->ajaxReturn(array("status" => 0, "info" => "用户名或密码错误"));
	} else {
		session_start();
		unset($studentinfo["password"]);
		session("xh", $studentinfo["xh"]); //登录成功后将学生学号、姓名写入session
		session("name", $studentinfo["name"]);
	}
}

function prepareForAPI(){
	if(isAPIMode()){
		doAPILogin();
	}
}