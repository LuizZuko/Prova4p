<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;
    protected $fillable = ['nome', 'email', 'pais', 'saldo_carteira'];
    protected function casts(): array
    {
        return [
            'data_cadastro' => 'datetime',
            'saldo_carteira' => 'decimal:2',
        ];
    }
    public function compras(): HasMany
    {
        return $this->hasMany(Compra::class, 'usuario_id', 'id_usuario');
    }
    public function avaliacoes(): HasMany
    {
        return $this->hasMany(Avaliacao::class, 'usuario_id', 'id_usuario');
    }
}