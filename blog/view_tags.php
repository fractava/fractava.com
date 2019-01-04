<?php
echo "<div style=\"margin: 0 auto;\">";
			echo "<table style=\"width:30%;margin: 0 auto;\">";
			echo "<tr>";
			if($row['tag1'] != 0){
				$tag1 = $row['tag1'];
				
				echo "<td>";
				echo "<div style=\"background-color: gray;border-radius: 10px;width: 100%;margin: 0 auto;\">";
					foreach ($pdo->query("SELECT id , name FROM Blog_tags WHERE id =" . $tag1) as $tag) {
						echo "<p style =\"font-family: 'timeburner';text-align: center;\">" . $tag["name"] . "</p>";
					}
				echo "</div>";
				echo "</td>";
			}
			if($row['tag2'] != 0){
				$tag2 = $row['tag2'];
				
				echo "<td>";
				echo "<div style=\"background-color: gray;border-radius: 10px;width: 100%;margin: 0 auto;\">";
					foreach ($pdo->query("SELECT id , name FROM Blog_tags WHERE id =" . $tag2) as $tag) {
						echo "<p style =\"font-family: 'timeburner';text-align: center;\">" . $tag["name"] . "</p>";
					}
				echo "</div>";
				echo "</td>";

			}
			if($row['tag3'] != 0){
				$tag3 = $row['tag3'];
				
				echo "<td>";
				echo "<div style=\"background-color: gray;border-radius: 10px;width: 100%;margin: 0 auto;\">";
					foreach ($pdo->query("SELECT id , name FROM Blog_tags WHERE id =" . $tag3) as $tag) {
						echo "<p style =\"font-family: 'timeburner';text-align: center;\">" . $tag["name"] . "</p>";
					}
				echo "</div>";
				echo "</td>";
			}
			echo "</tr>";
			echo "</table>";
			echo "</div>";
			echo "<br>";