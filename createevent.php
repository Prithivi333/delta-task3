<?php
include "database.php";
include "navbar.php";
session_start();
class content
{
    public $header;
    public $body;
    public $footer;
}
if (isset($_POST['createinvite'])){
    $n = $_POST['Ename'];
    $_SESSION['name'] = str_replace(' ', '', $n);
    $sql="select * from events where Ename='".$_SESSION['name']."'";
    $r=$db->query($sql);
    $name = $_SESSION['name'];
    echo "Create invites here for " . $name . "<br>";
    $sql="select * from events where Ename='".$name."'";
    $result=$db->query($sql);
    if($result->num_rows>0){
        echo "Sorry ,but there seems to be an event with the same name.Please try with different name of event or without special characters or space."; 
    }
    else{
        $uname=$_SESSION['Uname'];
        $info = new content();
        $info->header = $_POST["header"];
        $info->body = $_POST["body"];
        $info->footer = $_POST["footer"];
        $jinfo = json_encode($info);
        $qry = $db->prepare("insert into events (Uname,Ename,Econtent,Etype) values (?,?,?,?)");
        $qry->bind_param("ssss", $uname, $name, $jinfo,$_POST['newevent']);
        $chk = $qry->execute();
        if ($chk) {
            echo "Contents added to invitation successfully!!";
            $nqry = "select EID from events where Ename='" . $name."'";
            $res = $db->query($nqry);
            $data = $res->fetch_assoc();
            $_SESSION['eid'] = $data['EID'];
            echo "<a href='invite.php'>Click here to search and send invites</a>";
        } else {
            echo "unable to add contents";
        }
    }
}
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<form method="post" id="inviteform" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>'>
<label>Event:</label>
<select id="events" name="newevent" required class="input">
    <option value="Birthday Party">Bday party</option>
    <option value="Wedding">Wedding/Anniversary</option>
    <option value="Funeral">Funeral/Obituary</option>
    <option value="Other">Other</option>
</select>
<label>Event Name:</label><input type="text" name="Ename" required class="input"><br>
<label>Enter Header Text:(REQUIRED)</label><br>
    <input type="text" name="header" required class="input"><br>
    <label>Enter contents of footer:(OPTIONAL)</label><br>
    <input type="text" name="footer"><br>
    <label>Enter contents in body of the invitation:</label><br>
    <textarea rows="5" cols="50" name="body" form="inviteform">TEXT</textarea><br>
    <button name="createinvite">Create Invitation</button>
</form>
</body>
</html>
