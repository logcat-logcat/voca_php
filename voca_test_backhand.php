<?php
if ($_POST['func'] == "get_rows"){
    $title = $_POST['file']; // 단어장 이름
    $id = $_POST['id']; // 사용자의 id



    $hostname = "localhost";
    $username = "test1";
    $password = "1234";
    $dbname = "voca";

    $conn = mysqli_connect($hostname, $username, $password, $dbname);


    $query = "SELECT * FROM " . $title .";"; 
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = array();
    while ($rows = mysqli_num_rows($result)) {
        $row[] = $rows;
    }
    echo(json_encode($row));

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>