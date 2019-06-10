<!--
*  login.html 
*  @version: 1.0.0
*  @author: Universidad Politecnica - Jazmin Pool, kath
*  @description: LOGIN DEL ALUMNO
*  @date: 09/06/2019
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="<?php echo constant('URL'); ?>public/css/style.css"></link>
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/fontawesome/css/all.css">
    <title>SEE - Kardex</title>
    <link rel="shortcut icon" href="">
</head>
<body>
    <form class="" method="POST" action="login">
    <div class="main flex">
        <div class="column login">

            <div class="row background-login" style="background-image: url(<?php echo constant('URL'); ?>public/img/new-footer-blue2.png)">
                <div class="column justify-center align-center">
                    <div class="row container">
                        <div class="column card-login">
                            <div class="row">
                                <div class="column align-start justify-center">
                                    <div class="white-space-24"></div>
                                    <div class="row-responsive">
                                        <div class="column text-center">
                                            <h1 class="uppercase tittle color-darkBlue">Universidad Politecnica de Quintana Roo</h1>
                                        </div>
                                    </div>

                                    <div class="white-space-32"></div>
                                    
                                    <div class="row-responsive">
                                        <div class="column text-center">
                                            <h3>Introduzca sus datos de acceso</h3>
                                        </div>
                                    </div>
                                    
                                    <div class="white-space-32"></div>

                                    <div class="row-responsive">
                                        <div class="column auto justify-center align-center icon-form">
                                            <i class="fa fa-user-graduate fa-2x"></i>
                                        </div>
                                        <div class="column">
                                            <input type="text" name="matricula" placeholder="Matr&iacute;cula" class="input input-form" required>
                                        </div>
                                    </div>
                                    
                                    <div class="white-space-32"></div>
                                    
                                    <div class="row-responsive">
                                        <div class="column auto justify-center align-center icon-form">
                                            <i class="fa fa-key fa-2x"></i>
                                        </div>
                                        <div class="column">
                                            <input type="password" name="pass" placeholder="Contraseña" class="input input-form" required>
                                        </div>
                                    </div>

                                    <div class="white-space-32"></div>

                                    
                                    <?php if (isset($this->error)): ?>
                                        <div class="row-responsive justify-center">
                                            <div class="column text-left ">
                                                <p class=""><?php echo $this->error; ?></p>
                                            </div>
                                        </div>

                                        <div class="white-space-32"></div>
                                    <?php endif ?>
                                    

                                    <div class="row-responsive justify-center">
                                        <div class="column">
                                            <button class="btn btn-login font-regular weight-semi uppercase">Ingresar</button>
                                        </div>
                                    </div>

                                    <div class="white-space-32"></div>

                                    <div class="row-responsive justify-center">
                                        <a href="#" class="color-darkBlue">¿Olvid&oacute; su contraseña?</a>
                                    </div>
                                    <div class="white-space-24"></div>
                                </div> <!--/.contenedor-->
                            </div>
                        </div> <!--/.card-login-->
                    </div>

                    <div class="row-responsive derechos justify-center">
                        <p class="color-white">
                            Queda totalmente prohibido reproducir o alterar total o parcialmente, por cualquier forma o medio, cada uno de los elementos (graficos, textos, etc.) que integran este sitio web, sin la correspondiente autorizacion de la Universidad Politecnica de Quintana Roo.
                        </p>
                    </div>
                </div>
            </div> <!--/.background login-->
            
        </div> <!--/.column login-->

    </div> <!--/.main flex-->
    </form>
</body>
</html>