<?php
session_start();
include "database.php";
include "navbar.php";
if(isset($_GET['ename'])){
$_SESSION['ename']=$_GET['ename'];
}
$sql="select * from events where Ename='".$_SESSION['ename']."'";
$res=$db->query($sql);
$r=$res->fetch_assoc();
$info=json_decode($r['Econtent']);
$head=$info->header;
$contents=$info->body;
$foot=$info->footer;
$contents=nl2br($contents);
if($r['Etype']==="Birthday Party"){
    echo '<style>
    .container{
        background-image: url("pics/bday.jpg");
        background-repeat: no-repeat;
        background-size: 100% 100%;
        background-position: center;
    }</style>';
}
if($r['Etype']==="Wedding"){
echo '<style type="text/css">
    .container{
        background-image: url("pics/wedding.jpg");
        background-repeat: no-repeat;
        background-size: 100% 100%;
        background-position: center;
    }</style>';
}
if($r['Etype']==="Funeral"){
echo '<style type="text/css">
    .container{
        background-image: url("pics/funeral.jpg");
        background-repeat: no-repeat;
        background-size: 100% 100%;
        background-position: center;
    }</style>';
}
if(isset($_GET['accept'])){
    $trf=$_GET['accept'];
    acceptance($trf);
}
function acceptance($trf)
{
    include "database.php";
    $nsql = "select * from status where Ename='" . $_SESSION['ename'] . "'";
    $data = $db->query($nsql);
    while ($row = $data->fetch_assoc()) {
            $_SESSION['sid'] = $row['SID'];
            $json = json_decode($row['Status'], true);
            if (array_key_exists($_SESSION['Uname'], $json)) {
            if ($trf == "true") {
                $json[$_SESSION['Uname']] = "true";
                $jd = json_encode($json);
                $query = $db->prepare("update status set Status=? where Ename='" . $_SESSION['ename'] . "' and SID='" . $_SESSION['sid'] . "'");
                $query->bind_param("s", $jd);
                $chk=$query->execute();
                if ($chk) {
                    echo "<script> alert(\"response added\");</script>";
                    echo "<script>window.open('home.php','_self')</script>";
                }
            } else if ($trf == "false") {
                $json[$_SESSION['Uname']] = "rejected";
                $jd = json_encode($json);
                $query = $db->prepare("update status set Status=? where Ename='" . $_SESSION['ename'] . "' and SID='" . $_SESSION['sid'] . "'");
                $query->bind_param("s", $jd);
                $chk=$query->execute();
                if ($chk) {
                    echo "<script> alert(\"response added\");</script>";
                    echo "<script>window.open('home.php','_self')</script>";
                }
            }
        }
    }
}
?>
<html>
    <head>
    <link href="https://fonts.googleapis.com/css2?family=Sacramento&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div id="title">Invitation for "<?php echo $_SESSION['ename'];?>":</div>
        <div class="container">
        <div class='head'><?php echo $head;?></div>
        <div class='main'><?php echo $contents;?></div>
        <div class='foot'><?php echo $foot;?></div>
        </div>
        <div id="accbox">
            You have not accepted / rejected this invitation yet!!<br>
            <a href="nacinvite.php?accept=true"><button class="accept">Accept</button></a><span><a href="nacinvite.php?accept=false"><button class="denied">Reject</button></a></span>
        </div>
        </body>
</html>