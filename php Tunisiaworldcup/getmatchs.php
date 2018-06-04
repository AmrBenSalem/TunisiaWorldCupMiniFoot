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


$result=$mysqli->query("SELECT * 
FROM  `quickstart_bl_match` ORDER BY m_id ASC , m_date ASC");

$content ="";
$actualdate =0;

$date1 = new DateTime("now");
$date1=$date1->format('Y-m-d');


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	
    	$date2 = new DateTime($row['m_date']);
    	$date2=$date2->format('Y-m-d');
		// $date2 = date('Y-m-d', strtotime($date2));


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

		

		$resultend = $mysqli->query("SELECT e_id 
        FROM  `quickstart_bl_match_events` WHERE e_id = 5 AND match_id = ".$row['id']);

        $resultc=$mysqli->query("SELECT * 
		FROM  `quickstart_bl_match`WHERE m_played = 1 ORDER BY m_id DESC ,m_time DESC, m_date DESC LIMIT 1");

		if ($resultc->num_rows > 0) {
		    // output data of each row
		    $rowc = $resultc->fetch_assoc();

		 }

		if (  ($resultend->num_rows > 0))
		{

			
				$content=$content.'
	                      <li id="'.$row1["t_name"].'0'.$row2["t_name"].'" class="list-item list--inset__item list-item--tappable list-item--longdivider" onclick="pushgame(this);">
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

	        
	            
	    } else if (($row['id'] == $rowc['id'])) {

	    	$content=$content.'
	                      <li id="'.$row1["t_name"].'0'.$row2["t_name"].'" class="list-item list--inset__item  list-item--longdivider">
	                        <div class="list-item__left"> 
	                            <div class="team-right">'.$row1["t_name"].'</div>
	                            <img class="list-item__thumbnail resizeimg" src="img/flags/'.$row1["t_name"].'_round_icon_256.png">               
	                        </div>

	                        <div class="list-item__center text-date">
	                            <div class="score"><img src="img/live/live.png" style="width: 45%;"></div>
	                            <div class="time">'.$row["m_time"].'</div>
	                        </div>

	                        <div class="list-item__right">
	                            <img class="list-item__thumbnail resizeimg" src="img/flags/'.$row2["t_name"].'_round_icon_256.png">
	                            <div class="team-left">'.$row2["t_name"].'</div>                 
	                        </div>
	                      </li>';

	    }
	    
		else {
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
	    }
    }
}
$content=$content.'</ul>';


// $content = $content . " <script> 
//                         setInterval(function() {
//                             $.ajax({
//                               type: 'POST',
//                               url: 'http://tunisia2017.com/phpapp/getlive.php'
//                               }).done(function( msg ) {
//                                   $('#contentlive').html(msg);
//                             });
//                         }, 5000);

// </script>";

echo $content;

$mysqli->close();
?>