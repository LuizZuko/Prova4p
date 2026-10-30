<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Jogo extends Model
{
    protected $table = 'jogos';
    protected $primaryKey = 'id_jogo';
    public $timestamps = false;
    protected $fillable = [
        'titulo', 'desenvolvedor_id', 'categoria_id',
        'preco', 'data_lancamento', 'avaliacao_media',
    ];
    protected function casts(): array
    {
        return [
            'preco' => 'decimal:2',
            'avaliacao_media' => 'decimal:2',
            'data_lancamento' => 'date',
        ];
    }
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id_categoria');
    }
    public function desenvolvedor(): BelongsTo
    {
        return $this->belongsTo(
            Desenvolvedor::class, 'desenvolvedor_id', 'id_desenvolvedor'
        );
    }
    public function avaliacoes(): HasMany
    {
        return $this->hasMany(Avaliacao::class, 'jogo_id', 'id_jogo');
    }
}