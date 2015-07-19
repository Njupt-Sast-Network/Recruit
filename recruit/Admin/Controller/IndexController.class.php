<?php
namespace Admin\Controller;
use Common\Model\StudentBasicInfoModel;
use Think\Controller;
class IndexController extends Controller {
    public function index() {
        $this->display();
    }
    public function comctrl(){
        $data["identity"] = I("session.identity","");
        switch ($data["identity"]) {
            case '部门管理员':
                $associations[0]["associationName"] = I("session.associationName","");
                $map["departmentName"] = I("session.departmentName","");
                $departments[0] = M("association_departments")->where($map)->field("id,departmentName")->find();
                $nowassociation = $associations[0]["associationName"];
                $nowdepartment = $departments[0]["id"];
                break;
            case '社团管理员':
                $associations[0]["associationName"] = I("session.associationName","");
                $map["association"] = I("session.associationName","");
                $departments = M("association_departments")->where($map)->field("id,departmentName,association")->select();
                $nowassociation = $associations[0]["associationName"];
                $nowdepartment = $departments[0]["id"];
                foreach ($departments as $de) {
                    if ($de["id"] == I("get.nowdepartment")) {
                        $nowdepartment = $de["id"];
                        break;
                    }
                }
                break;
            case '超级管理员':
                $associations = M("association_list")->field("associationName")->select();
                $departments = M("association_departments")->where($map)->field("id,departmentName,association")->select();
                $nowassociation = I("get.nowassociation","") ? I("get.nowassociation","") : $associations[0]["associationname"];
                $nowdepartment = I("get.nowdepartment","") ? I("get.nowdepartment","") : $departments[0]["id"];
                break;
            default:
                redirect("index");
                break;
        }
        $map["association"] = $nowassociation;
        $alldepartment = M("association_departments")->where($map)->field("id,departmentName")->select();
        $this->assign("nowassociation",$nowassociation);
        $this->assign("nowdepartment",$nowdepartment);
        $this->assign("identity",$data["identity"]);
        $this->assign("associations",$associations);
        $this->assign("departments",$departments);
        $this->assign("alldepartment",$alldepartment);
    	$this->display();
    }
    public function recuritlist(){
    	$this->display();
    }
}