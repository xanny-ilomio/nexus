<?php
//hash de contraseña en la base de datos
//anti-inyecciones, confirmando los datos que se ingresan antes de hacerlo
session_start();
include 'includes/connection.php';

//para mostrar errores en el caso de que algo sale mal. Cuando el usuraio o contraseña son incorrectos
$message="";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user = $_POST["user"];
    $password = $_POST["password"];

    //consulta SQL  para buscar la contraseña en la BD
    //$mysqli->prepare crea una consulta anti inyeccion
    // ? = marcador de posicion que se reemplazara con el valor $user
    $stmt=$mysqli->prepare("SELECT contraseña FROM usuarios WHERE nombre = ?");
    
    //vincular $user con la consulta
    // bind_param(tipo de dato, valor que reemplaza ?)
    $stmt->bind_param("s",$user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($passwordHash);
        $stmt->fetch(); 
    
    if(password_verify($password,$passwordHash)){
        $_SESSION["user"]=$user;
        //redireccionar segun su rol
        $rolType = $mysqli->prepare("SELECT rol_id FROM usuarios WHERE nombre = ?");
        $rolType->bind_param("i", $user);
        $rolType->execute();
        //agarrar el valor dentro del row
        $rol = $rolType->get_result();  
        $row = $rol->fetch_assoc();
        $rolResult = $row['rol_id']; 

        if($rolResult == 1){
            header("Location: pages/admin.php");
            exit();
        } else if($rolResult == 2){
            echo"funciono";
            header("Location: pages/community.php");
            exit();
        }else{
            header("Location: pages/designer.php");
            exit();

        }
    }else{
        $message="Contraseña incorrecta.";
    }
    }else{
        $message= "El usuario no existe.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/index.css">
    <link rel="icon" href="logos/icon nexus.svg" type="image/x-icon">
    <title>Nexus</title>
</head>
<body>
    <div class="login">
        <div class="login-left">
            <div class="login-left-container">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                    <filter id="noiseFilter">
                      <feTurbulence type="fractalNoise" baseFrequency="0.8" numOctaves="2" stitchTiles="stitch" />
                    </filter>
                    <rect width="100%" height="100%" filter="url(#noiseFilter)" opacity="0.15" />
                  </svg> -->
                <div class="login-logo">
                    <img src="logos/nexus logo white.png" alt="nexus logo">
                </div>
                <div class="slogan">
                    <p>THE NEW CONCEPT</p>
                </div>
            </div>
        </div>
        <div class="login-right">
            <div class="login-right-container">
                <form class="container" action="" method="POST">
                    <h1>Usuario</h1>
                    <!-- ACOMODAR -->
                    <?php if ($message): ?>
                        <p style="color: red;"><?= htmlspecialchars($message) ?></p>
                    <?php endif; ?>
                    <div class="input-container">
                        <input type="text" name="user" placeholder="usuario" required>
                        <img src="images/icons/user.svg" alt="user icon">
                    </div>
                    <div class="input-container">
                        <input type="password" name="password" placeholder="contraseña" required>
                        <img src="images/icons/lock.svg" alt="lock icon">
                    </div>
                    <a href="#">¿Ha olvidado su contraseña?</a>
                    <button>Ingresar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>