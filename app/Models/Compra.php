<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Compra extends Model
{
    protected $table = 'compras';
    protected $primaryKey = 'id_compra';
    public $timestamps = false;
    protected $fillable = ['usuario_id', 'metodo_pagamento', 'valor_total'];
    protected function casts(): array
    {
        return [
            'data_compra' => 'datetime',
            'valor_total' => 'decimal:2',
        ];
    }
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }
    public function itens(): HasMany
    {
        return $this->hasMany(ItemCompra::class, 'compra_id', 'id_compra');
    }
}