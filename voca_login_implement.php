<html>
	<head>
		<script src="http://210.114.22.121/voca_php/lib/jquery-3.6.3.min.js"></script>
	</head>
	<body>
	<Script language ="javascript">
		function pageGoPost(d){ // d는 구조체 느낌의 문자열
			//alert("aaa");
			var insdoc = "";
			
			for (var i = 0; i < d.vals.length; i++) { // d의 vals의 값만큼 반복 vals는 데이터 이름, 값 저장하는 배?열
			  insdoc+= "<input type='hidden' name='"+ d.vals[i][0] +"' value='"+ d.vals[i][1] +"'>"; // 값을 정리해서 저장
			}
			//매계변수 받은전달값 정리
			//alert("bbb");
			//alert(insdoc);
			var goform = $("<form>", {method: "post",action: d.url,target: d.target,html: insdoc}).appendTo("body");

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
		
		
		

		$qurry_id_check = "select * from user where id = '$id'";
		$mysql_id_check = mysqli_query($conn,$qurry_id_check);
		$row_id=mysqli_fetch_array($mysql_id_check);
		
		if($row_id[0]){ //아이디 있음
			if($new == 'new member'){ //  회원가입 일때 - 이미 아이디 있음
				echo"<script> pageGoPost({url: '/voca_php/voca_main_login.php', target: '_self',vals: [['error', 'ID already exists']]}); </script>";
			}else{ // 로그인 일떄
				if($row_id[pass] === $pass){ // 비번 일치 - 로그인 성공	
					echo"<script> pageGoPost({url:'/voca_php/voca_main_page.php', target:'_self', vals:[['id', '$id']]}); </script>";
				}else{ // 비번 불일치
					echo"<script> pageGoPost({url: '/voca_php/voca_main_login.php', target: '_self',vals: [['error', 'no pass']]}); </script>";
				}
			}
		}else{ // 아이디 없음
			if($new == 'new member'){ // 회원가입일때 - 회원가입 성공
				if(strlen($id) < 1){ // 아이디가 공백인 경우
					echo"<script> pageGoPost({url: '/voca_php/voca_main_login.php', target: '_self',vals: [['error', 'id len']]}); </script>";
				}else if(strlen($pass) < 5){ // 비밀번호가 4자리 이하일 경우
					echo"<script> pageGoPost({url: '/voca_php/voca_main_login.php', target: '_self',vals: [['error', 'pass len']]}); </script>";
				}else{
					$qurry_newu = "insert into user values('$id','$pass');";
					$mysql_newu = mysqli_query($conn,$qurry_newu);
					
					echo"<script> pageGoPost({url:'/voca_php/voca_main_page.php', target:'_self', vals:[['id', '$id']]}); </script>";
				}
				
			}else{ // 로그인일때 - 아이디 없어서 빠꾸
				echo"<script> pageGoPost({url: '/voca_php/voca_main_login.php', target: '_self',vals: [['error', 'no id']]}); </script>";
			}
		}
	
		
	?>
	</body>
</html>