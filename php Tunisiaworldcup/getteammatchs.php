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

$result=$mysqli->query("SELECT * 
FROM  `quickstart_bl_match` WHERE team1_id = ( SELECT id 
		FROM  `quickstart_bl_teams` WHERE t_name ='".$_POST['dt']."' ) OR team2_id = ( SELECT id 
		FROM  `quickstart_bl_teams` WHERE t_name ='".$_POST['dt']."' ) ORDER BY m_id ASC , m_date ASC");

$content ="";
$actualdate =0;


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	if ($row['m_date'] != $actualdate)
    	{
    		$content=$content.'</ul><ul class="list list--inset">
                      <li class="list-header list-header--material">
                        '.$row['m_date'].'
                      </li>';
            $actualdate = $row['m_date'];
    	}
    	$result1=$mysqli->query("SELECT t_name 
		FROM  `quickstart_bl_teams` WHERE id ='".$row['team1_id']."'");
		$row1 = $result1->fetch_assoc();
		$result2=$mysqli->query("SELECT t_name 
		FROM  `quickstart_bl_teams` WHERE id ='".$row['team2_id']."'");
		$row2 = $result2->fetch_assoc();

		if ($row['m_played'] == 0)
		{
	        $content=$content.'
	                      <li id="'.$row1["t_name"].'0'.$row2["t_name"].'" class="list-item list--inset__item  list-item--longdivider">
	                        <div class="list-item__left"> 
	                            <div class="team-right">'.$row1["t_name"].'</div>
	                            <img class="list-item__thumbnail resizeimg" src="img/flags/'.$row1["t_name"].'_round_icon_256.png">               
	                        </div>

	                        <div class="list-item__center text-date">
	                            <div class="score">-</div>
	                            <div class="time">'.$row["m_time"].'</div>
	                        </div>

	                        <div class="list-item__right">
	                            <img class="list-item__thumbnail resizeimg" src="img/flags/'.$row2["t_name"].'_round_icon_256.png">
	                            <div class="team-left">'.$row2["t_name"].'</div>                 
	                        </div>
	                      </li>';
	    }else {
	    	$content=$content.'
	                      <li id="'.$row1["t_name"].'0'.$row2["t_name"].'" class="list-item list--inset__item list-item--tappable list-item--longdivider" onclick="pushgame2(this)">
	                        <div class="list-item__left"> 
	                            <div class="team-right">'.$row1["t_name"].'</div>
	                            <img class="list-item__thumbnail resizeimg" src="img/flags/'.$row1["t_name"].'_round_icon_256.png">               
	                        </div>

	                        <div class="list-item__center text-date">
	                            <div class="score">'.$row["score1"].' - '.$row["score2"].'</div>
	                            <div class="time">'.$row["m_time"].'</div>
	                        </div>

	                        <div class="list-item__right">
	                            <img class="list-item__thumbnail resizeimg" src="img/flags/'.$row2["t_name"].'_round_icon_256.png">
	                            <div class="team-left">'.$row2["t_name"].'</div>                 
	                        </div>
	                      </li>';
	    }
    }
} else {
    echo "0 results";
}
$content=$content.'</ul>';
echo $content;

}

$mysqli->close();
?>