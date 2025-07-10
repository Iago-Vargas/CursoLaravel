<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TransactionsController extends Controller implements HasMiddleware
{
    // Declarar o construtor
    public function __construct(protected Transactions $transaction){}

    public static function middleware()
    {
        // Protegemos o index e o show para que não seja necessário autenticar
       return [new Middleware('auth:sanctum' , except: ['index', 'show'])];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Aqui estamos solicitando todo conteudo da tabela equivalente a um select * from ..
        return response()->json($this->transaction->with('userRelation:id,name')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // Request é a representação da solicitação HTTP
    {
        /* validar os dados*/
        $validatedData = $request -> validate([
            'transaction_name'=>'required|string|max:255',
            'transaction_date'=>'required',
            'transaction_category'=>'required',
            'transaction_amount'=>'required',
            'transaction_type'=>'required',

        ]);

        /* criar o objeto */
        $transaction = $request->user()->transactionsRelation()->create($validatedData);
        // 201 é o codigo de created, do endpoint
        return response()->json($transaction, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        // Aqui estamos solicitando um elemento especifico da tabela, equivalente a um select * from .. where id = $id
        $transaction = $this->transaction->with('userRelation')->find($id);
        // Caso não exista esse find ele entra no if e retorna um erro
        if (!$transaction)
        {
            /* Mensagem de erro e estamos passando a mensagem de erro 404 Not Found*/
            return response()->json([ 'errorMessage' => 'Searched Resource Does Not Exists.' ], 404);
        }
        /* Passamos um expecifico da lista e a mensagem de sucesso 200 */
        return response()->json($transaction, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /* Encontrar o elemento que queremos alterar */
        $transaction = $this->transaction->find($id);
        /* Verificamos se ele realmente existe */
        if (!$transaction){
            return response()->json([ 'errorMessage'=>'Updated Resource Does Not Exists.'], 404);
        }

        /* Agora vamos validar os dados */
        $validatedData = $request->validate([
           'transaction_name' => 'required|string|max:255',
           'transaction_date' => 'required',
           'transaction_category' => 'required',
           'transaction_amount' => 'required',
           'transaction_type' => 'required'
        ]);

        /* Aqui agora sim atualizamos o objeto que desejamos */
        $transaction->update($validatedData);
        return response()->json($transaction, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        /* Encontraremos o elemento novamente */
        $transaction = $this->transaction->find($id);
        /* Verificamos se existe menos ou não */
        if (!$transaction){
            return response()->json(['errorMessage' => 'Removed Resource Does Not Exists.'], 404);
        }

        /* Deletamos o objeto */
        $transaction -> delete($transaction);
        return response()->json(['SuccessMessage' => 'Transaction Removed Successfully!'], 200);
    }
}
