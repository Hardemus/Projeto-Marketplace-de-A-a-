<?php
require('vendor/autoload.php');

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

class FinalizaPg
{

    private $Data;
    private $Id;
    private $Resultado;

    public function FinalizaCompra(array $data)
    {
        $this->Data = $data;
        if (in_array('', $this->Data)) {
            $this->Resultado = false;
        } else {
            $this->Banco();
            $this->FinalCompra();
        }
    }

    public function EnviaPedido(int $id){
        $this->Id = $id;
        if($this->Id == null){
            $this->Resultado = false;
        }else{
            $this->AtualizaStatus();
        }

    }

    public function getResultado()
    {
        return $this->Resultado;
    }

    private function Banco()
    {
        $this->Data = array_map('addslashes', $this->Data);
        $this->Data = array_map('htmlspecialchars', $this->Data);
        $this->Data = array_map('trim', $this->Data);
        preg_replace('/[^[:alnum:]@]/', '', $this->Data);

        $this->Data['nome'] = (string) $this->Data['nome'];
        $this->Data['cpf'] = (string) $this->Data['cpf'];
        $this->Data['email'] = (string) $this->Data['email'];
        $this->Data['whatsapp'] = (string) $this->Data['whatsapp'];
        $this->Data['endereco'] = (string) $this->Data['endereco'];
        $this->Data['estado'] = (string) $this->Data['estado'];
        $this->Data['cidade'] = (string) $this->Data['cidade'];
        $this->Data['cep'] = (string) $this->Data['cep'];
        $this->Data['ip'] = (string) $this->Data['ip'];
        $this->Data['valor'] = $this->Data['valor'];
        $this->Data['data'] = date('Y-m-d H:i:s');
    }

    private function FinalCompra()
    {
        $criarCliente = new Criar();

        $criarCompras = new Criar();

        $criarCliente->Criacao('cliente', $this->Data);


        $lerCompras = new Ler();
        $lerCompras->Leitura('carrinho', "WHERE ip = :ip", "ip={$this->Data['ip']}");
        if ($lerCompras->getResultado()) {
            foreach ($lerCompras->getResultado() as $carrinho) {

                $lerCompras->Leitura('produtos', "WHERE id = :id", "id={$carrinho['id_produto']}");
                $prod = Formata::Resultado($lerCompras);
                if ($prod) {
                    foreach ($lerCompras->getResultado() as $produto) {
                        $produto = (object) $produto;


                        $valor = preg_replace('/\W+/u', '',$this->Data['valor']);
                        $cpf = preg_replace('/\W+/u', '',$this->Data['cpf']);


                        //echo "Nome: {$cliente->nome} data: {$vencimento} plano: {$gerar['plano']} valor: {$gerar['valor']} ";

                        $clientId = 'Client_Id_6888880906100cc0960011a902dd3fcbe7e21dd4';
                        $clientSecret = 'Client_Secret_d5b8dccd2f72891ed297decf5da3d99649a7a1a9';

                        $options = [
                            'client_id' => $clientId,
                            'client_secret' => $clientSecret,
                            'sandbox' => false // altere conforme o ambiente (true = Homologação e false = producao)
                        ];

                        $items = [
                            [
                                "name" => 'Pedido nº' .$criarCliente->getResultado() . date('s') . date('d') . date('Y'),
                                "amount" => 1,
                                "value" => intval($valor),
                            ],
                        ];



                        $customer = [
                            "name" => $this->Data['nome'],
                            "cpf" => $cpf,
                            "email" => $this->Data['email'],
                        ];


                        $bankingBillet = [
                            "expire_at" => date('Y-m-d', strtotime("+ 3 days")),
                            "message" => "Boleto Gerado Com Sucesso",
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
                            
                            $compras = [

                                "foto" => $produto->capa,
                                "titulo" => $produto->nome,
                                "valor" => $produto->valor,
                                "id_cliente" => $criarCliente->getResultado(),
                                "total" => $this->Data['valor'],
                                "numero_pedido" => $criarCliente->getResultado() . date('s') . date('d') . date('Y'),
                                "boleto" => $response['data']['link'],
                                "ip" => $this->Data['ip'],
                                "date" => date('Y-m-d'),
    
    
                            ];
    
                        } catch (GerencianetException $e) {
                            print_r($e->code);
                            print_r($e->error);
                            print_r($e->erroDescription);
                        } catch (Exception $e) {
                            print_r($e->getMessage());
                        }




                        

                        $criarCompras->Criacao('compras', $compras);
                    }
                }
            }
        }


        $excluirCarrinho = new Excluir();
        $excluirCarrinho->Remover('carrinho', "WHERE ip = :ip", "ip={$this->Data['ip']}");



        if ($criarCliente->getResultado()) {
            $this->Resultado = true;
        } else {
            $this->Resultado = false;
        }
    }

    private function AtualizaStatus(){
        $atualizaStatus = new Atualizar();
        $dadosStatus = ['status' => 'S'];
        $atualizaStatus->Atualizando('compras', $dadosStatus,"WHERE id_cliente = :id", "id=$this->Id");
        if ($atualizaStatus->getResultado()) {
            $this->Resultado = true;
        }else {
            $this->Resultado = false;
        }
    }

}
