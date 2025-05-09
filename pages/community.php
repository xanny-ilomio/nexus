<?php
session_start();
include '../includes/connection.php';
?>
                
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nexus</title>
        <link rel="stylesheet" href="../styles/cm.css">
        <link rel="icon" href="../logos/icon nexus.svg">
        <!-- <script defer>
            const user = <?= json_encode($user) ?>;
        </script> -->
        <script src="../scripts/community.js" defer></script>
        <script src="../scripts/welcome.js" defer></script>
    </head>
    <body>
        <!-- SIDEBAR -->
        <button class="desplegable" onclick=show() id="desplegable-btn">
            <div class="bar" id="bar1"></div>
            <div class="bar" id="bar2"></div>
            <div class="bar" id="bar3"></div>
        </button>
            <nav class="nav-list" id="sidebar">
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
                            <li><span>Lisa Mendoza</span></li>
                        </ul>
                    </li>    
            
                </ul>
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
            <div class="welcome" data-user="<?= htmlspecialchars($_SESSION['user'])?>">
                <div class="date"></div>
                <div class="hello"></div>
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