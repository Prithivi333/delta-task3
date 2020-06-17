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
}
$qry="select * from status where EID='".$_SESSION['eid']."'";
$result=$db->query($qry);
while($row=$result->fetch_assoc()){
$data=json_decode($row['status']);
if($data!=null || $data!="" || !isset($data)){
foreach($data as $name=>$stat){
    if($stat=="false"){
        echo $name.": Not yet accepted<br>";
    }
    else if($stat=="true"){
        echo $name.":Accepted<br>";
    }
    else{
        echo $name.":Rejected";
    }
}
}else{
    echo "No invites sent yet";
}
}
?>
<html>
    <style>
        .container{
            width: 800px;
            height: auto;
            margin: auto;
            padding: auto;
            border: 2px solid black;
        }
        .header{
            width: 800px;
            height: auto;
            margin: auto;
            padding: auto;
            border: 2px solid black;
        }
        .contents{
            width: 800px;
            height: auto;
            margin: auto;
            padding: auto;
            border: 2px solid black;
        }
        .foot{
            width: 800px;
            height: auto;
            margin: auto;
            padding: auto;
            border: 2px solid black;
        }
    </style>
    <body>
        <div>Your Invitation for "<?php echo $_SESSION['name'];?>":</div>
        <div class="container">
        <div class='head'><?php echo $head;?></div>
        <div class='main'><?php echo $contents;?></div>
        <div class='foot'><?php echo $foot;?></div>
        </div>
        <div><button onclick="window.open('moreinvites.php','_self')">Invite more</button></div>
</html>
