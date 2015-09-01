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
