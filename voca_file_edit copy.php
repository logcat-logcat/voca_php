

	
<html>
<head>
	<meta charset="UTF-8">
	<title>voca helper</title>
	<link rel = "stylesheet" href = "/voca_php/css/voca_file_edit.css">
	<script src="http://210.114.22.121/voca_php/lib/jquery-3.6.3.min.js"></script>
	<!-- C:\Users\USER\Desktop\플라스크\static\css\voca_main_page.css -->
</head>

<body>
	<?php
		$hostname = "localhost";
		$username = "test1";
		$password = "1234";
		$dbname = "voca";

		$conn = mysqli_connect($hostname,$username,$password,$dbname);

		
		if($conn){ // db와 연결
			echo("연결완료<br>");
		}else{
			echo("연결실패<br>");	
		}
		
		$id = $_POST['id'];
		$file_name = $_POST['file_name'];
		$new = $_POST['new'];
		
		$rows = array(); //1차원 배열 생성
		$cnt = 0;
		
		
		if($new == 'new'){ // create file 버튼을 받았을때는 new_word() 함수만 호출해줌
			<script>new_word();</script>
		}else if($new == 'edit'){ // edit 버튼으로 들어왔을때는 파일에 있는 데이터를 2차원 배열에 카피한 후 그것을 출력해줌
			$qurry_file_value = "select * from $file_name";
			$mysql_file_value = mysqli_query($conn,$qurry_file_value);
			
			while($file_row = mysqli_fetch_row($mysql_file_value)){
				 $rows[] = $file_row; // 1차원 배열의 값에 배열을 삽입하여 rows 는 2차원 배열이 됨
			}
			print_file($rows); // 데이터 출력
		}else if($new == 'test'){ // test 누르고 들어왔을때는 test 페이지로 넘김
		}else{ // get이나 오류로 들어왔을 경우 login 페이지로 넘김
			<script>location.href = "/voca_php/voca_main_login.php";</script>
		}
		
		function print_file(array $rows){ /** 파일 출력함수 */
			$cnt = count($rows);
			$a_rows=0;
			while($a_rows < $cnt){ // rows에 들어있는 배열의 값만큼 반복
				
				$a_rows++;
				
				
				$top_file = 10*$a_rows;
				
				echo "<div class = 'word' id = 'word$a_rows' style = 'top : $top_file%; left:35%;'> 
						<div id = 'word_boundary1'>
							<p id = 'number' name = 'number'>$a_rows</p>
						</div>
						<div id = 'word_boundary2'>
							<input type = 'text' id = 'english_e$a_rows' value = {$rows[$a_rows-1][0]}></input>
						</div>
						<div id = 'word_boundary3'>
							<input type = 'text' class = 'translate_e' id = 'translate_e$a_rows' value = {$rows[$a_rows-1][1]} ></input>  
						</div>
						<div id = 'word_boundary4'>
							<button onclick = 'f_delete({$a_rows-1})' id = 'delete'>delete</button>
						</div>
					</div>";
			}
		}
		
	
		
		
	?>
	<script>
		function reload(){ location.reload(); } /**  새로고침 */

		function quit(){ // quit 눌렀을떄, yes 랑 no 버튼 나옴
			if (confirm('홈 화면으로 나가시겠습니까?')) {
			   pageGoPost({url:'/voca_php/voca_main_page.php', target:'_self', vals:[['id', '<? echo ($id);?>']]});
			} else {}
		}
		
		function pageGoPost(d){  /** js로 form 역할하는 함수*/

			var insdoc = "";
			
			for (var i = 0; i < d.vals.length; i++) { // d의 vals의 값만큼 반복 vals는 데이터 이름, 값 저장하는 배?열
			  insdoc+= "<input type='hidden' name='"+ d.vals[i][0] +"' value='"+ d.vals[i][1] +"'>"; // 값을 정리해서 저장
			}
			var goform = $("<form>", {method: "post",action: d.url,target: d.target,html: insdoc}).appendTo("body");

			goform.submit();
		}
		
		function f_delete(cnt){ /** delete 했을때 해당 단어 삭제, ajax로 서버에 요청해서 단어 지운다음 print_file() 호출함  */
			var index = cnt;
			$.ajax({
				url: 'voca_php/update_rows.php', // 서버 측 파일 경로
				type: 'post', // 전송 방식
				data: { rows: <?php echo json_encode($rows); ?>, cnt: index , func: "new_word" }, // 전송할 데이터 (배열을 JSON 문자열로 변환)
				success: function(updated_rows){ // 서버 측에서 처리된 결과를 받아옴
					rows = JSON.parse(updated_rows); // JSON 문자열을 배열로 변환하여 업데이트된 $rows 배열을 받음
					print_file(rows); // 업데이트된 $rows 배열로 화면을 업데이트
				}
			})
		}
		
		function new_word(){ /** 단어칸 추가, ajax로 서버에 값 요청해서  print_file() 호출함 */
			$.ajax({
				url: 'voca_php/update_rows.php', // 서버 측 파일 경로
				type: 'post', // 전송 방식
				data: { rows: <?php echo json_encode($rows); ?>, func: "new_word" }, // 전송할 데이터 (배열을 JSON 문자열로 변환)
				success: function(updated_rows){ // 서버 측에서 처리된 결과를 받아옴
					rows = JSON.parse(updated_rows); // JSON 문자열을 배열로 변환하여 업데이트된 $rows 배열을 받음
					print_file(rows); // 업데이트된 $rows 배열로 화면을 업데이트
				}
			})
		}
		function save(){ /**  저장버튼 */
			var js_rows = []; // 현제 유저가 수정한 inputtext 값들을 저장해서 새로운 배열을 생성
			
			for (var i = 0; i < <?php echo ($cnt);?>; i++) {
				myArray[i] = [];
				myArray[i][0] = document.getElementById("english_e$a_rows"+i).value;
				myArray[i][1] = document.getElementById("translate_e$a_rows"+i).value;
				
			}
			
			$.ajax({
				url: 'voca_php/update_rows.php', // 서버 측 파일 경로
				type: 'post', // 전송 방식
				data: { rows: json_encode(js_row),old_title : <?php echo ($file_name);?> , new_title : document.getElementById("file_name").value, func: "save" }, // 전송할 데이터 (배열을 JSON 문자열로 변환)
				success: function(return){ // 서버 측에서 처리된 결과를 받아옴
					alert(return);
				}
			})
		}
	</script>
	<div  id = "left_div" > 
		<button onclick = "reload()" id = "main_text">VOCA<br>HELPER</button>
		
		<p id = "id" name = "id">id : <? echo ($id);?></p>
		
		

		
		<button onclick = "new_word()" id = "new_word">new word</button>
		
		<button onclick = "save()" id = "save">save</button>
		
		<button onclick = "quit()" id = "quit">quit</button>
		
	</div>
	
	<input type="text" id="file_name" name="file_name" value="file : <? echo ($file_name);?>">
	
</body>
</html>