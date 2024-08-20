
<?php 
    session_start();  
    
    require_once '../classes/conn.php';
?><!--Validar sessão aberta, se usuário está logado.-->




<?php
    echo '<p>Atualizado em: '.date("d/m/Y H:i:s").' !</p>';
    $count = 0;
    $sql_Higrometro_1_0 = "SELECT * FROM tb_dispositivo where modelo_dispositivo = 'Higrometro_1_0' AND cd_casa_dispositivo = ".$_SESSION['cd_casa']." ";
    //$select_dispositivo = "SELECT * FROM tb_dispositivo WHERE cd_dispositivo = '".$_SESSION['dispositivo']."'";
    $result_Higrometro_1_0 = mysqli_query($conn, $sql_Higrometro_1_0);
    $row_Higrometro_1_0 = mysqli_fetch_assoc($result_Higrometro_1_0);
    // Exibe as informações do usuário no formulário
    if($row_Higrometro_1_0) {
        // A data e hora não são maiores que 30 segundos
        echo '<div class="card text-white border-success shadow-lg bg-secondary  align-items-center" style="margin: 10px;">';
        echo '<div class="card-header btn-block"><h1 class="card-title">Central de controle térmico</h1>';
        echo '<td><a href="'.$_SESSION['dominio'].'/pages/dashboard/index.php" class="btn btn-block btn-outline-warning"><i class="icon-cog"></i>Voltar ao início</a></td>';
        echo '</div>'; 
        echo '<form method="post" action="'.$_SESSION['dominio'].'/pages/md_dispositivo/view_clima_tempo.php">';
        echo '<input type="text" id="concd_casa" name="concd_casa" value="'.$_SESSION['cd_casa'].'" style="display:none;">';
        echo '<input class="btn btn-outline-success btn-lg btn-block" type="submit" value="Parametros">';
        echo '</form>';
        echo '<div class="card-footer text-muted">';
        echo '</div>';
        echo '</div>';
    }
    ?>

    <?php
    

        
    
    


$sql_casa = "SELECT * FROM tb_dispositivo where modelo_dispositivo != 'Higrometro_1_0' AND cd_casa_dispositivo = ".$_SESSION['cd_casa']." ";
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

                if($_SESSION['md_edicao_hw'] == 0){
                    echo '<div class="card-header bg-danger">Offline';
                }else if($_SESSION['md_edicao_hw'] == 1){
                    echo '<div class="card-header bg-danger">Offline';
                }else if($_SESSION['md_edicao_hw'] == 2){
                    echo '<div class="card-header bg-danger"><a href="'.$_SESSION['dominio'].'/pages/md_dispositivo/edit_dispositivo.php" class="btn btn-block btn-danger">Offline&nbsp<i class="icon-ellipsis"></i></a></div>'; 
                }
                echo '</div>';    
            } else {
                // A data e hora não são maiores que 30 segundos
                echo '<div class="card text-white border-success mb-3 shadow-lg bg-secondary mb-3 align-items-center" style="margin: 10px; max-width: 18rem;">';
                
                if($_SESSION['md_edicao_hw'] == 0){
                    echo '<div class="card-header bg-success">Online <i class="icon-ellipsis"></i></div>';
                }else if($_SESSION['md_edicao_hw'] == 1){
                    echo '<div class="card-header bg-success">Online <i class="icon-ellipsis"></i></div>';
                }else if($_SESSION['md_edicao_hw'] == 2){
                    echo '<div class="card-header bg-success"><a href="'.$_SESSION['dominio'].'/pages/md_dispositivo/edit_dispositivo.php" class="btn btn-block btn-success">Online&nbsp<i class="icon-ellipsis"></i></a></div>'; 
                }
                //echo '<td><a href="'.$_SESSION['dominio'].'/pages/dashboard/index.php" class="btn btn-block btn-outline-warning"><i class="icon-cog"></i>Voltar ao início</a></td>';
            }
        }
        
        echo '<div class="card-body">';
        echo '<h5 class="card-title">'.$casas['titulo_dispositivo'].' - '.$casas['local_dispositivo'].'</h5>';
        //echo '<h5 class="card-title">'.$casas['marca_dispositivo'].' '.$casas['modelo_dispositivo'].' '.$casas['versao_dispositivo'].'</h5>';
        echo '<p class="card-title">IP - '.$casas['ip_dispositivo'].'</p>';
        echo '<p class="card-title">MAC - '.$casas['mac_dispositivo'].'</p>';
        echo '</div>';

        
        echo '<div class="card-footer text-muted">';
        if (($dataAtual - $dataStatus) > 10) {
            //echo '<form method="post" action="'.$_SESSION['dominio'].'/pages/md_dispositivo/editar_dispositivo.php">';
            //echo '<form>';
            echo '<input type="text" id="concd_dispositivo" name="concd_dispositivo" value="'.$casas['cd_dispositivo'].'" style="display:none;">';
            echo '<input class="btn btn-outline-danger btn-lg btn-block" type="submit" value="Acionar suporte">';
            //echo '</form>';
        } else {
            
            echo '<form method="post" action="'.$_SESSION['dominio'].'/pages/md_dispositivo/view_dispositivo.php">';
            if($casas['modelo_dispositivo'] == "Higrometro_1_0"){
                echo '<input value="'. $casas['canal_1'] .'°C" class="btn mb-3 btn-block btn-sm btn-info">';
                echo '<input value="'. $casas['canal_2'] .'%" class="btn mb-3 btn-block btn-sm btn-info">';
            }
            
            echo '<input type="text" id="concd_dispositivo" name="concd_dispositivo" value="'.$casas['cd_dispositivo'].'" style="display:none;">';
            
            
            echo '<input class="btn btn-outline-success btn-lg btn-block" type="submit" value="Parametros">';
            
            echo '<p style="text-align: center;"> ';
            for($i = 1; $i < 7; $i++){
                if($casas['canal_'.$i] > 0){
                    if($casas['canal_'.$i] == 1){
                        echo ' <i style="color: #D00;" class="icon-circle-cross"></i> ';
                    }
                    if($casas['canal_'.$i] == 2){
                        echo ' <i style="color: #0D0;" class="icon-circle-check"></i> ';
                    }   
                }
            }
            echo ' </p>';
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
                
              
                