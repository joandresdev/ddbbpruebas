<!--
*  login.html 
*  @version: 1.0.0
*  @author: Universidad Politecnica -  kath
*  @description: ERROR 404
*  @date: 10/06/2019
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
    <div class="main flex">
        <div class="column errors justify-center align-center">
        <div class="container column">
                <div class="kristen-img justify-center responsive-img">
                    <img src="http://new.upqroo.edu.mx/assets/img/kristen.png" alt="Kristen es linda" title="Kristen es linda">
                </div>
                <div class="white-space-32"></div>
                <h2 class="text-center">
                    Lo sentimos, la página que solicitas no existe
                </h2>
                <div class="white-space-8"></div>
                <h4 class="text-center">
                    Puedes aprovechar y alimentar a todos los perritos
                </h4>
                <div class="white-space-24"></div>
                <div class="row auto justify-center">
                        <a href="<?php echo constant('URL'); ?>" class="btn btn-admin bg-darkBlue color-white font-regular weight-semi">REGRESAR A INICIO</a>
                </div>
            </div>
        </div>
    </div> 
    
</body>
</html>