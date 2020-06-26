<?php
include "database.php";
include "navbar.php";
session_start();
if (!isset($_SESSION["UID"])) {
    echo "<script>window.open('index.php?mes=Access denied!','_self');</script>";
}
echo '<div id="title">Welcome <b>' . $_SESSION['Uname'] . '</b>!!<br></div>';
$array = array();
$sql = "select * from events where Uname='" . $_SESSION['Uname'] . "'";
$r = $db->query($sql);
while ($info = $r->fetch_assoc()) {
    array_push($array, $info['Ename']);
}
if(isset($_GET['del'])){
    $info=$db->query("select * from status where Ename='".$_GET['ename']."'");
    while ($row = $info->fetch_assoc()) {
        $json = json_decode($row['Status'], true);
        if (array_key_exists($_SESSION['Uname'], $json)) {
            $json[$_SESSION['Uname']] = "deleted";
            $jd = json_encode($json);
            $query = $db->prepare("update status set Status=? where Ename='" . $_GET['ename'] . "' and SID='" . $row['SID'] . "'");
            $query->bind_param("s", $jd);
            $chk = $query->execute();
            if($chk){
            echo "<script> alert(\"deleted the invite\");</script>";
            }
        }
    }
}
?>
<html>
    <head>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
    body{
      background-image: url('welcome.jpg');
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: 100% 100%;
    }
    html,body{
      height: 50%;
      width: 100%;
    }
    </style>
    </head>
<body>
<div class="tab">
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
<div class="tab">
    <div class="myevents">Attending Events</div>
    <div class="view">
        <?php
            $qry="select * from status";
            $result=$db->query($qry);
            while($info=$result->fetch_assoc()){
                $json=json_decode($info['Status']);
                if(isset($json)){
                foreach($json as $name=>$status){
                    if($name===$_SESSION['Uname']){
                        if($status==="false"){
                            echo "<a href='nacinvite.php?ename=".$info['Ename']."'>".$info['Ename'].": Not yet accepted</a><br>";//go to a page to view and accept/reject invite
                        }
                        if($status==="true"){
                            echo "<a href='viewaccinvite.php?ename=".$info['Ename']."'>".$info['Ename'].": Accepted</a><br>";//go to a page to view accepted invite
                        }
                        if($status==="rejected"){
                            echo "<a href='viewaccinvite.php?ename=".$info['Ename']."'>".$info['Ename'].": 
                                Rejected</a><a href=\"home.php?del=true&ename=".$info['Ename']."\"><button id='reject'>Delete Invite</button></a><br>";//setup to hide deleted invite from dashboard
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
