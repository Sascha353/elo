<!doctype html>
<html>
<head>
<title>EloRating</title>
</head>

<body>

<header class="header" id="head">Elo Calculator</header>
<br>
<br>
<SCRIPT LANGUAGE="JavaScript"><!--
function enable_form1() {

if(document.form.player2.checked)
{
document.form.rating_player2_solo.disabled=false;
document.form.rating_player2_team.disabled=false;
}

else
{
document.form.rating_player2_solo.disabled=true;
document.form.rating_player2_team.disabled=true;
}
}

//-->
</SCRIPT>

<SCRIPT LANGUAGE="JavaScript"><!--
function enable_form2() {

if(document.form.player4.checked)
{
document.form.rating_player4_solo.disabled=false;
document.form.rating_player4_team.disabled=false;
}

else
{
document.form.rating_player4_solo.disabled=true;
document.form.rating_player4_team.disabled=true;
}
}

//-->
</SCRIPT>

<form action="" method="POST" name="form">
  <p> Range:
    <input id="range" name="range" type="text" value="4000">
    Factor:
    <input id="factor" name="factor" type="text" value="5">
    <br>
    <br>
<table>
    <thead>
        <tr>
            <th>Player</th>
            <th>Played</th>
            <th>Solo rating</th>
            <th>Team rating</th>
            <th>Goals</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Player 1</td>
            <td><input type="checkbox" name="player1" value="played" checked disabled></td>
            <td><input id="rating_player1_solo" name="rating_player1_solo" type="text" value="1000"></td>
            <td><input id="rating_player1_team" name="rating_player1_team" type="text" value="1000"></td>
            <td><select id="goals1" name="goals1">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				</select></td>
        </tr>
        <tr>
            <td>Player 2</td>
            <td><input type="checkbox" onclick="enable_form1()" name="player2" value="ON"></td>
            <td><input id="rating_player2_solo" name="rating_player2_solo" type="text" value="" disabled></td>
            <td><input id="rating_player2_team" name="rating_player2_team" type="text" value="" disabled></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Player 3</td>
            <td><input type="checkbox" name="player3" value="played" checked disabled></td>
            <td><input id="rating_player3_solo" name="rating_player3_solo" type="text" value="1000"></td>
            <td><input id="rating_player3_team" name="rating_player3_team" type="text" value="1000"></td>
            <td><select id="goals2" name="goals2">
      			<option value="1">1</option>
     			<option value="2">2</option>
      			<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				</select></td>
        </tr>
        <tr>
            <td>Player 4</td>
            <td><input type="checkbox" onclick="enable_form2()" name="player4" value="played"></td>
            <td><input id="rating_player4_solo" name="rating_player4_solo" type="text" value="" disabled></td>
            <td><input id="rating_player4_team" name="rating_player4_team" type="text" value="" disabled></td>
        </tr>
    </tbody>
</table>
  </p>
<input type="submit"/>
</form>
<?php

    if ($_SERVER['REQUEST_METHOD']=='POST') 
    {
		$player2 = $_POST['player2'];
		$player4 = $_POST['player4'];
		$range = $_POST['range'];
		$factor = $_POST['factor'];
		$rating_player1_solo = $_POST['rating_player1_solo'];
		$rating_player1_team = $_POST['rating_player1_team'];
		$rating_player2_team = $_POST['rating_player2_team'];
		$rating_player3_solo = $_POST['rating_player3_solo'];
		$rating_player3_team = $_POST['rating_player3_team'];
		$rating_player4_team = $_POST['rating_player4_team'];
		$goals1 = $_POST['goals1'];
		$goals2 = $_POST['goals2'];

		/* #1 solo or team winrate */
		if(isset($_POST["player2"])) {
			/* winrate team 1*/
			$rating_team1 = ($rating_player1_team + $rating_player2_team) / 2;
			/* #2 solo or team */
			if(isset($_POST["player4"])) {
				/*  winrate team 2*/
       			$rating_team2 = ($rating_player3_team + $rating_player4_team) / 2;
				/* expected winrate Team 1 */
				$rate_team1 = 1 / (1+ pow(10, (($rating_team2 - $rating_team1) / $range)));
			} else {
				/* expected winrate Team 1 */
				$rate_team1 = 1 / (1+ pow(10, (($rating_player3_solo - $rating_team1) / $range)));
			}
     	} else {
			if(isset($_POST["player4"])) {
				/*  winrate team 2*/
       			$rating_team2 = ($rating_player3_team + $rating_player4_team) / 2;
				/* expected winrate Team 1 */
        		$rate_player1 = 1 / (1+ pow(10, (($rating_team2 - $rating_player1_solo) / $range)));
			} else {
				/* expected winrate Player 1 */
        		$rate_player1 = 1 / (1+ pow(10, (($rating_player3_solo - $rating_player1_solo) / $range)));
			}
		}
		
		/* #2 solo or team winrate */
		if(isset($_POST["player4"])) {
			/* winrate team 2*/
			$rating_team2 = ($rating_player3_team + $rating_player4_team) / 2;
			/* #2 solo or team */
			if(isset($_POST["player2"])) {
				/*  winrate team 2*/
       			$rating_team1 = ($rating_player1_team + $rating_player2_team) / 2;
				/* expected winrate Team 2 */
				$rate_team2 = 1 / (1+ pow(10, (($rating_team1 - $rating_team2) / $range)));
			} else {
				/* expected winrate Team 2 */
				$rate_team2 = 1 / (1+ pow(10, (($rating_player1_solo - $rating_team2) / $range)));
			}
     	} else {
			if(isset($_POST["player2"])) {
				/*  winrate team 2*/
       			$rating_team1 = ($rating_player1_team + $rating_player2_team) / 2;
				/* expected winrate Team 2 */
				$rate_player3 = 1 / (1+ pow(10, (($rating_team1 - $rating_player3_solo) / $range)));
			} else {
				/* expected winrate Player 3 */
        		$rate_player3 = 1 / (1+ pow(10, (($rating_player1_solo - $rating_player3_solo) / $range)));
			}
		}
		
		/* #1 expected goals */
		if(isset($_POST["player2"])) {
			
			if(isset($_POST["player4"])) {
				if ($rate_team1 > $rate_team2) {
					$exp_goals1 = 10;
				} elseif ($rating_team1 > $rating_team2) {
					$exp_goals1 = round ((10/$rate_team1) * $rate_team2, 2);
				} else {
					$exp_goals1 = round ((10/$rate_team2) * $rate_team1, 2);
				}
			} else {
				if ($rate_team1 > $rate_player3) {
					$exp_goals1 = 10;
				} elseif ($rating_team1 > $rating_player3_solo) {
					$exp_goals1 = round ((10/$rate_team1) * $rate_player3, 2);
				} else {
					$exp_goals1 = round ((10/$rate_player3) * $rate_team1, 2);
				}
			}
     	} else {
			if(isset($_POST["player4"])) {
				if ($rate_player1 > $rate_team2) {
					$exp_goals1 = 10;
				} elseif ($rating_player1_solo > $rating_team2) {
					$exp_goals1 = round ((10/$rate_player1) * $rate_team2, 2);
				} else {
					$exp_goals1 = round ((10/$rate_team2) * $rate_player1, 2);
				}
			} else {
				if ($rate_player1 > $rate_player3) {
					$exp_goals1 = 10;
				} elseif ($rating_player1_solo > $rating_player3_solo) {
					$exp_goals1 = round ((10/$rate_player1) * $rate_player3, 2);
				} else {
					$exp_goals1 = round ((10/$rate_player3) * $rate_player1, 2);
				}
			}
		}

		/* Expected goals Player 3 */	
			if(isset($_POST["player4"])) {
			
			if(isset($_POST["player2"])) {
				if ($rate_team2 > $rate_team1) {
					$exp_goals2 = 10;
				} elseif ($rating_team2 > $rating_team1) {
					$exp_goals2 = round ((10/$rate_team2) * $rate_team1, 2);
				} else {
					$exp_goals2 = round ((10/$rate_team1) * $rate_team2, 2);
				}
			} else {
				if ($rate_team2 > $rate_player1) {
					$exp_goals2 = 10;
				} elseif ($rating_team2 > $rating_player1_solo) {
					$exp_goals2 = round ((10/$rate_team2) * $rate_player1, 2);
				} else {
					$exp_goals2 = round ((10/$rate_player1) * $rate_team2, 2);
				}
			}
     	} else {
			if(isset($_POST["player2"])) {
				if ($rate_player3 > $rate_team1) {
					$exp_goals2 = 10;
				} elseif ($rating_player3_solo > $rating_team1) {
					$exp_goals2 = round ((10/$rate_player3) * $rate_team1, 2);
				} else {
					$exp_goals2 = round ((10/$rate_team1) * $rate_player3, 2);
				}
			} else {
				if ($rate_player3 > $rate_player1) {
					$exp_goals2 = 10;
				} elseif ($rating_player3_solo > $rating_player1_solo) {
					$exp_goals2 = round ((10/$rate_player3) * $rate_player1, 2);
				} else {
					$exp_goals2 = round ((10/$rate_player1) * $rate_player3, 2);
				}
			}
		}
			
		/* Expected differenz */
		if ($exp_goals1 > $exp_goals2) {
			$exp_diff = $exp_goals1 - $exp_goals2;
		} else {
			$exp_diff = $exp_goals2 - $exp_goals1;
		}
		
		/* #1 points player or team  */
		if(isset($_POST["player2"])) {
			if ($goals1 > $goals2) {
				$points_team1 = round (($exp_diff - ($goals2 - $goals1)) * $factor);
			} else {
				$points_team1 = round ((($exp_diff - ($goals1 - $goals2)) * -1) * $factor);
			}
     	} else {
			if ($goals1 > $goals2) {
				$points_player1 = round (($exp_diff - ($goals2 - $goals1)) * $factor);
			} else {
				$points_player1 = round ((($exp_diff - ($goals1 - $goals2)) * -1) * $factor);
			}
		}
				
		/* #2 points player or team */
		if(isset($_POST["player4"])) {
			if ($goals2 > $goals1) {
				$points_team2 = round (($exp_diff - ($goals1 - $goals2)) * $factor);
			} else {
				$points_team2 = round ((($exp_diff - ($goals2 - $goals1)) * -1) * $factor);
			}	
     	} else {
				if ($goals2 > $goals1) {
				$points_player3 = round (($exp_diff - ($goals1 - $goals2)) * $factor);
			} else {
				$points_player3 = round ((($exp_diff - ($goals2 - $goals1)) * -1) * $factor);
			}	
		}
		
		/* #1 new rating player or team */
		if(isset($_POST["player2"])) {
			$new_rating_player1_team = $rating_player1_team + $points_team1;
			$new_rating_player2_team = $rating_player2_team + $points_team1;
     	} else {
			$new_rating_player1_solo = $rating_player1_solo + $points_player1;
		}
		
		/* #2 new rating player or team */
		if(isset($_POST["player4"])) {
			$new_rating_player3_team = $rating_player3_team + $points_team2;
			$new_rating_player4_team = $rating_player4_team + $points_team2;
     	} else {
			$new_rating_player3_solo = $rating_player3_solo + $points_player3;
		}
		// print this to html source, use "." (dot) for append text to another text/variable
    }
?>

<table border="1">
    <thead>
        <tr>
            <th>Player</th>
            <th>Solo rating</th>
            <th>Team rating</th>
            <th>Goals</th>
            <th>Expexted Winrate</th>
            <th>Expexted Goals</th>
            <th>Gained Points</th>
            <th>New solo rating</th>
            <th>New team rating</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo "Player 1" ?></td>
            <td><?php echo $rating_player1_solo ?></td>
            <td><?php echo $rating_player1_team ?></td>
            <td><?php echo $goals1 ?></td>
            <td><?php echo sprintf("%.2f%%", $rate_player1 * 100) ?></td>
            <td><?php echo $exp_goals1 ?></td>
            <td><?php echo $points_player1 ?></td>
            <td><?php echo $new_rating_player1_solo ?></td>
            <td><?php echo $new_rating_player1_team ?></td>
        </tr>
        <tr>
            <td><?php echo "Player 2" ?></td>
            <td><?php echo $rating_player2_solo ?></td>
            <td><?php echo $rating_player2_team ?></td>
            <td><?php echo $goals1 ?></td>
            <td><?php echo sprintf("%.2f%%", $rate2 * 100) ?></td>
            <td><?php echo $exp_goals1 ?></td>
            <td><?php echo "" ?></td>
            <td><?php echo $new_rating2s ?></td>
            <td><?php echo $new_rating_player2_team ?></td>
        </tr>
        <tr>
            <td><?php echo "Team 1" ?></td>
            <td><?php echo "" ?></td>
            <td><?php echo $rating_team1 ?></td>
            <td><?php echo $goals1 ?></td>
            <td><?php echo sprintf("%.2f%%", $rate_team1 * 100) ?></td>
            <td><?php echo $exp_goals1 ?></td>
            <td><?php echo $points_team1 ?></td>
            <td><?php echo "" ?></td>
            <td><?php echo "" ?></td>
        </tr>
        <tr>
            <td><?php echo " " ?></td>
            <td><?php echo " " ?></td>
            <td><?php echo " " ?></td>
            <td><?php echo " " ?></td>
            <td><?php echo " " ?></td>
            <td><?php echo " " ?></td>
            <td><?php echo " " ?></td>
            <td><?php echo " " ?></td>
            <td><?php echo " " ?></td>
        </tr>
        <tr>
            <td><?php echo "Player 3" ?></td>
            <td><?php echo $rating_player3_solo ?></td>
            <td><?php echo $rating_player3_team ?></td>
            <td><?php echo $goals2 ?></td>
            <td><?php echo sprintf("%.2f%%", $rate_player3 * 100) ?></td>
            <td><?php echo $exp_goals2 ?></td>
            <td><?php echo $points_player3 ?></td>
            <td><?php echo $new_rating_player3_solo ?></td>
            <td><?php echo $new_rating_player3_team ?></td>
        </tr>
        <tr>
            <td><?php echo "Player 4" ?></td>
            <td><?php echo $rating4s ?></td>
            <td><?php echo $rating_player4_team ?></td>
            <td><?php echo $goals2 ?></td>
            <td><?php echo sprintf("%.2f%%", $rate4 * 100) ?></td>
            <td><?php echo $exp_goals2 ?></td>
            <td><?php echo "" ?></td>
            <td><?php echo $new_rating4s ?></td>
            <td><?php echo $new_rating_player4_team ?></td>
        </tr>
        <tr>
            <td><?php echo "Team 2" ?></td>
            <td><?php echo "" ?></td>
            <td><?php echo $rating_team2 ?></td>
            <td><?php echo $goals2 ?></td>
            <td><?php echo sprintf("%.2f%%", $rate_team2 * 100) ?></td>
            <td><?php echo $exp_goals2 ?></td>
            <td><?php echo $points_team2 ?></td>
            <td><?php echo "" ?></td>
            <td><?php echo "" ?></td>
        </tr>
    </tbody>
</table>

<table border="1">
    <thead>
        <tr>
            <th>Expected difference</th>
            <th>Range</th>
            <th>Factor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $exp_diff ?></td>
            <td><?php echo $range ?></td>
            <td><?php echo $factor ?></td>
        </tr>
    </tbody>
</table>

</body>
</html>