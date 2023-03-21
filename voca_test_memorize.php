<html>
    <head> 
        <title></title>
        <link rel = "stylesheet" href = "http://sdh55767.cafe24.com/voca_php/css/voca_test_memorize.css">
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

            function left_disable(){
                $('.left-arrow').animate({opacity : "0"}, 1000);
                document.getElementById('left-arrow').disabled = true;
            }
            function left_able(){
                $('.left-arrow').animate({opacity : "1"}, 1000);
                document.getElementById('left-arrow').disabled = false;
            }
            function right_disable(){
                $('.right-arrow').animate({opacity : "0"}, 1000);
                document.getElementById('right-arrow').disabled = true;
            }
            function right_able(){
                $('.right-arrow').animate({opacity : "1"}, 1000);
                document.getElementById('right-arrow').disabled = false;
            }
            function show_a(){
                if(row_cnt % 2 == 1){
                    document.getElementById('op2_a').textContent = row[row_cnt-1]['1'];
                }else{
                    document.getElementById('op1_a').textContent = row[row_cnt-1]['1'];
                }
            }
            function concil_a(){
                if(row_cnt % 2 == 1){
                    document.getElementById('op2_a').textContent = "";
                }else{
                    document.getElementById('op1_a').textContent = "";
                }
            }

            function left(){
                

                row_cnt--; // 왼쪽으로 이동하는 거니 단어매계변수 -1
                console.log(row_cnt);

                if(row_cnt == 1) left_disable(); // 첫번째 단어면 왼쪽버튼 사라지기
                if(row_cnt == row_length-1) right_able(); // 마지막에서 두변쨰 단어면 오른쪽 버튼 보이기

                if(row_cnt % 2 == 1){ //홀수번째, 옵션2에서 온다.
                    document.getElementById('op1-b1').disabled = false;
                    document.getElementById('op1-b2').disabled = false;  
                    document.getElementById('op2-b1').disabled = true;
                    document.getElementById('op2-b2').disabled = true;
                    
                    document.getElementById('op2_p').textContent = row_cnt+"/"+row_length;
                    document.getElementById('op2_q').textContent = row[row_cnt-1]['0'];
                    document.getElementById('op2_a').textContent = "";

                    $('.option1').animate({left : "0"},0);
                    $('.option1').animate({opacity : '1.0', left : "50%"},1000);
                    $('.option2').animate({opacity : '0.0', left : "75%"},400);
                    $('.option2').animate({left : "0"},0);
                }else{ // 짝수번째, 옵션 1이 온다.
                    document.getElementById('op1-b1').disabled = true;
                    document.getElementById('op1-b2').disabled = true;  
                    document.getElementById('op2-b1').disabled = false;
                    document.getElementById('op2-b2').disabled = false;
                    
                    document.getElementById('op1_p').textContent = row_cnt+"/"+row_length;
                    document.getElementById('op1_q').textContent = row[row_cnt-1]['0'];
                    document.getElementById('op1_a').textContent = "";
                    
                    $('.option2').animate({left : "0"},0);
                    $('.option2').animate({opacity : '1.0', left : "50%"},1000);
                    $('.option1').animate({opacity : '0.0', left : "75%"},400);
                    $('.option1').animate({left : "0"},0);
                }
             
            }
            function right(){
                
                row_cnt++; // 오른쪽으로 이동하기 때문에 단어 매계변수 +1
                console.log(row_cnt);

                if(row_cnt == 2) left_able(); // 두번째 단어일때 왼쪽 버튼 보이기
                if(row_cnt == row_length) right_disable(); // 마지막 단어일때 오른쪽 버튼 숨기기

                if(row_cnt % 2 == 1){ //홀수번째, 옵션2에서 온다
                    document.getElementById('op1-b1').disabled = false;
                    document.getElementById('op1-b2').disabled = false;  
                    document.getElementById('op2-b1').disabled = true;
                    document.getElementById('op2-b2').disabled = true; 

                    document.getElementById('op2_p').textContent = row_cnt+"/"+row_length;
                    document.getElementById('op2_q').textContent = row[row_cnt-1]['0'];
                    document.getElementById('op2_a').textContent = "";
                    
                   
                    $('.option1').animate({left : "75%"},0);
                    $('.option2').animate({opacity : '0.0', left : "0"},600);
                    $('.option1').animate({opacity : '1.0', left : "50%"},1000);
                }else{ // 짝수번째, 옵션 1이 온다.
                    document.getElementById('op1-b1').disabled = true;
                    document.getElementById('op1-b2').disabled = true;  
                    document.getElementById('op2-b1').disabled = false;
                    document.getElementById('op2-b2').disabled = false; 

                    document.getElementById('op1_p').textContent = row_cnt+"/"+row_length;
                    document.getElementById('op1_q').textContent = row[row_cnt-1]['0'];
                    document.getElementById('op1_a').textContent = "";
                    
                    $('.option2').animate({left : "75%"},0);
                    $('.option1').animate({opacity : '0.0', left : "0"},600);
                    $('.option2').animate({opacity : '1.0', left : "50%"},1000);
                }
            }

            document.addEventListener("keydown", function(event) {
                if (event.keyCode == 37) { // 왼쪽 방향키
                    left();
                }
                if (event.keyCode == 39) { // 오른쪽 방향키
                    right();
                }
            });

            row = <? echo(json_encode($row))?>; // 단어장의 단어 배열
            option = <? echo(json_encode($_POST['option']))?>; // random인지 no_random 인지 담겨있는 변수
            
            // 2차원 배열을 무작위로 섞는 함수
            function shuffleArray(array) { // 배열을 무작위로 섞을때 가장 효율적인 알고리즘인  Fisher-Yates 알고리즘을 사용한다.
                for (let i = array.length - 1; i > 0; i--) { // 배열의 마지막 부터 처음까지 반복한다
                    const j = Math.floor(Math.random() * (i + 1)); // 해당 요소보다 아래에 있는 요소중의 무작위로 선택해서 서로 바꾼다.
                    [array[i], array[j]] = [array[j], array[i]];  // array의 i번째 요소와 j번째 요소의 값을 서로 바꾸는 코드
                }
                return array;
            }

            // row 배열을 무작위로 섞는 코드
            if (option === "random") {
                row = shuffleArray(row);
            }else if(option === "no_random"){

            }else{
                location.href = '/voca_php/voca_main_login.php'; // get 또는 이상한 방법으로 접속시 로그인 화면으로 보낸다.
            }

            row_length = row.length; // 단어장의 길이
            console.log(row);
            row_cnt = 1; // 단어장 번호 받는 매계변수

            
        </script>
        
        
        
        <!-- 메인 바 -->
        <div class="main_bar">
            <h1>VOCA HELPER</h1>
            <p id = "id">ID: <?php echo($_POST['id'])?></p>
            <p id = "file_name">file: <?php echo($_POST['file'])?></p>
           
		    <button  id = "go_main"  name = "go_main" onclick = "go_main()">go main</button> 
	        
        </div>    

        <!-- 옵션 선택 영역 -->
        

       <div class="option2" style = "opacity : 0; left : 75%;">
            
            <p class="option-description" id = "op1_p">1/40</p>
            <h2 style = "top : 10%" id = "op1_q">단어</h2>
            <h2 style = "top : 50%" id = "op1_a">뜻</h2>
            
            <button class="option-button1" id = "op2-b1" disabled = "true" onclick="show_a();">뜻 보기</button>
            <button class="option-button2" id = "op2-b2" disabled = "true" onclick="concil_a();">뜻 숨기기</button>
        </div>
        <div class="option1">
            <p class="option-description" id = "op2_p">1/40</p>
            <h2 style = "top : 10%" id = "op2_q">단어</h2>
            <h2 style = "top : 50%" id = "op2_a">뜻</h2>
            <button class="option-button1" id = "op1-b1" onclick="show_a();">뜻 보기</button>
            <button class="option-button2" id = "op1-b2" onclick="concil_a();">뜻 숨기기</button>
        </div>
    
        <!-- 다른 옵션으로 이동할 수 있는 화살표 버튼 -->
     
        <button class="left-arrow" id = "left-arrow" onclick="left()" disabled = "true" style = "opacity : 0;"></button>
        <button class="right-arrow" id = "right-arrow" onclick="right()"></button>
        

    
        <!-- 바닥글 -->
        <div class="footer-container">
            <p>저작권 © 2023 App logcat. All rights reserved.</p>
        </div>

        <script>
            document.getElementById('op2_q').textContent = row[row_cnt-1]['0'];
            document.getElementById('op2_a').textContent = "";
            document.getElementById('op2_p').textContent = "1/"+row_length;
        </script>
    </body>
  </html>  