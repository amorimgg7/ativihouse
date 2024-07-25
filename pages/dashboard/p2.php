
<?php 
    session_start();  
    
    require_once '../../classes/conn.php';
?><!--Validar sessão aberta, se usuário está logado.-->




<?php
                  echo '<p>Atualizado em: '.date("d/m/Y H:i:s").' !</p>';
                  //echo '<div >';
                  ////echo '<div class="card-deck">';


                  $count = 0;
                  //$sql_casa = "SELECT *, UNIX_TIMESTAMP(dt_status_dispositivo) DIV 60 AS time_group FROM tb_dispositivo WHERE cd_casa_dispositivo = " . $_SESSION['cd_casa'] . " ORDER BY time_group, dt_status_dispositivo desc";

                  //$sql_casa = "SELECT *, UNIX_TIMESTAMP(dt_status_dispositivo) DIV 60 AS time_group FROM tb_dispositivo WHERE cd_casa_dispositivo = " . $_SESSION['cd_casa'] . " ORDER BY dt_status_dispositivo DESC, time_group, dt_status_dispositivo";


$sql_casa = "SELECT * FROM tb_dispositivo where cd_casa_dispositivo = ".$_SESSION['cd_casa']." ";
$resulta_casa = $conn->query($sql_casa);
if ($resulta_casa->num_rows > 0) {
    while ($casas = $resulta_casa->fetch_assoc()) {
        if ($count % 3 == 0) {
            if ($count > 0) {
                echo '</div>'; // Fecha a div anterior, exceto na primeira iteração
            }
            echo '<div class="card-deck justify-content-center">';
        }

        if (isset($casas['dt_status_dispositivo'])) {
            $dataStatus = strtotime($casas['dt_status_dispositivo']);
            $dataAtual = time();

            if (($dataAtual - $dataStatus) > 10) {
                // A data e hora são maiores que 30 segundos
                echo '<div class="card text-white border-danger mb-3 shadow-lg bg-secondary align-items-center" style="margin: 10px; max-width: 18rem;">';
                echo '<div class="card-header bg-danger">Offline</div>';    
            } else {
                // A data e hora não são maiores que 30 segundos
                echo '<div class="card text-white border-success mb-3 shadow-lg bg-secondary mb-3 align-items-center" style="margin: 10px; max-width: 18rem;">';
                echo '<div class="card-header bg-success">Online</div>'; 
            }
        }
        
        echo '<div class="card-body">';
        echo '<h5 class="card-title">'.$casas['local_dispositivo'].'</h5>';
        echo '<h5 class="card-title">'.$casas['marca_dispositivo'].' '.$casas['modelo_dispositivo'].' '.$casas['versao_dispositivo'].'</h5>';
        echo '<p class="card-title">IP - '.$casas['ip_dispositivo'].'</p>';
        echo '<p class="card-title">MAC - '.$casas['mac_dispositivo'].'</p>';
        echo '</div>';
        echo '<div class="card-footer text-muted">';
        if (($dataAtual - $dataStatus) > 10) {
            //echo '<form method="post" action="'.$_SESSION['dominio'].'/pages/md_dispositivo/editar_dispositivo.php">';
            echo '<form>';
            echo '<input type="text" id="concd_dispositivo" name="concd_dispositivo" value="'.$casas['cd_dispositivo'].'" style="display:none;">';
            echo '<input class="btn btn-outline-danger btn-lg btn-block" type="submit" value="Acionar suporte">';
            echo '</form>';
        } else {
            echo '<form method="post" action="'.$_SESSION['dominio'].'/pages/md_dispositivo/editar_dispositivo.php">';
            echo '<input type="text" id="concd_dispositivo" name="concd_dispositivo" value="'.$casas['cd_dispositivo'].'" style="display:none;">';
            echo '<input class="btn btn-outline-success btn-lg btn-block" type="submit" value="Parametros">';
            echo '</form>';
        }
        

        //include 'p1.php';

        echo '</div>';
        echo '</div>';

        $count++;
    }
    if ($count % 3 != 0) {
        echo '</div>'; // Fecha a última div se não for múltiplo de 3
    }
}

                  
                  
                  
                  
                  ////echo '</div>';
                  //echo '</div>';
                  //echo '</div>';
                  //echo '</div>';
                  //echo '</div>';
                ?>
                
              
                