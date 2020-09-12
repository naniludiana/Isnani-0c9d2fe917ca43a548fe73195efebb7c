<?php session_start();
include("../back-end/config.php");
$_SESSION['login']=="";
date_default_timezone_set('Asia/Jakarta');
$ldate=date( 'Y-m-d H:i:s', time () );
mysqli_query($con,"UPDATE userlog  SET logout = '$ldate' WHERE username = '".$_SESSION['login']."' ORDER BY id DESC LIMIT 1");
session_unset();
$_SESSION['errmsg']="You have successfully logout";
?>
<script language="javascript">
	document.location="index.php";
</script>