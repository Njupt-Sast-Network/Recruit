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

    public function getQuestions($id) {
        $condition['id'] = $id;
        $result = $this->where($condition)->find();
        $questions = array();
        $k = 0;
        for($i = 1; $i <= 3; $i++) {
            if (isset($result['quest'.$i])) {
                $questions[$k] = $result['quest'.$i];
                $k++;
            }
        }
        return $questions;
    }
}