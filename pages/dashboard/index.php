

<?php
    session_start();

    $_SESSION['cd_pessoa'] = 1;
    $_SESSION['senha_pessoa'] = "asd,123";
    
    if(!isset($_SESSION['cd_pessoa']))
    {
        //header("location: http://amorimgg77.lovestoblog.com/pages/samples/login.php");
        echo '<script>location.href="'.$_SESSION['dominio'].'../samples/login.php";</script>';    
        exit; 
    }
    if($_SESSION['senha_pessoa'] == "")
    {
      //header("location: http://amorimgg77.lovestoblog.com/pages/samples/lock-screen.php");
      echo '<script>location.href="'.$_SESSION['dominio'].'../../samples/lock-screen.php";</script>';  
      exit;
    }
    require_once '../../classes/conn.php';
    
    include("../../classes/functions.php");
    //conectar($_SESSION['cnpj_empresa']);

    $u = new Usuario;
    
?><!--Validar sessão aberta, se usuário está logado.-->




<!DOCTYPE html>
<html lang="pt-br">

<head>
  

  <!-- Required meta tags --> 
  <meta charset="utf-8">
  <meta>
  <!--<meta http-equiv='refresh' content='30'>-->
  <!--<meta http-equiv="refresh" content="5;url=../samples/lock-screen.php">-->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
  <title>AtiviSoft</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../../vendors/flag-icon-css/css/flag-icon.min.css"/>
  <link rel="stylesheet" href="../../vendors/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../../vendors/jquery-bar-rating/fontawesome-stars-o.css">
  <link rel="stylesheet" href="../../vendors/jquery-bar-rating/fontawesome-stars.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  
  

</head>
<script src="../../js/functions.js"></script>
  <!--<body onmousemove="resetTimer()" onclick="resetTimer()" onkeypress="resetTimer()">-->
  <body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include ("../../partials/_navbar.php");?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php include ("../../partials/_sidebar.php");?>
      <!-- partial -->
      <div class="main-panel" >
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12 mb-4 mb-xl-0">
              
              
              
              <p class="font-weight-normal mb-2 text-muted"><span id="data-atual"></span></p>
              <script>
                var data = new Date();
                var mesPorExtenso = new Intl.DateTimeFormat('pt-BR', { month: 'long' }).format(data).toUpperCase();
                var dia = data.getDate();
                var ano = data.getFullYear();
                document.getElementById("data-atual").innerHTML = 'HOJE É '+dia + ' DE ' + mesPorExtenso + ', ' + ano;
              </script>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-xl-3 flex-column d-flex grid-margin stretch-card">
              <!--<div class="row flex-grow">-->
                <?php
                  
                    //echo '<h1>Módulo Hospedagem!</h1>';
                    //echo '<h6>&nbsp&nbsp&nbsp&nbsp Licença ao módulo de controle de casas voltado a pessoas que alugam casas e espaços.</h6>';
                    
                    include '../../pages/md_casa/index.php';
                    //include '../../pages/md_patrimonio/index.php';
                  


                  

                ?>
              <!--</div>-->
            </div>
          </div>

        </div>

        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <!--<footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © sistma.com 2023</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://localhost/_1_1_sistema" target="_blank">Sistema.com</a> from 1.1</span>
          </div>
          <span class="text-muted d-block text-center text-sm-left d-sm-inline-block mt-2">Distributed By: <a href="https://www.themewagon.com/" target="_blank">ThemeWagon</a></span>
        </footer>-->
        
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- base:js -->
  <script src="../../vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="../../js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

