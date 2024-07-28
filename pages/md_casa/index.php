
<div class="card-deck">
    
                <?php
                  $sql_casa = "SELECT * FROM tb_casa";
                  $resulta_casa = $conn->query($sql_casa);
                  if ($resulta_casa->num_rows == 1){
                    while ( $casa = $resulta_casa->fetch_assoc()){
                      $_SESSION['cd_casa'] = $casa['cd_casa'];

                      ?>
                      <script>
                        function updateContent1() {
                          fetch('../../partials/p2.php')
                          .then(response => response.text())
                          .then(data => {
                            document.getElementById('content1').innerHTML = data;
                          })
                          .catch(error => console.error('Erro:', error));
                        }
                        setInterval(updateContent1, 3000);
                        window.onload = updateContent1;
                      </script>
                      <div style="width:100" class="typeahead" id="content1" style="display: inline-block; column-break-inside: avoid;   "><h1>Carregando #1...</h1></div>
                    <?php

                      
                    }
                  }
                  if ($resulta_casa->num_rows > 1){
                    while ( $casas = $resulta_casa->fetch_assoc()){
                      echo '<div class="col">';
                      //echo '<a href="'.$_SESSION['dominio'].'/pages/filmes/index.php?cd_filme='.$casas['cd_casa'].'" title="'.$casas['titulo_casa'].'">';
                      

                      //class="card border-success mb-3" style="max-width: 18rem;"  livre       0 
                      //class="card border-info mb-3" style="max-width: 18rem;"     preparando  1
                      //class="card border-warning mb-3" style="max-width: 18rem;"  ocupado     2
                      

                      if($casas['status_casa'] == '0'){
                        echo '<div class="card border-success mb-3 shadow-sm align-items-center" style="max-width: 18rem;">';
                        echo '<div class="card-header bg-success">Livre</div>';

                      }else if($casas['status_casa'] == '1'){
                        echo '<div class="card border-info mb-3 shadow-sm align-items-center" style="max-width: 18rem;">';
                        echo '<div class="card-header bg-info">Reservado</div>';

                      }else if($casas['status_casa'] == '2'){
                        echo '<div class="card border-info mb-3 shadow-sm align-items-center" style="max-width: 18rem;">';
                        echo '<div class="card-header bg-info">Ocupado</div>';

                      }else if($casas['status_casa'] == '3'){
                        echo '<div class="card border-warning mb-3 shadow-sm align-items-center" style="max-width: 18rem;">';
                        echo '<div class="card-header bg-warning">Em preparação</div>';

                      }else{
                        echo '<div class="card border-danger mb-3 shadow-sm align-items-center" style="max-width: 18rem;">';
                        echo '<div class="card-header bg-danger">Sinistro</div>';

                      }


                      
                      echo '<div class="card-body">';

                      echo '<h5 class="card-title">'.$casas['titulo_casa'].'</h5>';
                      echo '<p class="card-text">'.$casas['obs_casa'].'</p>';
                      //echo '<h5 class="card-title">'.$casas['obs_casa'].'</h5>';

                      //echo '<p class="card-text">'.$casas['obs_casa'].'</p>';
                      //echo '<img src="'.$casas['imagem_capa_casa'].'" width="180" height="240" class="img-responsive">';
                      echo '</div>';

                      echo '<div class="card-footer text-muted">';
                      //<a href="'.$_SESSION['dominio'].'/pages/filmes/index.php?cd_filme='.$casas['cd_casa'].'" title="'.$casas['titulo_casa'].'">
                      echo '<form method="post" action="'.$_SESSION['dominio'].'/pages/md_hospedagem/editar_casa.php">';

                      echo '<input type="text" id="concd_casa" name="concd_casa" value="'.$casas['cd_casa'].'" style="display:none;">';
                      echo '<input class="btn btn-outline-success btn-lg btn-block" type="submit" value="Parametros">';
                      echo '</form>';
                      //echo '<a href="'.$_SESSION['dominio'].'/pages/md_hospedagem/editar_casa.php?cd_casa='.$casas['cd_casa'].'" class="btn btn-outline-success btn-lg btn-block">Parametros</a>';
                      echo '</div>';

                      echo '</div>';
                      //echo '</a>';
                      echo '</div>';
                    }
                  }
                ?>
             
          </div>