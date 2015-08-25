<?php 
namespace Home\Model;
use Think\Model\ViewModel;
class StudentViewModel extends ViewModel {
	public $viewFields = array(
        'student_recruit_info' => array('id','xh','department1','department2','department3','association','quest1','quest2','quest3','acceptState'),
        'student_basic_info' => array('name','mail','dorm','birthday','sex','college','major','gaozhong','qq','_on'=>'student_recruit_info.xh=student_basic_info.xh'),


    );

}
?>

select `student_recruit_info`.`id` AS `id`,`student_recruit_info`.`xh` AS `xh`,`student_recruit_info`.`deparment1` AS `department1`,`student_recruit_info`.`deparment2` AS `department2`,`student_recruit_info`.`deparment3` AS `department3`,`student_recruit_info`.`association` AS `association`,`student_recruit_info`.`quest1` AS `quest1`,`student_recruit_info`.`quest2` AS `quest2`,`student_recruit_info`.`quest3` AS `quest3`,`student_recruit_info`.`acceptState` AS `acceptState`,`student_basic_info`.`name` AS `name`,`student_basic_info`.`mail` AS `mail`,`student_basic_info`.`name` AS `name`,`u_deal`.`invoice` AS `invoice` from ((`u_deal` join `u_fee`) join `u_enroll`) where ((`u_fee`.`name` = `u_deal`.`feename`) and (`u_enroll`.`idcard` = `u_deal`.`idcard`) and (`u_fee`.`id` = `u_deal`.`feeid`)) 