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
	<?php
		$hostname = "localhost";
		$username = "test1";
		$password = "1234";
		$dbname = "voca";

		$conn = mysqli_connect($hostname,$username,$password,$dbname);

	/*	
		if($conn){
			echo("연결완료<br>");
		}else{
			echo("연결실패<br>");	
		}
		*/
		$id = $_POST['id'];
		
		$qurry_num_check = "select * from file_num_stack";
		$mysql_num_check = mysqli_query($conn,$qurry_num_check);

		while($row_num=mysqli_fetch_array($mysql_num_check)){
			$file_num = $row_num[0]+1;
			
			$qurry_newu = "UPDATE file_num_stack SET stack = $file_num;";
			$mysql_newu = mysqli_query($conn,$qurry_newu);
		}
	?>
	<div  id = "top_div" > 
		<button onClick = "reload()" id = "main_text">VOCA HELPER</button>
	</div>
	
	 <!-- id만 보냄 -->
	
	<form action="/voca_php/voca_file_edit.php" method="post" >  <!-- 단어장 만들때 보낼값-->
		<p id = "id" name = "id" value = <?echo($_POST['id'])?>>id : '<?echo($_POST['id'])?>'</p>
		<input type="submit" id = "new_word" name = "new_member" value="create file" /> <!-- disabled 테그로 post로 전송 안시키려 했는데 그러면 그냥 버튼 동작 자체를 안해서 그냥 보냄-->	
		<input type = 'hidden' name = 'new' value = "new">
		<input type = 'hidden' name = 'file_name' value = "<?echo("file" . $file_num)?>">
		<input type = 'hidden' name = 'id' value = "<?echo($id)?>">
	</form>
	
	<form action="/import_word" method="post" >  <!-- 온라인 단어장 불러올때-->
		<input type="submit" id = "import_word" name = "import_word" value="import online file"  /> <!-- disabled 테그로 post로 전송 안시키려 했는데 그러면 그냥 버튼 동작 자체를 안해서 그냥 보냄-->	
	</form>
	
	<form action="/voca_php/voca_main_login.php" method="post" >  <!-- 로그아웃-->
		<input type="submit" id = "logout"  name = "logout" value="logout" /> 
	</form>

	 <!-- 바닥글 -->
	 <div class="footer-container">
        <p>저작권 © 2023 App logcat. All rights reserved.</p>
    </div>
	<?
		
		$cnt = 0; // 단어장의 갯수 새어줄 변수
		$id = $_POST['id'];
		
		/*
		$qurry_newu = "insert into user_file_cross values('$id','file1');";
		$mysql_newu = mysqli_query($conn,$qurry_newu);
		*/
		
		$qurry_file_check = "select * from user_file_cross where id = '$id'";
		$mysql_file_check = mysqli_query($conn,$qurry_file_check);

		
		$left_cnt = -20;
		$top_cnt = 40;
		while($row_file=mysqli_fetch_array($mysql_file_check)){
			//echo"파일 있음";
			$left_cnt = $left_cnt + 25;
			if($left_cnt > 80){
				$left_cnt = 5;
				$top_cnt = $top_cnt + 30;
			}
			echo "
			<link rel='stylesheet' type='text/css' href='/voca_php/css/voca_main_page.css'>
			
			<form action='/voca_php/voca_file_edit.php' method='post' id='file_form' style='left: $left_cnt%; top: $top_cnt%;'>
				<p id='file_name' name='file_name'>$row_file[1]</p>
				<button type='submit' id = 'file_test' name='new' value='test'>Test</button>
				<button type='submit' id = 'file_edit' name='new' value='edit'>Edit</button>
				<input type='hidden' name='id' value='$id'>
				<input type='hidden' name='file_name' value='$row_file[1]'>
			</form>

			";
		}
		
	?>
</body>
</html>
