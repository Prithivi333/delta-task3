<?php
session_start();
include "database.php";
include "navbar.php";
$sql="select * from events where Uname='".$_SESSION['Uname']."' and Ename='".$_SESSION['name']."'";
$res=$db->query($sql);
if (isset($_POST['submit'])) {
    $searchq = $_POST['search'];
    $searchq = preg_replace("#[^0-9a-z]#i", "", $searchq);
    $sql = "select * from users where Uname like '%" . $searchq . "%' and not Uname='".$_SESSION['Uname']."'";
    $result = $db->query($sql);
    while($r=$res->fetch_assoc()){
    if ($result->num_rows > 0) {
        if($r['Estatus']!=null || $r['Estatus']!=""){
            $data=json_decode($r['Estatus']);
            $GLOBALS['add']=$data;
             //print_r($data);
            print_r($GLOBALS['add']);
            foreach($GLOBALS['add'] as $name=>$stat){
        while ($info = $result->fetch_assoc()) {
            print_r($info);
                    if($name!==$info['Uname']){
                echo "<div class='links'>" . $info['Uname'] . "<br>
              <button class='select' id='" . $info['Uname'] . "'onclick=\"select(this.id)\"'>Select</button></div>";
                }
                else{echo "no";}
            }
        }
    }
}
    else {
        echo "No users found";
    }
}
}
 else {
    echo "...";
}
if(isset($_POST['done'])){
    $n=$_POST['n'];
    $i=0;
    while($i<count($n)){
        $qry="select * from events where Uname='".$_SESSION['Uname']."'";
        $r=$db->query($qry);
        while($info=$r->fetch_assoc()){
            if(isset($n[$i])){
            //echo $GLOBALS['add'];
            $GLOBALS['add']->{$n[$i]}="false";
            $i+=1;
            }
        }
    }
    $json=json_encode($add);
    $qry=$db->prepare("update events set Estatus = ? where Ename='".$_SESSION['name']."' and Uname='".$_SESSION['Uname']."'");   
    $qry->bind_param("s",$json);
    $chk=$qry->execute();
    if($chk){
        echo "Done!!";
    }
}
?>
<html>
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