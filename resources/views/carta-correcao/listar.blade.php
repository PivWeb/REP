@extends('default.layout', ['title' => 'Cartas de Correção Emitidas'])


@section('content')
<div class="container mt-4">
    <h2>Cartas de Correção Emitidas</h2>

    <a href="{{ route('carta-correcao.form') }}" class="btn btn-success mb-3">Nova Carta de Correção</a>

    @if($cartas->count())
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Chave de Acesso</th>
                    <th>Protocolo</th>
                    <th>Status</th>
                    <th>Motivo</th>
                    <th>Enviado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartas as $carta)
                    <tr>
                        <td>{{ $carta->id }}</td>
                        <td><small>{{ $carta->chave }}</small></td>
                        <td>{{ $carta->protocolo }}</td>
                        <td>{{ $carta->cStat }}</td>
                        <td>{{ $carta->xMotivo }}</td>
                        <td>{{ $carta->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('carta-correcao.download', $carta->id) }}" class="btn btn-sm btn-outline-primary">
                                Baixar XML
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $cartas->links() }} <!-- Paginação -->
    @else
        <div class="alert alert-info">Nenhuma carta de correção emitida ainda.</div>
    @endif
</div>
@endsection
