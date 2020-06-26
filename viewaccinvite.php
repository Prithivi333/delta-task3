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
        background-image: url("bday.jpg");
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;
    }</style>';
}
if($r['Etype']==="Wedding"){
echo '<style type="text/css">
    .container{
        background-image: url("wedding.jpg");
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;
    }</style>';
}
if($r['Etype']==="Funeral"){
echo '<style type="text/css">
    .container{
        background-image: url("funeral.jpg");
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;
    }</style>';
}
?>
<html>
    <head>
    <link href="https://fonts.googleapis.com/css2?family=Sacramento&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div id="title">Your Invitation for "<?php echo $_SESSION['ename'];?>":</div>
        <div class="container">
        <div class='head'><?php echo $head;?></div>
        <div class='main'><?php echo $contents;?></div>
        <div class='foot'><?php echo $foot;?></div>
        </div>
        </body>
</html>