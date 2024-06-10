<?php
ob_start();
require('./sheep_core/config.php');

require('vendor/autoload.php');

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$gerar = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if(isset($gerar['gerarBoleto'])){
    unset($gerar['gerarBoleto']);
    
    $ler = new Ler();
    $ler->Leitura('usuarios', "WHERE id = :id", "id={$gerar['id']}");
    if($ler->getResultado()){
     foreach($ler->getResultado() as $cliente);
      $cliente = (object) $cliente;
    }
   
    $vencimento = date('d/m/Y', strtotime($gerar['data']));

    $cpf = preg_replace('/\W+/u', '', $cliente->cpf);
     

    //echo "Nome: {$cliente->nome} data: {$vencimento} plano: {$gerar['plano']} valor: {$gerar['valor']} ";

$clientId = 'Client_Id_777'; // insira seu Client_Id, conforme o ambiente (Des ou Prod)
$clientSecret = 'Client_Secret_777'; // insira seu Client_Secret, conforme o ambiente (Des ou Prod)

$options = [
  'client_id' => $clientId,
  'client_secret' => $clientSecret,
  'sandbox' => false,// altere conforme o ambiente (true = Homologação e false = producao)
  //'timeout' => 60
];

$items = [
    [
        "name" => $gerar['plano'],
        "amount" => 1,
        "value" => intval($gerar['valor']),
    ]
];


$customer = [
    "name" => $cliente->nome,
    "cpf" => $cpf,
    "email" =>  $cliente->email,
    // "phone_number" => "",
    // "birth" => "",
    // "address" => [
    //  "street" => "",
    //  "number" => "",
    //  "neighborhood" => "",
    //  "zipcode" => "",
    //  "city" => "",
    //  "complement" => "",
    //  "state" => "",
    //  "juridical_person" => "",
    //  "corporate_name" => "",
    //  "cnpj" => ""
    // ],
];


$bankingBillet = [
    "expire_at" => $gerar['data'],
    "message" => "Boleto gerado na plataforma EAD MaykonSilveira.com.br",
    "customer" => $customer,
];

$payment = [
    "banking_billet" => $bankingBillet
];

$body = [
    "items" => $items,
    "payment" => $payment
];

try {
    $api = new Gerencianet($options);
    $response = $api->createOneStepCharge($params = [], $body);
    header("Location: ".$response['data']['link']);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}



}

?>