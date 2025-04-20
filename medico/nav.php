<!-- sidebar menu start -->
<div class="sidebar-menu sticky-sidebar-menu">

    <!-- logo start -->
    <div class="logo">
        <a href="medi.php">
            <img src="../assets/images/nombre_cesmed.png" alt="nombreCESMED" title="nombreCESMED" class="img-fluid" style="height:35px; width: 100%;" />
        </a>
    </div>


    <div class="logo-icon text-center">
        <a href="medi.php" title="logo"><img src="../assets/images/logo_cesmed.png" alt="logo-icon" style="height:47px;""> </a>
    </div>
    <!-- //logo end -->

    <div class="sidebar-menu-inner" id="barra-lateral">
    
    <input type="text" id="id_usuario" value="<?php echo htmlspecialchars($_SESSION["id_usuario"]);?>" hidden>
        <!-- sidebar nav start -->
        <ul class="nav nav-pills nav-stacked custom-nav">
            <li class="active"><a href="medi.php"><i class="fa fa-tachometer"></i><span>INICIO</span></a>
            </li>
            <li class="menu-list">
                <a href="#"><i class="fa fa-address-book"></i>
                <span class="text-uppercase">Casos<i class="lnr lnr-chevron-right"></i></span></a>
                <ul class="sub-menu-list">
                    <li><a href="caso_create.php">Caso nuevo</a> </li>
                    <li><a href="cita_control.php">Cita de control</a> </li>
                    <li><a href="casos_abiertos.php">Alta médica</a> </li>
                    <li><a href="altas_medicas.php">Historial médico</a> </li>
                </ul>
            </li>
            <li class="menu-list">
                <a href="#"><i class="fa fa-calendar"></i>
                <span class="text-uppercase">Agenda<i class="lnr lnr-chevron-right"></i></span></a>
                <ul class="sub-menu-list">
                    <li><a href="cita_age_doc.php">Agenda Médico</a> </li>
                    <li><a href="cita_age_read.php">Citas agendadas</a> </li>
                    <li><a href="historial_citas.php">Historial de citas</a> </li>
                    <li><a href="citas_atendidas.php">Citas atendidas</a> </li>
                    <li><a href="disp_med.php">Disponibilidad Médico</a> </li>
                </ul>
            </li>
            <li>
                <a href="sala_espera.php"><i class="fa fa-clock-o"></i> <span>Sala de espera</span></a>
            </li>

        </ul>
        <!-- //sidebar nav end -->
        <!-- toggle button start -->
        <a class="toggle-btn">
            <i class="fa fa-angle-double-left menu-collapsed__left"><span>Ocultar barra lateral</span></i>
            <i class="fa fa-angle-double-right menu-collapsed__right"><p><small>Más</small></p></i>
        </a>
        <!-- //toggle button end -->
    </div>
</div>
<!-- //sidebar menu end -->
<!-- header-starts -->
<div class="header sticky-header">

    <!-- notification menu start -->
    <div class="menu-right">
        <div class="navbar user-panel-top">
            <div class="search-box">
                <p style="color: #22445d; font-family: sans-serif; font-size: 20px;" id="rol_usr"><span class="fa fa-user-md"></span> MÉDICO</p>
            </div>

            <div class="user-dropdown-details d-flex">

                <div class="profile_details_left">
                    <ul class="nofitications-dropdown">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell-o"></i><span class="badge blue">3</span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="notification_header">
                                        <h3>You have 3 new notifications</h3>
                                    </div>
                                </li>
                                <li>
                                    <a href="#" class="grid">
                                        <div class="user_img"><img src="../assets/images/avatar1.jpg" alt=""></div>
                                        <div class="notification_desc">
                                            <p>Johnson purchased template</p>
                                            <span>Just Now</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="odd">
                                    <a href="#" class="grid">
                                        <div class="user_img"><img src="../assets/images/avatar2.jpg" alt=""></div>
                                        <div class="notification_desc">
                                            <p>New customer registered </p>
                                            <span>1 hour ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="grid">
                                        <div class="user_img"><img src="../assets/images/avatar3.jpg" alt=""></div>
                                        <div class="notification_desc">
                                            <p>Lorem ipsum dolor sit amet </p>
                                            <span>2 hours ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="notification_bottom">
                                        <a href="#all" class="bg-primary">See all notifications</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="profile_details">
                    <ul>
                        <li class="dropdown profile_details_drop">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenu3" aria-haspopup="true" aria-expanded="false">
                                <div class="profile_img">
                                    <img src="" class="rounded-circle" id="imagen-perfil" alt="" />
                                    <div class="user-active">
                                        <span></span>
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu drp-mnu" aria-labelledby="dropdownMenu3">
                                <li class="user-info">
                                    <h5 class="user-name" id="nom_usr"></h5>
                                </li>
                                <li> <a href="perfil.php"><i class="lnr lnr-user"></i>Mi Perfil</a> </li>
                                <li> <a href="c_contrasena.php"><i class="lnr lnr-cog"></i>Cambio de contraseña</a></li>
                                <li class="logout"> <a href="../login/login.php?cerrar_sesion=1"><i class="fa fa-power-off"></i>Cerrar sesión</a> </li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </div>
            
        </div>
    </div>
    <!--notification menu end -->
</div>