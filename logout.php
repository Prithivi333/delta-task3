<?php
    include"database.php";
    session_start();

    unset($_SESSION["UID"]);
    unset($_SESSION["Uname"]);
    session_destroy();
    echo "<script>window.open('index.php','_self');</script>";
?>