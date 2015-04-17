<?php
/**
 * Created by PhpStorm.
 * User: Huangdie
 * Date: 2015/4/16
 * Time: 21:40
 */

namespace Common\Model;
use Think\Model;

class AssociationDepartmentsModel extends Model {

    // 使用部门id和社团id返回部门名称
    public function getDepartmentNameByDepartmentId($id, $association) {
        $condition['departmentId'] = $id;
        $condition['association'] = $association;
        $result = $this->where($condition)->find();
        return $result['departmentName'];
    }

    // 添加部门(管理员)
    // departmentInfo中包含用户信息
    // 管理员是departmentId为0的用户
    public function addDepartment($departmentInfo) {
        $association = $_SESSION['association'];
        $department = $_SESSION['department'];
        if (!$association || $department != 0) {
            return 'access forbidden';
        }
        $condition['username'] = $departmentInfo['username'];
        $result = $this->where($condition)->count();
        if ($result > 0) {
            return 'user exist';
        }
        return $this->add($departmentInfo);
    }
}