<?php
include "database.php";
include "navbar.php";
session_start();
if (!isset($_SESSION["UID"])) {
    echo "<script>window.open('index.php?mes=Access denied!','_self');</script>";
}
echo 'Welcome ' . $_SESSION['Uname'] . '!!<br>';
$array = array();
$sql = "select * from events where Uname='" . $_SESSION['Uname'] . "'";
$r = $db->query($sql);
while ($info = $r->fetch_assoc()) {
    array_push($array, $info['Ename']);
}
?>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <style>
        .dropdwn {
        position: relative;
        display: inline-block;
    }

    .myevents {
        background-color: #4CAF50;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
    }

    .view {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .view a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }
    .view a:hover{
        background-color: #ddd;
    }
    .dropdwn:hover .view{display: block;}
    </style>

<body>
<div class="dropdwn">
    <button class="myevents">My Events</button>
    <div class="view">
        <?php
            $i=0;
            while($i<count($array)){
            echo "<a href='hinvites.php?msg=".$array[$i]."'>".$array[$i]."</a>";
            $i++;
            }
            ?>
    </div>
</div>
</body>
</html>