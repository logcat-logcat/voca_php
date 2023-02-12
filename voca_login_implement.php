<Script language ="javascript">
	function pageGoPost(d){
		alert("aaa")
		var insdoc = "";
		
		for (var i = 0; i < d.vals.length; i++) {
		  insdoc+= "<input type='hidden' name='"+ d.vals[i][0] +"' value='"+ d.vals[i][1] +"'>";
		}
		//매계변수 받은전달값 정리
		alert("bbb")
		var goform = $("<form>", {
		method: "post",
		action: d.url,
		target: d.target,
		html: insdoc
		}).appendTo("body");
		
		alert("ccc")
		
		goform.submit();
	}
</script>
<?php
	
	$hostname = "localhost";
	$username = "test1";
	$password = "1234";
	$dbname = "voca";

	$conn = mysqli_connect($hostname,$username,$password,$dbname);


	if($conn){
		echo("연결완료<br>");
	}else{
		echo("연결실패<br>");	
	}



	$id = $_POST['id'];
	$pass = $_POST['pass'];
	$new = $_POST['new'];
	
	
	
	
	if($new === "new member"){ // 회원가입
		$qurry_newu = "insert into user values('$id','$pass');";
		$mysql_newu = mysqli_query($conn,$qurry_newu);
		
	}else{ // 로그인
		$qurry_id_check = "select * from user where id = '$id'";
		$mysql_id_check = mysqli_query($conn,$qurry_id_check);
		$row_id=mysqli_fetch_array($mysql_id_check);
		if($row_id[0]){ //아이디 있음
			if($row_id[pass] === $pass){ // 비번 일치
				echo"<script> pageGoPost({url:'210.114.22.121/voca_php/main_page.php', target:'_self', vals:[['id', 'logcat']]}); </script>";
			}else{ // 비번 불일치
				echo"<script> pageGoPost({url: '210.114.22.121/voca_php/login_page.php', target: '_self',vals: [['error', 'no pass']]}); </script>";
			}
		}else{ // 아이디 없음
			echo"<script> pageGoPost({url: '210.114.22.121/voca_php/login_page.php', target: '_self',vals: [['error', 'no id']]}); </script>";
		}
	}	
	
?>
