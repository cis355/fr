<?php
/* ---------------------------------------------------------------------------
 * filename    : functions.php
 * author      : George Corser, gcorser@gmail.com
 * description : This class provides functions for rest of application 
 * ---------------------------------------------------------------------------
 */
class Functions {
	
	public function __construct() {
		exit('No constructor required for class: Functions');
	} 
	
	public static function dayMonthDate($dateval) {
		// receives $dateval in format: 2017-03-13
		// returns $dateval in format: Mon Mar-13
		// see: https://www.w3schools.com/php/func_date_date.asp
		$days = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
		$day = $days[date('w', strtotime($dateval))];
		$dateval = $day . ' ' . date('M-d', strtotime($dateval));
		return $dateval;
	} 
	
	public static function timeAmPm($timeval) {
		// receives $timeval in format: 00:00:00
		// returns $timeval in format: 00:00 am, or 00:00 pm
		if ($timeval < 12) // morning (am)
			$timeval = substr($timeval, 0, 5) . ' am';
		else { // noon-afternoon-evening (pm)
			$hour = substr($timeval,0,2);
			$hour = $hour - 12;
			if ($hour == 0) $hour = 12;
			if ($hour < 10) $hour = '0' . $hour;
			$timeval = $hour . substr($timeval,2,3) . ' pm';
		}
		return $timeval;
	}
	
	//function that will display the svsu logo on each page
	//logo css added to the bootstrap css
	public function logoDisplay() {
		echo '<div> ';
		echo '<img src="img/svsulogo.png" width="50%" class="logo" alt="SVSU logo"/>';
		echo '</div>';
	}
	
	public function logoDisplay2() {
		echo '<div> ';
		echo '<img src="img/svsulogo.png" width="50%" class="logo2" alt="SVSU logo"/>';
		echo '</div>';
	}
} // end class: Functions
?>