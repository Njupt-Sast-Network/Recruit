<?php
namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $this->display();
    }
    public function comctrl()
    {
        $data["identity"] = I("session.identity", "");
        switch ($data["identity"]) {
            case '部门管理员':
                $associations[0]["associationName"] = I("session.associationName", ""); // 首先有个associatitons和departments，这两个东西存的是当前身份下能够操作的社团（们）和部门（们）
                $map["departmentName"] = I("session.departmentName", "");
                $departments[0] = M("association_departments")->where($map)->field("id,departmentName")->find(); //这两个东西来产生页面上左边的那两个下拉框，给用户选择变成哪些身份的权利
                $nowassociation = $associations[0]["associationName"];
                $nowdepartment = $departments[0]["id"]; //同样的，部门管理员权限最小，只能操作当前社团的当前部门，所以完全不管get过来什么，当前部门都是这个部门
                break;
            case '社团管理员':
                $associations[0]["associationName"] = I("session.associationName", "");
                $map["association"] = I("session.associationName", "");
                $departments = M("association_departments")->where($map)->field("id,departmentName,association")->select();
                $nowassociation = $associations[0]["associationName"]; //社团管理员的当前社团必定为自己的社团，所以不管get过来什么

                $nowdepartment = $departments[0]["id"];
                foreach ($departments as $de) {
                    //对本社团的所有部门进行一次遍历，假如其中的某个部门正好等于get过来的那个部门，那就把当前部门改成get过来的那个部门，否则就是第一个部门
                    if ($de["id"] == I("get.nowdepartment")) {
                        $nowdepartment = $de["id"];
                        break;
                    }
                }
                break;
            case '超级管理员':
                $associations = M("association_list")->field("associationName")->select();
                $map['association'] = I('get.nowassociation');
                $departments = M("association_departments")->where($map)->field("id,departmentName,association")->select();
                $nowassociation = I("get.nowassociation", "") ? I("get.nowassociation", "") : $associations[0]["associationName"]; //nowassociation和nowdepartment
                session('associationName', $nowassociation);
                $nowdepartment = I("get.nowdepartment", "") ? I("get.nowdepartment", "") : $departments[0]["id"]; //这两个意思是当前正在以某个社团的某个部门的身份进行操作
                break; //因为超级管理员能够变成所有身份，所以get过来什么就变什么，不需要做权限检测
            default:
                redirect("index");
                break;
        }
        $_SESSION["nowassociation"] = $nowassociation;
        $_SESSION["nowdepartment"] = $nowdepartment;
        $map["association"] = $nowassociation;
        $alldepartment = M("association_departments")->where($map)->field("id,departmentName")->select();
        $this->assign("nowassociation", $nowassociation);
        $this->assign("nowdepartment", $nowdepartment);
        $this->assign("identity", $data["identity"]);
        $this->assign("associations", $associations);
        $this->assign("departments", $departments);
        $this->assign("alldepartment", $alldepartment);
        // dump($_SESSION);die();
        $this->display();
    }
    public function recuritlist()
    {
        $allrecruit = M("student_recruit_info")->where(array("association"=>$_SESSION["nowassociation"]))->select();
        $basic = M("student_basic_info");
        $tmpdepartments = M("association_departments")->select();
        foreach ($tmpdepartments as $vt) {
            $departments[$vt["id"]] = $vt;//用id为下标序列化部门列表
        }
        $this->assign("departments",$departments);
        foreach ($allrecruit as $p => $vr) {
            $map["xh"] = $vr["xh"];
            $allrecruit[$p]["name"] = $basic->where($map)->getField("name");
            $allrecruit[$p]["departmentName1"] = $departments[$vr["department1"]]["departmentName"];
            $allrecruit[$p]["departmentName2"] = $departments[$vr["department2"]]["departmentName"];
            if (($vr["acceptstate"] == 0 && $vr["department1"] == $_SESSION["nowdepartment"]) || ($vr["acceptstate"] == -1 && $vr["department2"] == $_SESSION["nowdepartment"])) {
                $allrecruit[$p]["able"] = 1;
            }else{
                $allrecruit[$p]["able"] = 0;
            }
        }
        $this->assign("recruit",$allrecruit);
        $this->display();
    }
    public function apply(){
        //录取
        if (!isset($_POST)) {
            $this->error("未选择");
        }
        $id = $_POST["id"];
        $info = M("student_recruit_info")->where('id='.$id)->find();
        if (($info["acceptstate"] == 0 && $info["department1"] == $_SESSION["nowdepartment"]) || ($info["acceptstate"] == -1 && $info["department2"] == $_SESSION["nowdepartment"])) {
                M("student_recruit_info")->where('id='.$id)->setField("acceptState",$_SESSION["nowdepartment"]);
                $this->success("成功");
        }else{
            $this->error("无权限访问");
        }
    }
    public function refuse(){
        //拒绝
        if (!isset($_POST)) {
            $this->error("未选择");
        }
        $id = $_POST["id"];
        $info = M("student_recruit_info")->where('id='.$id)->find();
        if (($info["acceptstate"] == 0 && $info["department1"] == $_SESSION["nowdepartment"]) || ($info["acceptstate"] == -1 && $info["department2"] == $_SESSION["nowdepartment"])) {
            $status = $info["acceptstate"] - 1;
            M("student_recruit_info")->where('id='.$id)->setField("acceptState",$status);
            $this->success($status);
        }else{
            $this->error("无权限访问");
        }
    }
    public function AssocMgr()
    {
        $data["identity"] = I("session.identity", "");
        switch ($data["identity"]) {
            case '部门管理员':
                $this->error('权限不足');
                break;
            case '社团管理员':
                $associations[0]["associationName"] = I("session.associationName", "");
                $map["association"] = I("session.associationName", "");
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
                $nowassociation = I("get.nowassociation", "") ? I("get.nowassociation", "") : $associations[0]["associationName"];
                $nowdepartment = I("get.nowdepartment", "") ? I("get.nowdepartment", "") : $departments[0]["id"];
                session('associationName', $nowassociation);
                break;
            default:
                redirect("index");
                break;
        }
        $map["association"] = $nowassociation;
        $alldepartment = M("association_departments")->where($map)->field("id,departmentName")->select();
        $this->assign("nowassociation", $nowassociation);
        $this->assign("nowdepartment", $nowdepartment);
        $this->assign("identity", $data["identity"]);
        $this->assign("associations", $associations);
        $this->assign("departments", $departments);
        $this->assign("alldepartment", $alldepartment);

        //目前已经获得当前管理的社团名为$nowassociation,对应的部门列表为$alldepartment
        //下面需要读出对应社团的部门列表
        $allDeptUser = M("association_departments")->where($map)->field("id,departmentName,username")->select();
        $this->assign("allDeptUser", $allDeptUser);
        // dump($allDeptUser);

        $this->display();
    }
    public function handleDept()
    {
        if (!IS_AJAX) {
            echo "非法操作";
            die();
        }
        if (I('session.identity') != "社团管理员" && I('session.identity') != "超级管理员") {
            $this->ajaxReturn(array('errno' => 1, 'errmsg' => '权限不足'));
        }

        $db = M('association_departments');

        if (I('session.identity') == '社团管理员' && I('post.action') != 'add') {
            //这里判断请求操作的部门是否为该社团的部门
            $deptBelonging = $db->where('id=' . I('post.id'))->getField('association');
            if ($deptBelonging != I('session.associationName')) {
                $this->ajaxReturn(array('errno' => 1, 'errmsg' => '权限不足'));
            }
        }
        //下面开始执行指定操作
        switch (I('post.action')) {
            case 'rstpwd': //重置账号密码
                $map['id'] = I('post.id');
                $map['username'] = I('post.username');
                $map['password'] = md5('spf' . I('post.password'));
                if ($db->save($map) === false) {
                    $this->ajaxReturn(array('errno' => -1, 'errmsg' => 'SQL错误', 'sql' => $db->getLastSql()));
                    die();
                } else {
                    $this->ajaxReturn(array('errno' => 0, 'errmsg' => 'success'));
                }
                break;
            case 'del':
                $result = $db->where('id=' . I('post.id'))->delete();
                if ($result === false) {
                    $this->ajaxReturn(array('errno' => -1, 'errmsg' => 'SQL错误', 'sql' => $db->getLastSql()));
                } elseif ($result === 0) {
                    $this->ajaxReturn(array('errno' => 3, 'errmsg' => '没有删除任何数据', 'sql' => $db->getLastSql()));
                } else {
                    $this->ajaxReturn(array('errno' => 0, 'errmsg' => 'success'));
                }
                break;
            case 'add':
                if (I('post.association') != I('session.associationName')) {
                    $this->ajaxReturn(array('errno' => 1, 'errmsg' => '权限不足', 'debug' => array('post' => I('post.association'), 'session' => I('session.associationName'))));
                };
                $_POST = I('post.');
                $map['association'] = $_POST['association'];
                $map['departmentName'] = $_POST['departmentName'];
                if ($db->where($map)->count() > 0) {
                    $this->ajaxReturn(array('errno' => 4, 'errmsg' => '该部门已存在'));
                };
                if ($db->where(array('username' => $_POST['username']))->count() > 0) {
                    $this->ajaxReturn(array('errno' => 4, 'errmsg' => '该用户名已存在'));
                }
                $_POST['password'] = md5('spf' . $_POST['password']);
                $db->create($_POST);
                if ($db->add()) {
                    $this->ajaxReturn(array('errno' => 0, 'errmsg' => 'success'));
                }
                break;
            default:
                $this->ajaxReturn(array('errno' => 2, 'errmsg' => '操作方法错误', 'action' => I('post.action')));
                break;
        }
    }

    public function editQuestion()
    {
        $data["identity"] = I("session.identity", "");
        switch ($data["identity"]) {
            case '部门管理员':
                $this->error('权限不足');
                break;
            case '社团管理员':
                $associations[0]["associationName"] = I("session.associationName", "");
                $map["association"] = I("session.associationName", "");
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
                $nowassociation = I("get.nowassociation", "") ? I("get.nowassociation", "") : $associations[0]["associationName"];
                $nowdepartment = I("get.nowdepartment", "") ? I("get.nowdepartment", "") : $departments[0]["id"];
                break;
            default:
                redirect("index");
                break;
        }
        $map["association"] = $nowassociation;
        $alldepartment = M("association_departments")->where($map)->field("id,departmentName")->select();
        $this->assign("nowassociation", $nowassociation);
        $this->assign("nowdepartment", $nowdepartment);
        $this->assign("identity", $data["identity"]);
        $this->assign("associations", $associations);
        $this->assign("departments", $departments);
        $this->assign("alldepartment", $alldepartment);

        //目前已经获得当前管理的社团名为$nowassociation,对应的部门列表为$alldepartment
        //下面需要读出对应社团的部门列表
        $allDeptUser = M("association_departments")->where($map)->field("id,departmentName,username")->select();
        $this->assign("allDeptUser", $allDeptUser);
        // dump($allDeptUser);
        $quest = M("association_list")->where(array('associationName' => $nowassociation))->field('quest1,quest2,quest3')->find();
        $this->assign("quest", $quest);
        // dump($quest);die();
        $this->display();
    }

    public function handleEditQuestion()
    {
        if (!IS_AJAX) {
            echo "非法操作";die();
        }
        if (I('session.identity') != "社团管理员" && I('session.identity') != "超级管理员") {
            $this->ajaxReturn(array('errno' => 1, 'errmsg' => '权限不足'));
        }

        $dbAssocDept = M('association_departments');

        if (I('session.identity') == '社团管理员') {
            //这里判断请求操作的部门是否为该社团的部门
            $deptBelonging = $dbAssocDept->where('id=' . I('post.id'))->getField('association');
            if ($deptBelonging != I('session.associationName')) {
                $this->ajaxReturn(array('errno' => 1, 'errmsg' => '权限不足'));
            }
        }
        $dbAssocList = M('association_list');
        $data['quest1'] = I('post.quest1');
        $data['quest2'] = I('post.quest2');
        $data['quest3'] = I('post.quest3');
        $result = $dbAssocList->where(array('associationName' => I('post.associationName')))->save($data);
        if ($result === false) {
            $this->ajaxReturn(array('errno' => -1, 'errmsg' => 'SQL错误', 'sql' => $dbAssocList->getLastSql()));
        } else {
            $this->ajaxReturn(array('errno' => 0, 'errmsg' => 'success'));
        }
    }
    public function loginout(){
        session(null);
        $this->redirect("index");
    }
}
