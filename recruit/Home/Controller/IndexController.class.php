<?php
namespace Home\Controller;

use Think\Controller;
class IndexController extends Controller {
    // 首页
    public function index() {
        $this->display();
        // $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }

    // 登陆页面，请通过向/Home/User/doLogin发POST请求来完成登陆
    public function login() {
        $this->display();
    }

    // 注册
    // 向/Home/User/doReg进行POST
    public function reg() {
        $this->display();
    }

    // 报名状态
    public function recruitState() {
        $this->assign('user', getStuInfo());
        $this->display();
    }

    // 报名、修改志愿
    // 注意：添加新的报名请向/Home/User/doRegAssociation进行POST
    // 修改志愿向/Home/User/doChangeDepartment
    public function changeDepartment() {
        $this->display();
    }

    // 修改个人信息
    // 向/Home/User/doChangeInfo进行POST
    public function changeInfo() {
        $this->assign('user', getStuInfo());
        $this->display();
    }

    // 修改密码
    // 向/Home/User/doChangeDepartment进行POST
    public function changePassword() {
        $this->display();
    }
}