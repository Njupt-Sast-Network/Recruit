<?php 
namespace Home\Model;
use Think\Model\ViewModel;
class StudentViewModel extends ViewModel {
	public $viewFields = array(
        'student_recruit_info' => array('id','xh','department1','department2','association','quest1','quest2','quest3','acceptState'),
        'student_basic_info' => array('name','mail','dorm','birthday','sex','college','major','gaozhong','qq','_on'=>'student_recruit_info.xh=student_basic_info.xh'),


    );

}
?>

