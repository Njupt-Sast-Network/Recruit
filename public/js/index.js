function teamSelector() {
	// 社团及部门数组
	var teamNum = ['科协','外联','办公室'];
	var teamDepartment = [];
	teamDepartment[0] = ['电子部','计算机部','网络部'];
	teamDepartment[1] = ['b1','b2','b3'];
	teamDepartment[2] = ['c1','c2','c3'];
	// 更新函数
	function update(num) {
		if($('#teamselect').val() == '==请选择=='){
			newoption = '';
		} else {
			for(var i = 0,newoption = '';i<teamDepartment[num].length;i++){
			newoption += "<option class='choice'>" + teamDepartment[num][i] + "</option>";
		    }
		}
		
		var newSelect_1 = "<select class='form-control tSelector' id='department_1'>" + newoption + "</select>";
		$('#department_1').replaceWith(newSelect_1);
		var newSelect_2 = "<select class='form-control tSelector' id='department_2'>" + newoption + "</select>";
		$('#department_2').replaceWith(newSelect_2);
	}
    // 检测变化
	$('#teamselect').change(function(){
		var team = $('#teamselect').val();
		// 检测社团
		for(var i = 0;i<teamNum.length;i++){
			if(teamNum[i] == team){
				break;
			}
		}
		update(i);
		// console.log(i);
	});
}

function addTeam() {
	$("depAdd").click(function(){
		if($("teamselect").val() == "==请选择=="){
			alert("请选择一个社团");
		} else {
			$.ajax({
				type : "POST",
				url : "",
				// 发送请求数据，接收回调数据，反映在界面中
			});
		}
	});
}

function changeTeam() {
	$("depChange").click(function(){
		
	});
}

// function saveTeam() {

// }

// function deleteTeam() {

// }

$(document).ready(function(){
	teamSelector();
	// addTeam();
});