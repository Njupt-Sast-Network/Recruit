<?php
/**
 * Created by PhpStorm.
 * User: Huangdie
 * Date: 2015/4/18
 * Time: 19:31
 */
namespace Home\Controller;

use Common\Model\AssociationDepartmentsModel;
use Common\Model\AssociationListModel;
use Common\Model\StudentBasicInfoModel;
use Common\Model\StudentRecruitInfoModel;
use Think\Controller;

class UserController extends Controller
{

    public function doLogin()
    {
        // echo "string";
        // $studentBasicInfo = new StudentBasicInfoModel();
        // $student = $studentBasicInfo->getStudentInfoByXh();
        $map["xh"] = I('post.xh', '');
        $map["password"] = md5('spf' . I('post.password', ''));
        $studentinfo = M("student_basic_info")->where($map)->find();
        if (!$studentinfo) {
            $this->ajaxReturn(array("status" => 0, "info" => "用户名或密码错误", "data" => $map));
        } else {
            session_start();
            unset($studentinfo["password"]);
            session("xh", $studentinfo["xh"]); //登陆成功后将学生学号、姓名写入session
            session("name", $studentinfo["name"]);
            $this->ajaxReturn(array("status" => 1, "info" => "success", "data" => $studentinfo));
        };
    }

    public function doLogout()
    {
        session_destroy();
        header('Location: /');
    }

    public function getRecruitState()
    {
        $studentBasicInfo = new StudentBasicInfoModel();
        $studentRecruitInfo = new StudentRecruitInfoModel();
        $associationDepartments = new AssociationDepartmentsModel();
        $associationLists = new AssociationListModel();
        $xh = I('session.xh', '');
        $student = $studentBasicInfo->getStudentInfoByXh($xh);
        if (!$student) {
            die('用户数据获取失败,请重新登陆!');
        }
        $recruitState = $studentRecruitInfo->getStudentRecruitState(array('xh' => $xh));
        foreach ($recruitState as $item) {
            $item['department1'] = $associationDepartments->getDepartmentNameByDepartmentId($item['department1'], $item['association']);
            $item['department2'] = $associationDepartments->getDepartmentNameByDepartmentId($item['department2'], $item['association']);
            $acceptState = $item['acceptState'];
            if ($acceptState > 0) {
                $item['acceptState'] = '被' . $associationDepartments->getDepartmentNameByDepartmentId($acceptState, $item['association']) . '录取';
            } else if ($acceptState == -99) {
                $item['acceptState'] = '全部被拒绝';
            } else {
                $item['acceptState'] = '第一志愿被拒绝';
            }
            $item['association'] = $associationLists->getAssociationNameById($item['association']);
        }
        $this->assign('recruitState', $recruitState);
        $this->display();
    }

    public function doReg()
    {
        $studentBasicInfo = new StudentBasicInfoModel();
        $data['xh'] = I('post.xh', '', '/^[BHYQ][\d]+/i');
        $data['name'] = I('post.name', '', '/^[\x{4e00}-\x{9fa5}]+$/u');
        $data['password'] = I('post.password', '');
        // 检查提交数据完整程度
        foreach ($data as $key => $value) {
            if (!$value) {
                $this->ajaxReturn(array("status" => 0, "info" => $key . "缺失"));
            }
        }
        $data['password'] = md5('spf' . $data['password']);
        $map["xh"] = $data["xh"];
        if ($studentBasicInfo->where($map)->count() > 0) {
            $this->ajaxReturn(array("status" => 0, "info" => "此学号已被注册,如果忘记密码请寻找社团管理员"));
        } else {
            $back = $studentBasicInfo->add($data);
            session("xh", $data["xh"]); //登陆成功后将学生学号、姓名写入session
            session("name", $data["name"]);
            $returndata["data"] = $back;
            $returndata["info"] = "成功";
            $returndata["status"] = 1;
            $this->ajaxReturn($returndata);
        }
    }

    public function doRegAssociation()
    {
        //新增添加报名信息
        $studentRecruitInfo = new StudentRecruitInfoModel();
        $data['xh'] = I('session.xh', '');
        $data['department1'] = I('post.department1', '');
        $data['department2'] = I('post.department2', '');
        $data['association'] = I('post.association', '');
        foreach ($data as $key => $value) {
            if (!$value) {
                $this->ajaxReturn(array("status" => 0, "info" => $key . "缺失"));
            }
        }
        $data['quest1'] = I('post.quest1', '');
        $data['quest2'] = I('post.quest2', '');
        $data['quest3'] = I('post.quest3', '');
        $res = $studentRecruitInfo->studentRegisterAssociation($data['xh'], $data);
        if ($res) {
            $this->ajaxReturn(array("status" => 1, "info" => "成功"));
        } else {
            $this->ajaxReturn(array("status" => 0, "info" => "你已经报名了这个社团"));
        }
    }

    public function doChangeDepartment()
    {
        //修改报名信息
        $studentRecruitInfo = new StudentRecruitInfoModel();
        $map["xh"] = I('session.xh', '');
        $map["id"] = I('post.id');
        $changed['department1'] = I('post.department1', '');
        $changed['department2'] = I('post.department2', '');
        $changed['quest1'] = I('post.quest1', '');
        $changed['quest2'] = I('post.quest2', '');
        $changed['quest3'] = I('post.quest3', '');
        if (!$map["xh"]) {
            $this->ajaxReturn(array("status" => 0, "info" => "未登录"));
        }
        if ($studentRecruitInfo->where($map)->save($changed)) {
            $this->ajaxReturn(array("status" => 1, "info" => "成功"));
        } else {
            $this->ajaxReturn(array("status" => 0, "info" => "更新失败"));
        }
    }
    public function delDepartment()
    {
        //删除报名信息
        $map["xh"] = I('session.xh', '');
        $map["id"] = I('post.id');
        if (!$map["xh"]) {
            $this->ajaxReturn(array("status" => 0, "info" => "未登录"));
        }
        if (M("student_recruit_info")->where($map)->delete()) {
            $this->ajaxReturn(array("status" => 1, "info" => "成功"));
        } else {
            $this->ajaxReturn(array("status" => 0, "info" => "删除失败"));
        }
    }
    public function doChangePassword()
    {
        $xh = I('session.xh', '');
        $map["xh"] = I('session.xh', '');
        if (!$map["xh"]) {
            $this->ajaxReturn(array("status" => 0, "info" => "未登录"));
        }
        $old = md5('spf' . I('post.old', ''));
        $current = I('post.current', '');
        $student = M("student_basic_info")->where($map)->find();
        if ($student['password'] != $old) {
            $this->ajaxReturn(array("status" => 0, "info" => "旧密码不正确"));
        } else {
            if (strlen($current) < 6) {
                $this->ajaxReturn(array("status" => 0, "info" => "新密码太短"));
            }
            $res = D('StudentBasicInfo')->setStudentPassword($xh, $current);
            if (!$res) {
                $this->ajaxReturn(array("status" => 0, "info" => $res));
            } else {
                $this->ajaxReturn(array("status" => 1, "info" => "成功"));
            }
        }
    }

    public function doChangeInfo()
    {
        $student = getStuInfo();
        $data['name'] = I('post.name', '', '/^[\x{4e00}-\x{9fa5}]+$/u');
        $data['birthday'] = (int) $_POST['birthday-y'] . '-' . (int) $_POST['birthday-m'] . '-' . (int) $_POST['birthday-d'];
        $data['qq'] = I('post.qq', '', 'number_int');
        $data['mail'] = I('post.mail', '', 'email');
        $data['phone'] = I('post.phone', '', 'number_int');
        $data['sex'] = I('post.sex', '', 'number_int');
        $data['dorm'] = I('post.dorm', '');
        $data['college'] = I('post.college', '');
        $data['gaozhong'] = I('gaozhong', '');
        $data['major'] = I('major', '');
        // 检查提交数据完整程度
        foreach ($data as $key => $value) {
            if (!$value) {
                $this->ajaxReturn(array("status" => 0, "info" => $key . "缺失"));
            }
        }
        $map["xh"] = I("session.xh", "");
        $b = D('StudentBasicInfo')->where($map)->save($data);
        if ($b) {
            $this->ajaxReturn(array("status" => 1, "info" => "成功"));
        } else {
            $this->ajaxReturn(array("status" => 0, "info" => "更新失败", "data" => $data));
        };
    }
    public function associationinfo()
    {
        //此接口用于查询社团信息，发送社团名称，返回社团的3个问题以及社团的所有部门
        $name = I("associationName", "");
        $departments = M("association_departments")->where(array("association" => $name))->field("id,departmentName")->select();
        $info = M("association_list")->where(array("associationName" => $name))->field("associationName,quest1,quest2,quest3")->find();
        $info["departments"] = $departments;
        $this->ajaxReturn(array("status" => 0, "data" => $info));

    }

}
