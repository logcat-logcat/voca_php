<?php
if ($_POST['func'] == "save") {
    $rows = $_POST['rows'];
    $old_title = $_POST['old_title'];
    $new_title = $_POST['new_title'];

    echo "값 받음";

    $hostname = "localhost";
    $username = "";
    $password = "";
    $dbname = "";

    $conn = mysqli_connect($hostname, $username, $password, $dbname);

    $query = "DELETE FROM $old_title";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);

    $query = "RENAME TABLE $old_title TO $new_title";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);

    $query = "INSERT INTO $new_title (q, a) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    foreach ($rows as $row) {
        $q = $row['0'];
        $a = $row['1'];
        mysqli_stmt_bind_param($stmt, "ss", $q, $a);
        mysqli_stmt_execute($stmt);
    }

    

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>