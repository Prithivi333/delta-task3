<?php
include "database.php";
session_start();
//echo "<script>console.log({$_SESSION['UID']});</script>";
?>
<!DOCTYPE html>
<html>

<head>
  <title>Event Planner</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    body{
      background-image: url('pics/hello.jpg');
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: 75% 100%;
      background-position: center;
    }
    html,body{
      height: 100%;
      width: 100%;
    }
    </style>
</head>

<body>
    <div class='log'>
      <?php
      if (isset($_POST["login"])) {
        $sql = "select * from users where Uname='{$_POST["Uname"]}' and Upwd='{$_POST["Upwd"]}'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
          $data = $result->fetch_assoc();
          $_SESSION["UID"] = $data["UID"];
          $_SESSION["Uname"] = $data["Uname"];
          echo "<script>window.open('home.php','_self');</script>";
        } else {
          echo "<div class='error'>Invalid credentials</div>";
        }
      }
      if (isset($_GET["mes"])) {
        echo "<div class='error'>{$_GET['mes']}</div>";
      }
      ?>
      <form method="post" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>'>
        <label>User Name</label><br>
        <input type="text" name="Uname" required class="input"><br>
        <label>Password</label><br>
        <input type="password" name="Upwd" required class="input"><br>
        <button type="submit" name="login">Login</button>
      </form>
      <p class="txt">New user? Sign up here:</p><button type="submit" name="signup" onclick="window.open('signup.php','_self')">Sign UP</button>
    </div>

</body>

</html>
