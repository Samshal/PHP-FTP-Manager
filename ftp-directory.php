<?php
	require_once("ftp-connect.php");
	class ftp_directory extends connection
	{
		private static $_acceptedOptions = array("name", "goto", "display", "create", "delete");
		public function manipulate_directory($params, $others)
		{
			if (!self::isUsable($params) || !in_array($params, self::$_acceptedOptions))
			{
				return self::print_error("InvalidParameterException");
			}
			if ($params == "name")
			{
				return self::pwd();
			}
			else if ($params == "goto")
			{
				if (!self::isUsable($others))
				{
					return self::print_error("InvalidInstructionRequestException");
				}
				else
				{
					if (self::chdir($others))
					{
						return "Directory Change Successful";
					}
					else
					{
						return "We were unable to change the directory";
					}
				}
			}
			else if ($params == "display")
			{
				if (!self::isUsable($others))
				{
					return self::print_error("InvalidInstructionRequestException");
				}
				else
				{
					return self::nlist($others);
				}
			}
			else if ($params == "create")
			{
				if (!self::isUsable($others))
				{
					return self::print_error("InvalidInstructionRequestException");
				}
				else
				{
					if (self::mkdir($others))
					{
						return "$others created successfully";
					}
					else
					{
						return "We Could Not Create The Directory: $others";
					}
				}
			}
			else if ($params == "delete")
			{
				if (!self::isUsable($others))
				{
					return self::print_error("InvalidInstructionRequestException");
				}
				else
				{
					if (self::rmdir($others))
					{
						return "$others deleted successfully";
					}
					else
					{
						return "We Could Not Delete The Directory: $others";
					}
				}
			}
		}

		private function pwd()
		{
			return ftp_pwd($this->connection);
		}

		private function chdir($location)
		{
			if ($location == "true")
			{
				if (!ftp_cdup($this->connection))
				{
					return false;
				}
				else
				{
					return true;
				}
			}
			else
			{
				if (!ftp_chdir($this->connection, $location))
				{
					return false;
				}
				else
				{
					return true;
				}
			}
		}
		protected function nlist($location)
		{
			if (!ftp_nlist($this->connection, $location))
			{
				return "Unable to retrieve current directories files/folders";
			}
			else
			{
				return ftp_nlist($this->connection, $location);
			}
		}
		protected function mkdir($name)
		{
			if (!ftp_mkdir($this->connection, $name))
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		protected function rmdir($name)
		{
			if (!ftp_rmdir($this->connection, $name))
			{
				return false;
			}
			else
			{
				return true;
			}
		}
	}
?>