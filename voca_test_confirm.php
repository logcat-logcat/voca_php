<html>
    <head> 
        <title></title>
        <link rel = "stylesheet" href = "http://sdh55767.cafe24.com/voca_php/css/voca_test_test.css">
        <script src="http://210.114.22.121/voca_php/lib/jquery-3.6.3.min.js"></script>
        
    </head>
    <body>
    <?php
                
        $title = $_POST['file']; // 단어장 이름
        $id = $_POST['id']; // 사용자의 id
        
        $hostname = "localhost";
        $username = "test1";
        $password = "1234";
        $dbname = "voca";
        
        $conn = mysqli_connect($hostname, $username, $password, $dbname);
        
        $row = array();
        $qurry_file_value = "select * from " . $title . ";";
        $mysql_file_value = mysqli_query($conn, $qurry_file_value);
        
        while ($file_row = mysqli_fetch_row($mysql_file_value)) {
            $row[] = $file_row; // 1차원 배열의 값에 배열을 삽입하여 rows 는 2차원 배열이 됨
        }
        
        
        mysqli_close($conn);
    ?>
                
        <script>
            function go_main(){ // go main 눌렀을떄, yes 랑 no 버튼 나옴
                if (confirm('홈 화면으로 나가시겠습니까?')) {
                    pageGoPost({url:'/voca_php/voca_main_page.php', target:'_self', vals:[['id', '<? echo ($_POST['id'])?>']]});
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

            row = <? echo (json_encode($row)) ?>; // 단어장의 단어 배열
            id = <? echo (json_encode($id)) ?>; // id 저장
            answer = <? echo (json_encode($_POST['answer'])) ?>; // 단어장의 단어 배열
            option = <? echo(json_encode($_POST['option']))?>; // random인지 no_random 인지 담겨있는 변수
            
            // 2차원 배열을 무작위로 섞는 함수
            

            
            if (id == "") {
               location.href = '/voca_php/voca_main_login.php'; // get 또는 이상한 방법으로 접속시 로그인 화면으로 보낸다.
            }

            row_length = row.length; // 단어장의 길이
            console.log(row);
            
            console.log(answer);
            var answer_cnt =0;
            for(var i =0 ; i < row_length ; i++){
                if(row[i]['1'] == answer[i]){
                    answer_cnt++;
                } 
            }

            
            
        </script>
        
        
        
        <!-- 메인 바 -->
        <div class="main_bar">
            <h1>VOCA HELPER</h1>
            <p id = "id">ID: <?php echo($_POST['id'])?></p>
            <p id = "file_name">file: <?php echo($_POST['file'])?></p>
           
		    <button  id = "go_main"  name = "go_main" onclick = "go_main()">go main</button> 
	        
        </div>    

        <!-- 옵션 선택 영역 -->
        

       <div class="option2">
           
            <h2 style = "top : 10%" id = "op1_q">test</h2>
            
        </div>
        
    
        <!-- 다른 옵션으로 이동할 수 있는 화살표 버튼 -->
     
        
        

    
        <!-- 바닥글 -->
        <div class="footer-container">
            <p>저작권 © 2023 App logcat. All rights reserved.</p>
        </div>

        <script>
            document.getElementById('op1_q').textContent = answer_cnt+"/"+row_length;
        </script>
        
    </body>
  </html>  