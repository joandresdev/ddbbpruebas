<!--
*  profile.html 
*  @version: 1.0.0
*  @author: Universidad Politecnica - Jazmin Pool, kath
*  @description: PERFIL ALUMNO
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="<?php echo constant('URL'); ?>public/css/style.css"></link>
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/fontawesome/css/all.css">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> -->
    <title>SEE - Perfil</title>
    <link rel="shortcut icon" href="">
</head>
<body>
    <div class="main flex">
        <div class="column profile">
            <div class="row-responsive">
            <div class="column menu-left align-center justify-center">
                        <div class="white-space-24"></div>
                        <div class="responsive-img item-left justify-center align-center">
                            <img src="<?php echo constant('URL'); ?>public/img/upqroo-newlogo@2x.png" alt="responsive img" title="responsive img" class="cover-img "/>
                        </div>
                        <div class="white-space-32"></div>
                        <div class="white-space-16"></div>
                        <div class="column main align-center auto">
                            <div class="row item-left justify-center align-start">
                                <div class = "column">
                                    <h4 class="color-white weight-regular font-small"><a href="<?php echo constant('URL'); ?>alumnos/datos">Datos generales</a></h4>
                                </div>
                            </div>
                            <div class="row item-left justify-center">
                                <div class = "column">
                                    <h4 class="color-white weight-regular font-small"><a href="<?php echo constant('URL'); ?>xd">Carga académica</a></h4>
                                </div>                        
                            </div>
                            <div class="row item-left justify-center">
                                <div class = "column">
                                    <h4 class="color-white weight-regular font-small"><a href="<?php echo constant('URL'); ?>xd">Calificaciones</a></h4>
                                </div>
                            </div>
                            <div class="row item-left justify-center">
                                <div class="column">
                                    <h4 class="color-white weight-regular font-small"><a href="<?php echo constant('URL'); ?>xd">Kardex</a></h4>
                                </div>
                            </div>
                            <div class="row item-left justify-center">
                                <div class = "column">
                                    <h4 class="color-white weight-regular font-small"><a href="<?php echo constant('URL'); ?>xd">Horario</a></h4>
                                </div>
                            </div>
                            <div class="row item-left justify-center">
                                <div class = "column">
                                    <h4 class="color-white weight-regular font-small"><a href="<?php echo constant('URL'); ?>xd">Noticias</a></h4>
                                </div>
                            </div>
                            <div class="row item-left justify-center">
                                <div class = "column">
                                    <h4 class="color-white weight-regular font-small"><a href="<?php echo constant('URL'); ?>xd">Formatos</a></h4>
                                </div>
                            </div>
                            <div class="row item-left justify-center">
                                <div class = "column">
                                    <h4 class="color-white weight-regular font-small"><a href="<?php echo constant('URL'); ?>xd">Correo Institucional</a></h4>
                                </div>
                            </div>
                            <div class="row item-left justify-center">
                                <div class = "column">
                                    <h4 class="color-white weight-regular font-small"><a href="<?php echo constant('URL'); ?>logout">Cerrar Sesión</a></h4>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="column">
                    <div class="row-responsive">
                            <div class="row-responsive header-general-data align-center" style="background-image: url(<?php echo constant('URL'); ?>public/img/new-footer-blue.png)">
                                <div class="column space-header">
                                <div class="row-responsive responsive-img container-img-profile">
                                    <img src="<?php echo constant('URL'); ?>public/img/student-compress.png" alt="Profile student" class="cover-img img-profile">
                                </div>
                                </div>
                                <div class="column align-start header-content">
                                    <div class="row auto">
                                        <div class="column auto">
                                            <h1 class="color-white font-large"><?php echo $this->datos['nombre']; ?></h1>
                                            <h3 class="color-white font-medium weight-regular">Ing. Software</h3>
                                        </div>  
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="row-responsive">
                        <div class="column container-info-student justify-start">
                            <div class="white-space-24"></div>
                            <div class="row-responsive justify-center">
                                <div class="column auto">
                                    <div class="white-space-8"></div>
                                    <h4 class="color-darkgray weight-bold font-small text-left">Plan de estudios</h4>
                                    <p class="color-darkgray weight-regular">
                                        ISOF-2013 de 375 Créditos
                                    </p>
                                    <div class="white-space-24"></div>
                                    <h4 class="color-darkgray weight-bold font-small">Cr&eacute;ditos acumulados</h4>
                                    <p class="color-darkgray weight-regular">
                                        297.0
                                    </p>
                                    <div class="white-space-24"></div>
                                    <h4 class="color-darkgray weight-bold font-small text-left">Matricula</h4>
                                    <p class="color-darkgray weight-regular">
                                        <?php echo $this->datos['matricula']; ?>
                                    </p>
                                    <div class="white-space-24"></div>
                                    <h4 class="color-darkgray weight-bold font-small">Estatus</h4>
                                    <p class="color-darkgray weight-regular">
                                        Regular
                                    </p>
                                    <div class="white-space-24"></div>
                                    <h4 class="color-darkgray weight-bold font-small">Situaci&oacute;n de vigencia</h4>
                                    <p class="color-darkgray weight-regular">
                                        SEP-DIC2016
                                    </p>
                                    <div class="white-space-24"></div>
                                    <h4 class="color-darkgray weight-bold font-small">Periodo actual o &uacute;ltimo</h4>
                                    <p class="color-darkgray weight-regular">
                                        MAY-AGO2019
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="column align-center">
                            <div class="white-space-32"></div>
                            <div class="column container">
                            <h2 class="color-darkBlue weight-bold">Datos generales del estudiante</h2>
                                <form class="column frm-info-gral">
                                    <div class="row-responsive break-ipad">
                                        <div class="column ">
                                            <div class="column container-input-info-gral">
                                            <h4 class="color-darkgray font-regular">Fecha de Nacimiento</h4>
                                            <input type="text" name="txtFechaNac" placeholder="<?php echo $this->datos['cumple']; ?>" class="input input-info-profile" required>
                                            </div>
                                        </div>
                                        <div class="column align-center">
                                            <div class="column container-input-info-gral">
                                            <h4 class="color-darkgray font-regular">Clave CURP</h4>
                                            <input type="text" name="txtCurp" placeholder="<?php echo $this->datos['curp']; ?>" class="input input-info-profile" required>
                                            </div>
                                        </div>
                                        <div class="column align-end">
                                            <div class="column container-input-info-gral">
                                            <h4 class="color-darkgray font-regular">C.P</h4>
                                            <input type="text" name="txtCp" placeholder="<?php echo $this->datos['cp']; ?>" class="input input-info-profile" required>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="white-space-16"></div>
                                    <div class="row">
                                        <div class="column container-input-large">
                                            <h4 class="color-darkgray font-regular">Direccion completa</h4>
                                            <input type="text" name="txtDireccion" placeholder="<?php echo $this->datos['direccion']; ?>" class="input input-info-profile" required>
                                        </div>
                                    </div>
                                    <div class="white-space-16"></div>
                                    <div class="row-responsive break-ipad">
                                        <div class="column">
                                            <div class="column container-input-info-gral" >
                                            <h4 class="color-darkgray font-regular">Telefono Domicilio</h4>
                                            <input type="text" name="txtTelDom" placeholder="018006971" class="input input-info-profile" required>
                                        </div>
                                        </div>
                                        <div class="column align-center">
                                            <div class="column container-input-info-gral">
                                            <h4 class="color-darkgray font-regular">Telefono Celular</h4>
                                            <input type="text" name="txtTelCel" placeholder="<?php echo $this->datos['cel']; ?>" class="input input-info-profile" required>
                                            </div>
                                        </div>
                                        <div class="column align-end">
                                            <div class="column container-input-info-gral" >
                                            <h4 class="color-darkgray font-regular">Correo Electronico</h4>
                                            <input type="email" name="txtCorreo" placeholder="<?php echo $this->datos['matricula']; ?>@upqroo.alumnos.com" class="input input-info-profile" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="white-space-32"></div>
                                    <div class="white-space-8"></div>
                                    <div class="row">
                                        <button type="submit" class="btn btn-general-data  bg-darkBlue color-white font-regular weight-semi">Modificar datos</button>
                                    </div>
                                    <div class="white-space-64"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
</body>
</html>