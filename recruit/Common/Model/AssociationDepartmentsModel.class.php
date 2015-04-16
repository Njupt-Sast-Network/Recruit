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
}