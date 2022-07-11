      <?php
session_start();
function split_name($name) {
    $name = trim($name);
    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
    $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
    return array($first_name, $last_name);
}
class DbConnect
{
    // private $host='localhost';
    // private $dbName = 'webutbac_attendance';
    // private $user = 'webutbac';
    // private $pass = 'l3v0pZFV@2020';
    // public $conn;

    private $host='localhost';
    private $dbName = 'utb_attendance';
    private $user = 'root';
    private $pass = '';
    public $conn;

    public function connect()
    {
        try {
         $conn = new PDO('mysql:host='.$this->host.';dbname='.$this->dbName, $this->user, $this->pass);
         return $conn;
        } catch (PDOException $e) {
            echo "Database Error ".$e->getMessage();
            return null;
        }
    }
}

/**
 * ============================= Main View
 */
class MainView extends DbConnect
{
    
    function todays_attendance(){
        $con = parent::connect();
        $sel = $con->prepare("SELECT * FROM attendance_records WHERE CAST(attendance_records.RecordTime AS DATE) = CAST( curdate() AS DATE)");
        $sel->execute();
        $cnt = 0;
        if ($sel->rowCount()>=1) {
            $arr = [];
            while ($ft_sel = $sel->fetch(PDO::FETCH_ASSOC)) {
                $user = $ft_sel['RecordUser'];
                if (in_array($user, $arr)) {
                    continue;
                }else{
                    array_push($arr, $user);
                    $cnt++;
                }
            }
        }
        // $ft_sel = $sel->fetch(PDO::FETCH_ASSOC);
        return $cnt;
    }

    function todays_right_arrival(){
        $con = parent::connect();
        $sel = $con->prepare("SELECT * FROM attendance_records WHERE CAST(attendance_records.RecordTime AS DATE) = CAST( curdate() AS DATE) AND substr(attendance_records.RecordTime, 12,2)<'08'");
        $sel->execute();
        $cnt = 0;
        if ($sel->rowCount()>=1) {
            $arr = [];
            while ($ft_sel = $sel->fetch(PDO::FETCH_ASSOC)) {
                $user = $ft_sel['RecordUser'];
                if (in_array($user, $arr)) {
                    continue;
                }else{
                    array_push($arr, $user);
                    $cnt++;
                }
            }
        }
        // $ft_sel = $sel->fetch(PDO::FETCH_ASSOC);
        return $cnt;
    }

    function todays_lates(){
        $con = parent::connect();
        $sel = $con->prepare("SELECT * FROM attendance_records WHERE CAST(attendance_records.RecordTime AS DATE) = CAST( curdate() AS DATE) AND substr(attendance_records.RecordTime, 12,2)>='08'");
        $sel->execute();
        $cnt = 0;
        if ($sel->rowCount()>=1) {
            $arr = [];
            while ($ft_sel = $sel->fetch(PDO::FETCH_ASSOC)) {
                $user = $ft_sel['RecordUser'];
                if (in_array($user, $arr)) {
                    continue;
                }else{
                    array_push($arr, $user);
                    $cnt++;
                }
            }
        }
        // $ft_sel = $sel->fetch(PDO::FETCH_ASSOC);
        return $cnt;
    }
    function all_cards(){
        $con = parent::connect();
        $sel = $con->prepare("SELECT * FROM attendance_users");
        $sel->execute();
        while ($ft_sel = $sel->fetch(PDO::FETCH_ASSOC)) {
            $user_id = $ft_sel['UserId'];
            $user_photo = $user_id;
?> 
<center>
    <table>
        <tr>
            <td><button class="btn btn-primary" id="download<?=$user_photo?>" onclick="return downloadimage('imageDIV<?=$user_photo?>','<?=$ft_sel['Names']?>','card')">Download Card</button><hr></td>
            <!-- <td><button class="btn btn-secondary" onclick="return downloadimage('qrImg<?=$user_photo?>','<?=$ft_sel['Names']?>','qqr');">Download QR</button><hr></td> -->
        </tr>
        <tr>
            <td>
                <div style="display: none;" id="previewImage<?=$user_photo?>"></div>
                <div id="imageDIV<?=$user_photo?>" style="width: 500px;background-image: url('img/card.jpg');background-repeat: no-repeat;background-size: 100%;float: left;">
                    <center>
                        <img src="img/users/<?=$user_photo?>.jpg" style="width: 188px;height: 200px;margin-top: 41.5%;margin-left: -20px;">
                    </center>
                    <h3 style="margin-top: 13%;font-weight: bold;color: #fff;text-align: left;margin-left: 24%;font-size: 20px;"><?=$ft_sel['Names']?></h3>
                    <h3 style="margin-top: 4%;font-weight: bold;color: #fff;text-align: left;margin-left: 30%;font-size: 20px"><?=$ft_sel['Position']?></h3>
                    <h3 style="margin-top: 3%;font-weight: bold;color: #fff;text-align: left;margin-left: 24%;font-size: 20px">0<?=$ft_sel['Phone']?></h3>
                    <h3 style="margin-top: 3%;font-weight: bold;color: #fff;text-align: left;margin-left: 24%;font-size: 20px"><?=$ft_sel['Email']?></h3>
                    <h3 style="margin-top: 3%;font-weight: bold;color: #fff;text-align: left;margin-left: 24%;font-size: 20px">UTB-<?=$filled_int = sprintf("%04d", $ft_sel['UserId']) ?></h3>
                </div>
            </td>
            <td><?php 

                $vv = "https://utb.ac.rw/attendance/scan.php?content=".$ft_sel['UserId'];
            ?>
                <div id="qrImg<?=$user_photo?>" style="background-color: white;width: 500px;background-repeat: no-repeat;background-size: 100%;float: right;">
                    <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?=$vv?>&choe=UTF-8" filename="<?=$ft_sel['Names']?>.png" basename="<?=$ft_sel['Names']?>" name='<?=$ft_sel['Names']?>' id='<?=$ft_sel['Names']?>'/>
                        <!-- <img src="img/users/<?=$user_photo?>.jpg" style="width: 188px;height: 200px;margin-top: 41.5%;margin-left: -20px;"> -->

                </div>
            </td>

        </tr>
    </table>
</center>
<?php
        }
    }

    function todays_attendance_detailed(){
        $con = parent::connect();
        $sel = $con->prepare("SELECT substr(attendance_records.RecordTime, 12,2)-'08' AS diff,attendance_records.*,attendance_users.* FROM attendance_records,attendance_users WHERE attendance_records.RecordUser=attendance_users.UserId AND CAST(attendance_records.RecordTime AS DATE) = CAST( curdate() AS DATE)");
        $sel->execute();
        if ($sel->rowCount()>=1) {
            $cnt = 1;
            while ($ft_sel = $sel->fetch(PDO::FETCH_ASSOC)) {
                switch (true) {
                    case $ft_sel['diff']<0:
                        $diff = '+';
                        $obs = 'Excellent';
                        break;
                    case $ft_sel['diff']<=1:
                        $diff = '< 1Hrs';
                        $obs = 'Late';
                        break;
                    case $ft_sel['diff']<=4:
                        $diff = ">".$ft_sel['diff'].'Hrs';
                        $obs = 'Too Late';
                        break;    
                    default:
                        $diff = $ft_sel['diff'].'Hrs';
                        $obs = 'Not Worked';
                        break;
                }
                ?>
                <tr>
                    <td><?=$cnt?></td>
                    <td><?=$ft_sel['Names']?></td>
                    <td><?=$ft_sel['Position']?></td>
<!--                     <td><?=$ft_sel['']?></td> -->
                    <td><?=substr($ft_sel['RecordTime'], 11,5)?></td>
                    <td><?=$diff?></td>
                    <td><?=$obs?></td>
                </tr>
                <?php
                $cnt++;
            }
        }
    }

}



?>