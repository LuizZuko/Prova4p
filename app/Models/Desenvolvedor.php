<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Desenvolvedor extends Model
{
    protected $table = 'desenvolvedores';
    protected $primaryKey = 'id_desenvolvedor';
    public $timestamps = false;
    protected $fillable = [
        'nome_estudio', 'pais', 'ano_fundacao', 'email_contato'
    ];
    protected function casts(): array
    {
        return ['ano_fundacao' => 'date'];
    }
    public function jogos(): HasMany
    {
        return $this->hasMany(Jogo::class, 'desenvolvedor_id', 'id_desenvolvedor');
    }
}
