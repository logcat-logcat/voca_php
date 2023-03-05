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
							<input type = 'text' class = 'english_e' id = 'english_e$a_rows' value = {$rows[$a_rows-1][0]}></input>
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
		

		row_length = <?php echo json_encode($cnt); ?>; // 현제 단어장의 단어 갯수를 저장하는 변수, index가 아니어서 1부터 시작한다.

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
		

			document.getElementById('word'+index).remove(); // html 객체 삭제

			while(index+1 < row_length){ //삭제한 단어가 마지막단어가 아닐경우에 루프, index는 인덱스 값이고 row_length는 1부터시작하는 숫자
				index++;
				if(index+1 != row_length){
					document.getElementById('word'+(index+1)).id = "word"+index"; //삭제한 단어 뒤의 단어를 한칸씩 앞으로 당겨준다. index는 0부터 시작하는 index값이고 div의 id는 1부터 시작한다.
					document.getElementById('word'+index).style.top = (index*10) + '%';; // id를 바꾼 div객체의 y좌표도 당겨준다.
				}
			}

			row_length--; // 단어가 삭제되어 단어 수가 1개 준다.
		}
		
		function new_word(){ /** 단어칸 추가, ajax로 서버에 값 요청해서  print_file() 호출함 */
			row_length++;

			var div_main = document.createElement("div");

			div_main.id = "word"+row_length;
			div_main.className = "word";
			div_main.style.top = (row_length*10) + '%';
			div_main.style.left = '35%';

			var div1 = document.createElement("div");
			div1.id = "word_boundary1";
			var div2 = document.createElement("div");
			div2.id = "word_boundary2";
			var div3 = document.createElement("div");
			div3.id = "word_boundary3";
			var div4 = document.createElement("div");
			div4.id = "word_boundary4";

			var p = document.createElement("p");
			p.id = 'number';
			p.textContent = ''+ row_length;

			var input_q = document.createElement("input");
			input_q.type = "text";
			input_q.className = "english_e"; // 클레스명 추가하는 방법
			input_q.id = "english_e"+row_length;
			input_q.value = "단어 입력";

			var input_a = document.createElement("input");
			input_a.type = "text";
			input_a.className = "translate_e";
			input_a.id = "translate_e"+row_length;
			input_a.value = "뜻 입력";

			var button = document.createElement("button");
			button.addEventListener("click", function(){f_delete(row_length); }); // 버튼 테그에 onclick 추가하는 방법
			button.id = 'delete';
			button.textContent = 'delete';


			div1.appendChild(p);
			div2.appendChild(input_q);
			div3.appendChild(input_a);
		    div4.appendChild(button);

			div_main.appendChild(div1);
			div_main.appendChild(div2);
			div_main.appendChild(div3);
			div_main.appendChild(div4);

			document.body.appendChild(div_main);
		}

		function save(){ /**  저장버튼 */
			var edited_rows = []; // 저장할때 inputText 값들을 따로 저장할 배열 생성,
			
			for (var i = 0; i < row_length; i++) {
				edited_rows[i] = [];
				edited_rows[i][0] = document.getElementById("english_e"+i).value;
				edited_rows[i][1] = document.getElementById("translate_e"+i).value;
				
			}
			
			$.ajax({
				url: 'voca_php/update_rows.php', // 서버 측 파일 경로
				type: 'post', // 전송 방식
				data: { rows: json_encode(edited_rows),old_title : <?php echo ($file_name);?> , new_title : document.getElementById("file_name").value, func: "save" }, // 전송할 데이터 (배열을 JSON 문자열로 변환)
				success: function(return){ // 서버 측에서 처리된 결과를 받아옴
					alert("save success");
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