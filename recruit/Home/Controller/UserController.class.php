<?php
/**
 * Created by PhpStorm.
 * User: Huangdie
 * Date: 2015/4/18
 * Time: 19:31
 */
namespace Home\Controller;

use Common\Model\StudentBasicInfoModel;
use Common\Model\StudentRecruitInfoModel;
use Common\Model\AssociationDepartmentsModel;
use Common\Model\AssociationListModel;
use Think\Controller;

class UserController extends Controller {

    public function doLogin() {
        $studentBasicInfo = new StudentBasicInfoModel();
        $student = $studentBasicInfo->getStudentInfoByXh(I('post.xh', ''));
        if (!$student) {
            die('fail');
        }
        $password = I('post.password', '');
        if (md5('spf'.$password) != $student['password']) {
            die('fail');
        };
        session_start();
        session(['xh'], $student['xh']);
        echo 'ok';
    }

    public function doLogout() {
        session_destroy();
        header('Location: /');
    }

    public function getRecruitState() {
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
                $item['acceptState'] = '被'.$associationDepartments->getDepartmentNameByDepartmentId($acceptState, $item['association']).'录取';
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

    public function doReg() {
        $studentBasicInfo = new StudentBasicInfoModel();
        $data['xh'] = I('post.xh', '', '/^[BHYQ][\d]+/i');
        $data['name'] = I('post.name', '', '/^[\x{4e00}-\x{9fa5}]+$/u');
        $data['birthday'] = (int)$_POST['birthday-y'].'-'.(int)$_POST['birthday-m'].'-'.(int)$_POST['birthday-d'];
        $data['year'] = date('Y');
        $data['password'] = I('post.password', '');
        $data['qq'] = I('post.qq', '', 'number_int');
        $data['mail'] = I('post.mail', '', 'email');
        $data['phone'] = I('post.phone', '', 'number_int');
        $data['sex'] = I('post.sex', '', 'number_int');
        $data['dorm'] = I('post.dorm', '');
        $data['college'] = I('post.college', '');
        $data['gaozhong'] = I('gaozhong', '');
        // 检查提交数据完整程度
        foreach($data as $key => $value) {
            if (!$value) {
                die($key);
            }
        }
        $data['password'] = md5('spf'.$data['password']);
        if ($studentBasicInfo->addStudent($data)) {
            echo 'ok';
        } else {
            echo 'fail';
        }
    }

    public function doRegAssociation() {
        $studentRecruitInfo = new StudentRecruitInfoModel();
        $data['xh'] = I('session.xh', '');
        $data['department1'] = I('post.department1', '');
        $data['department2'] = I('post.department2', '');
        $data['association'] = I('post.association', '');
        foreach($data as $key => $value) {
            if (!$value) {
                die($key);
            }
        }
        $data['quest1'] = I('post.quest1', '');
        $data['quest2'] = I('post.quest2', '');
        $data['quest3'] = I('post.quest3', '');
        $res = $studentRecruitInfo->studentRegisterAssociation($data['xh'], $data);
        echo $res;
    }

    public function doChangeDepartment() {
        $studentRecruitInfo = new StudentRecruitInfoModel();
        $xh = I('session.xh', '');
        $changed['department1'] = I('post.department1', '');
        $changed['department2'] = I('post.department2', '');
        $association = I('post.association');
        if (!$xh) {
            die('relogin');
        }
        echo $studentRecruitInfo->studentChangeDepartment($xh,$changed, $association);
    }

    public function doChangePassword() {
        $xh = I('session.xh', '');
        if (!$xh) {
            die('relogin');
        }
        $old = md5('spf'.I('post.old', ''));
        $current = I('post.current', '');
        $student = getStuInfo();
        if ($student['password'] != $old) {
            die('old_pass_mismatch');
        } else {
            if (strlen($current) < 8) {
                die('too_short');
            }
            $res = D('StudentBasicInfo')->setStudentPassword($xh, md5('spf'.$current));
            if (!$res) {
                die('fail');
            }
            echo 'success';
        }
    }

    public function doChangeInfo() {
        $student = getStuInfo();
        $data['name'] = I('post.name', '', '/^[\x{4e00}-\x{9fa5}]+$/u');
        $data['birthday'] = (int)$_POST['birthday-y'].'-'.(int)$_POST['birthday-m'].'-'.(int)$_POST['birthday-d'];
        $data['qq'] = I('post.qq', '', 'number_int');
        $data['mail'] = I('post.mail', '', 'email');
        $data['phone'] = I('post.phone', '', 'number_int');
        $data['sex'] = I('post.sex', '', 'number_int');
        $data['dorm'] = I('post.dorm', '');
        $data['college'] = I('post.college', '');
        $data['gaozhong'] = I('gaozhong', '');
        // 检查提交数据完整程度
        foreach($data as $key => $value) {
            if (!$value) {
                die($key);
            }
        }
        echo D('StudentBasicInfo')->updateStudentInfo($student['xh'], $data);
    }

}