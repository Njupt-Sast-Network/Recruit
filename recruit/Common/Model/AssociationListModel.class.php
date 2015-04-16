<?php
/**
 * Created by PhpStorm.
 * User: Huangdie
 * Date: 2015/4/16
 * Time: 21:37
 */

namespace Common\Model;
use Think\Model;

class AssociationListModel extends Model {

    // 使用社团id返回社团名称
    public function getAssociationNameById($id) {
        $condition['id'] = $id;
        $result = $this->where($condition)->find();
        return $result['associationName'];
    }
}