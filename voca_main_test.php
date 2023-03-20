<html>
    <head> 
        <title></title>
        <link rel = "stylesheet" href = "http://sdh55767.cafe24.com/voca_php/css/voca_main_test.css">
        <script src="http://210.114.22.121/voca_php/lib/jquery-3.6.3.min.js"></script>
    </head>
    <body>
        <?php
            if($_POST['id'] == ""){ // get이나 오류로 들어왔을 경우 login 페이지로 넘김
                echo "<script>location.href = '/voca_php/voca_main_login.php';</script>";
            }
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

            function left(){
                
                document.getElementById('left-arrow').disabled = true;
                document.getElementById('right-arrow').disabled = false;

                document.getElementById('op1-b1').disabled = false;
                document.getElementById('op1-b2').disabled = false;  
                document.getElementById('op2-b1').disabled = true;
                document.getElementById('op2-b2').disabled = true;  

                $('.left-arrow').animate({opacity : "0"}, 1000);
                $('.right-arrow').animate({opacity : "1"}, 1000);

                $('.option1').animate({opacity : '1.0', left : "50%"},1000);
                $('.option2').animate({opacity : '0.0', left : "75%"},400);
            }
            function right(){
                document.getElementById('left-arrow').disabled = false;
                document.getElementById('right-arrow').disabled = true;

                document.getElementById('op1-b1').disabled = true;
                document.getElementById('op1-b2').disabled = true;  
                document.getElementById('op2-b1').disabled = false;
                document.getElementById('op2-b2').disabled = false; 

                $('.left-arrow').animate({opacity : "1"}, 1000);
                $('.right-arrow').animate({opacity : "0.0"}, 1000);

                $('.option1').animate({opacity : '0.0', left : "0"},600);
                $('.option2').animate({opacity : '1.0', left : "50%"},1000);
                
                
            }
            function test(str){
                pageGoPost({url:'/voca_php/voca_test_test.php', target:'_self', vals:[['id', '<? echo ($_POST['id'])?>'],['file', '<? echo ($_POST['file'])?>'],['option', str]]});
            }
            function memorize(str){
                pageGoPost({url:'/voca_php/voca_test_memorize.php', target:'_self', vals:[['id', '<? echo ($_POST['id'])?>'],['file', '<? echo ($_POST['file'])?>'],['option', str]]});
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
        

       <div class="option2" style = "opacity : 0; left : 75%;">
            <h2>시험보기</h2>
            <p class="option-description">단어를 하나씩 보여주면 뜻을 작성합니다.<br> 단어장에 정렬된 순서와 무작위 순서를 선택할 수 있습니다.</p>
            <button class="option-button1" id = "op2-b1" disabled = "true" onclick="test('no_random');">시작하기</button>
            <button class="option-button2" id = "op2-b2" disabled = "true" onclick="test('random');">렌덤순서</button>
        </div>
        <div class="option1">
            <h2>단어 외우기</h2>
            <p class="option-description">단어를 하나씩 보여주면서 뜻을 암기합니다.<br> 단어장에 정렬된 순서와 무작위 순서를 선택할 수 있습니다. </p>
            <button class="option-button1" id = "op1-b1" onclick="memorize('no_random');">시작하기</button>
            <button class="option-button2" id = "op1-b2" onclick="memorize('random');">렌덤순서</button>
        </div>
    
        <!-- 다른 옵션으로 이동할 수 있는 화살표 버튼 -->
     
        <button class="left-arrow" id = "left-arrow" onclick="left()" disabled = "true" style = "opacity : 0;"></button>
        <button class="right-arrow" id = "right-arrow" onclick="right()"></button>
        

    
        <!-- 바닥글 -->
        <div class="footer-container">
            <p>저작권 © 2023 App logcat. All rights reserved.</p>
        </div>
    </body>
  </html>  