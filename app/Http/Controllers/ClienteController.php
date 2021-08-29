<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function inserirCliente(Request $request){
        $dadosCliente = $request->input();

        $cliente = new Cliente();
        $cliente->setFromArray($dadosCliente);
        $cliente->save();
        return response()->json($cliente, 200);
    }
    
    public function alterarCliente(Request $request){
        $dadosCliente = $request->input();
        $email = $dadosCliente['email'];
        $cliente = Cliente::where('email', $email)->first();

        if($cliente == null){
            return response()->json(['Erro' => 'Não encontrado'], 404);
        }

        $cliente->setFromArray($dadosCliente);

        $cliente->save();
        return response()->json($cliente, 200);
    }

    public function buscarTodosClientes(Request $request){
        $todosClientes = Cliente::all();

        return response()->json($todosClientes, 200);
    }

    public function enviarEmails(Request $request){
       $emailParaEnviar = [];
       
       $todosClientes = Cliente::all();

       foreach($todosClientes as $cliente){
           if(($cliente->disponivelParaEmail()) == true){
                $emailParaEnviar[] = $cliente['email'];
                $cliente['ultimoContato'] = (new \DateTimeImmutable())->format('Y-m-d');
                $cliente->save(); 
            }
        }

        $resposta = ['Emails enviados para' => $emailParaEnviar];
        return response()->json($resposta, 200);
    }    
}
