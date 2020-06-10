<?php
include "database.php";
include "navbar.php";
$enamevar=$_GET['msg'];
$sql="select * from events where Ename='".$enamevar."'";
$res=$db->query($sql);
$r=$res->fetch_assoc();
$info=json_decode($r['Econtent']);
$head=$info->header;
$contents=$info->body;
$foot=$info->footer;
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
        <div>Your Invitation for "<?php echo $enamevar;?>":</div>
        <div class="container">
        <div class='head'><?php echo $head;?></div>
        <div class='main'><?php echo $contents;?></div>
        <div class='foot'><?php echo $foot;?></div>
        </div>
        <a href='invite.php'>Click here to search and send invites</a>
    </body>
</html>