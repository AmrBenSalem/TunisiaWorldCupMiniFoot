<?php header("Access-Control-Allow-Origin: *"); ?>
<?php
$host = 'sql41.topnetpro.com';
$user = 'ftmf';
$password = 'EjJBRpSQXTHrKFdY';
$dbname = "ftmf_db";

// Create connection
$mysqli = new mysqli($host,$user,$password,$dbname);




$content ="";

$result2=$mysqli->query("SELECT *
FROM  `quickstart_bl_players` WHERE id = ".$_POST['dt']);

$resultp=$mysqli->query("SELECT ph_filename
FROM  `quickstart_bl_photos` , `quickstart_bl_assign_photos`  WHERE cat_id = ".$_POST['dt']." AND photo_id = id");
if ($result2->num_rows > 0) {
    $rowp = $resultp->fetch_assoc();
    if ($rowp['ph_filename'] =="")
    {
        $rowp['ph_filename']="User_font_awesome.svg.png";
    }
} else {
    $rowp['ph_filename']="User_font_awesome.svg.png";
}


if ($result2->num_rows > 0) {
    // output data of each row
    while($row2 = $result2->fetch_assoc()) {

        $content=$content.'<div><ons-row class="firstrowplayer">
                                    <ons-col class="centerTextAlign">
                                        <img class="resizeimgplayer" src="http://www.tunisia2017.com/media/bearleague/'.$rowp['ph_filename'].'">
                                    </ons-col>
                                </ons-row>
                            </div>


                                <ons-row  class="tablerow">
                                <ons-col class="bordercol">
                                        <div class="centertitle">Number</div>';

        $result3=$mysqli->query("SELECT fvalue
            FROM  `quickstart_bl_extra_values` WHERE uid = ".$_POST['dt']." AND f_id = 1");
        if ( $result3->num_rows > 0 )
        {
            $row3 = $result3->fetch_assoc();
            $content=$content.'<span class="centeredvalue">'.$row3['fvalue'].'</span>';
        }

        $content=$content.'</ons-col>
        <ons-col class="bordercol">
                                        <div class="centertitle">Goals</div>';

        $result3=$mysqli->query("SELECT COUNT(e_id) as NbGoals
            FROM  `quickstart_bl_match_events` WHERE player_id = ".$_POST['dt']." AND e_id = 4");
        if ( $result3->num_rows > 0 )
        {
            $row3 = $result3->fetch_assoc();
            $content=$content.'<span class="centeredvalue">'.$row3['NbGoals'].'</span>';
        }else {
            $content=$content.'<span class="centeredvalue">'.$row3['NbGoals'].'</span>';
        }
            $content = $content . '
                                    </ons-col>';
                                    
                                        

                                    //     <ons-col class="bordercol">
                                    //     <div class="centertitle">Matchs</div>
                                    //     <span class="centeredvalue">5</span>
                                    // </ons-col >';
        


        $content = $content .'<ons-col class="bordercol">
                                        <div class="centertitle">Position</div>' ;
        $result3=$mysqli->query("SELECT fvalue
            FROM  `quickstart_bl_extra_values` WHERE uid = ".$_POST['dt']." AND f_id = 9");
        if ( $result3->num_rows > 0 )
        {
            $row3 = $result3->fetch_assoc();
            $content=$content.'
                                        <span class="centeredvalue">'.$row3['fvalue'].'</span>
                                    ';
        }
        $content=$content.'</ons-col>
                                </ons-row>      <ul class="list list--inset">
                      <li class="list-item list--inset__item">
                        <div class="list-item__left overrided"> 
                            <div>Birth date </div>               
                        </div>

                        <div class="list-item__right overrided">';
                                    




        $result3=$mysqli->query("SELECT fvalue
            FROM  `quickstart_bl_extra_values` WHERE uid = ".$_POST['dt']." AND f_id = 8");
        if ( $result3->num_rows > 0 )
        {
            $row3 = $result3->fetch_assoc();
            $content=$content.'<div>'.$row3['fvalue'].'</div>';
        }


        $content=$content.'                              
                        </div>
                      </li>
      </ul>

          <ul class="list list--inset">
                      <li class="list-item list--inset__item">
                        <div class="list-item__left overrided"> 
                            <div>Weight (kg)</div>               
                        </div>

                        <div class="list-item__right overrided">
        ';

        $result3=$mysqli->query("SELECT fvalue
            FROM  `quickstart_bl_extra_values` WHERE uid = ".$_POST['dt']." AND f_id = 2");
        if ( $result3->num_rows > 0 )
        {
            $row3 = $result3->fetch_assoc();
            $content=$content.'<div>'.$row3['fvalue'].'</div>';
        }

        $content = $content.'                
                        </div>
                      </li>
      </ul>
      <ul class="list list--inset">
                      <li class="list-item list--inset__item">
                        <div class="list-item__left overrided"> 
                            <div>Height (cm)</div>               
                        </div>

                        <div class="list-item__right overrided">
    ';

    $result3=$mysqli->query("SELECT fvalue
            FROM  `quickstart_bl_extra_values` WHERE uid = ".$_POST['dt']." AND f_id = 3");
        if ( $result3->num_rows > 0 )
        {
            $row3 = $result3->fetch_assoc();
            $content=$content.'<div>'.$row3['fvalue'].'</div>';
        }

        $content=$content.'
                                            
                        </div>
                      </li>
      </ul>';
    }
}




echo $content;

$mysqli->close();
?>