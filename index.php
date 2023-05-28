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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo/logo-title.png">
    <link rel="stylesheet" href="styleindex.css">
    <title>Place OO</title>
<body style="overflow: unset;">
<!-- <div class="loadpage" id="load">
            <div class="contin" id="contin">
                <img id="img1" src="logo/insert.png" alt="">
            </div>
        </div> -->
<div class="con" >
        <nav>
            <div class="right">
                <h1><span style="color:#331a6d; font-size:20px;">welcom,</span><?php echo $_SESSION["user"]; ?></h1>
            </div>
            <div class="links">
                <a href="profile.php?id=<?php echo $_SESSION['email'] ?>">profile</a>
                <a href="message.php">Messanger</a>
                <a href="?logout=" style="color:red;" alt="logout"><img src="logo/out.png" width="25px"></a>
            </div>
        </nav>
        <div class="main" >
          <header>
          <form action="index.php" method="post" id="form">
          <?php
          if (isset($_POST["priv"])&&$_POST["priv"]!='') {
            echo'<select name="priv" onchange="sub()"><option value="'.$_POST["priv"].'">'.$_POST["priv"].'</option>';
            $r = $con->query("SELECT * FROM provincs WHERE name!='".$_POST["priv"]."'");
            if ($r){
              while ($w = $r->fetch_array(MYSQLI_ASSOC)) {
                echo "<option value='".$w['name']."'>".$w['name']."</option>";
              }
              echo'</select>';     
            } 
            if(isset($_POST["priv"])&&$_POST["priv"]!=''&&isset($_POST["city"])&&$_POST["city"]!='') {

              echo'<select name="city" onchange="sub()"><option value="'.$_POST["city"].'">'.$_POST["city"].'</option>';
              $r = $con->query("SELECT * FROM citys WHERE provincs='".$_POST["priv"]."' AND name!= '".$_POST["city"]."'");
              if ($r){
                while ($w = $r->fetch_array(MYSQLI_ASSOC)) {
                  echo "<option value='".$w['name']."'>".$w['name']."</option>";
                }
                echo'</select>';     
                }
            }else{
              echo'<select name="city" onchange="sub()"><option value="">المدينة</option>';
              $r = $con->query("SELECT * FROM citys WHERE provincs='".$_POST["priv"]."'");
              if ($r){
                while ($w = $r->fetch_array(MYSQLI_ASSOC)) {
                  echo "<option value='".$w['name']."'>".$w['name']."</option>";
                }
                
                echo'</select>';     
                }
            }
          }
          else{
             echo'<select name="priv" onchange="sub()"><option value="">اختر المحافظه</option>';
              $r = $con->query("SELECT * FROM provincs");
              if ($r){
                while ($w = $r->fetch_array(MYSQLI_ASSOC)) {
                  echo "<option value='".$w['name']."'>".$w['name']."</option>";
                }
                echo'</select>';     
              }
            }
            ?>
        </form>
      </header>
      <div class="contact">
        <?php
        if (isset($_POST["priv"])&&$_POST["priv"]!=''&&isset($_POST['city'])==false) {
          $r = $con->query("SELECT * FROM users WHERE priv='".$_POST["priv"]."' And email!='".$_SESSION['email']."' AND type!='clint' ORDER BY users . activety DESC");
            if ($r) {
              while ($w = $r->fetch_array(MYSQLI_ASSOC)) {
                echo '<div class="stuf">
                <div class="img">
                   <img src="'.$w['img'].'" alt="" width="70%" height="65%" >
                  </div>
                  <div class="info">
                    <h1>'.$w['name'].'</h1>';
                      if ($w['online']=='active') {
                        echo'<h3>online</h3>';
                      }else{
                        echo'<h3 style="color:#ff4949;">offline</h3>';
                      }
                    echo'
                    <div class="sample">
                      <div class="imgs">
                        <img src="'.$w['img1'].'" alt="" width="100%" height="100%" >
                        </div>
                        <div class="imgs">
                        <img src="'.$w['img2'].'" alt="" width="100%" height="100%" >
                        </div>
                  </div>
                  <button>
                      <a href="profile.php?id='.$w['email'].'"> profile</a>
                    </button>
                  </form>
                </div>
              </div>
              <br>';
              }
            }
        }elseif(isset($_POST["priv"])&&$_POST["priv"]!=''&&isset($_POST["city"])&&$_POST["city"]!='') {
          $r = $con->query("SELECT * FROM users WHERE priv='".$_POST["priv"]."' AND city='".$_POST["city"]."' And email!='".$_SESSION['email']."' AND type!='clint' ORDER BY users . activety DESC");
          if ($r) {
            while ($w = $r->fetch_array(MYSQLI_ASSOC)) {
              echo '<div class="stuf">
              <div class="img">
                 <img src="'.$w['img'].'" alt="" width="70%" height="65%" >
                </div>
                <div class="info">
                  <h1>'.$w['name'].'</h1>';
                    if ($w['online']=='active') {
                      echo'<h3>online</h3>';
                    }else{
                      echo'<h3 style="color:#ff4949;">offline</h3>';
                    }
                  echo'
                  <div class="sample">
                    <div class="imgs">
                      <img src="'.$w['img1'].'" alt="" width="100%" height="100%" >
                      </div>
                      <div class="imgs">
                      <img src="'.$w['img2'].'" alt="" width="100%" height="100%" >
                      </div>
                </div>
                <button>
                    <a href="profile.php?id='.$w['email'].'"> profile</a>
                  </button>
                </form>
              </div>
            </div>
            <br>';
            }
          }
        }
        else {
          $r = $con->query("SELECT * FROM users WHERE type!='clint' AND email!='".$_SESSION['email']."' ORDER BY users . activety DESC");
          if ($r) {
            while ($w = $r->fetch_array(MYSQLI_ASSOC)) {
              echo '<div class="stuf">
              <div class="img">
                 <img src="'.$w['img'].'" alt="" width="70%" height="65%" >
                </div>
                <div class="info">
                  <h1>'.$w['name'].'</h1>';
                    if ($w['online']=='active') {
                      echo'<h3>online</h3>';
                    }else{
                      echo'<h3 style="color:#ff4949;">offline</h3>';
                    }
                  echo'
                  <div class="sample">
                    <div class="imgs">
                      <img src="'.$w['img1'].'" alt="" width="100%" height="100%" >
                      </div>
                      <div class="imgs">
                      <img src="'.$w['img2'].'" alt="" width="100%" height="100%" >
                      </div>
                </div>
                <button>
                    <a href="profile.php?id='.$w['email'].'"> profile</a>
                  </button>
                </form>
              </div>
            </div>
            <br>';
            }
          }
        }
          ?>
          
          
        </div>
      </div>
    </div>
     <!-- <div style="display: none;">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/Yf5d_Zx3AaI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/Yf5d_Zx3AaI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div> -->
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
  function sub(){
  document.getElementById('form').submit();
  }
  function send(){
        n=document.getElementById('email').value;
        e=document.getElementById('pass').value;
        document.getElementById('emai').innerHTML='';
        document.getElementById('result').innerHTML='';
        if(e!=''&&n!=''){
            x=new XMLHttpRequest();
            x.onreadystatechange=function(){
                if(x.readyState==4&&x.status==200){
                    if(x.responseText=='<link rel="stylesheet" href="style.css">index.php'){
                        window.location.href = 'index.php';
                    }else if(x.responseText=='<link rel="stylesheet" href="style.css">rowng email'){
                        document.getElementById('emai').innerHTML='<div style="color: white; margin-bottom: 30px; padding: 10px; height: 20px; border-radius: 20px; text-shadow: 0 0 1px black;">'+x.responseText+'</div>';
                    }else{
                        document.getElementById('result').innerHTML='<div  style="color: #fd0000; margin-bottom: 30px; padding: 10px; height: 20px; border-radius: 20px; text-shadow: 0 0 1px #202020;">'+x.responseText+'</div>';
                    }
                }
            }
            x.open("GET","insert.php?email="+n+"&pass="+e+"");
            x.send();
        }
        else{
            document.getElementById('emai').innerHTML='<div style="color:white; font-size:30px; margin-bottom: 30px; padding: 10px; height: 20px; border-bottom:1px solid white; border-radius: 20px; text-shadow: 0 0 1px #202020;">ادخل البيانات كاملة</div>';
        }
    }
    function mo() {
        window.location.href = 'signup.php';
    }
</script>