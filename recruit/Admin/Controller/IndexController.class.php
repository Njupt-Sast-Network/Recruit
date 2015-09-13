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
        $map2["association"] = $nowassociation;
        $alldepartment = M("association_departments")->where($map2)->field("id,departmentName")->select();
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
        $allrecruit = M("student_recruit_info")->where(array("association" => $_SESSION["nowassociation"]))->select();
        $basic = M("student_basic_info");
        $tmpdepartments = M("association_departments")->select();
        foreach ($tmpdepartments as $vt) {
            $departments[$vt["id"]] = $vt; //用id为下标序列化部门列表
        }
        $this->assign("departments", $departments);
        foreach ($allrecruit as $p => $vr) {
            $map["xh"] = $vr["xh"];
            $allrecruit[$p]["name"] = $basic->where($map)->getField("name");
            $allrecruit[$p]["departmentName1"] = $departments[$vr["department1"]]["departmentName"];
            $allrecruit[$p]["departmentName2"] = $departments[$vr["department2"]]["departmentName"];
            if (($vr["acceptState"] == 0 && $vr["department1"] == $_SESSION["nowdepartment"]) || ($vr["acceptState"] == -1 && $vr["department2"] == $_SESSION["nowdepartment"])) {
                $allrecruit[$p]["able"] = 1;
            } else {
                $allrecruit[$p]["able"] = 0;
            }
        }
        if (isset($_GET["xh"])) {$condition["xh"] = $_GET["xh"];}
        if (isset($_GET["name"])) {$condition["name"] = $_GET["name"];}
        if (isset($_GET["department1"])) {$condition["department1"] = $_GET["department1"];}
        if (isset($_GET["department2"])) {$condition["department2"] = $_GET["department2"];}
        if (isset($_GET["acceptState"])) {$condition["acceptState"] = $_GET["acceptState"];}
        $count = 0;
        foreach ($allrecruit as $one) {
            $b = true;
            foreach ($condition as $cname => $va) {
                if ($one[$cname]!==$va) {
                    $b = false;
                    break;
                }
            }
            if ($b) {
                $count++;
                $shaixuan[] = $one;
            }
        }
        $num = (int) $_GET["num"] ? (int) $_GET["num"] : 20;
        $page = (int) $_GET["page"] ? (int) $_GET["page"] : 1;
        $allpage = ceil($count / $num);
        if ($page > $allpage) {
            $page = $allpage;
        }
        $start = ($page - 1) * $num;
        $end = $page * $num;
        for ($i = $start; $i < $end; $i++) {
            if (!isset($shaixuan[$i])) {
                break;
            }
            $final[] = $shaixuan[$i];
        }
        $this->assign("count", $count);
        $this->assign("num", $num);
        $this->assign("page", $page);
        $this->assign("allpage", $allpage);
        $this->assign("recruit", $final);
        // dump($departments);
        $this->display();
    }
    public function downloadallxls()
    {

        $allrecruit = M('student_download')->where(array("association" => $_SESSION["nowassociation"]))->select();
        $basic = M("student_basic_info");
        $tmpdepartments = M("association_departments")->select();
        foreach ($tmpdepartments as $vt) {
            $departments[$vt["id"]] = $vt; //用id为下标序列化部门列表
        }
        $this->assign("departments", $departments);
        foreach ($allrecruit as $p => $vr) {
            $map["xh"] = $vr["xh"];
            $allrecruit[$p]["name"] = $basic->where($map)->getField("name");
            $allrecruit[$p]["departmentName1"] = $departments[$vr["department1"]]["departmentName"];
            $allrecruit[$p]["departmentName2"] = $departments[$vr["department2"]]["departmentName"];
            if (($vr["acceptState"] == 0 && $vr["department1"] == $_SESSION["nowdepartment"]) || ($vr["acceptState"] == -1 && $vr["department2"] == $_SESSION["nowdepartment"])) {
                $allrecruit[$p]["able"] = 1;
            } else {
                $allrecruit[$p]["able"] = 0;
            }
        }
        if (isset($_GET["xh"])) {$condition["xh"] = $_GET["xh"];}
        if (isset($_GET["name"])) {$condition["name"] = $_GET["name"];}
        if (isset($_GET["department1"])) {$condition["department1"] = $_GET["department1"];}
        if (isset($_GET["department2"])) {$condition["department2"] = $_GET["department2"];}
        if (isset($_GET["acceptState"])) {$condition["acceptState"] = $_GET["acceptState"];}
        $count = 0;
        foreach ($allrecruit as $one) {
            $b = true;
            foreach ($condition as $cname => $va) {
                if ($one[$cname]!==$va) {
                    $b = false;
                    break;
                }
            }
            if ($b) {
                $count++;
                $shaixuan[] = $one;
            }
        }
     /*   $num = (int) $_GET["num"] ? (int) $_GET["num"] : 20;
        $page = (int) $_GET["page"] ? (int) $_GET["page"] : 1;
        $allpage = ceil($count / $num);
        if ($page > $allpage) {
            $page = $allpage;
        }
        $start = ($page - 1) * $num;
        $end = $page * $num;
        for ($i = $start; $i < $end; $i++) {
            if (!isset($shaixuan[$i])) {
                break;
            }
            $final[] = $shaixuan[$i];
        }*/
        
        vendor('PHPExcel');
        $i=4;
        $php_path = dirname(__FILE__) . '/';
        $excelurl = $php_path.'../../../public/download/all.xls';
        $objPHPExcel = \PHPExcel_IOFactory::load($excelurl);
        foreach($shaixuan as $k=>$v){
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B'.$i, $v['name'])
                ->setCellValue('A'.$i, $v['xh'])
                ->setCellValue('D'.$i, $v['phone'])
                ->setCellValue('E'.$i, $v['departmentName1'])
                ->setCellValue('F'.$i, $v['departmentName2'])
                ->setCellValue('H'.$i, $v['mail'])
                ->setCellValue('I'.$i, $v['qq'])
                ->setCellValue('J'.$i, $v['dorm'])
                ->setCellValue('K'.$i, $v['college'])
                ->setCellValue('L'.$i, $v['major'])
                ->setCellValue('M'.$i, $v['birthday'])
                ->setCellValue('N'.$i, $v['gaozhong'])
                ->setCellValue('O'.$i, $v['quest1'])
                ->setCellValue('P'.$i, $v['quest2'])
                ->setCellValue('Q'.$i, $v['quest3']);
        switch ($v["acceptState"]) {
                case 0:
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, '审查中');
                    break;
                case -1:
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, '被第一部门拒绝'); 
                    break;
                case -2:
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, '彻底没戏');
                    break;
                default:
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, $departments[$v["acceptState"]]["departmentName"].'录取');
                    break;
                }
        switch ($v["sex"]) {
                case 1:
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, '男');
                    break;
                case 2:
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, '女'); 
                    break;
                
                }
    $i++;
    }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', $final[0]['association'].'招新报名统计表');
    ob_end_clean();  //清空缓存 
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
    header("Content-Type:application/force-download");
    header("Content-Type:application/vnd.ms-execl");
    header("Content-Type:application/octet-stream");
    header("Content-Type:application/download");
    header('Content-Disposition:attachment;filename='.$final[0]['association'].'报名统计表.xls');//设置文件的名称
    header("Content-Transfer-Encoding:binary");
    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;

    }
    public function downloaddetailxls()
    {
        $mapxh['association']=$_GET['ass'];
        $mapxh['xh']=$_GET['xh'];
        $allrecruit = M('student_download')->where($mapxh)->select();
        $basic = M("student_basic_info");
        $tmpdepartments = M("association_departments")->select();
        foreach ($tmpdepartments as $vt) {
            $departments[$vt["id"]] = $vt; //用id为下标序列化部门列表
        }
            $allrecruit[0]["departmentName1"] = $departments[$allrecruit[0]["department1"]]["departmentName"];
            $allrecruit[0]["departmentName2"] = $departments[$allrecruit[0]["department2"]]["departmentName"];
        $final=$allrecruit;
        vendor('PHPExcel');
        $i=4;
        $php_path = dirname(__FILE__) . '/';
        $excelurl = $php_path.'../../../public/download/detail.xls';
        $objPHPExcel = \PHPExcel_IOFactory::load($excelurl);
        foreach($final as $k=>$v){
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B4', $v['name'])
                ->setCellValue('E4', $v['xh'])
                ->setCellValue('B6', $v['phone'])
                ->setCellValue('D8', $v['departmentName1'])
                ->setCellValue('H8', $v['departmentName2'])
                ->setCellValue('H6', $v['mail'])
                ->setCellValue('E6', $v['qq'])
                ->setCellValue('B7', $v['dorm'])
                ->setCellValue('E5', $v['college'])
                ->setCellValue('H5', $v['major'])
                ->setCellValue('H4', $v['birthday'])
                ->setCellValue('E7', $v['gaozhong'])
                ->setCellValue('B9', $v['quest1'])
                ->setCellValue('B10', $v['quest2'])
                ->setCellValue('B11', $v['quest3'])
                ->setCellValue('A9', $v['question1'])
                ->setCellValue('A10', $v['question2'])
                ->setCellValue('A11', $v['question3']);
        switch ($v["sex"]) {
                case 1:
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B5', '男');
                    break;
                case 2:
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B5', '女'); 
                    break;
                default:
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B5', '未选择');
                    break;
                }
    $i++;
    }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', $final[0]['association'].'招新个人信息表');
    ob_end_clean();  //清空缓存 
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
    header("Content-Type:application/force-download");
    header("Content-Type:application/vnd.ms-execl");
    header("Content-Type:application/octet-stream");
    header("Content-Type:application/download");
    header('Content-Disposition:attachment;filename='.$final[0]['association'].'__'.$final[0]['name'].'.xls');//设置文件的名称
    header("Content-Transfer-Encoding:binary");
    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;

    }
    public function apply()
    {
        //录取
        if (!isset($_POST)) {
            $this->error("未选择");
        }
        $id = $_POST["id"];
        $info = M("student_recruit_info")->where('id=' . $id)->find();
        if (($info["acceptState"] == 0 && $info["department1"] == $_SESSION["nowdepartment"]) || ($info["acceptState"] == -1 && $info["department2"] == $_SESSION["nowdepartment"])) {
            M("student_recruit_info")->where('id=' . $id)->setField("acceptState", $_SESSION["nowdepartment"]);
            $this->success("成功");
        } else {
            $this->error("无权限访问");
        }
    }
    public function refuse()
    {
        //拒绝
        if (!isset($_POST)) {
            $this->error("未选择");
        }
        $id = $_POST["id"];
        $info = M("student_recruit_info")->where('id=' . $id)->find();
        if (($info["acceptState"] == 0 && $info["department1"] == $_SESSION["nowdepartment"]) || ($info["acceptState"] == -1 && $info["department2"] == $_SESSION["nowdepartment"])) {
            $status = $info["acceptState"] - 1;
            M("student_recruit_info")->where('id=' . $id)->setField("acceptState", $status);
            $this->success($status);
        } else {
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
                // $map['password'] = md5('spf' . I('post.password'));
                $map['password'] = password_hash(I('post.password'), PASSWORD_DEFAULT, array("cost" => 9));
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
                // $_POST['password'] = md5('spf' . $_POST['password']);
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT, array("cost" => 9));
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

        $dbAssocList = M('association_list');

    /*    if (I('session.identity') == '社团管理员') {
            //这里判断请求操作的部门是否为该社团的部门
            $map['associationName'] = I('post.associationName');
            $deptBelonging = $dbAssocDept->where($map)->getField('associationName');
            if ($deptBelonging != I('session.associationName')) {
                $this->ajaxReturn(array('errno' => 2, 'errmsg' => '权限不足','data'=>[$deptBelonging,I('session.associationName'),$dbAssocDept->getLastSql()]));
            }
        }*/
        // $dbAssocList = M('association_list');
        $data['quest1'] = I('post.quest1');
        $data['quest2'] = I('post.quest2');
        $data['quest3'] = I('post.quest3');
        $result = $dbAssocList->where(array('associationName' => I('session.associationName')))->save($data);
        if ($result === false) {
            $this->ajaxReturn(array('errno' => -1, 'errmsg' => 'SQL错误', 'sql' => $dbAssocList->getLastSql()));
        } else {
            $this->ajaxReturn(array('errno' => 0, 'errmsg' => 'success'));
        }
    }
    public function changePwd()
    {
        if (I("session.identity", "") !== "超级管理员" && I("session.identity", "") !== "社团管理员") {
            $this->error('您无权限操作此页面！');
        }
        $this->display();
    }
    public function changePwdStep1()
    {
        if (I("session.identity", "") !== "超级管理员" && I("session.identity", "") !== "社团管理员") {
            $this->ajaxReturn(array('status' => -1, 'msg' => "权限不足"));
        }
        if (!IS_AJAX) {
            echo "非法操作";die();
        }
        $db = D('StudentBasicInfo');
        $result = $db->getStudentInfoByXh(I('post.xh', null, '/^[BHYQ][\d]+/i'));
        if ($result === null || $result['name'] !== I('post.name')) {
            $this->ajaxReturn(array('status' => 1, 'errmsg' => '未找到匹配的学号姓名'));
        }
        $token = md5('NjuptSast' . $result['id'] . $result['xh']);
        session('token', $token);
        $this->ajaxReturn(array(
            'status' => 0,
            'errmsg' => 'found',
            'data' => array(
                'id' => $result['id'],
                'token' => $token,
            ),
        ));
    }

    public function changePwdStep2()
    {
        if (I("session.identity", "") !== "超级管理员" && I("session.identity", "") !== "社团管理员") {
            $this->ajaxReturn(array('status' => -1, 'msg' => "权限不足"));
        }
        if (!IS_AJAX) {
            echo "非法操作";die();
        }
        $_POST = I('post.');
        if ($_POST['token'] !== session('token') || $_POST['token'] !== md5('NjuptSast' . $_POST['id'] . $_POST['xh'])) {
            $this->ajaxReturn(array('status' => -1, 'msg' => 'Token 不正确'));
            return;
        }
        $db = D('StudentBasicInfo');
        $db->setStudentPassword($_POST['xh'], $_POST['password']);
        session('token', null);
        $this->ajaxReturn(array('status' => 0, 'msg' => 'success'));
    }

    public function loginout()
    {
        session(null);
        $this->redirect("index");
    }
    public function detail()
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
        for ($i = 0; $i < count($departments); $i++) {
            $dep[$departments[$i]["id"]] = $departments[$i];
        }
        $this->assign("departments", $dep);
        $this->assign("alldepartment", $alldepartment);

        if (isset($_GET["xh"])) {
            $xh = $_GET["xh"];
        } else {
            $this->error("请选择新生");
        }
        $map["xh"] = $xh;
        $info = M("student_basic_info")->where($map)->find();
        if (!$info) {
            $this->error("查无此人");
        }
        $map["association"] = $nowassociation;
        $recruit = M("student_recruit_info")->where($map)->find();
        if (!$recruit) {
            $this->error("此新生未报名你的社团");
        }
        $tmpdepartments = M("association_departments")->select();
        foreach ($tmpdepartments as $vt) {
            $departments2[$vt["id"]] = $vt; //用id为下标序列化部门列表
        }
        $this->assign("basic", $info);
        $this->assign("recruit", $recruit);
        $this->assign("departments2", $departments2);
        $this->display();
    }
}
