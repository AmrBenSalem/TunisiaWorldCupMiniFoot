<?php header("Access-Control-Allow-Origin: *"); ?>
<?php
$host = 'sql41.topnetpro.com';
$user = 'ftmf';
$password = 'EjJBRpSQXTHrKFdY';
$dbname = "ftmf_db";

// Create connection
$mysqli = new mysqli($host,$user,$password,$dbname);




$content ="";

$result2=$mysqli->query("SELECT first_name , last_name
FROM  `quickstart_bl_players` WHERE id = ".$_POST['dt']);
if ($result2->num_rows > 0) {
    // output data of each row
    while($row2 = $result2->fetch_assoc()) {

    	if(!mb_check_encoding($row2['first_name'], 'UTF-8') OR !($row2['first_name'] === mb_convert_encoding(mb_convert_encoding($row2['first_name'], 'UTF-32', 'UTF-8' ), 'UTF-8', 'UTF-32'))) {
                    $row2['first_name'] = mb_convert_encoding($row2['first_name'], 'UTF-8', 'pass'); 
            }

            if(!mb_check_encoding($row2['last_name'], 'UTF-8') OR !($row2['last_name'] === mb_convert_encoding(mb_convert_encoding($row2['last_name'], 'UTF-32', 'UTF-8' ), 'UTF-8', 'UTF-32'))) {
                    $row2['last_name'] = mb_convert_encoding($row2['last_name'], 'UTF-8', 'pass'); 
            }

        echo $row2['first_name']." ".$row2['last_name'];
    }
}





$mysqli->close();
?>