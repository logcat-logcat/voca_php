

	
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
		
		
		
		if($new == 'new'){ // create file 버튼을 받았을때는 new_word() 함수만 호출해줌
			
		}else if($new == 'edit'){ // edit 버튼으로 들어왔을때는 파일에 있는 데이터를 2차원 배열에 카피한 후 그것을 출력해줌
			$qurry_file_value = "select * from $file_name";
			$mysql_file_value = mysqli_query($conn,$qurry_file_value);
			
			while($file_row = mysqli_fetch_row($mysql_file_value)){
				 $rows[] = $file_row; // 1차원 배열의 값에 배열을 삽입하여 rows 는 2차원 배열이 됨
			}
			print_file($rows); // 데이터 출력
		}else if($new == 'test'){ // test 누르고 들어왔을때는 test 페이지로 넘김
		}else{ // get이나 오류로 들어왔을 경우 login 페이지로 넘김
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
							<input type = 'text' id = 'english_e' value = {$rows[$a_rows-1][0]}></input>
						</div>
						<div id = 'word_boundary3'>
							<input type = 'text' class = 'translate_e' id = 'translate_e$a_rows' value = {$rows[$a_rows-1][1]} ></input>  
						</div>
						<div id = 'word_boundary4'>
							<button onclick = '' id = 'delete'>delete</button>
						</div>
					</div>";
			}
		}
		
		echo "<div class = 'word' id = 'word' style = 'top : 80%; left : 35%;'> 
					<div id = 'word_boundary1'>
						<p id = 'number' name = 'number'>$rows</p>
					</div>
					<div id = 'word_boundary2'>
						<input type = 'text' id = 'english_e' value = '$cnt'></input>
					</div>
					<div id = 'word_boundary3'>
						<input type = 'text' class = 'translate_e' id = 'translate_e' value = 'a'></input>
					</div>
					<div id = 'word_boundary4'>
						<button onclick = '' id = 'delete'>delete</button>
					</div>
				</div>";
	
		
		
	?>
	<script>
		function reload(){ location.reload(); } /**  새로고침 */

		function quit(){ // quit 눌렀을떄, yes 랑 no 버튼 나옴
			if (confirm('홈 화면으로 나가시겠습니까?')) {
			   pageGoPost({url:'/voca_php/voca_main_page.php', target:'_self', vals:[['id', '<? echo ($id)?>']]});
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
		
		function f_delete(id, cnt){ /** delete 했을때 출력  */
			document.getElementById(id).innerHTML = ''; //받아온 div의 id값을 이용하여 삭제
			<?php
				unset($rows[$cnt]); // 배열값도 삭제
			?>
		}
		
		function new_word(){ /** 단어칸 추가, ajax로 서버에 값 요청해서  new_file() 호출함 */
			alert("testtest");
			<?php
				$rows[] = array('단어 입력','뜻 입력');
				print_file($rows);
				
			?>
		}
		
	</script>
	<div  id = "left_div" > 
		<button onclick = "reload()" id = "main_text">VOCA<br>HELPER</button>
		
		<p id = "id" name = "id">id : <? echo ($id)?></p>
		
		

		
		<button onclick = "new_word()" id = "new_word">new word</button>
		
		<button onclick = "" id = "save">save</button>
		
		<button onclick = "quit()" id = "quit">quit</button>
		
	</div>
	
	<input type="text" id="file_name" name="file_name" value="file : <? echo ($file_name)?>">
	
</body>
</html>