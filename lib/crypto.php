<?php
#  lib for handling crypted passwords
#  Part of the web-cyradm project 
# 
#  See http://www.web-cyradm.org
#
#  Copyright (C) 2002 by Luc de Louw <luc@delouw.ch>
#
#  License: GNU GPL
#
class password{

	var $table;
	var $username;
	var $userinput;
	var $newpassword;
	var $encryption;

	var $checked;

	// Check if supplied password is valid

	function check($table, $username, $userinput, $encryption){
		include ("config.inc.php");
		include ("DB.php");

		switch ($encryption){
		case "crypt":

			/* First get the encrypted password out of the database to have the salt */

		        $query = "SELECT password FROM $table WHERE username ='$username'";
			$handle=DB::connect ($DSN,true);
	       		$result = $handle->query($query);
			$row=$result->fetchRow(DB_FETCHMODE_ASSOC, 0);
		
			$dbinput = $row['password'];

			// The salt used is the encrypted password
			print "<br>From DB: ".$dbinput."<br>";	
			print "userinput: ".crypt($userinput,$dbinput)."<p>";
	
			if ($dbinput == crypt($userinput,$dbinput)){
				return true;
			}
			else {
				return false;
			}

			break;		
		}
	}

	/* This function sets the new password without checking an old password.
	   If you use this function be sure to first check the old password supplied by the
	   user by doing: return =$pwd->check($table,$username,$userinput,$encryption);
	*/

	function update($table,$username,$newpassword,$encryption){
		include ("config.inc.php");

		switch ($encryption){
		case "crypt":

			// Encrypt the cleartext password supplied
			$newpassword=crypt($newpassword,substr($newpassword,0,2));
	
			$query="UPDATE $table SET password='$newpassword' WHERE username='$username'";
			$handle=DB::connect ($DSN,true);
			$result = $handle->query($query);
			
			if ($result){	
				print $newpassword;
				return true;
			}
			
		}
	}

	function encrypt($password,$encryption){
		switch ($encryption){
                case "crypt":
			$password=crypt($newpassword,substr($password,0,2));
			return $password;
		}
	}
		



}

?>
