@php $editando = isset($jogo); @endphp
<form action="{{ $editando ? route('jogos.update',$jogo) : route('jogos.store') }}" method="POST">
 @csrf
 @if ($editando) @method('PUT') @endif
 <div class="form-grid">
 <div class="field field-full">
 <label for="titulo">Nome do jogo</label>
 <input id="titulo" name="titulo" maxlength="120" required
 value="{{ old('titulo',$jogo->titulo ?? '') }}" placeholder="Ex.: Cyberpunk 2077">
 @error('titulo') <span class="field-error">{{ $message }}</span> @enderror
 </div>
 <div class="field">
 <label for="categoria_id">Categoria</label>
 <select id="categoria_id" name="categoria_id" required>
 <option value="">Selecione</option>
 @foreach ($categorias as $categoria)
 <option value="{{ $categoria->id_categoria }}"
 @selected(old('categoria_id',$jogo->categoria_id ?? '') == $categoria->id_categoria)>
 {{ $categoria->nome_categoria }}
 </option>
 @endforeach
 </select>
 @error('categoria_id') <span class="field-error">{{ $message }}</span> @enderror
 </div>
 <div class="field">
 <label for="desenvolvedor_id">Desenvolvedor</label>
 <select id="desenvolvedor_id" name="desenvolvedor_id" required>
 <option value="">Selecione</option>
 @foreach ($desenvolvedores as $desenvolvedor)
 <option value="{{ $desenvolvedor->id_desenvolvedor }}"
 @selected(old('desenvolvedor_id',$jogo->desenvolvedor_id ?? '') ==
 $desenvolvedor->id_desenvolvedor)>
 {{ $desenvolvedor->nome_estudio }}
 </option>
 @endforeach
 </select>
 @error('desenvolvedor_id') <span class="field-error">{{ $message }}</span> @enderror
 </div>
 <div class="field">
 <label for="preco">Preço (R$)</label>
 <input id="preco" name="preco" type="number" min="0" step="0.01" required
 value="{{ old('preco',$jogo->preco ?? '') }}" placeholder="149.90">
 @error('preco') <span class="field-error">{{ $message }}</span> @enderror
 </div>
 <div class="field">
 <label for="data_lancamento">Data de lançamento</label>
 <input id="data_lancamento" name="data_lancamento" type="date" required
 value="{{ old('data_lancamento',isset($jogo) ? $jogo->data_lancamento?->format('Y-m-d') : '') }}">
 @error('data_lancamento') <span class="field-error">{{ $message }}</span> @enderror
 </div>
 </div>
 <div class="form-actions">
 <a class="button button-secondary" href="{{ route('jogos.index') }}">Cancelar</a>
 <button class="button button-primary" type="submit">
 {{ $editando ? 'Salvar alterações' : 'Cadastrar jogo' }}
 </button>
 </div>
</form>