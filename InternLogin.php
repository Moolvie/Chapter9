<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/1999/xhtml">
<html>
<head>
	<title>Intern Registration</title>
<head>
<body>
<h1>College Internship</h1>
<h2>Intern Registration</h2>
<?php
$errors = 0;
$email = "";
if (empty($_POST['email'])) {
	++$errors;
	echo "<p>You need to enter an e-mail address.</p>\n";
}
else {
     $email = stripslashes($_POST['email'];
     if (preg_match("/^[\w-]+(\.[\w-]+)*@" .
	"[\w-]+(\.[\w-]+)*(\.[a-zA-Z\{2, })$/i" .
	$email) == 0) {
	++$errors;
	echo "<p>You need to enter a valid " .
		"e-mail address.</p>\n";
	$email = "";
     }
}
if (empty($_POST['password'])) {
	++$errors;
	echo "<p>You need to enter a password.</p>\n";
	$password = "";
}
else
	$password = stripslashes($_POST['password']);
if (empty($_POST['password2'})){
	++$errors;
	echo "<p>You need to enter a confirmation password.</p>\n";
	$password2 = "";
}
else 
	$password2 = stripslashes($_POST['password2']):
if ((!(empty($password))) && (!(empty($password2)))) {
	if (strlen($password) < 6) {
		++$errors;
		echo "<p>The password is too short.</p>\n";
		$password = "";
		$password2 = "";
	}
	if ($password <> $password2) {
		++$errors;
		echo "<p>The paswords do not match.</p>\n";
		$password = "";
		$password2 = "";
	}
}
?>
</body>
</html>
