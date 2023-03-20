<?php
function insertValuesToTable($conn, $tableName, $rows) { /** 테이블과 배열을 받으면 테이블에 배열 넣어준다. */
    
    
    $query = "INSERT INTO " . $tableName . " (q, a) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    foreach ($rows as $row) {
        $q = $row['0'];
        $a = $row['1'];
        mysqli_stmt_bind_param($stmt, "ss", $q, $a);
        mysqli_stmt_execute($stmt);
    }
    
    mysqli_stmt_close($stmt);
}

function insertValuesToCrossTable($conn, $id, $tableName) { /**  id와 테이블 이름 받고 없는거면 유저 파일 크로스에 입력해준다. */
    $query = "SELECT * FROM user_file_cross WHERE id = ? AND file = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $id, $tableName);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 0) {
        $query = "INSERT INTO user_file_cross VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ss', $id, $tableName);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
}
if ($_POST['func'] == "delete_file") {
    $id = $_POST['id'];
    $title = $_POST['title'];

    $hostname = "localhost";
    $username = "test1";
    $password = "1234";
    $dbname = "voca";

    $conn = mysqli_connect($hostname, $username, $password, $dbname);

    $query = "DROP TABLE {$title};"; // 테이블의 모든 행 삭제
    $stmt = mysqli_prepare($conn, $query);
    if (!mysqli_stmt_execute($stmt)) {
        echo mysqli_error($conn);
    }

    $query = 'DELETE FROM user_file_cross WHERE id = ? and file =  ? ;';
    $stmt = mysqli_prepare($conn, $query); 
    mysqli_stmt_bind_param($stmt, 'ss', $id ,$title);
    //mysqli_stmt_execute($stmt);
    if (!mysqli_stmt_execute($stmt)) {
        echo mysqli_error($conn);
    }

}
else if ($_POST['func'] == "save") {
    $rows = $_POST['rows']; // 배열
    $old_title = $_POST['old_title']; // 원래 단어장 이름
    $new_title = $_POST['new_title']; // 바꿀 단어장 이름
    $id = $_POST['id']; // 사용자의 id
    $c_title = $_POST['change_title'];

    

    $hostname = "localhost";
    $username = "test1";
    $password = "1234";
    $dbname = "voca";

    $conn = mysqli_connect($hostname, $username, $password, $dbname);


    $query = "SELECT * FROM user_file_cross WHERE file = ?"; // 파일의 바꿀 이름이 이미 있는지 확인
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $new_title);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    //echo($c_title);
    if (!mysqli_num_rows($result) == 0) { // 이름이 있으면 빠꾸
        if($c_title == "new"){
            echo "error: 파일 이름이 이미 존재합니다.";

            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            exit(); // 프로그램 종료
        }
    }

    $query = 'DELETE FROM user_file_cross WHERE id = ? and file =  ? ;';
    $stmt = mysqli_prepare($conn, $query); 
    mysqli_stmt_bind_param($stmt, 'ss', $id ,$old_title);
    //mysqli_stmt_execute($stmt);
    if (!mysqli_stmt_execute($stmt)) {
        echo mysqli_error($conn);
    }

    $query = "drop table ". $old_title . ";"; // 테이블의 모든 행 삭제
    $stmt = mysqli_prepare($conn, $query);
    if (!mysqli_stmt_execute($stmt)) {
        echo mysqli_error($conn);
    }

    $query = "CREATE TABLE " . $new_title . " (q varchar(25) default NULL,a varchar(25) default NULL)"; // 테이블의 이름은 ?로 바인딩이 불가
    $stmt = mysqli_prepare($conn, $query);
    // mysqli_stmt_execute($stmt);
    if (!mysqli_stmt_execute($stmt)) {
        echo mysqli_error($conn);
    }

     echo ($new_title . " ? " . $old_title. " ? ");

   

    insertValuesToTable($conn, $new_title, $rows);
    insertValuesToCrossTable($conn, $id, $new_title);

        

    /*
        $query = "RENAME TABLE ? TO ?"; // 파일의 이름을 바꾼다.
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ss', $old_title, $new_title);
        mysqli_stmt_execute($stmt);
    */

    

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>