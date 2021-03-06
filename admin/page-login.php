<?php

session_start();

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE ){
	header("Location: dashboard.php");	
}
elseif(isset($_POST['submit']))
{
	include '../connections/db_connect.php' ;
	echo $user = $_POST['loginUsername'];
	echo $pass = md5($_POST['loginPassword']) ;

	$q = $db->prepare("SELECT id, username, password FROM admin WHERE username=?") OR die('query preparation failed');
	$q->bind_param('s',$user);
	$q->execute();

	$q->bind_result($id,$dbuser,$dbpass);

	$q->fetch();
	
	if($dbuser == $user && $dbpass == $pass){
		$_SESSION['user'] = $dbuser;
		$_SESSION['loggedin'] = TRUE;
		header("Location: index.php");
	}

	else{
		echo "<script> alert('Incorrect Login Credentials'); </script>";
		$_SESSION['loggedin'] = False;
		header("Refresh:1; url=page-login.html");
	}

	$q->free_result();
	$q->close();
	$db->close();
}
else{header('Location: page-login.html');}

?>