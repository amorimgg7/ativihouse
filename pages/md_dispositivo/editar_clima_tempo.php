<?php 
    session_start();  
    if(!isset($_SESSION['cd_pessoa']))
    {
        header("location: ../../pages/samples/login.php");
        exit;
    }
    require_once '../../classes/conn.php';
    include("../../classes/functions.php");
    $u = new Usuario;
?><!--Validar sessão aberta, se usuário está logado.-->

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Clima Tempo</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">

  
</head>

<body onmousemove="resetTimer()" onclick="resetTimer()" onkeypress="resetTimer()">
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include ("../../partials/_navbar.php");?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php include ("../../partials/_sidebar.php");?>
      <!-- partial -->
      <div class="main-panel">        
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                

                <?php
                  if(isset($_POST['limparTela'])){
                    //echo "<script>window.alert('Mostrar botão de limpar OS!');</script>";
                    session_start();
                    $_SESSION['cd_pessoa'] = 0;
                    $_SESSION['cd_casa'] = 0;
                    $_SESSION['cd_dispositivo'] = 0;
                    $_SESSION['vtotal_casa'] = 0;
                    $_SESSION['vpag_total'] = 0;
                }
                ?>
                
                <?php
                  if(isset($_POST['concd_casa']) ){
                    $_SESSION['cd_casa'] = $_POST['concd_casa'];
                    $_SESSION['casa'] = $_POST['concd_casa'];
                  }
                  

                  echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';

if (isset($_SESSION['casa'])) {
    $sql_Higrometro_1_0 = "SELECT * FROM tb_dispositivo WHERE modelo_dispositivo = 'Higrometro_1_0' AND cd_casa_dispositivo = " . $_SESSION['casa'];
    $resulta_Higrometro_1_0 = $conn->query($sql_Higrometro_1_0);

    if ($resulta_Higrometro_1_0->num_rows > 0) {
        $counter = 0;

        while ($Higrometro_1_0 = $resulta_Higrometro_1_0->fetch_assoc()) {
            $counter++;

            // Estrutura HTML para os gráficos
            echo '<div class="card text-white border-danger mb-3 shadow-lg bg-secondary align-items-center" style="margin: 10px;">';
            echo '<div class="card-header bg-danger">' . $counter . ' - ' . $Higrometro_1_0['mac_dispositivo'] . '</div>';
            echo '<div class="row mb-3 shadow-lg bg-secondary" style="margin: 0px;">
                    <div class="col-sm-6 col-lg-6 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Última Hora</h4>
                          <canvas id="lineChart_1H_' . $counter . '"></canvas>
                        </div>
                      </div>
                    </div>
                  <!--</div>
                  <div class="row mb-3 shadow-lg bg-secondary" style="margin: 0px;">-->
                    <div class="col-sm-6 col-lg-6 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Últimas 24 Horas</h4>
                          <canvas id="lineChart_24H_' . $counter . '"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>';
              echo '</div>';

            // Consultar dados do banco de dados
            $sql_clima_tempo_1H = "SELECT 
                DATE_FORMAT(dt_clima_tempo, '%Y-%m-%d %H:%i:00') AS minuto,
                ROUND(AVG(temperatura_clima_tempo), 2) AS media_temperatura,
                ROUND(AVG(umidade_clima_tempo), 2) AS media_umidade
            FROM 
                clima_tempo
            WHERE 
                mac_dispositivo_clima_tempo = '" . $Higrometro_1_0['mac_dispositivo'] . "' 
                AND dt_clima_tempo >= NOW() - INTERVAL 1 HOUR
            GROUP BY 
                DATE_FORMAT(dt_clima_tempo, '%Y-%m-%d %H:%i:00')
            ORDER BY 
                minuto ASC
            LIMIT 60;";

            $sql_clima_tempo_24H = "SELECT 
                                    DATE_FORMAT(dt_clima_tempo, '%Y-%m-%d %H:00:00') AS hora,
                                    ROUND(AVG(temperatura_clima_tempo), 2) AS media_temperatura,
                                    ROUND(AVG(umidade_clima_tempo), 2) AS media_umidade
                                FROM 
                                    clima_tempo
                                WHERE 
                                    mac_dispositivo_clima_tempo = '" . $Higrometro_1_0['mac_dispositivo'] . "' 
                                    AND dt_clima_tempo >= NOW() - INTERVAL 24 HOUR
                                GROUP BY 
                                    DATE_FORMAT(dt_clima_tempo, '%Y-%m-%d %H:00:00')
                                ORDER BY 
                                    hora ASC
                                LIMIT 24";

            $resulta_clima_tempo_1H = $conn->query($sql_clima_tempo_1H);
            $resulta_clima_tempo_24H = $conn->query($sql_clima_tempo_24H);

            $temperaturas_1H = [];
            $umidades_1H = [];
            $temperaturas_24H = [];
            $umidades_24H = [];

            if ($resulta_clima_tempo_1H->num_rows > 0) {
                while ($clima_tempo_1H = $resulta_clima_tempo_1H->fetch_assoc()) {
                    $temperaturas_1H[] = $clima_tempo_1H["media_temperatura"];
                    $umidades_1H[] = $clima_tempo_1H["media_umidade"];
                }
            }

            if ($resulta_clima_tempo_24H->num_rows > 0) {
                while ($clima_tempo_24H = $resulta_clima_tempo_24H->fetch_assoc()) {
                    $temperaturas_24H[] = $clima_tempo_24H["media_temperatura"];
                    $umidades_24H[] = $clima_tempo_24H["media_umidade"];
                }
            }

?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Função para criar gráficos
                    function createChart(ctx, type, labels, datasets) {
                        return new Chart(ctx, {
                            type: type,
                            data: {
                                labels: labels,
                                datasets: datasets
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }

                    // Dados fornecidos pelo PHP para a última hora
                    var temperaturas_1H = <?php echo json_encode($temperaturas_1H); ?>;
                    var umidades_1H = <?php echo json_encode($umidades_1H); ?>;
                    var labels_1H = Array.from({length: temperaturas_1H.length}, (_, i) => i + 1);

                    // Configuração dos datasets para a última hora
                    var temperatureDataset_1H = {
                        label: 'Temperatura (Última Hora)',
                        data: temperaturas_1H,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: false
                    };

                    var humidityDataset_1H = {
                        label: 'Umidade (Última Hora)',
                        data: umidades_1H,
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1,
                        fill: false
                    };

                    // Gráfico de linha para a última hora
                    var ctxLine_1H = document.getElementById('lineChart_1H_<?php echo $counter; ?>').getContext('2d');
                    createChart(ctxLine_1H, 'line', labels_1H, [temperatureDataset_1H, humidityDataset_1H]);

                    // Dados fornecidos pelo PHP para as últimas 24 horas
                    var temperaturas_24H = <?php echo json_encode($temperaturas_24H); ?>;
                    var umidades_24H = <?php echo json_encode($umidades_24H); ?>;
                    var labels_24H = Array.from({length: temperaturas_24H.length}, (_, i) => i + 1);

                    // Configuração dos datasets para as últimas 24 horas
                    var temperatureDataset_24H = {
                        label: 'Temperatura (Últimas 24 Horas)',
                        data: temperaturas_24H,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: false
                    };

                    var humidityDataset_24H = {
                        label: 'Umidade (Últimas 24 Horas)',
                        data: umidades_24H,
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1,
                        fill: false
                    };

                    // Gráfico de linha para as últimas 24 horas
                    var ctxLine_24H = document.getElementById('lineChart_24H_<?php echo $counter; ?>').getContext('2d');
                    createChart(ctxLine_24H, 'line', labels_24H, [temperatureDataset_24H, humidityDataset_24H]);
                });
            </script>
<?php
        }
    }
}
      
?>

              </div>
            </div>
          </div>
      
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <?php
          //include("../../partials/_footer.php");
        ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="../../vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="../../vendors/select2/select2.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="../../js/file-upload.js"></script>
  <script src="../../js/typeahead.js"></script>
  <script src="../../js/select2.js"></script>
  <!-- End custom js for this page-->
</body>

</html>