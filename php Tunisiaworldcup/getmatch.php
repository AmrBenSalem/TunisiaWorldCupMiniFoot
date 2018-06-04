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
$teams = explode("0", $_POST['dt']);


$result=$mysqli->query("SELECT * 
FROM  `quickstart_bl_match` WHERE team1_id = ( SELECT id 
        FROM  `quickstart_bl_teams` WHERE t_name ='".$teams[0]."' ) AND team2_id = ( SELECT id 
        FROM  `quickstart_bl_teams` WHERE t_name ='".$teams[1]."' ) ");


$content ="";


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        $content=$content.' <ul class="list list--inset">
                      <li class="list-item list--inset__item livematch">
                        <div class="list-item__left"> 
                            <div class="team-right">'.$teams[0].'</div>
                            <img class="list-item__thumbnail resizeimg" src="img/flags/'.$teams[0].'_round_icon_256.png">               
                        </div>

                        <div class="list-item__center text-date backgroundimgnone">
                            <div class="score">'.$row["score1"].' - '.$row["score2"].'</div>
                            <div class="livetime">'.$row["m_time"].'</div>

                        </div>

                        <div class="list-item__right backgroundimgnone">
                            <img class="list-item__thumbnail resizeimg" src="img/flags/'.$teams[1].'_round_icon_256.png">
                            <div class="team-left">'.$teams[1].'</div>                 
                        </div>
                      </li>
                </ul> ';
        $result3=$mysqli->query("SELECT *
            FROM  `quickstart_bl_match_events` WHERE e_id <> 5 AND match_id = ".$row['id']." ORDER BY eordering ASC");

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
                    if ($row7['t_name'] == $teams[1])
                    {
                    $content=$content.'<ul class="list noline">
                    <li class="list-item list-item--nodivider noline paddinglist">
                        <div class="list-item__right overrideright noline">
                            <img class="resizeimgcard" src="img/live/yellow_card.png">
                            <div class="divLive">'.$playername.'</div>
                            <div class="divTimeRight">( '.$row3['minutes'].'“ )</div>              
                        </div>
                      </li> </ul>';
                    } else {

                      $content=$content.'<ul class="list noline"> <li class="list-item list-item--nodivider noline paddinglist">
                        <div class="list-item__left overrideleft noline"> 
                            <div class="divTime">( '.$row3['minutes'].'“ )</div> 
                            <div class="firstimg divLiveFirst">'.$playername.'</div>
                            <img class="firstimg resizeimgcard" src="img/live/yellow_card.png">              
                        </div>
                    </li>
                </ul>';
                    }

                } else if ($row3['e_id'] == 2 )
                {
                    if ($row7['t_name'] == $teams[1])
                    {
                    $content=$content.'<ul class="list noline">
                    <li class="list-item list-item--nodivider noline paddinglist">
                        <div class="list-item__right overrideright noline">
                            <img class="resizeimgcard" src="img/live/red_card.png">
                            <div class="divLive">'.$playername.'</div>
                            <div class="divTimeRight">( '.$row3['minutes'].'“ )</div>              
                        </div>
                      </li> </ul>';
                    } else {

                      $content=$content.' <ul class="list noline"> <li class="list-item list-item--nodivider noline paddinglist">
                        <div class="list-item__left overrideleft noline"> 
                            <div class="divTime">( '.$row3['minutes'].'“ )</div> 
                            <div class="firstimg divLiveFirst">'.$playername.'</div>
                            <img class="firstimg resizeimgcard" src="img/live/red_card.png">              
                        </div>
                    </li>
                </ul>';
                    }

                } else if ($row3['e_id'] == 3 )
                {
                    if ($row7['t_name'] == $teams[1])
                    {
                    $content=$content.'<ul class="list noline">
                    <li class="list-item list-item--nodivider noline paddinglist">
                        <div class="list-item__right overrideright noline">
                            <img class="resizeimgcard" src="img/live/yellow-red_card.png">
                            <div class="divLive">'.$playername.'</div>
                            <div class="divTimeRight">( '.$row3['minutes'].'“ )</div>              
                        </div>
                      </li> </ul>';
                    } else {

                      $content=$content.'<ul class="list noline"> <li class="list-item list-item--nodivider noline paddinglist">
                        <div class="list-item__left overrideleft noline"> 
                            <div class="divTime">( '.$row3['minutes'].'“ )</div> 
                            <div class="firstimg divLiveFirst">'.$playername.'</div>
                            <img class="firstimg resizeimgcard" src="img/live/yellow-red_card.png">              
                        </div>
                    </li>
                </ul>';
                    }

                } else if ($row3['e_id'] == 4 )
                {
                    if ($row7['t_name'] == $teams[1])
                    {
                    $content=$content.'<ul class="list noline">
                    <li class="list-item list-item--nodivider noline paddinglist goalscored">
                        <div class="list-item__right overrideright noline">
                            <img class="resizeimgcard" src="img/live/ball.png">
                            <div class="divLive">'.$playername.'</div>
                            <div class="divTimeRight">( '.$row3['minutes'].'“ )</div>              
                        </div>
                      </li></ul>';
                    } else {

                      $content=$content.'<ul class="list noline"> <li class="list-item list-item--nodivider noline paddinglist goalscored">
                        <div class="list-item__left overrideleft noline"> 
                            <div class="divTime">( '.$row3['minutes'].'“ )</div> 
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

}

$mysqli->close();
?>