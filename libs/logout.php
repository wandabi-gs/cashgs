<?php

session_start();



if(isset($_SESSION['unique_id'])){
    include_once "../templates/chats/php/config.php";
    $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
    if(isset($logout_id)){
        $status = "offline";
        $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id={$_GET['logout_id']}");
        if($sql){
            session_unset();
            session_destroy();
            header("location: ../templates/login.php");
            exit();
        }
    }else{
        header("location: ../users.php");
    }
}else{  
    header("location: ../login.php");
}

?>