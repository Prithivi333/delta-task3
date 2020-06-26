<?php
session_start();
include "database.php";
include "navbar.php";
if (isset($_POST['submit'])) {
    $sql="select * from status where EID='".$_SESSION['eid']."'";
    $res=$db->query($sql);
    $searchq = $_POST['search'];
    $searchq = preg_replace("#[^0-9a-z]#i", "", $searchq);
    $sqlq = "select * from users where Uname like '%" . $searchq . "%' and not Uname='".$_SESSION['Uname']."'";
    $result = $db->query($sqlq);
    while($r=$res->fetch_assoc()){
        //echo"chk";
    if ($result->num_rows > 0) {
        if($r['Status']!=null || $r['Status']!=""){
            global $data;
            $data=json_decode($r['Status']);
            foreach($data as $name=>$stat){
        while ($info = $result->fetch_assoc()) {
            //print_r($info);
                    if($name!==$info['Uname']){
                echo "<div class='links'>" . $info['Uname'] . "<br>
              <button class='select' id='" . $info['Uname'] . "'onclick=\"select(this.id)\"'>Select</button></div>";
                }
                
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
        $row=$db->query($qry);
        while($info=$row->fetch_assoc()){
            if (isset($n[$i])) {
                $stat[$n[$i]] = "false";
                $i += 1;
                $json = json_encode($stat);
                $qry = $db->prepare("insert into status (EID,Ename,Status) values(?,?,?)");
                $qry->bind_param("iss", $_SESSION['eid'], $_SESSION['name'], $json);
                $chk = $qry->execute();
            }
        }
    }
    if($chk){
        echo "<div id='ilink'>Done!!<br><button id='Ilink' onclick=\"link()\">Get Link!</button></div>";
    }
}
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
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
    <div id="popup">
        <div id="header">Link for the attendee</div>
        <span id="close">&times;</span>
        <input type="text" readonly value="http://localhost/party/ainvites.php?ename=<?php echo $_SESSION['name']?>" id="copytxt"><button onclick="copy()">Copy to clipboard</button>
    </div>
    <script>
    function select(name) {
        document.getElementById("form").innerHTML +="<input name=\"n[]\" value='"+name+"' readonly></input><br>";
        document.getElementById(name).style.display='none';

    }
    function link() {
        var box = document.getElementById('popup');
        var close = document.getElementById('close');
        var btn = document.getElementById('Ilink');
        btn.onclick = function() {
            box.style.display = "block";
            //document.body.setAttribute('class','blur');
        }
        close.onclick = function() {
            box.style.display = "none";
            //document.body.setAttribute('class',null);
        }
        window.onclick = function(event) {
            if (event.target == box) {
                box.style.display = "none";
                //document.body.setAttribute('class',null);
            }
        }
    }

    function copy() {
        var copytxt = document.getElementById("copytxt");
        copytxt.select();
        document.execCommand("copy");
        alert("Copied the link: " + copytxt.value);
    }
</script>
</html>
