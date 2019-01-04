<?php
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/config.inc.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/account/inc/functions.inc.php");
	$user = check_user(true , "?redirect=http://fractava.com/admin/index.php");
	if($user["admin"] != "1"){
		die("Du bist kein Admin");
	}
?>
<?php
	switch($_GET["requested_data"]){
		case 0:
			//für alle Daten senden reserviert
			break;
		case 1:
			$stat1 = file('/proc/stat'); 
			sleep(1); 
			$stat2 = file('/proc/stat'); 
			$info1 = explode(" ", preg_replace("!cpu +!", "", $stat1[0])); 
			$info2 = explode(" ", preg_replace("!cpu +!", "", $stat2[0])); 
			$dif = array(); 
			$dif['user'] = $info2[0] - $info1[0]; 
			$dif['nice'] = $info2[1] - $info1[1]; 
			$dif['sys'] = $info2[2] - $info1[2]; 
			$dif['idle'] = $info2[3] - $info1[3]; 
			$total = array_sum($dif); 
			$cpu = array(); 
			foreach($dif as $x=>$y) $cpu[$x] = round($y / $total * 100, 1);
			echo(100 - $cpu['idle']);
			break;
		case 2:
			//Processor Informationen
			break;
		case 3:
			//Processor Temperatur
			$contents = file("/sys/class/thermal/thermal_zone2/temp");
			echo ((int)$contents[0])/1000;
			break;
		case 4:
			//RAM Total
			$fh = fopen('/proc/meminfo','r');
			$mem = 0;
			while ($line = fgets($fh)) {
				$pieces = array();
				if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
					$mem = $pieces[1];
					break;
				}
			}
			fclose($fh);
			echo $mem;
			break;
		case 5:
			//RAM Free
			$fh = fopen('/proc/meminfo','r');
			$mem = 0;
			while ($line = fgets($fh)) {
				$pieces = array();
				if (preg_match('/^MemFree:\s+(\d+)\skB$/', $line, $pieces)) {
					$mem = $pieces[1];
					break;
				}
			}
			fclose($fh);
			echo $mem;
			break;
		case 6:
			//SWAP Total
			$fh = fopen('/proc/meminfo','r');
			$mem = 0;
			while ($line = fgets($fh)) {
				$pieces = array();
				if (preg_match('/^SwapTotal:\s+(\d+)\skB$/', $line, $pieces)) {
					$mem = $pieces[1];
					break;
				}
			}
			fclose($fh);
			echo $mem;
			break;
		case 7:
			//SWAP Free
			$fh = fopen('/proc/meminfo','r');
			$mem = 0;
			while ($line = fgets($fh)) {
				$pieces = array();
				if (preg_match('/^SwapFree:\s+(\d+)\skB$/', $line, $pieces)) {
					$mem = $pieces[1];
					break;
				}
			}
			fclose($fh);
			echo $mem;
			break;
		case 8:
			$str   = @file_get_contents('/proc/uptime');
			$num   = floatval($str);
			$secs  = $num % 60;
			$num   = (int)($num / 60);
			$mins  = $num % 60;
			$num   = (int)($num / 60);
			$hours = $num % 24;
			$num   = (int)($num / 24);
			$days  = $num;

			var_dump(array(
				"days"  => $days,
				"hours" => $hours,
				"mins"  => $mins,
				"secs"  => $secs
			));
			break;
		case 9:
			//reservated for phpinfo
			//phpinfo();
			break;
	}
	
	
?>
