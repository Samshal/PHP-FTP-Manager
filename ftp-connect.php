<?php
	abstract class connection
	{
		private static $_server;
		private static $_user;
		private static $_password;
		private static $_port;
		private static $ini_file = "parameters.ini";
		private static $_showErrors;
		public $connection;

		protected function print_error($exception)
		{
			die($exception);
		}
		protected function isUsable($tocheck)
		{
			if (empty($tocheck) || ($tocheck == ''))
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		private function parse_config_data()
		{
			$config_data = parse_ini_file(self::$ini_file); //retrieving configuration data from the file 'parameters.ini'
			if (!self::isUsable( $config_data["FTP_SERVER"]) || !self::isUsable($config_data["FTP_USER"]) || !self::isUsable($config_data["FTP_PASSWORD"]))
			{
				return self::print_error("EmptyDataException");
			}
			self::$_server = $config_data["FTP_SERVER"];
			self::$_port = $config_data["FTP_PORT"];
			self::$_user = $config_data["FTP_USER"];
			self::$_password = $config_data["FTP_PASSWORD"];
			self::$_showErrors = $config_data["SHOW_ERRORS"];
			return;
		}
		protected function _login()
		{
			if (!ftp_login($this->connection, self::$_user, self::$_password))
			{
				self::print_error("LoginErrorException");
			}
			else
			{
				return ftp_login($this->connection, self::$_user, self::$_password);
			}
		}
		public function __construct()
		{
			self::parse_config_data();
			error_reporting(self::$_showErrors);
			if (!self::isUsable(self::$_port))
			{
				if (ftp_connect(self::$_server))
				{
					$this->connection = ftp_connect(self::$_server);					
				}
				else
				{
					self::print_error("InvalidDataException");
				}
			}
			else
			{
				if (ftp_connect(self::$_server, self::$_port))
				{
					$this->connection = ftp_connect(self::$_server, self::$_port);					
				}
				else
				{
					self::print_error("InvalidDataException");
				}
			}
			return self::_login();
		}
	}
?>