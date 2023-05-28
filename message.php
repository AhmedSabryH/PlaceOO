<?php
    session_start();
    require("connection.php");
    if (isset($_SESSION["user"])!=true) {
        header("location:login.php");
    }
    if (isset($_GET["logout"])) {
        $r = $con->query("UPDATE users SET online='deactive' WHERE email='".$_SESSION["email"]."'");
        session_destroy();
        header("location:login.php");
    }
    if(isset($_GET["id"])){
        $_SESSION["touser"]=$_GET["id"];

    }
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo/logo-title.png">
    <link rel="stylesheet" href="styleindex.css">
    <title>Messages</title>
<body style="overflow: unset;">
<div class="con" >
        <nav>
            <div class="right">
                <h1><span style="color:#331a6d; font-size:20px;">welcom,</span><?php echo $_SESSION["user"]; ?></h1>
            </div>
            <div class="links">
                <a href="index.php">Home</a>
                <a href="profile.php?id=<?php echo $_SESSION['email'] ?>">profile</a>
                <a href="?logout=" style="color:red;" alt="logout"><img src="logo/out.png" width="25px"></a>
            </div>
        </nav>
        <div class="main" >
        <div class="continar">
        <div class="leftmessage" id="leftmessage">
            <h1>Messages</h1>
         <?php

            //get all users

                  $r = $con->query("SELECT * FROM messages WHERE fromU= '".$_SESSION["email"]."' OR toU='".$_SESSION["email"]."' ORDER BY 'users.id' DESC ");
                  if (mysqli_num_rows($r)!=0){
                      $users=array();
                      while($w = $r->fetch_array(MYSQLI_ASSOC)) {
                          if ($w['fromU']!=$_SESSION['email']) {
                            array_push($users,"".$w['fromU']."");
                            }else{
                                array_push($users,"".$w['toU']."");                
                }
            }
            
            //fillter results

            $users=array_unique($users);
            
            //fix indexs
            
            sort($users);
            
            //get final result

            for ($i=0; $i < count($users) ; $i++) { 
                $r3 = $con->query("SELECT * FROM messages WHERE toU= '".$_SESSION["email"]."' AND fromU='".$users[$i]."' OR fromU= '".$_SESSION["email"]."' AND toU='".$users[$i]."' ORDER BY id DESC LIMIT 1 ");
                if (mysqli_num_rows($r3)!=0) {
                    $w3 = $r3->fetch_array(MYSQLI_ASSOC);
                    if ($w3['fromU']!=$_SESSION['email']) {
                                echo'<a href="?id='.$w3['fromU'].'">
                                        <div class="imguser">';
                                        $r2 = $con->query("SELECT * FROM users WHERE email= '".$w3['fromU']."'");
                                        $w2 = $r2->fetch_array(MYSQLI_ASSOC);
                                        echo'<img src="'.$w2['img'].'" alt="" width="100%" height="100%">';
                                        echo '</div>
                                        <div class="infouser">
                                        <h1>'.$w2['name'].'</h1>';
                                        if ($w2['online']=='active') {
                                            echo '<p id="type"><span>.</span>online</p>';
                                        }else{
                                            echo '<p id="type" style="color:red;"><span>.</span>offline</p>';
                                        }
                                        echo '<p id="lastmessage">'.$w3['message'].'</p>
                                        </div>
                                        </a>
                                        <br/>';
                                    }else{
                                    echo'<a href="?id='.$w3['toU'].'">
                                            <div class="imguser">';
                                    $r2 = $con->query("SELECT * FROM users WHERE email= '".$w3['toU']."'");
                                      $w2 = $r2->fetch_array(MYSQLI_ASSOC);
                                      echo'<img src="'.$w2['img'].'" alt="" width="100%" height="100%">';
                                    echo '</div>
                                    <div class="infouser">
                                        <h1>'.$w2['name'].'</h1>';
                                        if ($w2['online']=='active') {
                                            echo '<p id="type"><span>.</span>online</p>';
                                        }else{
                                            echo '<p id="type" style="color:red;"><span>.</span>offline</p>';
                                        }
                                        echo '<p id="lastmessage">'.$w3['message'].'</p>
                                        </div>
                                        </a>
                                        <br/>';
                                    
                            }
                }
            }
            }else{
                    echo'<h1>You Need Start Chat With Any One <h1>';
                }
                ?>
    </div>
    <div class="rightmessage">
            <div class="headermessage">
                <?php
                if (isset($_SESSION['touser'])&&$_SESSION['touser']!='') {
                    $r = $con->query("SELECT * FROM users WHERE email= '".$_SESSION['touser']."'");
                    $w = $r->fetch_array(MYSQLI_ASSOC);
                    echo'
                    <div class="imgconmessage">
                        <img src="'.$w['img'].'" alt="" width="100%" height="100%">
                    </div>
                    <h1>'.$w['name'].'</h1>';
                    if ($w['online']=='active') {
                        echo '<p id="type" style="color: rgb(2, 192, 2);"><span>.</span>online</p>';
                        }else{
                            echo '<p id="type" style="color:red;"><span>.</span>offline</p>';
                        }
                echo'</div>
                    ';
                }else{
                    echo'<div class="imgconmessage">
                     </div>
                <h1><_Select User</h1>
                <p id="type" style="color: rgb(2, 192, 2);"></p>
            </div>';
                }

                ?>
            <div class="mainmessage" id="mainmessage">
                
            </div>
            <div class="fottermessage">
                <input type="text" id="message" placeholder="text message...">
                <input type="button" onclick="send()" id="btn" value="send"> 
            </div>
        </div>
      </div>
        </div>
    </div>
    <div class="loadpage" id="load">
            <div class="contin" id="contin">
                <img id="img1" src="logo/insert.png" alt="">
            </div>
        </div>
     <div style="display: none;">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/Yf5d_Zx3AaI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/Yf5d_Zx3AaI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
</body>
</html>
<script>
         window.addEventListener("load",function(){
            setTimeout(() => {
                 document.getElementById("load").remove();
            },1200);
         })
    </script>
<script>
    var input = document.getElementById("message");
     // Execute a function when the user presses a key on the keyboard
     input.addEventListener("keypress", function(event) {
       // If the user presses the "Enter" key on the keyboard
       if (event.key === "Enter") {
         // Cancel the default action, if needed
         event.preventDefault();
         // Trigger the button element with a click
         document.getElementById("btn").click();
       }
     });
    function send(){
        
        n=document.getElementById('message').value;
        x=new XMLHttpRequest();
        x.onreadystatechange=function(){
            if(x.readyState==4&&x.status==200){
                // document.getElementById('result').innerHTML=x.responseText;
                // alert(x.responseText);
            }
        }
        x.open("GET","insertMessage.php?msg="+n+"");
        x.send();
        document.getElementById('message').value="";
    }
    setInterval(real, 200);
function real(){
            x=new XMLHttpRequest();
        x.onreadystatechange=function(){
            if(x.readyState==4&&x.status==200){
            document.getElementById('mainmessage').innerHTML=x.responseText;
                // alert(x.responseText);
            }
        }
        x.open("GET","realTimeChat.php?touser=''");
        x.send();    
        }
</script>