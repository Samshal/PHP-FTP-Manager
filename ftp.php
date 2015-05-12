<?php
	require_once("ftp-directory.php");
	class ftp extends ftp_directory
	{
		public function download($file, $location, $mode)
		{
			if ($mode != "FTP_ASCII" || $mode != "FTP_BINARY")
			{
				$mode == "FTP_ASCII";
			}
			if (!self::isUsable($location))
			{
				$location = $file;
			}
			if (!self::isUsable($file))
			{
				return self::print_error("InvalidParameterException");
			}
			if (ftp_get($this->connection, $location, $file, $mode))
			{
				return "Download Successful. $file saved to $location";
			}
			else
			{
				return "Could Not Download Specified File";
			}
		}
	}
?>