<?php
/**
 * Created by PhpStorm.
 * User: Huangdie
 * Date: 2015/4/16
 * Time: 20:07
 */

namespace Common\Model;
use Think\Model;

class StudentRecruitInfo extends Model{

    // 返回指定学号的学生报名、录取状况
    public function getStudentRecruitState($condition) {
        return $this->where($condition)->find();
    }

    // 返回学生是否可以被用户录取(社团部门用户)
    public function isStudentAcceptAble($xh) {
        $condition['xh'] = $xh;
        $condition['association'] = $_SESSION['association'];
        $thisDepartment = $_SESSION['department'];
        $result = $this->where($condition)->find();
        if (!$result) {
            return false;
        }
        if ($result['acceptState'] > 0) {
            return false;
        }
        if ($result['department1'] == $thisDepartment || ($result['acceptState'] < 0 && $result['department2'] == $thisDepartment)) {
            return true;
        }
        return false;
    }

    // 录取学生(社团部门用户)
    public function acceptStudent($xh) {
        if ($this->isStudentAcceptAble($xh)) {
            $condition['xh'] = $xh;
            $data['acceptState'] = $_SESSION['department'];
            $this->where($condition)->save($data);
        } else {
            return false;
        }
    }

    // 录取学生(root)
    public function acceptStudentRoot($xh, $association, $department) {
        if ($_SESSION['association'] != 0) {
            return false;
        }
        $condition['xh'] = $xh;
        $condition['association'] = $association;
        $data['department'] = $department;
        return $this->where($condition)->save($data);
    }

    // 录取学生(社团管理员)
    public function acceptStudentManager($xh, $department) {
        if ($_SESSION['department'] != 0) {
            return false;
        }
        $condition['xh'] = $xh;
        $condition['association'] = $_SESSION['association'];
        $data['acceptState'] = $department;
        return $this->where($condition)->save($data);
    }

    // 返回学生是否报名了某个社团
    public function studentRegistered($xh, $association) {
        $condition['xh'] = $xh;
        $condition['association'] = $association;
        return $this->where($condition)->count();
    }

    // 学生报名
    public function studentRegisterAssociation($xh, $registrationInfo) {
        if (!$this->studentRegistered($xh, $registrationInfo['association'])) {
            return $this->add($registrationInfo);
        } else {
            return false;
        }
    }

    // 学生修改报名志愿部门
    // changed中包含department1和department2
    public function studentChangeDepartment($xh, $changed, $association) {
        $condition['xh'] = $xh;
        $condition['association'] = $association;
        $theStudent = $this->getStudentRecruitState($condition);
        if (!$theStudent) {
            return 'no reg info';
        }
        if ($theStudent['acceptState'] > 0) {
            return 'already accepted';
        }
        return $this->where($condition)->save($changed);
    }
}