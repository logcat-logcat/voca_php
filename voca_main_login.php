

<?php
	//alert("test");
	$error = $_POST["error"];
	if (empty($error) == true){
	
	}else{
		if($error == "no id"){
			echo "<script> alert('아이디가 존재하지 않습니다.'); </script>";
		}else if($error == "no pass"){
			echo "<script> alert('비밀번호가 일치하지 않습니다.'); </script>";
		}else if($error == "ID already exists"){
			echo "<script> alert('아이디가 이미 존재합니다.'); </script>";
		
		}else if($error == "id len"){
			echo "<script> alert('아이디를 입력하세요.'); </script>";
		
		}else if($error == "pass len"){
			echo "<script> alert('페스워드는 5자리 이상으로 작성해 주세요.'); </script>";
		}
	}
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>HTML for python flask</title>
	<link rel = "stylesheet" href = "/voca_php/css/voca_main_login.css">
	<!-- C:\Users\USER\Desktop\플라스크\static\css\voca_main_login.css -->
</head>


<body>
	<p id = "main_text">VOCA HELPER</p>
	
	<form action="/voca_php/voca_login_implement.php" method="post" >  <!-- 로그인 값 보냄 id,"id값"  pass,"pass값"  new_member,"yes"or"no"      formaction onclick="alert('제출 완료!')"-->
	​	<p id = 'id_p'>id : <input type="text" id='id' name='id' value=''></p>
		<p id = 'pass_p'>pass : <input type="text" id='pass' name='pass' value=''></p>
		<input type="submit" id = 'login' name = 'new' value="login"/>
		<input type="submit" id = 'new_login' name = 'new' value="new member"/>
	</form>
</body>
</html>
