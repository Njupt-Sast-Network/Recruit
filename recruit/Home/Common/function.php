<?php
/**
 * Created by PhpStorm.
 * User: Huangdie
 * Date: 2015/4/19
 * Time: 19:18
 */

use Common\Model\StudentBasicInfoModel;

function getStuInfo() {
    $xh = I('session.xh', '');
    if (!$xh) {
        header('Location: /login');
        die();
    }
    $stuinfo = new StudentBasicInfoModel();
    return $stuinfo->getStudentInfoByXh($xh);
}