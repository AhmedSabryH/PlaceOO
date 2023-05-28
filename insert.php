<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
    session_start();
    require("connection.php");
    if (isset($_GET["user"])&&isset($_GET["email"])&&isset($_GET["pass"])&&isset($_GET["type"])) {
            $r = $con->query("INSERT INTO users VALUES ('null','".$_GET["user"]."','".sha1(sha1($_GET["email"]))."','".sha1(sha1($_GET["pass"]))."','','imgs/User.png','imgs/img.png','imgs/img.png','','','','".$_GET["type"]."','','active')");
            
            if ($r){
                $_SESSION["user"]=$_GET["user"];
                $_SESSION["type"]=$_GET["type"];
                $_SESSION["email"]=sha1(sha1($_GET["email"]));
                echo "index.php";
            }
        }
        elseif (isset($_GET["email"])&&isset($_GET["pass"])) {
            $r = $con->query("SELECT * FROM users WHERE email='".sha1(sha1($_GET["email"]))."'");
            if (mysqli_num_rows($r)!=0){
                $w = $r->fetch_array(MYSQLI_ASSOC);
                if($w["password"]==sha1(sha1($_GET["pass"]))){
                    $_SESSION["email"]=$w["email"];
                    $activety=$w['activety']+1;
                    $r = $con->query("UPDATE users SET online='active' , activety=".$activety." WHERE email='".sha1(sha1($_GET["email"]))."'");
                    $_SESSION["user"]=$w["name"];
                    $_SESSION["type"]=$w["type"];
                    echo "index.php";
                }else{
                    echo"rowng pass";
                }
            }else{
            echo "rowng email";
        }
    }
    elseif (isset($_GET["email"])) {
        $counter=0;
        $r = $con->query("SELECT * FROM users WHERE email='".sha1(sha1($_GET["email"]))."'");
        if (mysqli_num_rows($r)!=0){
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host='smtp.gmail.com';
            $mail->SMTPAuth=true;
            $mail->Username='placceo.o@gmail.com';
            $mail->Password='khbpruhbhdtcwgbl';
            $mail->SMTPSecure='ssl';
            $mail->Port=465;
            $mail->Port=465;
            $mail->setFrom('placceo.o@gmail.com');
            $mail->addAddress('PlaceOO.inc');
            $mail->addAddress($_GET["email"]);
            $mail->isHTML(true);
            $mail->Subject= 'Reset Password' ;
            $w = $r->fetch_array(MYSQLI_ASSOC);
            $_SESSION['email']=$w['email'];
            $mail->Body= 'We have received your request to change your password
            To change your password,<br><a href="http://localhost/placeoo/forgetpass.php?email='.$w['email'].'&id='.$w['password'].'">please click here</a>';
            if ($mail->send()) {
                $counter=1;        
            }
        }
        if ($counter==1) {
            echo'done';
            }else{
                echo'false';
            }
    }
    elseif (isset($_GET["pass"])) {
        $r = $con->query("UPDATE users SET password ='".sha1(sha1($_GET["pass"]))."' WHERE email='".$_SESSION["email"]."'");
        if ($r){
            session_destroy();
            echo'login';
        }else{
            echo "rowng email";
    }
}
    ?>