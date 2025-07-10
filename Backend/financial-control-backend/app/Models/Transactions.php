<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Importando o modelo User estrangeiro

class Transactions extends Model
{
    use HasFactory;

    protected $table = "transactions"; // Criar a tabela no banco de dados
    protected $fillable = [
        'transaction_name',
        'transaction_date',
        'transaction_category',
        'transaction_amount',
        'transaction_type',
    ];  // Habilitamos o preenchimento em massa no banco de dados

    // Relacionamento com o modelo User
    public function userRelation(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
