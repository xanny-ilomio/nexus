<?php
session_start();
include '../includes/connection.php';
$message="";
// REQUEST DE USUARIO
if($_SERVER['REQUEST_METHOD']=== 'POST'){
    //isset() verificamos que exista la solicitud
    if(isset($_POST['action'])){
        if($_POST['action'] === 'add'){
            $name = $_POST['name'];
            $apellido = $_POST['apellido'];
            $rol_id = $_POST['rol_id'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $correo = $_POST['correo'];

            //evitar duplicidad del correo
            $queryEmail = "SELECT * FROM usuarios WHERE correo = '$correo'";
            $resultEmail = mysqli_query($mysqli, $queryEmail);

            if(mysqli_num_rows($resultEmail) > 0){
                $message="Correo ya existente.";
            } else{
                $queryAddUser = "INSERT INTO usuarios(nombre, apellido, correo, contraseña, rol_id) VALUES ('$name','$apellido','$correo','$password',$rol_id)";
                if(mysqli_query($mysqli, $queryAddUser)){
                    //para dejar de enviar el POST al recargar la pagina
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit();
                }
            }

        }else if($_POST['action'] === 'edit'){
            //
        } else if($_POST['action']=== 'delete'){
            //
        }
    } 
}

//CARGAR USUARIOS PARA MOSTRAR EN LA TABLA
$users = [];
//query = consulta
$query = "SELECT * FROM usuarios";
$result = mysqli_query($mysqli, $query);
//procedemos si la consulta se logro
if($result){
    //mientras haya usuarios va a guardar su contenido
    //mysqli_fetch_assoc($result) = el resultado de la consulta en $result lo convierte en un array
    while($row = mysqli_fetch_assoc($result)){
        //guardamos en $users
        $users[]= $row;
    }
}

// LOGOUT
if(isset($_POST['logout'])){
    $_SESSION= array();
    session_destroy();
    header("Location: ../index.php");
    exit();
}

?>
                
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nexus</title>
        <link rel="stylesheet" href="../styles/admin98.css">
        <link rel="icon" href="../logos/icon nexus.svg">

        <script src="../scripts/community.js" defer></script>
        <script src="../scripts/welcome.js" defer></script>  
        <script src="../scripts/adduser3.js" defer></script>  
    </head>
    <body>
        <!-- SIDEBAR -->
        <button class="desplegable" onclick=show() id="desplegable-btn">
            <div class="bar" id="bar1"></div>
            <div class="bar" id="bar2"></div>
            <div class="bar" id="bar3"></div>
        </button>
            <nav class="nav-list" id="sidebar">
                <div>

                    <ul class="principal">
                        <li><a href=""><img src="../images/icons/home.svg" alt="inicio" class="nav-icons"><span>Inicio</span></a></li>
                        <li><a href=""><img src="../images/icons/inbox.svg" alt="inicio" class="nav-icons"><span>Bandeja de entrada</span></a></li>
                        <hr>
    
                        <li class="dropdown">
                            <div class="head">
                                <span>Proyectos</span>
                                <button class="dropdown-btn" onclick=toggleSubMenu(this)>
                                    <img src="../images/icons/dropdown.svg" alt="">
                                </button>
                                <button class="add-btn">
                                    <!-- HACER QUE FUNCIONE EL BOTON ADD -->
                                    <img src="../images/icons/add.svg" alt="">
                                </button>
                            </div>
                            <ul class="sub-menu">
                                <div>
                                    <li><a href=""><span>example</span></a></li>
                                </div>
                            </ul>
    
                        </li>
                        <hr>
                        <li>
                            <div>
                                <img src="../images/icons/team.svg" alt="inicio" class="nav-icons">
                                <span>Equipo</span>
                            </div>
                            <ul>
                                <?php foreach($users as $user): ?>
                                    <li><span><?= htmlspecialchars(ucwords($user['nombre'] . " " . $user['apellido'])) ?></span></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>    
                    </ul>
                </div>
                <div class="logout-btn">
                    <form action="" method="post">
                        <button class="logout" type="submit" name="logout">Cerrar Sesión</button>
                    </form>
                </div>
            </nav>
            <!-- SEARCH BOX -->
            <header class="header">
                <div class="left">
                    <div class="search-box">
                        <div class="row">
                            <input type="text" id="input-box" placeholder="Buscar" autocomplete="off">
                            <button>
                                <img src="../images/icons/search.svg" alt="">
                            </button>
                        </div>
                        <div class="result-box">
                        </div>
                    </div>
                </div>
                <div class="profile-photo">
                    <img src="../images/pfp/pfp.jpeg" alt="" class="pfp">
                </div>
            </header>

            <!-- MAIN CONTENT -->
        <main>
            <div class="welcome" data-user="<?= htmlspecialchars(ucwords($_SESSION['user']))?>">
                <div class="date"></div>
                <div class="hello"></div>
            </div>

            <!-- MANEJO DE USUARIOS -->
            <div class="projects-dashboard users">
            <div class="new-user">
                        <button class="close-addUser" onclick=closeNewUser()>
                            <img src="../images/icons/close.svg" alt="">
                        </button>
                        <h1>Nuevo usuario</h1>
                        <form action="" method="POST" class="new-user-form">
                            <input type="hidden" name="action" value="add">
                            <div class="container">
                                <label for="name">Nombre</label>
                                <input maxlength="30" type="text" id="name" name="name" required placeholder="Nombre">
                            </div>
                            
                            <div class="container">
                                <label for="apellido">Apellido</label>
                                <input type="text" id="apellido" name="apellido" maxlength="30" required placeholder="Apellido">
                            </div>
                            <?php if ($message): ?>
                                <p style="color: red;"><?= htmlspecialchars($message) ?></p>
                            <?php endif; ?>
                            
                            <div class="container">
                                <label for="correo">Email</label>
                                <!-- ACOMODAR EL .COM -->
                                <input maxlength="50" type="email" name="correo" id="correo" required placeholder="ejemplo@gmail.com" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.com$" title="El correo electrónico debe terminar con .com">
                            </div>
                            <div class="container">
                                <label for="dropdown">Rol</label>
                                <select name="rol_id" id="dropdown" required>
                                        <option class="option" value="" disabled selected>Seleccionar rol a cumplir</option>
                                        <option class="option" value="2">Community Manager</option>
                                        <option class="option" value="3">Diseñador</option>
                                </select>
                            </div>

                            <div class="container">
                                <label for="password">Contraseña</label>
                                <input type="password" name="password" id="password" required>
                            </div>

                            <button type="submit" class="new-user-btn">Añadir usuario</button>
                        </form>
                    </div>
                <div class="dashboard-header">
                    <h3>Usuarios</h3>
                </div>
                <div class="dashboard-content">
                    <table class="projects-table">
                        <thead>
                            <tr>
                                <th id="head1-table-user">Nombre</th>
                                <th id="head2-table-user">Apellido</th>
                                <th id="head3-table-user">Rol</th>
                                <th id="head4-table-user">Correo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($users as $user): ?>
                            <!-- por cada usuario existente, creamos un row en la tabla -->
                            <tr>
                                <td id="table1-user"><?= htmlspecialchars(ucwords($user['nombre'])) ?></td>
                                <td id="table2-user"><?= htmlspecialchars(ucwords($user['apellido']))  ?></td>
                                <?php 
                                    $rol = $user['rol_id'];
                                    if($rol === '1'){
                                        $userRol = "Administrador";
                                    } else if($rol === '2'){
                                        $userRol = "Community manager";
                                    } else if ($rol === '3'){
                                        $userRol = "Diseñador";
                                    }
                                 ?>
                                <td id="table3-user"><?= htmlspecialchars($userRol) ?></td>
                                <td id="table4-user"><?= htmlspecialchars($user['correo']) ?></td>
                            </tr>
                        </tbody>
                        <?php endforeach; ?>
                    </table>
                    <button class="add-project" onclick=newUser()>+ Añadir nuevo usuario</button>
                </div>
                
            </div>
            <div class="projects-dashboard">
                <div class="dashboard-header">
                    <h3>Proyectos</h3>
                </div>
                <div class="dashboard-content">
                    <table class="projects-table">
                        <thead>
                            <tr>
                                <th id="head1-table">Proyecto</th>
                                <th id="head2-table">Asignado a</th>
                                <th id="head3-table">Estatus</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <button class="add-project">+ Añadir nuevo proyecto</button>
                </div>
            </div>
        </main>
    </body>
</html>