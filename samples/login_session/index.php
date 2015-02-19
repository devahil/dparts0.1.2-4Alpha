<?php
    require_once './core/dpcore.config.php';
    $conf = new coreconfig();
    
?>
<!DOCTYPE html>

<html lang="es">
 <head>
 <title>Create Session</title>
 <meta charset="utf-8"/>
 </head>
 <body>
 <h1>Create Session</h1>
 <form action="webapps/main.php" method="post">
 <p>
 <label>User:</label> <br />
 <input type="text" name="usuario" /><BR>
 <label>Password:</label> <br />
 <input type="password" name="pass" />
 </p>
 <p>
 <input type="submit" value="Crear sesión" />
 </p>
 </form>
 </body>
</html>
