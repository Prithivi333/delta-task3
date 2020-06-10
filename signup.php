<?php
    //$db=new mysqli("localhost","root","","party");
    include "database.php";
    if(!$db)
	{
		echo "failed to connect with database";
    }
    if(isset($_POST['create'])){
        $existing="select * from users where Uname='{$_POST["newuname"]}' and Upwd='{$_POST["newupwd"]}'";
        $res=$db->query($existing);
        if($res->num_rows>0){
            echo "<div>Existing user!!</div>";
        }
        else{
        $newuname=$_POST['newuname'];
        $newupwd=$_POST['newupwd'];
        $entry=$db->prepare("insert into users (Uname,Upwd) values(?,?)");
        $entry->bind_param("ss",$newuname,$newupwd);
        $chk=$entry->execute();
        if($chk){
        echo "New Entry created successfully!";
       // echo "<script>document.getElementsByClassName('log').visibility='hidden';</script>";
       // echo "<script>console.log(document.getElementsByClassName('log').visibility);</script>";
        echo "<a href=index.php>Click here to login</a>";
        }
    }
}
?>
<link rel="stylesheet" type="text/css" href="css/style.css">
<div class="log">
<form method="post" action='<?php echo $_SERVER["PHP_SELF"];?>'>
        <label>Enter your full Name:</label><br>
        <input type="text" name="newuname" required class="input"><br>
        <label>Create your Password:</label><br>
        <input type="password" name="newupwd" required class="input"><br>
        <button type="submit" name="create">Create</button>
</form>
</div>