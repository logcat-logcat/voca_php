<!DOCTYPE html>
<script>
	function reload(){ location.reload(); }
</script>	
<html>
<head>
	<meta charset="UTF-8">
	<title>HTML for python flask</title>
	<link rel = "stylesheet" href = "/voca_php/css/voca_main_page.css">
	<!-- C:\Users\USER\Desktop\플라스크\static\css\voca_main_page.css -->
</head>

<body>
	
	<div  id = "top_div" > 
		<button onClick = "reload()" id = "main_text">VOCA HELPER</button>
	</div>
	
	
	<form action="/new_word" method="post" >  <!-- 단어장 만들때 보낼값-->
		<p id = "id" name = "id" value = <?echo($_POST['id'])?>>id : '<?echo($_POST['id'])?>'</p> <!-- id만 보냄 -->
		<input type="submit" id = "new_word" name = "new_member" value="create file"   formaction onclick="alert('제출 완료!')" /> <!-- disabled 테그로 post로 전송 안시키려 했는데 그러면 그냥 버튼 동작 자체를 안해서 그냥 보냄-->	
	</form>
	
	<form action="/import_word" method="post" >  <!-- 온라인 단어장 불러올때-->
		<p id = "id" name = "id" value = <?echo($_POST['id'])?>>id : '<?echo($_POST['id'])?>'</p> <!-- id만 보냄 -->
		<input type="submit" id = "import_word" name = "import_word" value="import online file"   formaction onclick="alert('제출 완료!')" /> <!-- disabled 테그로 post로 전송 안시키려 했는데 그러면 그냥 버튼 동작 자체를 안해서 그냥 보냄-->	
	</form>
	
	<form action="/voca_php/voca_main_login.php" method="post" >  <!-- 로그아웃-->
		<input type="submit" id = "logout"  name = "new_member" value="logout"   formaction onclick="alert('제출 완료!')" /> 
	</form>
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
		
		$cnt = 0; // 단어장의 갯수 새어줄 변수
		
		$qurry_id_check = "select * from user_file_cross where id = '$id'";
		$mysql_id_check = mysqli_query($conn,$qurry_id_check);
		$row_id=mysqli_fetch_array($mysql_id_check);
		if($row_id[0]){
			while($row_id[0]){
				echo "
				<form action='/' method='post' id = 'file_form' style = 'left : (10*$cnt)%; top : 40%'> 
					<p id = 'file_name' name = 'id'>나의 단어장1</p>
					<input type='submit' id = 'file_test' name = 'import_word' value='test'/> 
					<input type='submit' id = 'file_edit' name = 'import_word' value='edit'/> 					
				</form>
				";
				$cnt = $cnt + 1;
			}
		}
		

	?>
</body>
</html>
