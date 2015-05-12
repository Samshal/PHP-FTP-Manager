<?php
	require_once("ftp.php");
	$myFtp = new ftp();
	//downloading a file from the ftp server
	$file = $myFtp->download("README.txt", "", FTP_ASCII);
	echo $file;
	//printing the name of the current working directory
	$nameOfCurrentDirectory = $myFtp->manipulate_directory("name", "");
	echo $nameOfCurrentDirectory;
	//printing the content (files and folders) of the current directory
	$content = $myFtp->manipulate_directory("display", ".");
	foreach ($content as $member)
	{
		echo $member."<br/>";
	}
	//changing the current directory to the public folder
	$change = $myFtp->manipulate_directory("goto", "/public");
	echo $change;
?>