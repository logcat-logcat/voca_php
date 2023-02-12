
 <?
	$error = $_POST["error"];
	
 
 ?>
  <script language="javascript">
	if( <?echo ($_POST["error"])?> === "no id"){
		alert("입력한 id가 없습니다.");
	}else if( <?echo ($_POST["error"])?>  === "no pass"){
		alert("입력한 비밀번호가 올바르지 않습니다.");
	}
 </script>
 
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
