<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
@session_start();
// require("drive/config.php");
// $MyFunctions = new MyFunctions();
class DbConnectt
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


class MyFunctions{
function split_name($name) {
    $name = trim($name);
    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
    $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
    return array($first_name, $last_name);
}
function greeting_msg() {
    $hour = date('H');
    if ($hour >= 18) {
       $greeting = "Good Evening";
    } elseif ($hour >= 12) {
        $greeting = "Good Afternoon";
    } elseif ($hour < 12) {
       $greeting = "Good Morning";
    }
    return $greeting;
}
}

/**
 * ====================================== MAIN OPERATIONS
 */
class MainOpoerations extends DbConnectt
{
    function login($email,$pass){
        $con = parent::connect();
        $reg = $con->prepare("SELECT * FROM users WHERE Email=? AND Password=?");
        $reg->bindValue(1,$email);
        $reg->bindValue(2,md5($pass));
        $reg->execute();
        if ($reg->rowCount()==1) {
            $ft_reg = $reg->fetch(PDO::FETCH_ASSOC);
            $_SESSION['utb_att_email'] = $ft_reg['Email'];
            $_SESSION['utb_att_campus'] = $ft_reg['Campus'];
            $_SESSION['utb_att_names'] = $ft_reg['Names'];
            $_SESSION['utb_att_position'] = $ft_reg['Position'];
            $_SESSION['utb_att_user_id'] = $ft_reg['UserId'];
            switch ($ft_reg['Position']) {
                case 'Reception':
                    echo "success-reception";
                    break;

                case 'HR':
                    echo "success-hr";
                    break;
                
                default:
                    echo "failed";
                    break;
            }
            // echo "failed";

        }else{
            echo "failed";
            // echo $reg->rowCount();
        }

    }

    function scan_card($user_id){
        $MyFunctions = new MyFunctions();
        $con = parent::connect();
        $user = $con->prepare("SELECT * FROM attendance_users WHERE attendance_users.UserId='$user_id' OR attendance_users.Lfid='$user_id'");
        $user->execute();
        if ($user->rowCount()==1) {
            $ft_user = $user->fetch(PDO::FETCH_ASSOC);
            $dept = $ft_user['Class'];
            $attender = $ft_user['UserId'];
            $firstname = strtok($ft_user['Names'], ' ');
            $staff_dept = "";
            switch ($dept) {
                case 0:
                    $staff_dept = "Administration Staff";
                    break;
                
                default:
                    $staff_dept = "Teaching Staff";
                    break;
            }
        $sel_att = $con->prepare("SELECT * FROM attendance_records,attendance_users WHERE attendance_users.UserId=attendance_records.RecordUser AND (attendance_records.RecordUser='$user_id' OR attendance_users.Lfid='$user_id') AND CAST(attendance_records.RecordTime AS DATE) = CAST( curdate() AS DATE)");
        $sel_att->execute();
        $time_now = (int)date('H');
        if ($sel_att->rowCount()>=1) {
            $ft_sel_att = $sel_att->fetch(PDO::FETCH_ASSOC);
            $cnt_row = $sel_att->rowCount();
            $timme=(int)substr($ft_sel_att['RecordTime'], 11,2);
            $diff = $time_now-$timme;
        }else{
            $cnt_row = 0;
        }

        if ($cnt_row==0 AND $time_now>17) {
            $status = 'shift';
        }elseif ($cnt_row==0 AND $time_now<=17) {
            $status = 'IN';
        }elseif ($cnt_row==1 AND $diff<1 AND $time_now<=17) {
            $status = 'arleady';
        }else{
            if ($cnt_row==1 AND $diff>=1) {
                $status = 'OUT';
            }else{
                $status = 'arleady';
            }
            // $status = "Difference: ".$diff.", Now: ".$time_now.", Before: ".$timme;
            
        }

        }else{
            $status = "no_user";
        }

        switch ($status) {
            case 'shift':
                ?>
                <script type="text/javascript">
                        $("#respp").css("background-color","red");
                    </script>
                    <h1 style="font-family: Palatino Linotype;color: #fff;"><span>Attendance time ended, wait for <u>onother shift</u> ...</span></h1>
                    <?php
                break;
            case 'IN':
                $ins = $con->prepare("INSERT INTO attendance_records(RecordUser) VALUES('$attender')");
                $ok_ins = $ins->execute();
                        ?><script type="text/javascript">
                            $("#respp").css("background-color","green");
                        </script>
                        <center>
                            <table>
                                <tr>
                                    <td>
                                        <b><?=$staff_dept?></b>
                                    </td>
                                    <td>
                                        <h1 style="font-size:100px;font-weight:bolder;color: #000;">IN </h1>
                                    </td>
                                    <td>
                                        <img src="img/out.png" style="height: 100px;width: 100px;">
                                    </td>
                                </tr>
                            </table>
                        </center>
                        <h1 style="font-family: Palatino Linotype;color: #fff;"><?=$MyFunctions->greeting_msg()?> <span style="color:black"><?=$firstname?>,</span> <span>Your attendence successful recorded !</span></h1>
                        <?php
                // echo $status;
                break;
            case 'OUT':
                $ins = $con->prepare("INSERT INTO attendance_records(RecordUser) VALUES('$attender')");
                $ok_ins = $ins->execute();
                        ?><script type="text/javascript">
                            $("#respp").css("background-color","#0c6e82");
                        </script>
                        <center>
                            <table>
                                <tr>
                                    <td>
                                        <b><?=$staff_dept?></b>
                                    </td>
                                    <td>
                                        <h1 style="font-size:100px;font-weight:bolder;color: #000;">OUT </h1>
                                    </td>
                                    <td>
                                        <img src="img/out.png" style="height: 100px;width: 100px;">
                                    </td>
                                </tr>
                            </table>
                        </center>
                        <h1 style="font-family: Palatino Linotype;color: #fff;"><?=$MyFunctions->greeting_msg()?> <span style="color:black"><?=$firstname?>,</span> <span>You're successful Checked-Out.</span></h1>
                        <?php
                break;
            case 'arleady':
                ?><script type="text/javascript">
                    $("#respp").css("background-color","yellow");
                </script>
                <h1 style="font-family: Palatino Linotype;color: #fff;"><span style="color:black"><?=$firstname?> <span style="color:red">arleady attended  </span>.</h1>
                <?php
                break;
            case 'not':
                ?><script type="text/javascript">
                    $("#respp").css("background-color","red");
                </script>
                <h1 style="font-family: Palatino Linotype;color: #fff;"></span> <span>Try again later ...</span></h1>
                <?php
                break;
            case 'no_user':
                ?><script type="text/javascript">
                    $("#respp").css("background-color","red");
                </script>
                <h1 style="font-family: Palatino Linotype;color: #fff;"><span>Not attended ...</span></h1>
                <?php
                break;
            
            default:
                ?><script type="text/javascript">
                    $("#respp").css("background-color","red");
                </script>
                <h1 style="font-family: Palatino Linotype;color: #fff;"></span> <span>Failed, Try again later ...</span></h1>
                <?php
                break;
        }


    }


    function print_card($user_id){
        $con = parent::connect();
        $sel = $con->prepare("SELECT * FROM attendance_users WHERE attendance_users.UserId='$user_id' OR attendance_users.Lfid='$user_id'");
        $sel->execute();
        if ($sel->rowCount()==1) {
            while ($ft_sel = $sel->fetch(PDO::FETCH_ASSOC)) {
                $user_id = $ft_sel['UserId'];
                $user_photo = $user_id;
    ?> 
    <center>
        <table>
            <tr>
                <td><button class="btn btn-primary" id="download<?=$user_photo?>" onclick="downloadimage('imageDIV<?=$user_photo?>','<?=$ft_sel['Names']?>','card');downloadimage('qr_print<?=$user_photo?>','<?=$ft_sel['Names']?>','qqr');">Download Card</button><hr></td>
                <!-- <td><button class="btn btn-secondary" onclick="return downloadimage('qrcode<?=$user_photo?>','<?=$ft_sel['Names']?>','qqr');">Download QR</button><hr></td> -->
            </tr>
            <tr>
                <td>
                    <div style="display: none;" id="previewImage<?=$user_photo?>"></div>
                    <div id="imageDIV<?=$user_photo?>" style="width: 500px;height: 780px;background-image: url('img/card.jpg');background-size: 100%;background-repeat: no-repeat;">
                        <center>
                            <img src="img/users/<?=$user_photo?>.jpg" style="width: 180px;height: 204px;margin-top: 41%;margin-left: -10.5px;">
                        </center>
                        <br><br>
                        <table style="width: 100%;text-align:left;">
                            <tr>
                                <td style="font-size: 25px;color: #cfcf30;font-weight: bold;">&nbsp;&nbsp;&nbsp;Name:</td>
                                <td style="float:left;color: #eee;font-size: 20px;font-weight: bold;margin-top: 15px;">
                                    <label><?=$ft_sel['Names']?></label>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 25px;color: #cfcf30;font-weight: bold;">&nbsp;&nbsp;&nbsp;Position:</td>
                                <td style="float:left;color: #eee;font-size: 20px;font-weight: bold;margin-top: 15px;">
                                    <label><?=$ft_sel['Position']?></label>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 25px;color: #cfcf30;font-weight: bold;">&nbsp;&nbsp;&nbsp;ID <ss style="font-weight: lighter;">NO</ss>:</td>
                                <td style="float:left;color: #eee;font-size: 20px;font-weight: bold;margin-top: 15px;">
                                    <label>UTB-<?=$filled_int = sprintf("%04d", $ft_sel['UserId']) ?></label>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td><?php 

                    $vv = "https://utb.ac.rw/attendance/scan.php?content=".$ft_sel['UserId'];
                ?>
                    <input id="text<?=$user_photo?>" style="display: none;" type="text" value="<?=$vv?>" style="width:80%" /><br />
                    <table id="qr_print<?=$user_photo?>">
                        <tr>
                            <td>
                                <center><div id="qrcode<?=$user_photo?>"></div></center>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="color:black;font-style: italic;"><br>
                                    <center>
                                        <i style="font-size: 10.5px;font-weight: bolder;">
                                        This card is the property of UTB if found, 
                                        please return it to the address below:
                                        </i>
                                    <span style="font-size: 12px;">
                                        P.O.BOX:350 Kigali-Rwanda<br>
                                        <b>Tel:</b> (250) 788314252<br>
                                        <b>Email:</b> info@utb.ac.rw<br>
                                        <b>Website:</b> www.utb.ac.rw<br>
                                    </span>
                                        
                                    </center>
                                </p>
                            </td>
                        </tr>
                    </table>
                    <script type="text/javascript">
                    var qrcode = new QRCode("qrcode<?=$user_photo?>");

                    function makeCode () {    
                      var elText = document.getElementById("text<?=$user_photo?>");
                      
                      if (!elText.value) {
                        alert("Input a text");
                        elText.focus();
                        return;
                      }
                      
                      qrcode.makeCode(elText.value);
                    }

                    makeCode();

                    $("#text<?=$user_photo?>").
                      on("blur", function () {
                        makeCode();
                      }).
                      on("keydown", function (e) {
                        if (e.keyCode == 13) {
                          makeCode();
                        }
                      });
                    </script>
                </td>

            </tr>
        </table>
    </center>
    <?php
            }
        }else{
            echo 'not_found';
        }
    }

    function print_qr($user_id){
        $con = parent::connect();
        $sel = $con->prepare("SELECT * FROM attendance_users WHERE attendance_users.UserId='$user_id' OR attendance_users.Lfid='$user_id'");
        $sel->execute();
        if ($sel->rowCount()==1) {
            while ($ft_sel = $sel->fetch(PDO::FETCH_ASSOC)) {
                $user_id = $ft_sel['UserId'];
                $user_photo = $user_id;
    ?> 
    <center>
        <table>
            <tr>
                <td><button class="btn btn-primary" id="download<?=$user_photo?>" onclick="downloadimage('imageDIV<?=$user_photo?>','<?=$ft_sel['Names']?>','card');downloadimage('qr_print<?=$user_photo?>','<?=$ft_sel['Names']?>','qqr');">Download Card</button><hr></td>
                <!-- <td><button class="btn btn-secondary" onclick="return downloadimage('qrcode<?=$user_photo?>','<?=$ft_sel['Names']?>','qqr');">Download QR</button><hr></td> -->
            </tr>
            <tr>
                <td>

                </td>
                <td><?php 

                    $vv = "https://utb.ac.rw/attendance/scan.php?content=".$ft_sel['UserId'];
                ?>
                    <input id="text<?=$user_photo?>" style="display: none;" type="text" value="<?=$vv?>" style="width:80%" /><br />
                    <br><br>
                    <table id="qr_print<?=$user_photo?>">
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>
                                <center><br><br><div style="width: 240px;height: 240px" id="qrcode<?=$user_photo?>"></div></center>
                            </td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

                        </tr>
                        <tr>
                            <td colspan="3">
                                <p style="color:black;font-style: italic;font-weight: bold;font-family: Arial;"><br>
                                    <center>
                                        <i style="font-size: 14px;font-weight: bolder;font-family: Arial;">
                                        This card is the property of UTB if found, please<br> 
                                         return it to the address below:<br><br>
                                        </i>
                                    <span style="font-size: 14px;font-weight: bold;font-family: Arial;">
                                        P.O.BOX:350 Kigali-Rwanda<br>
                                        <b>Tel:</b> (+250) 788314252<br>
                                        <b>Email:</b> info@utb.ac.rw<br>
                                        <b>Website:</b> www.utb.ac.rw<br>
                                    </span>
                                        
                                    </center>
                                </p>
                            </td>
                        </tr>
                    </table>
                    <script type="text/javascript">
                    var qrcode = new QRCode("qrcode<?=$user_photo?>");

                    function makeCode () {    
                      var elText = document.getElementById("text<?=$user_photo?>");
                      
                      if (!elText.value) {
                        alert("Input a text");
                        elText.focus();
                        return;
                      }
                      
                      qrcode.makeCode(elText.value);
                    }

                    makeCode();

                    $("#text<?=$user_photo?>").
                      on("blur", function () {
                        makeCode();
                      }).
                      on("keydown", function (e) {
                        if (e.keyCode == 13) {
                          makeCode();
                        }
                      });
                    </script>
                </td>

            </tr>
        </table>
    </center>
    <?php
            }
        }else{
            echo 'not_found';
        }
    }

function scan_card_phone($user_id){
        $con = parent::connect();
        $sel_att = $con->prepare("SELECT * FROM attendance_records WHERE attendance_records.RecordUser='$user_id' AND CAST(attendance_records.RecordTime AS DATE) = CAST( curdate() AS DATE)");
        $sel_att->execute();
        if ($sel_att->rowCount()>=1) {
            echo "<h1>arleady</h1>";
        }else{
            $ins = $con->prepare("INSERT INTO attendance_records(RecordUser) VALUES('$user_id')");
            $ok_ins = $ins->execute();
            if ($ok_ins) {
                $sel = $con->prepare("SELECT * FROM attendance_users WHERE attendance_users.UserId='$user_id'");
                $sel->execute();
                if ($sel->rowCount()==1) {
                    $ft_sel = $sel->fetch(PDO::FETCH_ASSOC);
                    $user_photo = $user_id;
                    ?>
                    <center>
                    <div style="width: 100%;height: 1000px;background-image: url('img/card.jpg');background-repeat: no-repeat;background-size: 100%;">
                        <img src="img/users/<?=$user_photo?>.jpg" style="width: 36%;height: 20%;margin-top: 41.5%;margin-left: -2.5%;">
                        <!-- <img src="img/aa.jpeg" style="width: 36%;height: 20%;margin-top: 41.5%;margin-left: -2.5%;"> -->

                        <h3 style="margin-top: 13.5%;font-weight: bold;color: #fff;text-align: left;margin-left: 24%;font-size: 12px;"><?=$ft_sel['Names']?></h3>
                        <h3 style="margin-top: -1%;font-weight: bold;color: #fff;text-align: left;margin-left: 30%;font-size: 12px"><?=$ft_sel['Position']?></h3>
                        <h3 style="margin-top: -2%;font-weight: bold;color: #fff;text-align: left;margin-left: 24%;font-size: 12px">0<?=$ft_sel['Phone']?></h3>
                        <h3 style="margin-top: 0%;font-weight: bold;color: #fff;text-align: left;margin-left: 24%;font-size: 12px"><?=$ft_sel['Email']?></h3>
                        <h3 style="margin-top: 0%;font-weight: bold;color: #fff;text-align: left;margin-left: 24%;font-size: 12px">UTB-<?=$filled_int = sprintf("%04d", $ft_sel['UserId']) ?></h3>
                    </div>
                    </center>
                    <?php

                }else{
                    echo "<h1>Nooo</h1>";
                }
            }else{
                echo "<h1>Errorrrrrr</h1>";
            }
       }
}

function saveLfid($code,$lfid){
    if ($code=='' OR $lfid=='') {
        echo "null";
    }else{
        $con = parent::connect();
        $save = $con->prepare("UPDATE attendance_users SET attendance_users.Lfid='$lfid' WHERE attendance_users.UserId='$code'");
        $ok_save = $save->execute();
        if ($ok_save) {
            echo "<h3 style='color:green'>saved</h3>".$code;
        }else{
            echo "failed";
        }
    }
}

function shift_in($user_id,$srchDate){
    $con = parent::connect();
    $sel = $con->prepare("SELECT * FROM attendance_records WHERE attendance_records.RecordUser='$user_id' AND attendance_records.RecordTime LIKE '$srchDate%'");
    $sel->execute();
    $timme='-';
    if ($sel->rowCount()>=1) {
        $cnt = 1;
        while ($ft_sel = $sel->fetch(PDO::FETCH_ASSOC)) {
            if ($cnt==1) {
                $timme=substr($ft_sel['RecordTime'], 10,6);
            }
            $cnt++;
        }
    }
    return $timme;
}

function shift_out($user_id,$srchDate){
    $con = parent::connect();
    $sel = $con->prepare("SELECT * FROM attendance_records WHERE attendance_records.RecordUser='$user_id' AND attendance_records.RecordTime LIKE '$srchDate%'");
    $sel->execute();
    $timme='-';
    if ($sel->rowCount()>=1) {
        $cnt = 1;
        while ($ft_sel = $sel->fetch(PDO::FETCH_ASSOC)) {
            if ($cnt==2) {
                $timme=substr($ft_sel['RecordTime'], 10,6);
            }
            $cnt++;
        }
    }
    return $timme;
}

function observationIn($user_id,$date_time){
    $con = parent::connect();
    $sel = $con->prepare("SELECT * FROM attendance_users WHERE attendance_users.UserId='$user_id'");
    $sel->execute();
    $ft_sel = $sel->fetch(PDO::FETCH_ASSOC);
    $category = $ft_sel['Class'];
    $timme_hour=(int)substr($date_time, 1,2);
    $hrs_diff = $timme_hour-8;
    $timme_miniutes=(int)substr($date_time, 3,2);
    if ($timme_hour==7 AND $timme_miniutes>=40) {
        $status = 'On Time';
    }elseif ($timme_hour==7 AND $timme_miniutes<40) {
        $status = 'earlier';
    }elseif ($timme_hour<7) {
        $status = 'Too early';
    }elseif ($timme_hour==8 AND $timme_miniutes>30) {
        switch ($category) {
            case 0:
                $status = 'Late';
                break;
            
            default:
                $status = 'Late (Depends on teaching sceduler)';
                break;
        }
    }
    elseif ($timme_hour==8 AND $timme_miniutes<=30) {
        switch ($category) {
            case 0:
                $status = 'Too Late';
                break;
            
            default:
                $status = 'Too Late (Depends on teaching sceduler)';
                break;
        }
    }elseif ($timme_hour>8) {
        switch ($category) {
            case 0:
                $status = "Too Late (About $hrs_diff hour 's')";
                break;
            
            default:
                $status = "Too Late (About $hrs_diff hour 's' (Depends on teaching sceduler)";
                break;
        }
    }
    return $status;
}

function observationOut($user_id,$date_time){
    $con = parent::connect();
    $sel = $con->prepare("SELECT * FROM attendance_users WHERE attendance_users.UserId='$user_id'");
    $sel->execute();
    $ft_sel = $sel->fetch(PDO::FETCH_ASSOC);
    $category = $ft_sel['Class'];
    $timme_hour=(int)substr($date_time, 1,2);
    $hrs_diff = $timme_hour-8;
    $timme_miniutes=(int)substr($date_time, 3,2);
    if ($date_time=='-') {
        $status = 'Not Checked-Out';
    }elseif ($category==0 AND $timme_hour<17) {
        $status = 'Early';
    }elseif ($category==1 AND $timme_hour<20) {
        $status = 'Early';
    }elseif ($category==1 AND $timme_hour==20 AND $timme_miniutes<50) {
        $status = 'Early';
    }else{
        $status = 'On Time';
    }
    return $status;

}

function generalObservation($in_time,$out_time){
    $hour_in = (int)substr($in_time, 1,2);
    $hour_out = (int)substr($out_time, 1,2);
    if ($out_time=='-') {
        $resp = 'No Scan-Out.';
    }else{
        $diff = $hour_out-$hour_in;
        $resp = 'Worked <u>'.$diff.'</u> hours.';
    }
    
    return $resp;

}

function searchAttendanceByDateAndCategory($srchDate,$srchCategory){
    if ($srchDate=='' OR $srchCategory=='') {
        echo "null";
    }else{
        $arr = [];
        $con = parent::connect();
        $sel = $con->prepare("SELECT * FROM attendance_records,attendance_users WHERE attendance_users.UserId=attendance_records.RecordUser AND attendance_records.RecordTime LIKE '$srchDate%' AND attendance_users.Class='$srchCategory'");
        $sel->execute();
        if ($sel->rowCount()>=1) {
            $cnt =1;
            while ($ft_sel = $sel->fetch(PDO::FETCH_ASSOC)) {
                $user = $ft_sel['UserId'];
                if (in_array($user, $arr)) {
                    continue;
                }else{
                    array_push($arr, $user);
                    
                    $datetime = $ft_sel['RecordTime'];
                    switch ($ft_sel['Class']) {
                        case 0:
                            $category = 'Administration Staff';
                            break;
                        
                        default:
                            $category = 'Teaching Staff';
                            break;
                    }
                    ?>
                    <tr>
                        <td><?=$cnt++?></td>
                        <td><?=$ft_sel['Names']?></td>
                        <td><?=$ft_sel['Position']?></td>
                        <td><?=$category?></td>
                        <td style="font-weight:bold;font-style: italic;"><?=$this->shift_in($user,$srchDate);?></td>
                        <td><center><?=$this->observationIn($user,$this->shift_in($user,$srchDate))?></center></td>
                        <td style="font-weight:bold;font-style: italic;"><?=$this->shift_out($user,$srchDate);?></td>
                        <td><?=$this->observationOut($user,$this->shift_out($user,$srchDate))?></td>
                        <td style="font-weight: bolder;"><?=$this->generalObservation($this->shift_in($user,$srchDate),$this->shift_out($user,$srchDate));?></td>
                    </tr>
                    <?php
                }
            }
        }else{
            echo "<table class='table table-bordered'><tr> <td colspan='9'> <center style='font-weight:bolder'>No data found ...</center> </td> </tr></table>";
        }
    }
}

function missedEmployeesBYDate($srchDate,$srchCategory){
    $con = parent::connect();
    $sel = $con->prepare("SELECT * FROM attendance_users WHERE attendance_users.UserId NOT IN(SELECT attendance_users.UserId FROM attendance_records,attendance_users WHERE
    attendance_users.UserId=attendance_records.RecordUser
    AND attendance_records.RecordTime LIKE '$srchDate%' AND attendance_users.Class='$srchCategory') AND attendance_users.Class='$srchCategory' ORDER BY attendance_users.Names");
    $sel->execute();
    if ($sel->rowCount()!=0) {
?>
                <table class="table table-bordered" id="tbl_exporttable_to_xls" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Position</th>
                    </tr>
                  </thead>
                  <tbody id="resspp">
<?php
$cnt = 1;
        while ($ft_sel = $sel->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr>
                <td><?=$cnt++?></td>
                <td><?=$ft_sel['Names']?></td>
                <td><?=$ft_sel['Position']?></td>
            </tr>
            <?php
            // $cnt++;
        }
?>
    </tbody>
 </table>
<?php        
    }
}

}

$MainOpoerations = new MainOpoerations();

if (isset($_GET['login'])) {
    $MainOpoerations->login($_GET['email'],$_GET['password']);
}elseif (isset($_GET['scan_card'])) {
    $MainOpoerations->scan_card($_GET['content']);
}elseif (isset($_GET['print_card'])) {
    $MainOpoerations->print_card($_GET['contenttt']);
}elseif (isset($_GET['print_qr'])) {
    $MainOpoerations->print_qr($_GET['contenttt']);
}elseif (isset($_GET['savelfid'])) {
    $MainOpoerations->saveLfid($_GET['userCode'],$_GET['lfid']);
}elseif (isset($_GET['searchAtt'])) {
    $MainOpoerations->searchAttendanceByDateAndCategory($_GET['srchDate'],$_GET['srchCategory']);
}elseif (isset($_GET['missedEmployeesBYDate'])) {
    $MainOpoerations->missedEmployeesBYDate($_GET['srchDate'],$_GET['srchCategory']);
}

?>