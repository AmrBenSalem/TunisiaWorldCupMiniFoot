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


$result=$mysqli->query("SELECT t_name 
FROM  `quickstart_bl_teams` 
ORDER BY  `quickstart_bl_teams`.`t_name` ASC 
LIMIT 0 , 30");



$content ="";

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $content=$content.'<ul class="list list--inset">
                          <li id="'.$row["t_name"].'" class="push-button list-item list--inset__item list-item--tappable list-item--longdivider" onclick="pushh(this)">
                            <div class="list-item__left webkitbox"> 
                                <img class="list-item__thumbnail resizeimgteam" src="img/flags/'.$row["t_name"].'_round_icon_256.png">  
                                <div class="team-left">'.$row["t_name"].'</div>              
                            </div>

                          </li>
                    </ul>';
    }
} else {
    echo "0 results";
}

echo $content;

$mysqli->close();
?>