<?php header("Access-Control-Allow-Origin: *"); ?>
<?php
$host = 'sql41.topnetpro.com';
$user = 'ftmf';
$password = 'EjJBRpSQXTHrKFdY';
$dbname = "ftmf_db";

// Create connection
$mysqli = new mysqli($host,$user,$password,$dbname);



$result=$mysqli->query("SELECT * 
FROM  `quickstart_bl_match` WHERE match_descr='live'");



$content ="";


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        $team11=$mysqli->query("SELECT id,t_name 
        FROM  `quickstart_bl_teams` WHERE id=".$row['team1_id']);
        $team1 = $team11->fetch_assoc();
        $team22=$mysqli->query("SELECT id,t_name 
        FROM  `quickstart_bl_teams` WHERE id=".$row['team2_id']);
        $team2 = $team22->fetch_assoc();

        $content=$content.' <ul class="list list--inset">
                      <li class="list-item list--inset__item livematch">
                        <div class="list-item__left"> 
                            <div class="team-right">'.$team1['t_name'].'</div>
                            <img class="list-item__thumbnail resizeimg" src="img/flags/'.$team1['t_name'].'_round_icon_256.png">               
                        </div>

                        <div class="list-item__center text-date backgroundimgnone">
                            <div class="score">'.$row["score1"].' - '.$row["score2"].'</div>
                            <div class="livetime">'.$row["m_time"].'</div>

                        </div>

                        <div class="list-item__right backgroundimgnone">
                            <img class="list-item__thumbnail resizeimg" src="img/flags/'.$team2['t_name'].'_round_icon_256.png">
                            <div class="team-left">'.$team2['t_name'].'</div>                 
                        </div>
                      </li>
                </ul> ';

		$result3=$mysqli->query("SELECT *
            FROM  `quickstart_bl_match_events` WHERE match_id = ".$row['id']." ORDER BY ASC minutes");

        if ( $result3->num_rows > 0 )
        {
            while($row3 = $result3->fetch_assoc())
            {
                $result5=$mysqli->query("SELECT first_name , last_name
                FROM  `quickstart_bl_players` WHERE id = ".$row3['player_id']);

                $result6=$mysqli->query("SELECT team_id
                FROM  `quickstart_bl_players_team` WHERE player_id = ".$row3['player_id']);
                $row6 = $result6->fetch_assoc();

                $result7=$mysqli->query("SELECT t_name
                FROM  `quickstart_bl_teams` WHERE id = ".$row6['team_id']);
                $row7 = $result7->fetch_assoc();


                if ($result5->num_rows > 0) {
                    // output data of each row
                    while($row5 = $result5->fetch_assoc()) {
                        $playername =  $row5['first_name']." ".$row5['last_name'];
                    }
                }

                if ($row3['e_id'] == 1 )
                {
                    if ($row7['t_name'] == $teams[0])
                    {
                    $content=$content.'<ul class="list noline">
                    <li class="list-item list-item--nodivider noline paddinglist">
                        <div class="list-item__right overrideright noline">
                            <img class="resizeimgcard" src="img/live/yellow_card.png">
                            <div class="divLive">'.$playername.'</div>
                            <div class="divTimeRight">'.$row3['minutes'].'</div>              
                        </div>
                      </li> </ul>';
                    } else {

                      $content=$content.'<ul class="list noline"> <li class="list-item list-item--nodivider noline paddinglist">
                        <div class="list-item__left overrideleft noline"> 
                            <div class="divTime">'.$row3['minutes'].'</div> 
                            <div class="firstimg divLiveFirst">'.$playername.'</div>
                            <img class="firstimg resizeimgcard" src="img/live/yellow_card.png">              
                        </div>
                    </li>
                </ul>';
                    }

                } else if ($row3['e_id'] == 2 )
                {
                    if ($row7['t_name'] == $teams[0])
                    {
                    $content=$content.'<ul class="list noline">
                    <li class="list-item list-item--nodivider noline paddinglist">
                        <div class="list-item__right overrideright noline">
                            <img class="resizeimgcard" src="img/live/red_card.png">
                            <div class="divLive">'.$playername.'</div>
                            <div class="divTimeRight">'.$row3['minutes'].'</div>              
                        </div>
                      </li> </ul>';
                    } else {

                      $content=$content.' <ul class="list noline"> <li class="list-item list-item--nodivider noline paddinglist">
                        <div class="list-item__left overrideleft noline"> 
                            <div class="divTime">'.$row3['minutes'].'</div> 
                            <div class="firstimg divLiveFirst">'.$playername.'</div>
                            <img class="firstimg resizeimgcard" src="img/live/red_card.png">              
                        </div>
                    </li>
                </ul>';
                    }

                } else if ($row3['e_id'] == 3 )
                {
                    if ($row7['t_name'] == $teams[0])
                    {
                    $content=$content.'<ul class="list noline">
                    <li class="list-item list-item--nodivider noline paddinglist">
                        <div class="list-item__right overrideright noline">
                            <img class="resizeimgcard" src="img/live/yellow-red_card.png">
                            <div class="divLive">'.$playername.'</div>
                            <div class="divTimeRight">'.$row3['minutes'].'</div>              
                        </div>
                      </li> </ul>';
                    } else {

                      $content=$content.'<ul class="list noline"> <li class="list-item list-item--nodivider noline paddinglist">
                        <div class="list-item__left overrideleft noline"> 
                            <div class="divTime">'.$row3['minutes'].'</div> 
                            <div class="firstimg divLiveFirst">'.$playername.'</div>
                            <img class="firstimg resizeimgcard" src="img/live/yellow-red_card.png">              
                        </div>
                    </li>
                </ul>';
                    }

                } else if ($row3['e_id'] == 4 )
                {
                    if ($row7['t_name'] == $teams[0])
                    {
                    $content=$content.'<ul class="list noline">
                    <li class="list-item list-item--nodivider noline paddinglist goalscored">
                        <div class="list-item__right overrideright noline">
                            <img class="resizeimgcard" src="img/live/ball.png">
                            <div class="divLive">'.$playername.'</div>
                            <div class="divTimeRight">'.$row3['minutes'].'</div>              
                        </div>
                      </li></ul>';
                    } else {

                      $content=$content.'<ul class="list noline"> <li class="list-item list-item--nodivider noline paddinglist goalscored">
                        <div class="list-item__left overrideleft noline"> 
                            <div class="divTime">'.$row3['minutes'].'</div> 
                            <div class="firstimg divLiveFirst">'.$playername.'</div>
                            <img class="firstimg resizeimgcard" src="img/live/ball.png">              
                        </div>
                    </li>
                </ul>';
                    }

                }

            }

        }
	        
    }
}


echo $content;



$mysqli->close();
?>