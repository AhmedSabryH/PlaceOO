<?php
session_start();
require("connection.php");
$output='';
if (isset($_SESSION["touser"])) {
    $r = $con->query("SELECT * FROM messages WHERE fromU= '".$_SESSION["email"]."' AND toU='".$_SESSION["touser"]."' OR fromU= '".$_SESSION["touser"]."' AND toU='".$_SESSION["email"]."' ORDER BY id DESC ");
        if ($r){
            while($w = $r->fetch_array(MYSQLI_ASSOC))
            {
            if($w['toU']!=$_SESSION['email']){
                    $output='<div class="containmessage">
                    <div class="messagefrom">'.$w['message'].'</div>
                </div>';
            }else{
                $output='
                <div class="containmessage" style="justify-content: end;margin-left: -10px;">
                <div class="messageto">'.$w['message'].'</div>
                </div>';
                }
                echo $output;
            };
        }
    }
    ?>
