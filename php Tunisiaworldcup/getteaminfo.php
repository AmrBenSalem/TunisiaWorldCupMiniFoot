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


if (isset($_POST['dt']))
{

$resultteam = $mysqli->query("SELECT id 
		FROM  `quickstart_bl_teams` WHERE t_name ='".$_POST['dt']."'");
$rowid = $resultteam->fetch_assoc();


$result=$mysqli->query("SELECT * 
FROM  `quickstart_bl_match` WHERE m_played = 1  AND ( team1_id = ".$rowid['id']." OR team2_id = ".$rowid['id'].")" );

$content ="";
// $actualdate =0;

$resultgr=$mysqli->query("SELECT g_id
FROM quickstart_bl_grteams
WHERE t_id = ".$rowid['id']." ORDER BY g_id ASC");
$rowgr = $resultgr->fetch_assoc();

$tab[1]= "A";
$tab[2]= "B";
$tab[3]= "C";
$tab[4]= "D";
$tab[5]= "E";
$tab[6]= "F";

$wins=0;
$draws=0;
$losses=0;
$goals=0;
$goalstaken=0;
$points=0;
$rank=0;
$group = $tab[$rowgr['g_id']];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    		if ($row['team1_id'] == $rowid['id'] )
    		{
    			if ($row['score1'] > $row['score2'])
    			{
    				$wins = $wins + 1;
    				$goals = $goals + $row['score1'];
    				$goalstaken = $goalstaken + $row['score2'];
    				$points = $points + 3;
    			} else if ( $row['score1'] < $row['score2'] ) {
    				$losses = $losses + 1 ;
    				$goals = $goals + $row['score1'];
    				$goalstaken = $goalstaken + $row['score2'];
    			} else if ( $row['score1'] == $row['score2']  ) {
    				$draws = $draws + 1;
    				$goals = $goals + $row['score1'];
    				$goalstaken = $goalstaken + $row['score2'];
    				$points = $points + 1;
    			}
    		} else if ( $row['team2_id'] == $rowid['id']  ) {
    			if ($row['score2'] > $row['score1'])
    			{
    				$wins = $wins + 1;
    				$goals = $goals + $row['score2'];
    				$goalstaken = $goalstaken + $row['score1'];
    				$points = $points + 3;
    			} else if ( $row['score2'] < $row['score1'] ) {
    				$losses = $losses + 1 ;
    				$goals = $goals + $row['score2'];
    				$goalstaken = $goalstaken + $row['score1'];
    			} else if ( $row['score1'] == $row['score2']	 ) {
    				$draws = $draws + 1;
    				$goals = $goals + $row['score2'];
    				$goalstaken = $goalstaken + $row['score1'];
    				$points = $points + 1;
    			}
    		}
	    }
    }

$content = ' <ul class="list list--inset">
                      <li class="list-item list--inset__item">
                        <div class="list-item__left overrided"> 
                            <div>Group</div>               
                        </div>

                        <div class="list-item__right overrided">
                            <div>'.$group.'</div>                 
                        </div>
                      </li>
      </ul>

          <ul class="list list--inset">
                      <li class="list-item list--inset__item">
                        <div class="list-item__left overrided"> 
                            <div>Wins</div>               
                        </div>

                        <div class="list-item__right overrided">
                            <div>'.$wins.'</div>                 
                        </div>
                      </li>
      </ul>
      <ul class="list list--inset">
                      <li class="list-item list--inset__item">
                        <div class="list-item__left overrided"> 
                            <div>Draws</div>               
                        </div>

                        <div class="list-item__right overrided">
                            <div>'.$draws.'</div>                 
                        </div>
                      </li>
      </ul>
      <ul class="list list--inset">
                      <li class="list-item list--inset__item">
                        <div class="list-item__left overrided"> 
                            <div>Losses</div>               
                        </div>

                        <div class="list-item__right overrided">
                            <div>'.$losses.'</div>                 
                        </div>
                      </li>
      </ul>
      <ul class="list list--inset">
                      <li class="list-item list--inset__item">
                        <div class="list-item__left overrided"> 
                            <div>Goals</div>               
                        </div>

                        <div class="list-item__right overrided">
                            <div>+'.$goals.'/-'.$goalstaken.'</div>                 
                        </div>
                      </li>
      </ul>
      <ul class="list list--inset">
                      <li class="list-item list--inset__item">
                        <div class="list-item__left overrided"> 
                            <div>Points</div>               
                        </div>

                        <div class="list-item__right overrided">
                            <div>'.$points.'</div>                 
                        </div>
                      </li>
      </ul>
      ';

      // <ul class="list list--inset">
      //                 <li class="list-item list--inset__item">
      //                   <div class="list-item__left overrided"> 
      //                       <div>Rank</div>               
      //                   </div>

      //                   <div class="list-item__right overrided">
      //                       <div>1</div>                 
      //                   </div>
      //                 </li>
      // </ul>

echo $content;

}
$mysqli->close();
?>