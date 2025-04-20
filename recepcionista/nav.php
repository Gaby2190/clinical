<!-- sidebar menu start -->
<div class="sidebar-menu sticky-sidebar-menu">

    <!-- logo start -->
    <div class="logo">
        <a href="rece.php">
            <img src="../assets/images/nombre_cesmed.png" alt="nombreCESMED" title="nombreCESMED" class="img-fluid" style="height:35px; width: 100%;" />
        </a>
    </div>


    <div class="logo-icon text-center">
        <a href="rece.php" title="logo">
            <img src="../assets/images/logo_cesmed.png" alt="logo-icon" style="height:47px;"> 
        </a>
    </div>
    <!-- //logo end -->

    <div class="sidebar-menu-inner" id="barra-lateral">
    
    <input type="text" id="id_usuario" value="<?php echo htmlspecialchars($_SESSION["id_usuario"]);?>" hidden>
        <!-- sidebar nav start -->
        <ul class="nav nav-pills nav-stacked custom-nav">
            <li class="active"><a href="rece.php"><i class="fa fa-tachometer"></i><span>INICIO</span></a>
            </li>
            <li class="menu-list">
                <a href="#"><i class="fa fa-group"></i>
                <span class="text-uppercase">Pacientes<i class="lnr lnr-chevron-right"></i></span></a>
                <ul class="sub-menu-list">
                    <li><a href="paci_create.php">Registrar</a> </li>
                    <li><a href="paci_read.php">Actualizar</a> </li>
                </ul>
            </li>
            <li class="menu-list">
                <a href="#"><i class="fa fa-user-circle"></i>
                <span class="text-uppercase">Asistentes<i class="lnr lnr-chevron-right"></i></span></a>
                <ul class="sub-menu-list">
                    <li><a href="asis_create.php">Registrar</a> </li>
                    <li><a href="asis_read.php">Actualizar</a> </li>
                </ul>
            </li>
            <li class="menu-list">
                <a href="#"><i class="fa fa-address-book"></i>
                <span class="text-uppercase">Agenda<i class="lnr lnr-chevron-right"></i></span></a>
                <ul class="sub-menu-list">
                    <li><a href="cita_age_doc_n.php">Agenda Médicos</a> </li>
                    <!-- 
                    <li><a href="caso_create.php">Caso nuevo</a> </li>
                    <li><a href="cita_control.php">Cita de control</a> </li>
                    -->
                    <li><a href="cita_age_read.php">Citas agendadas</a> </li>
                    <li><a href="historial_citas.php">Historial de citas</a> </li>
                    <li><a href="disp_med.php">Disponibilidad Médicos</a> </li>
                    
                </ul>
            </li>

            <li class="menu-list">
                <a href="#"><i class="fa fa-hospital-o"></i>
                <span class="text-uppercase">Caja<i class="lnr lnr-chevron-right"></i></span></a>
                <ul class="sub-menu-list">
                    <li><a href="c_pendientes.php">Cobros pendientes</a> </li>
                    <li><a href="historial_tickets.php">Historial de Tickets</a> </li>
                    <li><a href="cobros_realizados.php">Cobros realizados</a> </li>
                    <li><a href="historial_pagos.php">Historial de pagos</a> </li>
                    <li><a href="cuadre_caja.php">Cuadre de caja diario</a> </li>
                    
                </ul>
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
                <p style="color: #22445d; font-family: sans-serif; font-size: 20px;" id="rol_usr"><span class="fa fa-id-card"></span> RECEPCIONISTA</p>
            </div>

            <div class="user-dropdown-details d-flex">

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
                                <li> <a href="perfil.php"><i class="lnr lnr-user"></i>Perfil</a> </li>
                                <li> <a href="c_contrasena.php"><i class="lnr lnr-cog"></i>Cambiar Clave</a></li>
                                <li class="logout"> <a href="../login/login.php?cerrar_sesion=1"><i class="fa fa-power-off"></i>Salir</a> </li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </div>
            
        </div>
    </div>
    <!--notification menu end -->
</div>
<!-- //header-ends -->