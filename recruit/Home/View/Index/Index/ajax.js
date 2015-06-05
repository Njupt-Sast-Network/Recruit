var k1=document.getElementById("1");
var k2=document.getElementById("question");
function post(){
	var post1=$('#1').html();
    var post2=$('#2').html();
    var post3=$('#3').html();
	$.ajax({
	  	type:"POST",
	  	url:"../../../../../public/index.php/recruit//Home/Controller/indexController.class.php/doRegAssociation()",
	  	
	 
	  data:{val:post1,val:post2,val:post3,department1:$('select1').val(),department2:$('select2').val()},
	  datatype:"json",
      success:function(){
         k1.style.display = "none";
         k2.style.display = "none";
         
      }
	}  
}

function bian(){
	k1.style.display="block";
	k2.style.display="block";
}