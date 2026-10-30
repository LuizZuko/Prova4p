<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ItemCompra extends Model
{
    protected $table = 'itens_compra';
    protected $primaryKey = 'id_item';
    public $timestamps = false;
    protected $fillable = ['compra_id', 'jogo_id', 'preco_unitario'];
    protected function casts(): array
    {
        return ['preco_unitario' => 'decimal:2'];
    }
    public function compra(): BelongsTo
    {
        return $this->belongsTo(Compra::class, 'compra_id', 'id_compra');
    }
    public function jogo(): BelongsTo
    {
        return $this->belongsTo(Jogo::class, 'jogo_id', 'id_jogo');
    }
}