<?php
/**
 * Created by PhpStorm.
 * User: Huangdie
 * Date: 2015/4/16
 * Time: 19:29
 */
namespace Common\Model;
use Think\Model;
class StudentBasicInfoModel extends Model {

    // 按学号获取学生基本信息
    public function getStudentInfoByXh($xh) {
        $condition['xh'] = $xh;
        return $this->where($condition)->find();
    }

    // 修改学生密码
    public function setStudentPassword($xh, $password) {
        $condition['xh'] = $xh;
        $newPassword['password'] = md5('spf'.$password);
        return $this->where($condition)->save(newPassword);
    }

    // 更新学生基本信息
    public function updateStudentInfo($xh, $info) {
        $condition['xh'] = $xh;
        return $this->where($condition)->save($info);
    }

    // 添加学生
    public function addStudent($info) {
        $condition['xh'] = $info['xh'];
        if ($this->where($condition)->count() > 0) {
            return 'reged';
        }
        return $this->add($info);
    }
}