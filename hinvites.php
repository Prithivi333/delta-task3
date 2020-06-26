<?php
session_start();
include "database.php";
include "navbar.php";
$_SESSION['name']=$_GET['msg'];
$sql="select * from events where Uname='".$_SESSION['Uname']."' and Ename='".$_SESSION['name']."'";
$res=$db->query($sql);
if($res){
$r=$res->fetch_assoc();
$info=json_decode($r['Econtent']);
$_SESSION['eid']=$r['EID'];
$head=$info->header;
$contents=$info->body;
$foot=$info->footer;
$contents=nl2br($contents);
if($r['Etype']==="Birthday Party"){
        echo '<style>
        .container{
            background-image: url("bday.jpg");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            background-position: center;
        }</style>';
}
if($r['Etype']==="Wedding"){
    echo '<style type="text/css">
        .container{
            background-image: url("wedding.jpg");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            background-position: center;
        }</style>';
}
if($r['Etype']==="Funeral"){
    echo '<style type="text/css">
        .container{
            background-image: url("funeral.jpg");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            background-position: center;
        }</style>';
}
}
?>
<html>
    <head>
    <link href="https://fonts.googleapis.com/css2?family=Sacramento&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@1,600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div id="title">Your Invitation for "<?php echo $_SESSION['name'];?>":</div>
        <div class="container">
        <div class='head'><?php echo $head;?></div>
        <div class='main'><?php echo $contents;?></div>
        <div class='foot'><?php echo $foot;?></div>
        </div>
        <p>Status of sent invites:</p>
    </body>
    <?php
    $qry="select * from status where EID='".$_SESSION['eid']."'";
    $result=$db->query($qry);
    global $row;
    while($row=$result->fetch_assoc()){
    $data=json_decode($row['Status']);
    if($data!=null || $data!="" || !isset($data)){
    foreach($data as $name=>$stat){
        if($stat=="false"){
            echo "<div class='nacinv'>".$name.": Waiting for response<br></div>";
        }
        else if($stat=="true"){
            echo "<div class='accinv'>".$name.":Accepted<br></div>";
        }
        else{
            echo "<div class='rejinv'>".$name.":Rejected<br></div>";
        }
    }
    }
    }
    if($result->num_rows==0){
        echo "No invites sent yet";
    }
    echo "<div><button class=\"more\" onclick=\"window.open('moreinvites.php','_self')\">Invite more</button></div>"
    ?>
</html>
