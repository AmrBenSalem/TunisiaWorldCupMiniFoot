<?php header("Access-Control-Allow-Origin: *"); ?>
<?php
$host = 'sql41.topnetpro.com';
$user = 'ftmf';
$password = 'EjJBRpSQXTHrKFdY';
$dbname = "ftmf_db";

// Create connection
$mysqli = new mysqli($host,$user,$password,$dbname);


// if ($mysqli->connect_error) {
//     die('Erreur de connexion (' . $mysqli->connect_errno . ') '
//             . $mysqli->connect_error);
// }
// echo "Connected successfully";


$result=$mysqli->query("SELECT quickstart_bl_teams.id,t_name, g_id
FROM quickstart_bl_teams, quickstart_bl_grteams
WHERE t_id = quickstart_bl_teams.id ORDER BY g_id ASC");


$tab[1]= "Group A";
$tab[2]= "Group B";
$tab[3]= "Group C";
$tab[4]= "Group D";
$tab[5]= "Group E";
$tab[6]= "Group F";

$content ='';
$actualgroup =0;
$first = 0;
$i=0;

// $teams;
// $ranking;

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$i++;
    	$wins=0;
		$draws=0;
		$losses=0;
		$goals=0;
		$goalstaken=0;
		$points=0;
		$rank=0;
		$group = $tab[$row['g_id']];
    	$resultmatch=$mysqli->query("SELECT * 
		FROM  `quickstart_bl_match` WHERE m_played = 1  AND ( team1_id = ".$row['id']." OR team2_id = ".$row['id'].")" );
		

		if ($resultmatch->num_rows > 0) {
    		while($rowm = $resultmatch->fetch_assoc()) {
    		if ($rowm['team1_id'] == $row['id'] )
    		{
    			if ($rowm['score1'] > $rowm['score2'])
    			{
    				$wins = $wins + 1;
    				$goals = $goals + $rowm['score1'];
    				$goalstaken = $goalstaken + $rowm['score2'];
    				$points = $points + 3;
    			} else if ( $rowm['score1'] < $rowm['score2'] ) {
    				$losses = $losses + 1 ;
    				$goals = $goals + $rowm['score1'];
    				$goalstaken = $goalstaken + $rowm['score2'];
    			} else if ( $rowm['score1'] == $rowm['score2']  ) {
    				$draws = $draws + 1;
    				$goals = $goals + $rowm['score1'];
    				$goalstaken = $goalstaken + $rowm['score2'];
    				$points = $points + 1;
    			}
    		} else if ( $rowm['team2_id'] == $row['id']  ) {
    			if ($rowm['score2'] > $rowm['score1'])
    			{
    				$wins = $wins + 1;
    				$goals = $goals + $rowm['score2'];
    				$goalstaken = $goalstaken + $rowm['score1'];
    				$points = $points + 3;
    			} else if ( $rowm['score2'] < $rowm['score1'] ) {
    				$losses = $losses + 1 ;
    				$goals = $goals + $rowm['score2'];
    				$goalstaken = $goalstaken + $rowm['score1'];
    			} else if ( $rowm['score1'] == $rowm['score2']	 ) {
    				$draws = $draws + 1;
    				$goals = $goals + $rowm['score2'];
    				$goalstaken = $goalstaken + $rowm['score1'];
    				$points = $points + 1;
    			}
    		}
	    	}
    	}
    	// $teams[$i]= $row['t_name'];
    	// $score[$i]= 







    	if ($row['g_id'] != $actualgroup)
    	{
    		if ($first == 1)
    		{
    			$content=$content.'</table>
			</ons-col>
		</ons-row>';
    		}

    		$content=$content.' <ons-row>
			<ons-col> <table class="tablerank"> <ul class="list list--inset">
					<li class="list-header list-header--material marginbotgroup">
                        '.$tab[$row['g_id']].'
                      </li>
				</ul> <tr class="th">
								  
								  <td class="td" colspan="2">
								  		<div class="centertitletab">Team</div>
								  </td>
								  <td class="td">
								  		<div class="centertitletab">Wins</div>
								  </td>
								  <td class="td">
								  		<div class="centertitletab">Losses</div>
								  </td>
								  <td class="td">
								  		<div class="centertitletab">Draws</div>
								  </td>
								  <td class="td">
								  		<div class="centertitletab">Points</div>
								  </td>
						</tr>';
            $actualgroup = $row['g_id'];
            $first = 1;
    	}
    	// <td class="td">
					// 			  		<div class="centertitletab">Rank</div>
					// 			  </td>


  //   	$result1=$mysqli->query("SELECT t_name 
		// FROM  `quickstart_bl_teams` WHERE id ='".$row['team1_id']."'");
		// $row1 = $result1->fetch_assoc();


	        $content=$content.'<tr>
								  
								  <td class="td tdsizeimg centertitletab">
								  		<img class="resizeimgtable" src="img/flags/'.$row['t_name'].'_round_icon_256.png">
								  </td>
								  <td class="td">
								  			'.$row['t_name'].'
								  </td>
								  <td class="td">
								  		<div class="centertitletab">'.$wins.'</div>
								  </td>
								  <td class="td">
								  		<div class="centertitletab">'.$losses.'</div>
								  </td>
								  <td class="td">
								  		<div class="centertitletab">'.$draws.'</div>
								  </td>
								  <td class="td">
								  		<div class="centertitletab">'.$points.'</div>
								  </td>
						</tr>';
	   
    }
} 

// <td class="td">
// 								  		<div class="centertitletab">2</div>
// 								  </td>
$content=$content.'</table>
			</ons-col>
		</ons-row>';
echo $content;

$mysqli->close();
?>