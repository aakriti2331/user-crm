<?php
ob_start();
session_start();
header('Cache-Control: no cache');
$session_id = session_id();

if($_SERVER['HTTP_HOST'] == 'localhost')
{
	$host = 'localhost';
	$username = 'root';
	$password = '';
	$dbName = 'crm';
}
else
{
	$host = 'localhost';
	$username = 'root';
	$password = 'djtklkl123tytrnja1212jln56';
	$dbName = 'masterro_crm';
}

$conn = new mysqli($host,$username,$password,$dbName);
$con=mysqli_connect($host,$username,$password,$dbName);
if($conn->connect_errno)
{
	echo $conn->connect_error;
}

$site_root = 'https://'.$_SERVER['HTTP_HOST'].'/user-crm/';

if(!isset($_SESSION['arabic']) && !isset($_SESSION['english']))
{
	$_SESSION['arabic'] = "";
	$_SESSION['english'] = 1;
	unset($_SESSION['arabic']);
}

function changelanguage($conn,$text1,$text2)
{
	if(isset($_SESSION['arabic']))
	{
		echo $text2;
	}
	else
	{
		echo $text1;
	}
}

if(isset($_SESSION['arabic'])) { $arabic = 'arabic_'; } else { $arabic =''; }


?>