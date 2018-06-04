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

$content ="";
$result=$mysqli->query("SELECT id
FROM  `quickstart_bl_teams` WHERE t_name ='".$_POST['dt']."'");
$row = $result->fetch_assoc();
$result3=$mysqli->query("SELECT player_id
FROM  `quickstart_bl_players_team` WHERE team_id =".$row['id']);
// $result2=$mysqli->query("SELECT *
// FROM  `quickstart_bl_players` WHERE team_id =".$row['id']."'");

if ($result3->num_rows > 0) {
    // output data of each row

    while($row3 = $result3->fetch_assoc()) {
        $result2=$mysqli->query("SELECT *
        FROM  `quickstart_bl_players` WHERE id = ".$row3['player_id']);
        $row2 = $result2->fetch_assoc();

        if(!mb_check_encoding($row2['first_name'], 'UTF-8') OR !($row2['first_name'] === mb_convert_encoding(mb_convert_encoding($row2['first_name'], 'UTF-32', 'UTF-8' ), 'UTF-8', 'UTF-32'))) {
                    $row2['first_name'] = mb_convert_encoding($row2['first_name'], 'UTF-8', 'pass'); 
            }

            if(!mb_check_encoding($row2['last_name'], 'UTF-8') OR !($row2['last_name'] === mb_convert_encoding(mb_convert_encoding($row2['last_name'], 'UTF-32', 'UTF-8' ), 'UTF-8', 'UTF-32'))) {
                    $row2['last_name'] = mb_convert_encoding($row2['last_name'], 'UTF-8', 'pass'); 
            }

        // $row2['first_name'] = utf8_encode($row2['first_name']);
        // $row2['last_name'] = utf8_encode($row2['last_name']);
            $result5=$mysqli->query("SELECT fvalue
            FROM  `quickstart_bl_extra_values` WHERE uid = ".$row3['player_id']." AND f_id = 1");
        if ( $result5->num_rows > 0 )
        {
            $row5 = $result5->fetch_assoc();
            $content=$content.'                                <ul class="list list--inset">
                                      <li id="'.$row2['id'].'" class="list-item list--inset__item list-item--tappable list-item--longdivider" onclick="pushplayer(this);" value="">
                                        <div class="list-item__left webkitbox"> 
                                           
                                            <div class="team-left">'.$row5['fvalue'].'- '.$row2['first_name'].' '.$row2['last_name'].'</div>              
                                        </div>

                                      </li>
                                </ul>';
            
        }
        else {

        $content=$content.'                                <ul class="list list--inset">
                                      <li id="'.$row2['id'].'" class="list-item list--inset__item list-item--tappable list-item--longdivider" onclick="pushplayer(this);" value="">
                                        <div class="list-item__left webkitbox"> 
                                           
                                            <div class="team-left">'.$row2['first_name'].' '.$row2['last_name'].'</div>              
                                        </div>

                                      </li>
                                </ul>';
        }
    }
}

echo $content;

$mysqli->close();
?>