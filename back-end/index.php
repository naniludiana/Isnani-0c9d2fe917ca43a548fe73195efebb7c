<?php session_start();
error_reporting(0);
include("../back-end/config.php");
if(isset($_POST['submit'])) {
  $_SESSION['submit']='';
}
if(isset($_POST['submit']))
{

  $ret=mysqli_query($con,"SELECT * FROM users WHERE userEmail='".$_POST['username']."' and password='".md5($_POST['password'])."'");
  $num=mysqli_fetch_array($ret);
  if($num>0)
  {
$extra="dashbord.php";//
$_SESSION['login']=$_POST['username'];
$_SESSION['id']=$num['id'];
$host=$_SERVER['HTTP_HOST'];
$uip=$_SERVER['REMOTE_ADDR'];
$status=1;
$log=mysqli_query($con,"insert into userlog(uid,username,userip,status) values('".$_SESSION['id']."','".$_SESSION['login']."','$uip','$status')");
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
else
{
  $_SESSION['login']=$_POST['username'];  
  $uip=$_SERVER['REMOTE_ADDR'];
  $status=0;
  mysqli_query($con,"insert into userlog(username,userip,status) values('".$_SESSION['login']."','$uip','$status')");
  $errormsg="Invalid username or password";
  $extra="login.php";
}
}

?>
<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" href="images/profile.gif">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="../front-end/css/main.css">
  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Example</title>
  <script type="text/javascript">
    function valid()
    {
      if(document.forgot.password.value!= document.forgot.confirmpassword.value)
      {
        alert("Password and Confirm Password Field do not match  !!");
        document.forgot.confirmpassword.focus();
        return false;
      }
      return true;
    }
  </script>
</head>
<body onload="initClock()">
  <section class="material-half-bg">
    <div class="cover">
    </div>
    
  </section>
  <section class="login-content">
    <div class="login-box">
     <p style="padding-left:20%; color:red">
      <?php if($errormsg){
        echo htmlentities($errormsg);
      }?>
    </p>
    <p style="padding-left:20%;  color:green">
      <?php if($msg){
        echo htmlentities($msg);
      }?></p>
      
      <form class="login-form" method="post">
        <a class="brand" href="../index.html">
          <div class="thumbnail"><center><img src="images/profile.gif" height="100"/></center></div></a><p/>
          <div class="form-group">
            <input class="form-control" name="username" type="text" placeholder="Email" autofocus>
          </div>
          <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="Password">
          </div>

          <div class="form-group btn-container">
            <button type="submit" name="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
          </div>
        </form>
      </div>
    </section>

    <div>
      <div>
        <button type="button">Hello</button>
      </div>
      <div>
        <form action="../back-end/index.php">
          <button type="submit">Registrasi</button>
        </form>
      </div>

      <!--digital clock start-->
      <div class="datetime">
        <div class="date">
          <span id="dayname">Day</span>,
          <span id="month">Month</span>
          <span id="daynum">00</span>,
          <span id="year">Year</span>
        </div>
        <div class="time">
          <span id="hour">00</span>:
          <span id="minutes">00</span>:
          <span id="seconds">00</span>
          <span id="period">AM</span>
        </div>
      </div>
    </div>
    <!--digital clock end-->

    <script type="text/javascript">
      function updateClock(){
        var now = new Date();
        var dname = now.getDay(),
        mo = now.getMonth(),
        dnum = now.getDate(),
        yr = now.getFullYear(),
        hou = now.getHours(),
        min = now.getMinutes(),
        sec = now.getSeconds(),
        pe = "AM";

        if(hou >= 12){
          pe = "PM";
        }
        if(hou == 0){
          hou = 12;
        }
        if(hou > 12){
          hou = hou - 12;
        }

        Number.prototype.pad = function(digits){
          for(var n = this.toString(); n.length < digits; n = 0 + n);
            return n;
        }

        var months = ["January", "February", "March", "April", "May", "June", "July", "Augest", "September", "October", "November", "December"];
        var week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var ids = ["dayname", "month", "daynum", "year", "hour", "minutes", "seconds", "period"];
        var values = [week[dname], months[mo], dnum.pad(2), yr, hou.pad(2), min.pad(2), sec.pad(2), pe];
        for(var i = 0; i < ids.length; i++)
          document.getElementById(ids[i]).firstChild.nodeValue = values[i];
      }

      function initClock(){
        updateClock();
        window.setInterval("updateClock()", 1);
      }
    </script>

    <!-- Essential javascripts for application to work-->
    <script src="../front-end/js/jquery-3.2.1.min.js"></script>
    <script src="../front-end/js/popper.min.js"></script>
    <script src="../front-end/js/bootstrap.min.js"></script>
    <script src="../front-end/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="../front-end/js/plugins/pace.min.js"></script>
  </body>
  </html>