<?php
include "database.php";
include "navbar.php";
session_start();
if (isset($_POST['submit'])) {
    $searchq = $_POST['search'];
    $searchq = preg_replace("#[^0-9a-z]#i", "", $searchq);
    $sql = "select * from users where Uname like '%" . $searchq . "%' and not Uname='" . $_SESSION['Uname'] . "'";
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
if (isset($_POST['done'])) {
    $n = $_POST['n'];
    $i = 0;
    while ($i < count($n)) {
        $qry = "select * from events where Uname='" . $_SESSION['Uname'] . "'";
        $r = $db->query($qry);
        while ($info = $r->fetch_assoc()) {
            if (isset($n[$i])) {
                $status[$n[$i]] = "false";
                $i += 1;
            }
        }
    }
    $json = json_encode($status);
    $qry = $db->prepare("insert into status (EID,Ename,Status) values(?,?,?)");
    $qry->bind_param("iss", $_SESSION['eid'], $_SESSION['name'], $json);
    $chk = $qry->execute();
    if ($chk) {
        echo "<div id='ilink'>Done!!<br><button id='Ilink' onclick=\"link()\">Get Link!</button></div>";
    }
}
?><html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Invite</title>
</head>
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
    <div id="popup">
        <div id="header">Link for the attendee</div>
        <span id="close">&times;</span>
        <input type="text" value="http://localhost/party/ainvites.php?ename=<?php echo $_SESSION['name']?>" id="copytxt"><button onclick="copy()">Copy to clipboard</button>
    </div>
</body>
<script>
    function select(name) {
        document.getElementById("form").innerHTML += "<input name=\"n[]\" value='" + name + "' readonly></input><br>";
        document.getElementById(name).style.display = 'none';

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
