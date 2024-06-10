<?php 

ob_start();
require('../sheep_core/config.php');

$clienteCadastro = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if(isset($clienteCadastro['Finalizar'])){
unset($clienteCadastro['Finalizar']);
var_dump($clienteCadastro);

$salvar = new FinalizaPg();
$salvar->FinalizaCompra($clienteCadastro);
if($salvar->getResultado()){

    header("Location: https://api.whatsapp.com/send?phone=5596999118176&text=Seu pedido foi recebido, confira agora o número do pedido a lista de produtos e o boleto para pagamento: ".HOME."/ver_pedido.php");
}else{
    header("Location: ". HOME ."/index.php?erro=true");
}
}


?>