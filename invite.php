<?php
include "database.php";
include "navbar.php";
session_start();
class Status{
    public function create($name,$stat){
        $this->{$name}=$stat;
    }
}
$status=new Status();
if (isset($_POST['submit'])) {
    $searchq = $_POST['search'];
    $searchq = preg_replace("#[^0-9a-z]#i", "", $searchq);
    $sql = "select * from users where Uname like '%" . $searchq . "%' and not Uname='".$_SESSION['Uname']."'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while ($info = $result->fetch_assoc()) {
            echo "<div class='links'>" . $info['Uname'] . "<br>
              <button class='select' id='" . $info['Uname'] . "'onclick=\"select(this.id)\"'>Select</button></div>";
        }
    } else {
        echo "No users found";
    }
} else {
    echo "...";
}
if(isset($_POST['done'])){
    $n=$_POST['n'];
    $i=0;
    while($i<count($n)){
        echo $i."out";
        echo count($n);
        $qry="select * from events where Uname='".$_SESSION['Uname']."'";
        $r=$db->query($qry);
        while($info=$r->fetch_assoc()){
            echo $i."in";
            $status->create($n[$i],"false");
            $i+=1;

        }
    }
    $json=json_encode($status);
    
}
?><html>

<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Invite</title>
</head>
<style>
    .links {
        text-align: center;
        position: relative;
        display: inline-block;
    }

    .links button {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .links button:hover {
        display: block;
        background-color: #ddd;
    }
</style>

<body>
    <div class='log'>
        <form method="post" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>'>
            <label>Search for users to send invites here:</label><br>
            <input type="text" required class="input" name="search"><br>
            <button type="submit" name="submit">SEARCH</button>
        </form>
    </div>
    <fieldset>
    <legend>Selected users:</legend>
    <form method="post" id="form" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>'>
    </fieldset>
        <button name='done'>Send!!</button>
    </form>
</body>
<script>
    function select(name) {
        document.getElementById("form").innerHTML +="<input name=\"n[]\" value='"+name+"' readonly></input><br>";
        document.getElementById(name).style.display='none';

    }
</script>

</html>