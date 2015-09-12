<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    // 首页
    public function index()
    {
        //$this->display();
        $this->redirect("login");
        // $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }

    // 登陆页面，请通过向/Home/User/doLogin发POST请求来完成登陆
    public function login()
    {
        $this->display();
    }
    public function verify()
    {
        $Verify = new \Think\Verify(); //使用验证码
        $Verify->fontSize = 35; //验证码字体大小
        $Verify->length = 4; //验证码长度
        $Verify->entry();
    }

    public function checkVerify()
    {
        return checkVerifyCode(I('get.code'));
    }


    // 注册
    // 向/Home/User/doReg进行POST
    public function reg()
    {
        $this->display();
    }

    // 报名状态
    public function recruitState()
    {
        $this->assign('user', getStuInfo());
        $this->display();
    }

    // 报名、修改志愿
    // 注意：添加新的报名请向/Home/User/doRegAssociation 进行POST
    // 修改志愿向/Home/User/doChangeDepartment
    public function changeDepartment()
    {
        getStuInfo(); //登陆检测
        $map["xh"] = I("session.xh", "");
        $recruitInfo = M("student_recruit_info")->where($map)->select();
        // $associations = M("association_list")->select();
        /*$obj_associations = M("association_list")->getField('id,associationName,quest1,quest2,quest3');
        //↑↑↑↑并不需要向前端输出所有字段，会导致安全问题（因为包含了密码和后台登陆用户名）
        foreach ($obj_associations as $key => $value) {
        $associations[] = $value;//然而由于TP一些奇怪的特性又不得不这么折腾一下
        }*/
        $tmpdepartments = M("association_departments")->select();
        foreach ($tmpdepartments as $vt) {
            $departments[$vt["id"]] = $vt['departmentName']; //用id为下标序列化部门列表
        }
        $associations = M("association_list")->field('id,associationName,quest1,quest2,quest3')->select();
        $this->assign("associations", $associations);
        $this->assign("departments", $departments);
        $this->assign("recruitInfo", $recruitInfo); //在前端用这个recruitInfo来存储此学生所有的报名信息
        // 在前端一定要存着每条已有的报名信息的id号，删除和更新的时候一定要发送id号，否则无法执行
        $this->display();
    }

    // 修改个人信息
    // 向/Home/User/doChangeInfo进行POST
    public function changeInfo()
    {
        getStuInfo(); //登陆检测
        $map["xh"] = I('session.xh', '');
        $stuinfo = M("student_basic_info")->where($map)->find();
        $this->assign("stuinfo", $stuinfo); //在前端预填学生原来的信息
        $this->display();
    }

    // 修改密码
    // 向/Home/User/doChangePassword进行POST
    public function changePassword()
    {
        getStuInfo(); //登陆检测
        $this->display();
    }
}
