
		<?php
			function account_right_corner(String $redirect = "https://fractava.com" , $vorname){
			require_once $_SERVER['DOCUMENT_ROOT'] . "/Mobile_Detect.php";
			
			
			$detect = new Mobile_Detect;
			if($detect->isMobile() && !$detect->isTablet()){
				$fontsize = "50px";
				
				echo "<style>";
				echo ".login_corner_text{font-size: " . $fontsize . ";color: #ffffff;}";
				echo "</style>";
				
				echo "<div style = \"width:100%;display: flex;justify-content: center;flex-direction: column;text-align: center;\">";
			}else{
				$margin = "5px";
				
				echo "<style>";
				echo ".login_corner_text{font-size: 1em;color: #ffffff;}";
				echo "</style>";
			
				echo "<div style=\"position: absolute;text-align: center;font-family: 'timeburner';right: 5px;top: 5px;margin:0px;margin-top:" . $margin . ";\">";
			}
			
			
			
			
			if(is_checked_in()){
					echo "<p class = \"login_corner_text\">Hallo " . htmlentities($vorname) . "</p>";
					echo "<p class = \"login_corner_text\" style=\"line-height: 40%;margin:0px;\">";
					echo 	"<a class = \"login_corner_text\" href =\"https://fractava.com/account/settings.php?redirect=" . $redirect . "\">";
					echo 	"Einstellungen</a>";
					echo 	" | ";
					echo 	"<a class = \"login_corner_text\" href =\"https://fractava.com/account/logout.php?redirect=" . $redirect . "\">";
					echo 	"Logout</a>";
					echo "</p>";
				}else{
					echo "<p class = \"login_corner_text\">";
					echo "<a class = \"login_corner_text\" href =\"https://fractava.com/account/login.php?redirect=" . $redirect . "\">";
					echo "Login</a>";
					echo " | ";
					echo "<a class = \"login_corner_text\" href =\"https://fractava.com/account/register.php\">";
					echo "Registrieren</a>";
					echo "</p>";
				}
			echo "</div>";
			}
		?>

