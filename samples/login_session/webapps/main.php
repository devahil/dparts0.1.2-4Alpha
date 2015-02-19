<?php
   
 require_once '../../../core/dpcore.security.php';
 $security=new coresecurity();
 $security->create_session($_POST['usuario'], $_POST['pass']);
 $nivel_acceso=4;
 if($nivel_acceso <= $_SESSION['usuario_nivel']){
     header("Location: ../redirect.php?err=5");
     exit();
 }

?>
<!DOCTYPE html>
<html lang="es">
 <head>
     <meta charset="utf-8"/>
 <title>Create Session</title>
 </head>
 <body>
 <div class="c1">
 <h2>Sesion DATA</h2>
 <section>
 <p>
     User: <?php echo $_SESSION['usuario_login'];?><br>
     User_Level: <?php echo $_SESSION['usuario_nivel'];?><br>
     User_ID: <?php echo $_SESSION['usuario_id'];?><br>
 </p>
 </section>
 </div>

 <div class="c2">
 <section>
 <p>
     <a href="../logout.php">Close</a> <!-- de esta forma se crea la nueva session, sin necesidad de crear otro script en php. -->
 </p>
 </section>
 </div>
 </body>
</html>