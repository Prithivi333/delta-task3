<?php
session_start();
include "database.php";
$name = $_SESSION['name'];
echo "Create invites here for " . $name . "<br>";
class content
{
    public $header;
    public $body;
    public $footer;
}
if (isset($_POST['createinvite'])) {
    $sql="select * from events where Ename='".$name."'and Uname='".$_SESSION['Uname']."'";
    $result=$db->query($sql);
    if($result->num_rows>0){
        echo "Sorry ,but there seems to be an event with the same name.Please try with different name of event."; 
    }
    else{
        $uname=$_SESSION['Uname'];
        $info = new content();
        $info->header = $_POST["header"];
        $info->body = $_POST["body"];
        $info->footer = $_POST["footer"];
        $jinfo = json_encode($info);
        $qry = $db->prepare("insert into events (Uname,Ename,Econtent) values (?,?,?)");
        $qry->bind_param("sss", $uname, $name, $jinfo);
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
<form method="post" id="inviteform" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>'>
    <label>Enter Header Text:(REQUIRED)</label><br>
    <input type="text" name="header" required class="input"><br>
    <label>Enter contents of footer:(OPTIONAL)</label><br>
    <input type="text" name="footer"><br>
    <label>Enter contents in body of the invitation:</label><br>
    <textarea rows="5" cols="50" name="body" form="inviteform">TEXT</textarea><br>
    <button name="createinvite">Create Invitation</button>
</form>