<?php

/**********************************************************************
 * ********************************************************************
 * CAMADA PRINCIPAL MAYKONSILVEIRA.COM.BR E MAYKON SILVEIRA
 * 
 * ********************************************************************
* MAYKONSILVEIRA.COM.BR DEREICIONANDO VOCÊ PARA O CAMINHO DO SUCESSO #*
 * *************MAYKON***SILVEIRA**************************************
 * *************sheep**TECHNOLOGIES***********************************
 * ********************************************************************
 *
 * ********************************************************************
 * ********************************************************************
 */
ob_start();
session_start();

require('./sheep_core/config.php');
?>
<!DOCTYPE html>
<html lang="pt-br" >
<head >
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Tudo Açaí</title>
        <link rel="stylesheet" href="painel/assets/css/app.min.css">
      
        <link rel="stylesheet" href="painel/assets/css/style.css">
        <!-- FIM DO CSS  SHEEP FRAMEWORK PHP - MAYKONSILVEIRA.COM.BR -->
</head>
<body>


<!-- Main Content -->
<div align="center" style="padding:20px; margin-top:120px;" >
 
        <div class="col-md-10"> 
      <section class="section" >


            <!-- inicio topo menu -->
            <?php
            
            require_once('topo.php');

            ?>
      
            <!-- fim topo menu -->


           <br>
         <!-- inicio formulario  topo menu -->
          <form action="filtros/finalizar.php" method="post" enctype="multipart/form-data">
         <div class="section-body" >
          <div class="row" >
            <div class="col-md-12">
              <div class="card">
                  
                    
                <div class="card-header">
                  <h4>Finalize o seu pedido</h4><br>
                 
                </div>
                <div class="card-body">
         
                  <div class="form-group row mb-4">
                   
                    <div class="col-md-12">
                      <input type="text" class="form-control" name="nome" placeholder="Nome Completo">
                    </div>
                    
                  </div>

                  <div class="form-group row mb-4">
                   
                    <div class="col-md-12">
                      <input type="text" class="form-control" name="cpf" placeholder="CPF só números">
                    </div>
                    
                  </div>

                  <div class="form-group row mb-4">
                   
                   <div class="col-md-12">
                     <input type="text" class="form-control" name="whatsapp" placeholder="Whatsapp exe: (00)00000-0000">
                   </div>
                   
                 </div>

                 <div class="form-group row mb-4">
                   
                   <div class="col-md-12">
                     <input type="email" class="form-control" name="email" placeholder="E-mail exe: seu-email@gmail.com">
                   </div>
                   
                 </div>

                 <div class="form-group row mb-4">
                   
                   <div class="col-md-12">
                     <input type="text" class="form-control" name="endereco" placeholder="Rua exe: rua 11, 1440">
                   </div>
                   
                 </div>


                 <div class="form-group row mb-4">
                   
                   <div class="col-md-12">
                     <input type="text" class="form-control" name="cep" placeholder="CEP exe: 00000.000">
                   </div>
                   
                 </div>

                 <div class="form-group row mb-4">
                   
                   <div class="col-md-12">
                     <input type="text" class="form-control" name="estado" placeholder="Estado exe: Paraná">
                   </div>
                   
                 </div>


                 <div class="form-group row mb-4">
                   
                   <div class="col-md-12">
                     <input type="text" class="form-control" name="cidade" placeholder="Cidade exe: Curitiba">
                   </div>
                   
                 </div>


                  <input type="hidden" name="ip" value="<?=$_SESSION['ip']?>">
                  <input type="hidden" name="valor" value="<?=$_SESSION['valor']?>">

                  <div class="form-group row mb-4">
                   
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-lg btn-primary"  style="width:100%;" name="Finalizar" >Finalizar</button>
                    </div>

                  </div>
                  <p><a href="https://maykonsilveira.com.br">Tudo Açaí</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
            </form>
      <!-- fim formulario  topo menu -->
      </section>
      </div>
        
       
    </div>

  <script src="assets/js/custom.js"></script>

 
  

</body>
</html>

<?php
ob_end_flush();
?>