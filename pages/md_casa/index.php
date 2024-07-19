<?php 
    session_start();  
    if(!isset($_SESSION['cd_colab']))
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
  <?php 
    if(isset($_SESSION['bloqueado'])){
      
      if($_SESSION['bloqueado'] == 1){
        echo "<meta http-equiv='refresh' content='60;url=../auto_pagamento/payment.php'>";
        
      }else if($_SESSION['bloqueado'] == 2){
        echo "<meta http-equiv='refresh' content='1;url=../auto_pagamento/payment.php'>";
      }
    }
  ?>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Hospedagem</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <?php
  		$caminho_pasta_empresa = "../web/imagens/".$_SESSION['cnpj_empresa']."//logos/";
		$foto_empresa = "LogoEmpresa.jpg"; // Nome do arquivo que será salvo
		$caminho_foto_empresa = $caminho_pasta_empresa . $foto_empresa;

		if (file_exists($caminho_foto_empresa)) {
			$tipo_foto_empresa = mime_content_type($caminho_foto_empresa);
  			echo "<link rel='shortcut icon' href='data:$tipo_foto_empresa;base64," . base64_encode(file_get_contents($caminho_foto_empresa)) . "' />";
		}else{
			echo "<link rel='shortcut icon' href='https://lh3.googleusercontent.com/pw/AP1GczOReqQClzL-PZkykfOwgmMyVzQgx27DTp783MI7iwKuKSv-6P6V7KOEbCC74sGdK3DEV3O88CsBLeIvOaQwGT3x4bqCTPRtyV9zcODbYVDRxAF8zf8Uev7geh4ONPdl3arNhnSDPvbQfMdpFRPM263V9A=w250-h250-s-no-gm?authuser=0' />";
		}
	?>
  <!-- endinject -->
  <script src="../../js/functions.js"></script>
  <link rel="shortcut icon" href="<?php echo $_SESSION['logo_empresa']; ?>" />
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
        <div class="content-wrapper" <?php echo $_SESSION['c_body'];?>>
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card" <?php $_SESSION['c_card'];?>>
                <div class="card-body" id="consulta" <?php echo $_SESSION['c_card'];?> style="display: none;" >
                  <h3 class="card-title"<?php echo $_SESSION['c_card'];?>>Consultar pela OS</h3>
                  <p class="card-description"<?php echo $_SESSION['c_card'];?>>Consulte a Ordem de Serviço para lançar as atividades e avisar ao cliente sobre o status atual.</p>
                  <div class="kt-portlet__body" >
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                          <form method="POST">
                            
                            <input placeholder="Ordem de Serviço" type="tel" name="conos_servico" id="conos_servico" type="tel" maxlength="10" class="aspNetDisabled form-control form-control-sm" required>
                            <br>
                            <button type="submit" name="consulta" class="btn btn-success">Consulta</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <?php
                  if($_SESSION['cd_casa'] > 0){
                    $_SESSION['casa'] = $_SESSION['cd_casa'];

                    echo '<script>document.getElementById("consulta_cliente").style.display = "none";</script>';
                  
                    echo '<div class="card-body">';
                    echo '<div class="kt-portlet__body">';
                    echo '<div class="row">';
                    echo '<div class="col-12 col-md-12">';
                    echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                            
                  
                    
                    
                    //echo '<form method="POST">';
                    
                    //echo '<h3 class="kt-portlet__head-title">Dados do Cliente</h3> ';

                    if($_SESSION['cd_cliente'] > 0){
                      $select_orcamento = "SELECT cl.cd_cliente, cl.tel_cliente, concat(cl.pnome_cliente, ' ', cl.snome_cliente) as full_nome_cliente FROM tb_cliente cl, tb_casa ca  WHERE ca.cd_casa = '".$_SESSION['cd_casa']."' AND cl.cd_cliente = ca.cd_cliente";
                      $result_orcamento = mysqli_query($conn, $select_orcamento);
                      while($row_orcamento = $result_orcamento->fetch_assoc()) {
                        //echo '<input value="'.$row_orcamento['full_nome_cliente'].'" name="listaid_orcamento" id="listaid_orcamento" class="aspNetDisabled form-control form-control-sm" style="display:none;">';
                        echo '<div class="typeahead" id="botoes" name="botoes" '.$_SESSION['c_card'].' style="display:block;">';
                        echo '<form method="POST">';
                        echo '<input value="'.$_SESSION['cd_cliente'].'" name="btncd_cliente" type="text" id="showcd_cliente" class="aspNetDisabled form-control form-control-sm" style="display: none;"/>';
                        echo '<label for="btnpnome_cliente">Nome</label>';
                        echo '<input value="'.$row_orcamento['full_nome_cliente'].'" name="btnpnome_cliente" type="text" id="btnpnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                        echo '<label for="btntel_cliente">Telefone</label>';
                        echo '<input value="'.$_SESSION['tel_cliente'].'" name="btntel_cliente" type="tel"  id="btntel_cliente" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';
                        //echo '<td><button type="submit" name="con_cliente" id="con_cliente" class="btn btn-block btn-outline-warning"><i class="icon-cog">Editar</i></button></td>';
                        echo '<td><button type="submit" name="desfazer_rezerva" id="desfazer_rezerva" class="btn btn-block btn-outline-warning"><i class="icon-cog">Desfazer Reserva</i></button></td>';
                        echo '</form>';
                        echo '</div>';
                      }
                    }else{
                      echo '<div class="card-body" id="consulta_cliente" name="consulta_cliente" '.$_SESSION["c_card"].'" >';
                      echo '<h3 class="card-title" '.$_SESSION["c_card"].' >Informar Cliente</h3>';
                      echo '<p class="card-description" '.$_SESSION["c_card"].' >Diga quem é o cliente para reservar este imóvel!</p>';
                      echo '<div class="kt-portlet__body" >';
                      echo '<div class="row">';
                      echo '<div class="col-12 col-md-12">';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                      echo '<div class="typeahead" id="botoes" name="botoes" '.$_SESSION['c_card'].' style="display:block;">';
                      echo '<form method="POST"> ';
                      echo '<div class="form-group" style="display: flex;">';
                      echo '<div class="input-group">';
                      echo '<div class="input-group-prepend">';
                      echo '<!--<span>-->';
                      echo '<select name="cd_pais" id="cd_pais"  class="input-group-text" required>';
                      echo '<option selected="selected"value="55">+55 Brasil</option>';
                      echo '</select>  ';
                      echo '<!--</span>-->';
                      echo '</div>';
                      echo '<input placeholder="Telefone do Cliente" type="tel" name="contel_cliente" id="contel_cliente" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" required oninput="validateInput(this)">';
                      echo '<div class="input-group-append">';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '<p id="error-message" style="color: #DDDDDD;"></p>';
                      echo '<br>';
                      echo '<button type="submit" name="consulta_cliente" class="btn btn-block btn-success">Reservar</button>';
                      echo '</form>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';


                      echo '<div class="card-body" id="cadastroCliente" style="display:none;">';
                      echo '<h3 class="kt-portlet__head-title">Dados do cliente</h3>';
                      echo '<div class="kt-portlet__body">';
                      echo '<div class="row">';
                      echo '<div class="col-12 col-md-12">';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                      echo '<form method="POST">';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">';
                      echo '<label for="pnome_cliente">Nome</label>';
                      echo '<input name="pnome_cliente" type="text" id="pnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm" required/>';
                      
                      echo '<label for="snome_cliente">sobrenome</label>';
                      echo '<input name="snome_cliente" type="text" id="snome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm" />';
                      echo '<label for="tel_cliente">Telefone</label>';
                      echo '<input name="tel_cliente" type="tel"'.$_SESSION["contel_cliente"].' id="tel_cliente" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';
                      echo '<!--<input type="submit" class="btn btn-success" value="Salvar">-->';
                      echo '</div>';
                      echo '<button type="submit" name="cad_cliente" class="btn btn-success" >Salvar</button>';
                      echo '</form>';
                      echo '<form method="post">';
                      echo '<button type="submit" class="btn btn-danger" name="limparOS" style="margin: 5px;">Refazer</button>';
                      echo '</form>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                    }
                    

                    //echo '<h3 class="kt-portlet__head-title">Dados do serviço</h3>';
                    echo '<div class="typeahead" '.$_SESSION['c_card'].' style="display: block;">';
                    //echo '<form method="POST" action="cadastro_servico.php">';
                    
                    echo '<label for="btncd_casa">Casa</label>';
                    echo '<input value="'.$_SESSION['cd_casa'].'" type="tel" name="btncd_casa" id="btncd_casa" class="form-control form-control-sm" readonly>';
                    
                    echo '<label for="btntitulo_casa">Título</label>';
                    echo '<input value="'.$_SESSION['titulo_casa'].'" type="text" name="btntitulo_casa" maxlength="999" id="btntitulo_casa"  class="form-control form-control-sm" placeholder="Caracteristica geral do serviço" readonly>';
                    
                    echo '<label for="btnobs_casa">Descrição</label>';
                    echo '<input value="'.$_SESSION['obs_casa'].'" type="text" name="btnobs_casa" maxlength="999" id="btnobs_casa"  class="form-control form-control-sm" placeholder="Caracteristica geral do estabelecimento" readonly>';
                    
                    
                    echo '<td><button type="submit" name="con_edit_os" id="con_edit_os" class="btn btn-block btn-outline-warning"><i class="icon-cog"></i>Editar</button></td>';
                    //echo '</form>';
                    echo '</div>';
                    //echo '<script>document.getElementById("btncd_casa").value = "'.$_SESSION['cd_casa'].'"</script>';
                    //echo '<script>document.getElementById("btntitulo_casa").value = "'.$_SESSION['titulo_casa'].'"</script>';
                    //echo '<script>document.getElementById("btnobs_casa").value = "'.$_SESSION['obs_casa'].'"</script>';
                    

                    
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                    
                    
/*
                    echo '<form method="post"'.$_SESSION['c_card'].'>';//echo '<button type="submit" class="btn btn-danger" name="limparOS" style="margin: 5px;">Nova Consulta</button>';
                    //echo '<button type="submit" class="btn btn-block btn-lg btn-warning" name="editaOS" style="margin-top: 20px; margin-bottom: 20px;"><i class="mdi mdi-file-check btn-icon-append"></i> Editar</button>';
                    echo '<button type="submit" class="btn btn-block btn-lg btn-danger" name="limparOS" style="margin-top: 20px; margin-bottom: 20px;"><i class="mdi mdi-reload btn-icon-prepend"></i> Nova Consulta</button>';
                    //<i class="mdi mdi-alert btn-icon-prepend"></i>  
                    echo '</form>';
*/
                  }

                  if(isset($_POST['lancarPagamento'])) {
                    $updateVpagServico = "UPDATE tb_servico SET
                    vpag_servico = ".$_POST['btnvpag_orcamento']."
                    WHERE cd_servico = ".$_SESSION['cd_servico']."";
                    mysqli_query($conn, $updateVpagServico);
                    $_SESSION['vpag_servico'] = $_POST['btnvpag_orcamento'];
                    echo  '<script>document.getElementById("btnvpag_orcamento").value = "'.$_POST['btnvpag_orcamento'].'";</script>';
                    header("location: consulta_servico.php");
                  }


                  if(isset($_POST['lancar'])) { //CADASTRAR SERVICO E CHAMAR SERVICO CADASTRADO PARA SESSION
                    //include("../../partials/load.html");
                    // Atualiza as informações do usuário no banco de dados
                    $insert_servico = "INSERT INTO tb_servico(cd_cliente, obs_servico, prioridade_servico, entrada_servico, prazo_servico, status_servico) VALUES(
                      '".$_SESSION['os_cliente']."',
                              
                      '".$_POST['obs_servico']."',
                      '".$_POST['prioridade_servico']."',
                      '".$_POST['data_hora_ponto']."',
                      '".$_POST['prazo_servico']."',
                      '0')
                    ";
                    mysqli_query($conn, $insert_servico);
                    //echo "<script>window.alert('Ordem de Serviço criada com sucesso!');</script>";
                    echo '<script>document.getElementById("cadOs").style.display = "none";</script>';
                    //echo "<script>window.alert('Usuário atualizado com sucesso!');</script>";
                    $select_servico = "SELECT * FROM tb_servico WHERE cd_cliente = '".$_SESSION['os_cliente']."' AND status_servico = 0 ORDER BY cd_servico DESC LIMIT 1";
                    $result_servico = mysqli_query($conn, $select_servico);
                    $row_servico = mysqli_fetch_assoc($result_servico);
                    // Exibe as informações do usuário no formulário
                    if($row_servico) {
                      $_SESSION['os_servico'] = $row_servico['cd_servico'];
                      //$_SESSION['os_servico'] = $row_servico['cd_servico'];
                      $_SESSION['servico'] = $row_servico['cd_servico'];
                      $_SESSION['titulo_servico'] = $row_servico['titulo_servico'];
                      $_SESSION['obs_servico'] = $row_servico['obs_servico'];
                      $_SESSION['prioridade_servico'] = $row_servico['prioridade_servico'];
                      $_SESSION['entrada_servico'] = $_POST['data_hora_ponto'];
                      $_SESSION['prazo_servico'] = $row_servico['prazo_servico'];
                      $_SESSION['orcamento_servico'] = $row_servico['orcamento_servico'];
                      $_SESSION['vpag_servico'] = $row_servico['vpag_servico'];
        
                      $insert_atividade = "INSERT INTO tb_atividade(cd_servico, titulo_atividade, obs_atividade, cd_colab, inicio_atividade, fim_atividade) VALUES(
                        '".$row_servico['cd_servico']."',
                        'A',
                        '".$row_servico['obs_servico']."',
                        '".$_SESSION['cd_colab']."',
                        '".$_POST['data_hora_ponto']."',
                        '".$_POST['data_hora_ponto']."')
                      ";
                      mysqli_query($conn, $insert_atividade);
                      //echo "<script>window.alert('Atividade Lançada!');</script>";
                      }
                      //echo "<script>window.alert('Usuário atualizado com sucesso!');</script>";
                  }

                  
                    
                  if(isset($_POST['con_edit_os'])) {
                      $query = "SELECT * FROM tb_servico WHERE cd_servico = '".$_POST['btncd_casa']."'";
                      $result = mysqli_query($conn, $query);
                      $row = mysqli_fetch_assoc($result);

                      // Exibe as informações do usuário no formulário
                      if($row) {
                        $_SESSION['os_servico'] = $row['cd_servico'];
                        $_SESSION['os_cliente'] = $row['cd_cliente'];
                                
                                
                        $_SESSION['titulo_servico'] = $row['titulo_servico'];
                        $_SESSION['obs_servico'] = $row['obs_servico'];
                        $_SESSION['prioridade_servico'] = $row['prioridade_servico'];
                        $_SESSION['entrada_servico'] = $row['entrada_servico'];
                        $_SESSION['prazo_servico'] = $row['prazo_servico'];
                        $_SESSION['orcamento_servico'] = $row['orcamento_servico'];
                        $_SESSION['vpag_servico'] = $row['vpag_servico'];
                      }
                              
                      $select_cliente = "SELECT * FROM tb_cliente WHERE cd_cliente = '".$_SESSION['os_cliente']."'";
                      $result_cliente = mysqli_query($conn, $select_cliente);
                      $row_cliente = mysqli_fetch_assoc($result_cliente);
                      if($row_cliente) {
                        $_SESSION['pnome_cliente'] = $row_cliente['pnome_cliente'];
                        $_SESSION['snome_cliente'] = $row_cliente['snome_cliente'];
                        $_SESSION['tel_cliente'] = $row_cliente['tel_cliente'];                
                      }


                  }


                  if(isset($_POST['edit_os'])) {
                      $edit_os = "UPDATE tb_servico SET
                        obs_servico = '".$_POST['editobs_servico']."',
                        prioridade_servico = '".$_POST['editprioridade_servico']."',
                        prazo_servico = '".$_POST['editprazo_servico']."'
                        WHERE cd_servico = '".$_POST['editos_servico']."'";
                        mysqli_query($conn, $edit_os);
                        echo "<script>window.alert('Servico editado!');</script>";

                        $query = "SELECT * FROM tb_servico WHERE cd_servico = '".$_POST['editos_servico']."'";
                        $result = mysqli_query($conn, $query);
                        $row = mysqli_fetch_assoc($result);
                        // Exibe as informações do usuário no formulário
                        if($row) {
                          $_SESSION['os_servico'] = $row['cd_servico'];
                          $_SESSION['os_cliente'] = $row['cd_cliente'];
                                
                                
                          $_SESSION['titulo_servico'] = $row['titulo_servico'];
                          $_SESSION['obs_servico'] = $row['obs_servico'];
                          $_SESSION['prioridade_servico'] = $row['prioridade_servico'];
                          $_SESSION['entrada_servico'] = $row['entrada_servico'];
                          $_SESSION['prazo_servico'] = $row['prazo_servico'];
                          $_SESSION['orcamento_servico'] = $row['orcamento_servico'];
                          $_SESSION['vpag_servico'] = $row['vpag_servico'];
                        }
                  }

                  if(isset($_POST['lancarOrcamento'])) {
                              
                        if($_POST['titulo_orcamento']==false){
                          $_SESSION['titulo_orcamento'] = $_POST['titulo_orcamento'];
                          $_SESSION['vcusto_orcamento'] = $_POST['vcusto_orcamento'];
                          echo "<script>window.alert('Descreva o Orcamento!');</script>"; 
                        }elseif($_POST['vcusto_orcamento']==false){
                          $_SESSION['titulo_orcamento'] = $_POST['titulo_orcamento'];
                          $_SESSION['vcusto_orcamento'] = $_POST['vcusto_orcamento'];
                          echo "<script>window.alert('Insira o Valor do Orcamento!');</script>";  
                        }else{
                          $_SESSION['titulo_orcamento'] = false;
                          $_SESSION['vcusto_orcamento'] = false;
                          $insertOrcamento = "INSERT INTO tb_orcamento_casa(cd_cliente, cd_casa, titulo_orcamento, vcusto_orcamento, status_orcamento) VALUES(
                            '".$_SESSION['cd_cliente_casa']."',
                            '".$_SESSION['cd_casa']."',
                            '".$_POST['titulo_orcamento']."',
                            '".$_POST['vcusto_orcamento']."',
                            '0')
                          ";
                          mysqli_query($conn, $insertOrcamento);
                          $_SESSION['vtotal_orcamento'] = $_SESSION['vtotal_orcamento'] + $_POST['vcusto_orcamento'];
                              
                          //$updateOrcamentoServico = "UPDATE tb_servico SET
                          //  orcamento_servico = ".$_SESSION['vtotal_orcamento']."
                          //  WHERE cd_servico = ".$_SESSION['os_servico']."";
                          //  mysqli_query($conn, $updateOrcamentoServico);
                        echo '<script>location.href="'.$_SESSION['dominio'].'pages/md_hospedagem/editar_casa.php";</script>';             

                          }            
                  }

                  if(isset($_POST['listaremover_orcamento'])) {//DELETE FROM `tb_orcamento_servico` WHERE `tb_orcamento_servico`.`cd_orcamento` = 198
                    if(($_SESSION['vtotal_orcamento'] - $_POST['listavalor_orcamento'])>=$_SESSION['vpag_servico']){
                      //echo "<script>window.alert('OK, pode remover');</script>";
                      $vtotal = $vtotal - $_POST['listavalor_orcamento'];
                      $removeOrcamento = "DELETE FROM `tb_orcamento_casa` WHERE `tb_orcamento_casa`.`cd_orcamento` = ".$_POST['listaid_orcamento']."";
                      mysqli_query($conn, $removeOrcamento);
                      
                      //$updateVtotalServico = "UPDATE tb_servico SET
                        //orcamento_servico = ".$vtotal."
                        //WHERE cd_servico = ".$_SESSION['os_servico']."";
                        //mysqli_query($conn, $updateVtotalServico);
                        echo '<script>location.href="'.$_SESSION['dominio'].'pages/md_hospedagem/editar_casa.php";</script>';             
                    }else{
                      echo "<script>window.alert('Valor pago não pode ser maior que o total do serviço!');</script>";  
                    }
                  }
                  
                  
                
                
                  if(isset($_POST['limparOS'])){
                    //echo "<script>window.alert('Mostrar botão de limpar OS!');</script>";
                    ////session_start();
                    $_SESSION['os_cliente'] = 0;
                    $_SESSION['os_servico'] = 0;
                    $_SESSION['vtotal_orcamento'] = 0;
                    $_SESSION['vpag_servico'] = 0;
                    
                    echo '<script>document.getElementById("consulta").style.display = "block";</script>';//botoes
                    echo '<script>document.getElementById("botoes").style.display = "none";</script>';//
                    
                    
                  }
                

                  
                ?>
                <script>
                          function enviarMensagemWhatsApp() {
                            // Obter os valores dos campos do formulário
                            var nomeCliente = document.getElementById("btnpnome_cliente").value;
                            var telefoneCliente = document.getElementById("btntel_cliente").value;
                            var numeroOS = document.getElementById("btncd_casa").value;
                            var entradaServico = document.getElementById("btnentrada_servico").value;

                            var observacoesServico = document.getElementById("btnobs_servico").value;
                            var prioridadeServico = document.getElementById("btnprioridade_servico").value;
                            var prazoServico = document.getElementById("btnprazo_servico").value;

                            var vtotalServico = document.getElementById("btnvtotal_orcamento").value;
                            var vpagServico = document.getElementById("btnvpag_orcamento").value;


                            var anoEntrada = entradaServico.substring(0, 4);
                            var mesEntrada = entradaServico.substring(5, 7);
                            var diaEntrada = entradaServico.substring(8, 10);
                            var horaEntrada = entradaServico.substring(11, 13);
                            var minutoEntrada = entradaServico.substring(14, 16);

                            var anoPrazo = prazoServico.substring(0, 4);
                            var mesPrazo = prazoServico.substring(5, 7);
                            var diaPrazo = prazoServico.substring(8, 10);
                            var horaPrazo = prazoServico.substring(11, 13);
                            var minutoPrazo = prazoServico.substring(14, 16)

                            // Montar a data organizada
                            var entradaOrganizada = diaEntrada + "/" + mesEntrada + "/" + anoEntrada + " às " + horaEntrada + ":" + minutoEntrada;
                            var prazoOrganizado = diaPrazo + "/" + mesPrazo + "/" + anoPrazo + " às " + horaPrazo + ":" + minutoPrazo;
                            if(prioridadeServico == "U"){
                              prioridadeOrganizada = "Urgente";
                            }
                            if(prioridadeServico == "A"){
                              prioridadeOrganizada = "Alta";
                            }
                            if(prioridadeServico == "M"){
                              prioridadeOrganizada = "Média";
                            }
                            if(prioridadeServico == "B"){
                              prioridadeOrganizada = "Baixa";
                            }
                            faltaPagar = vtotalServico - vpagServico;
                              // Construir a mensagem com todos os dados do formulário
                            var mensagem = "*Olá, " + nomeCliente + "!*\n";
                            mensagem += "Sou *<?php echo $_SESSION['pnome_colab'].' '.$_SESSION['snome_colab'];?>* , da empresa *<?php echo $_SESSION['nfantasia_filial'];?>* e fico no endereço *<?php echo $_SESSION['endereco_filial'];?>*.\n\n";
                            
                            mensagem += "Sua ordem de serviço de número *OS" + numeroOS + "*, deu entrada em nossa loja *" + entradaOrganizada + "*.\n";
                            mensagem += "Descrição da atividade: " + observacoesServico + "\n";
                            //mensagem += "Prioridade Requerida: *" + prioridadeOrganizada + "*\n";//Marcia pediu para tirar
                            mensagem += "O prazo previsto para entrega é: *" + prazoOrganizado + "*\n\n";
                            <?php
                              $select_orcamento_whatsapp = "SELECT * FROM tb_orcamento_servico WHERE cd_servico = '".$_SESSION['cd_servico']."' ORDER BY cd_orcamento ASC";
                              $result_orcamento_whatsapp = mysqli_query($conn, $select_orcamento_whatsapp);
                              echo 'mensagem += "*Lista detalhada*\n";';
                              while($row_orcamento_whatsapp = $result_orcamento_whatsapp->fetch_assoc()) {
                                $counter = $counter + 1;
                                //echo 'mensagem += count + " - '.$row_orcamento_whatsapp['titulo_orcamento'].' - '.$row_orcamento_whatsapp['vcusto_orcamento'].'"\n";';
                                ?>mensagem += "<?php echo '*'.$counter.'* - '.$row_orcamento_whatsapp['titulo_orcamento'].' - R$:'.$row_orcamento_whatsapp['vcusto_orcamento']; ?>\n";<?php
                              }
                              echo 'mensagem += "\n";';
                            ?>
                            mensagem += "Total: *R$:" + vtotalServico + "*\n";
                            mensagem += "Valor pago: R$:*" + vpagServico + "*\n";
                            mensagem += "Falta pagar: R$:*" + faltaPagar + "*\n\n";

                            mensagem += "\n__________________________________\n";
                            <?php
                              echo 'mensagem += "Acompanhe seu histórico pelo link:'.$_SESSION['dominio'].'pages/md_assistencia/acompanha_servico.php?cnpj='.$_SESSION['cnpj_empresa'].'&tel=" + telefoneCliente + "\n";';
                            ?>
                            mensagem += "\n__________________________________\n";


                            mensagem += "OBS: *_<?php echo $_SESSION['saudacoes_filial'];?>_*\n\n";//$_SESSION['endereco_filial']
                            mensagem += "```NuvemSoft © | Release: B E T A```";//$_SESSION['endereco_filial']
                            // Codificar a mensagem para uso na URL
                            var mensagemCodificada = encodeURIComponent(mensagem);
                            // Construir a URL do WhatsApp
                            var urlWhatsApp = "https://api.whatsapp.com/send?phone=" + telefoneCliente + "&text=" + mensagemCodificada;
                            // Abrir a janela do WhatsApp com a mensagem preenchida
                            window.open(urlWhatsApp, "_blank");
                          }



                          

                </script>
                </div>
                <div class="card" <?php $_SESSION['c_card'];?>>
                



                

              <?php
              //    if(isset($_POST['consulta'])) {
              //      // Consulta o usuário pelo CPF
              //      $sql_os = "SELECT * FROM tb_servico WHERE cd_servico = '".$_POST['conos_servico']."'";
              //      $result_os = mysqli_query($conn, $sql_os);
              //      $row_os = mysqli_fetch_assoc($result_os);

              //      // Exibe as informações do usuário no formulário
              //      if($row_os) {
              //        $_SESSION['os_servico'] = $_POST['conos_servico'];
              //        // Consulta o usuário pelo CPF
              //      }


              //    }


                    
                ?>
                
                <?php
                  
                  echo '<div class="row mt-3 ">';
                  echo '<div class="col-xl-3 flex-column d-flex grid-margin stretch-card">';
                  echo '<h3 class="kt-portlet__head-title">Área da automação</h3>';

                  echo '<div class="row justify-content-md-center"> ';

                  //echo '<div class="card-body" '.$_SESSION["c_card"].'" >';
                  //echo '<div class="card-body" id="consulta_cliente" name="consulta_cliente" '.$_SESSION["c_card"].'" >';
                  //echo '<h3 class="card-title" '.$_SESSION["c_card"].' >Area da automação</h3>';
                ?>
                

                
                      <script>
                        function updateContent1() {
                          fetch('p2.php')
                          .then(response => response.text())
                          .then(data => {
                            document.getElementById('content1').innerHTML = data;
                          })
                          .catch(error => console.error('Erro:', error));
                        }
                        setInterval(updateContent1, 3000);
                        window.onload = updateContent1;
                      </script>
                      <div id="content1"><h1>Carregando #1...</h1></div>
                    


                
              </div>

                

              </div>
            </div>
          </div>
        
     
    
  

        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <?php
          include("../../partials/_footer.php");
        ?>
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