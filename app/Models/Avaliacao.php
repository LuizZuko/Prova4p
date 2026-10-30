<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Avaliacao extends Model
{
    protected $table = 'avaliacoes';
    protected $primaryKey = 'id_avaliacao';
    public $timestamps = false;
    protected $fillable = [
        'usuario_id', 'jogo_id', 'nota', 'comentario', 'data_avaliacao'
    ];
    protected function casts(): array
    {
        return ['data_avaliacao' => 'date'];
    }
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }
    public function jogo(): BelongsTo
    {
        return $this->belongsTo(Jogo::class, 'jogo_id', 'id_jogo');
    }
}
