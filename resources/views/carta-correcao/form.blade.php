@extends('default.layout', ['title' => 'Emitir Carta de Correção'])

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">

            <h2 class="mb-4 text-primary">
                <i class="bi bi-file-earmark-text"></i> Emitir Carta de Correção
            </h2>

            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $erro)
                            <li><i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('carta-correcao.enviar') }}" method="POST" class="card p-4 shadow-sm">
                @csrf

                <div class="mb-3">
                    <label for="chave" class="form-label fw-semibold">Chave de Acesso da NF-e</label>
                    <input
                        type="text"
                        name="chave"
                        id="chave"
                        maxlength="44"
                        class="form-control @error('chave') is-invalid @enderror"
                        placeholder="Digite a chave de acesso da NF-e (44 dígitos)"
                        required
                        value="{{ old('chave') }}"
                    >
                    @error('chave')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="texto" class="form-label fw-semibold">Justificativa / Correção</label>
                    <textarea
                        name="texto"
                        id="texto"
                        rows="6"
                        class="form-control @error('texto') is-invalid @enderror"
                        maxlength="1000"
                        placeholder="Descreva aqui o motivo da correção (máximo 1000 caracteres)"
                        required
                    >{{ old('texto') }}</textarea>
                    @error('texto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('carta-correcao.listar') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-list-ul me-1"></i> Ver Cartas Emitidas
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send-fill me-1"></i> Enviar Carta de Correção
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
