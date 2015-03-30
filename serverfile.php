
<?PHP

/* This file is to be placed on the server to store and send the data being used to control the screen
 *
 * All Code by Matt DePero
 */

header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");



	// Ensure file exists by opening it, if not initialize it with no users
	$myfile = fopen("data.txt", "a+") or die("Unable to open file!");
	if(filesize("data.txt") == 0){
		// Initialize file with current date
		fwrite($myfile, date("D M jS")."|");
	}
	fclose($myfile);



	// Check if it is a new day (first line is list of dates). If it's a new day, add that day to the list of dates and also add a 0 to each user for that day.
	$myfile = fopen("data.txt", "r") or die("Unable to open file!");
	$alldata = fread($myfile,filesize("data.txt"));
	fclose($myfile);
	$lines = explode("*end*",$alldata,-1);
	$dates = explode("|",$lines[0],-1);
	if($dates[sizeof($dates)-1]==date("D M jS")){
		// Not a new date, just new user checking in
	}else{
		// New date, add new date and add a zero (not checked in) for all users on that date
		$myfile = fopen("data.txt", "r") or die("Unable to open file!");
		$alldata = fread($myfile,filesize("data.txt"));
		fclose($myfile);
		$lines = explode("*end*",$alldata,-1);
		$myfile = fopen("data.txt", "w") or die("Unable to open file!");
		foreach($lines as $key => $value){
			if($key == 0)
				fwrite($myfile, $value.date("D M jS")."|*end*");
			else
				fwrite($myfile, $value."|0*end*");
		}
		fclose($myfile);
	}


	// Set User Data. Either add a new user (checked in for today) or check in a current user for today
	if(isset($_REQUEST['newuser'])){


	}else{
		// Make sure they are not in the system, if they aren't in the system, return "no user" so the user end knows to add a first name, last name, and email
		$myfile = fopen("data.txt", "r") or die("Unable to open file!");
		$alldata = fread($myfile,filesize("data.txt"));
		fclose($myfile);
		if(str_replace($_REQUEST['set'],"",$alldata) == $alldata){
			// User doesn't exist, return "no user" saying the client needs to create an account
			echo "no user";
		}else{
			// Find user and mark the last available bit as checked in
			$lines = explode("*end*",$alldata,-1);
			foreach($lines as $key => $value){
				if(str_replace($_REQUEST['set'],"",$value) != $value){
					$lines[$key] = substr($lines[$key], 0, -3)."1*end*";
				}
			}
			$myfile = fopen("data.txt", "w") or die("Unable to open file!");
			foreach($lines as $key => $value){
				fwrite($myfile, $value);
			}
			fclose($myfile);
		}

	}




if(isset($_REQUEST['set'])){


}

if(isset($_REQUEST['get'])){
	$myfile = fopen("data.txt", "r") or die("Unable to open file!");
	echo fread($myfile,filesize("data.txt"));
	fclose($myfile);
}


?>