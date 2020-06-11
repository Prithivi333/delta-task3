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
    <link rel="stylesheet" type="text/css" href="style.css">
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
    .myevents :hover{
        background-color: #ff0022;
    }

    .view {
        display: block;
        position: relative;
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
    </style>

<body>
<div class="dropdwn">
    <div class="myevents">Hosting Events</div>
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
<div class="dropdown">
    <div class="myevents">Attending Events</div>
    <div class="view">
        <?php
            $qry="select * from events";
            $result=$db->query($qry);
            while($info=$result->fetch_assoc()){
                $json=json_decode($info['Estatus']);
                if(isset($json)){
                foreach($json as $name=>$status){
                    if($name===$_SESSION['Uname']){
                        if($status==="false"){
                            echo $info['Ename'].": Not accepted<br>";
                        }
                        else{
                            echo $info['Ename']."Accepted<br>";
                        }
                    }
                }
            }
            }
        ?>
    </div>
</div>
</body>
</html>
