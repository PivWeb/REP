<input type="hidden" id="caixa_livre" value="{{$usuario->caixa_livre}}" name="">
<input type="hidden" id="abertura" value="{{$abertura}}" name="">
<input type="hidden" id="prevenda_id" value="{{isset($item) ? $item->id : null}}" name="prevenda_id">

@if(isset($itens))
<input type="hidden" id="itens_pedido" value="{{json_encode($itens)}}">
<input type="hidden" id="valor_total" @if(isset($valor_total)) value="{{$valor_total}}" @else value='0' @endif>
<input type="hidden" id="delivery_id" @if(isset($delivery_id)) value="{{$delivery_id}}" @else value='0' @endif>
<input type="hidden" id="bairro" @if(isset($bairro)) value="{{$bairro}}" @else value='0' @endif>
<input type="hidden" id="codigo_comanda_hidden" @if(isset($cod_comanda)) value="{{$cod_comanda}}" @else value='0' @endif name="">
@endif

<input type="hidden" id="codigo_comanda" value="0" name="codigo_comanda">

@isset($pedido)
<input type="hidden" value="{{ $pedido->id }}" name="pedido_id">
@endif

@isset($filial)
<input type="hidden" id="filial" class="filial_id" name="filial_id" value="{{$filial == null ? null : $filial}}">
@endif

<div class="card card-custom gutter-b example">
    <div class="col-lg-12 mt-2">
        <div class="row row-cols-auto m-3">
            <h5 class=""><strong id="timer" class="is-desktop"></strong>
                @if($usuario->caixa_livre)
                <span class="text-info">Caixa Livre</span>
                <button data-toggle="modal" data-target="#modal-funcionarios" class="btn btn-sm btn-light-info">
                    <i class="bx bx-user"></i>
                </button>
                @endif
            </h5>
            <div class="col is-desktop">
                <button type="button" class="btn btn-dark btn-sm" style="margin-left: -10px" data-bs-toggle="modal" data-bs-target="#modal-selecionar_vendedor"><i class="bx bx-user-check"></i> Informar
                Vendedor</button>
            </div>
            <div class="col is-desktop">
                <button type="button" class="btn btn-info btn-sm" style="margin-left: -10px" data-bs-toggle="modal" data-bs-target="#modal-lista_pre_venda"><i class="bx bx-folder-open"></i> Lista de
                Pré-vendas</button>
            </div>
            <div class="col is-desktop">
                <a href="{{ route('frenteCaixa.list') }}" type="button" class="btn btn-primary  btn-sm" style="margin-left: -10px"><i class="bx bx-list-check"></i> Lista de Vendas</a>
            </div>
            <div class="col is-desktop">
                <button type="button" class="btn btn-warning btn-sm" style="margin-left: -10px" data-bs-toggle="modal" data-bs-target="#modal-fluxo_diario"><i class="bx bx-money"></i> Fluxo
                Diário</button>
            </div>
            <div class="col is-desktop">
                <a class="btn btn-success btn-sm" style="margin-left: -10px" href="{{ route('frenteCaixa.troca') }}"><i class="bx bx-sync"></i> Lista de Trocas</a>
            </div>

            <h4 class="h4-comanda text-primary"></h4>

            <div class="row ms-auto">
                <div class="col">
                    <button class="btn btn-outline-primary dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">Ações</button>
                    <ul class="dropdown-menu">
                        <li><a class="btn btn-outline-secondary dropdown-item" href="{{ route('frenteCaixa.devolucao') }}">Devolução</a>
                        </li>
                        <li><a class="btn btn-outline-secondary dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-sangria_caixa">Sangria</a>
                        </li>
                        <li><a class="btn btn-outline-secondary dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal-suprimento_caixa">Suprimento de Caixa</a>
                        </li>
                        <li><a class="btn btn-outline-secondary dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal-comanda_pdv">Apontar Comanda</a>
                        </li>
                        <li><a class="btn btn-outline-secondary dropdown-item" href="{{ route('frenteCaixa.fechar') }}">Fechar
                        Caixa</a>
                    </li>
                    <li><a class="btn btn-outline-secondary dropdown-item" href="{{ route('frenteCaixa.configuracao') }}">Configuração</a>
                    </li>
                    <li><a class="btn btn-outline-secondary dropdown-item" href="{{ route('frenteCaixa.list') }}">Sair</a>
                    </li>
                </ul>
            </div>

            <div class="col is-mobile">
                <button class="btn btn-outline-success dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">PDV</button>
                <ul class="dropdown-menu">

                    <li>
                        <button type="button" class="btn btn-outline-secondary dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-selecionar_vendedor"><i class="bx bx-user-check"></i> Informar Vendedor
                        </button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-outline-secondary dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-lista_pre_venda"><i class="bx bx-folder-open"></i> Lista de
                        Pré-vendas</button>
                    </li>
                    <li>
                        <a href="{{ route('frenteCaixa.list') }}" type="button" class="btn btn-outline-secondary dropdown-item" ><i class="bx bx-list-check"></i> Lista de Vendas</a>
                    </li>
                    <li>
                        <button type="button" class="btn btn-outline-secondary dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-fluxo_diario"><i class="bx bx-money"></i> Fluxo
                        Diário</button>
                    </li>
                    <li>
                        <a class="btn btn-outline-secondary dropdown-item" href="{{ route('frenteCaixa.troca') }}"><i class="bx bx-sync"></i> Lista de Trocas</a>
                    </li>

                </ul>
            </div>
            <div class="col">
                <div class="col" style="margin-left: -10px">
                    <a class="btn btn-outline-danger btn-sm" href="{{ route('vendas.index') }}">Sair</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row dark-theme m-1">
        <div class="col-lg-8 col-12">

            <div class="input-group-prepend">
                <span class="input-group-text" id="focus-codigo">
                    <li class="bx bx-barcode"></li>
                    <input class="mousetrap" type="" autofocus id="codBarras" name="">
                    <span id="mousetrapTitle"><span class="texto-leitor">CLIQUE AQUI PARA ATIVAR O LEITOR</span> <i class="las la-sort-down" style="margin-top: 4px;"></i></span>
                </span>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inp-produto_id" class="">Produto</label>
                        <div class="input-group">
                            <select class="form-control produto_id" name="produto_id" id="inp-produto_id"></select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    {!! Form::tel('quantidade', 'Quantidade')->attrs(['class' => 'qtd']) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::tel('valor_unitario', 'Valor Unitário')->attrs(['class' => 'moeda value_unit']) !!}
                </div>
                <div class="col-md-1 is-desktop" style="margin-left: 20px">
                    <br>
                    <button class="btn btn-primary btn-add-item" type="button">Adicionar</button>
                </div>
                <div class="col-md-1 is-mobile" style="margin-top: 10px">
                    <button class="btn btn-primary btn-add-item w-100" type="button">Adicionar</button>
                </div>
                <div class="table-responsive" style="height: 480px">
                    <table class="table mb-0 table-striped mt-2 table-itens table-pdv">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>QTD</th>
                                <th>Valor</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($itensDopedido)
                            @foreach($itensDopedido as $it)

                            {!! $it !!}
                            @endforeach
                            @endif
                            @if (isset($item))
                            @foreach ($item->itens as $key => $product)
                            <tr>

                                <input readonly type="hidden" name="key" class="form-control" value="{{ $product->key }}">
                                <input readonly type="hidden" name="produto_id[]" class="form-control" value="{{ $product->produto->id }}">

                                <td>
                                    <input readonly type="text" name="produto_nome[]" class="form-control" value="{{ $product->produto->nome }}">
                                </td>
                                <td>
                                    <input readonly type="tel" name="quantidade[]" class="form-control qtd-item" value="{{ __estoque($product->quantidade) }}">
                                </td>
                                <td>
                                    <input readonly type="tel" name="valor_unitario[]" class="form-control" value="{{ __moeda($product->valor) }}">
                                </td>
                                <td>
                                    <input readonly type="tel" name="subtotal_item[]" class="form-control subtotal-item" value="{{ __moeda($product->valor * $product->quantidade) }} " id="subtotal_input">
                                </td>
                                
                                <td>
            <input readonly type="tel" name="subtotal_item[]" class="form-control subtotal-item" value="R$ 50,00">
        </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    <hr>
                </div>
            </div>
            <div class="card" style="background-color: rgb(248, 242, 242) ; margin-top: -10px">
                <div class="row" style="margin-left: 5px">
                    <div class="col-md-3">
    <p class="mt-2">
        Desconto:
        <strong id="valor_desconto">R$ 0,00</strong>
        <button type="button" onclick="editarDesconto()" class="btn btn-warning btn-sm mt-1 btn-acrescimo"><i class="bx bx-edit"></i></button>
    </p>
</div>
                    
                    <!--div class="col-md-3">
                        <p class="mt-2">Desconto: <strong class="class_desconto" id="valor_desconto">R$ 0,00 </strong> <button type="button" onclick="setaDesconto()" class="btn btn-warning btn-sm mt-1 btn-desconto"><i class="bx bx-edit"></i></button></p>
                    </div-->
                    
                    
                    <div class="col-md-3">
                        <p class="mt-2">Acréscimo: <strong class="class_acrescimo" id="valor_acrescimo">R$ 0,00 </strong> <button type="button" onclick="setaAcrescimo()" class="btn btn-warning btn-sm mt-1 btn-acrescimo"><i class="bx bx-edit"></i></button></p>
                    </div>
                    <div class="col-md-6 col-12 mt-1 mb-1">
                        <label>Lista de Preços:</label>

                        <select name="" id="" style="width: 300px;" class="form-select mt-2 w-45">
                            @foreach ($lista as $item)
                            
                            <?php echo $item ?>
                            
                            <option value="">{{ $item->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    @isset($abertura)
                    @if(empresaComFilial() && $abertura)
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <div style="display: flex;align-items: center;height: 100%;">
                                <h6 class="mb-0">
                                    Local: <strong class="text-info">{{$filial != null ? $filial->descricao : 'Matriz'}}</strong>
                                </h6>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="card" style="background-color: rgb(243, 231, 231); height: 650px">
                <div class="row row-cols-auto m-2 btns-pdv">
                    <div class="col-lg-4 col-12">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#modal-selecionar_cliente" class="btn btn-info btn-sm btn-selecionar_cliente w-100"><i class="bx bx-user"></i>Cliente</button>
                    </div>
                    <div class="col-lg-4 col-12">
                        <button type="button" class="btn btn-primary btn-sm modal-pag_mult w-100" data-bs-toggle="modal" data-bs-target="#modal-pag_multi_pdv"><i class="bx bx-list-ol"></i>Pag. Multiplo</button>
                    </div>
                    <div class="col-lg-4 col-12">
                        <button type="button" class="btn btn-warning btn-sm w-100" data-bs-toggle="modal" data-bs-target="#modal-observacoes_pdv"><i class="bx bx-pencil"></i>Observações</button>
                    </div>
                </div>
                <hr>

<div class="container">
    <div class="row">
        <!-- Card do TOTAL VENDA -->
        <div class="card m-2 p-3" style="background-color: rgb(217, 223, 209); width: 100%; border-radius: 10px;">
            <b><h6 class="text-center">TOTAL VENDA</h6></b>
            <div class="d-flex justify-content-center align-items-center">
                <h2>R$<strong id="total" class="total-venda">0,00</strong></h2>
            </div>       
        </div>

        <!-- Card do TOTAL DESCONTO -->
        <!-- Desconto visível -->

<!-- Total Desconto no card -->
<div class="card m-2 p-3" style="background-color: rgb(217, 223, 209); border-radius: 10px;">
    <b><h6 class="text-center">TOTAL DESCONTO</h6></b>
    <div class="d-flex justify-content-center align-items-center">
        <h2 id="total_desconto" class="m-0 mx-2 fw-bold"  >R$ 0,00</h2>
    </div>
</div>

<!-- JS no final da página -->
<script>
    // Formata o valor como moeda BRL
    function formatarMoeda(valor) {
        return valor.toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });
    }

    // Converte "R$ 1.234,56" para número 1234.56
    function moedaParaNumero(valor) {
        return parseFloat(valor.replace(/[R$\s.]/g, '').replace(',', '.')) || 0;
    }

    // Atualiza o total desconto E o total a pagar
    function atualizaTotais() {
        const totalVenda = moedaParaNumero(document.getElementById('total').textContent);
        const desconto = moedaParaNumero(document.getElementById('valor_desconto').textContent);

        // Atualiza o TOTAL DESCONTO formatado no H1
        document.getElementById('total_desconto').textContent = formatarMoeda(desconto);

        // Calcula o TOTAL A PAGAR
        const totalPagar = totalVenda - desconto;
        document.getElementById('total_a_pagar').textContent = formatarMoeda(totalPagar);
    }

    // Simula edição de desconto (pode ser adaptado)
    function editarDesconto() {
        const atual = document.getElementById('valor_desconto').textContent.trim().replace("R$", "").trim();
        const novo = prompt("Informe o novo desconto:", atual);

        if (novo !== null && novo.trim() !== "") {
            const numero = moedaParaNumero(novo);
            const formatado = formatarMoeda(numero);

            document.getElementById('valor_desconto').textContent = formatado;
            atualizaTotais();
        }
    }

    // Atualiza tudo ao carregar a página
    window.addEventListener('DOMContentLoaded', atualizaTotais);
</script>


        <!-- Card do TOTAL A PAGAR -->
<div class="card m-2 p-3" style="background-color: rgb(217, 223, 209); width: 100%; border-radius: 10px;">
    <h5 class="m-3 text-center">TOTAL A PAGAR</h5>
    <div class="d-flex justify-content-center align-items-center">
        <h1 class="m-0 mx-2 fw-bold" style="font-size: 5rem;">
            <strong id="total_a_pagar" class="total-venda">R$ 0,00</strong>
        </h1>
    </div>
</div>


    </div>
</div>
<script>
    function setaDesconto() {
        // Captura o valor atual de #valor_desconto
        const novoDesconto = prompt("Informe o valor do desconto:", document.getElementById('valor_desconto').textContent.trim());

        if (novoDesconto) {
            // Atualiza o campo visível do desconto
            document.getElementById('valor_desconto').textContent = novoDesconto;

            // Joga esse valor direto no h1 do TOTAL DESCONTO
            document.getElementById('total_desconto').textContent = novoDesconto;
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('modal-formas-pagamento');

        modal.addEventListener('show.bs.modal', function () {
            const valorTotal = document.getElementById('total_a_pagar')?.innerText || "R$ 0,00";
            const campoTopo = document.getElementById('valor_modal_topo');
            if (campoTopo) {
                campoTopo.innerText = valorTotal;
            }
        });

        // Atalho F10 para abrir o modal
        document.addEventListener('keydown', function (event) {
            if (event.key === "F10" || event.keyCode === 121) {
                event.preventDefault();
                const botaoFinalizar = document.querySelector('[data-bs-target="#modal-formas-pagamento"]');
                if (botaoFinalizar) {
                    botaoFinalizar.click();
                }
            }
        });
    });
</script>






  <div class="modal fade" id="modal-formas-pagamento" tabindex="-1" aria-labelledby="modalFormasPagamentoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
    <div class="w-100">
        <h5 class="modal-title" id="modalFormasPagamentoLabel">Formas de Pagamento</h5>
        <h4 class="text-success mt-2" id="valor_modal_topo">R$ 0,00</h4>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="tipo_pagamento" class="form-label">Selecione a Forma de Pagamento:</label>
                    <select id="tipo_pagamento" name="tipo_pagamento" class="form-select">
                        <option value="">Selecione</option>
                        @foreach(App\Models\Venda::tiposPagamento() as $key => $tipo)
                            <option value="{{ $key }}">{{ $tipo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="valor_recebido" class="form-label">Valor Recebido:</label>
                    <input type="text" id="valor_recebido1" name="valor_recebido1" placeholder="Digite o valor recebido" class="form-control moeda">
                </div>
                <div class="card p-2" style="background-color: rgb(143, 145, 141);">
                    <h6>Troco:</h6>
                    <h3 id="valor-troco" class="text-white">R$ 0,00</h3>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="confirmar-pagamento">Confirmar</button>
            </div>
        </div>
    </div>
</div>       

                        {!! Form::hidden('subtotal', 'SubTotal')->attrs(['class' => 'moeda']) !!}

 
 <script>
   function parseMoeda(valor) {
    if (!valor) return 0;

    // Remove tudo que não é número
    valor = valor.replace(/\D/g, '');

    // Se o valor tiver menos de 3 dígitos, ajusta para centavos
    if (valor.length <= 2) {
        valor = valor.padStart(3, '0');
    }

    // Divide os centavos
    const inteiro = valor.slice(0, -2);
    const centavos = valor.slice(-2);

    return parseFloat(`${inteiro}.${centavos}`);
}



    function calcularTroco() {
        const valorRecebido = parseMoeda(document.getElementById('valor_recebido1').value);
        const valorTotal = parseMoeda(document.getElementById('valor_modal_topo').innerText);
        const troco = valorRecebido - valorTotal;
        document.getElementById('valor-troco').innerText = formatarMoeda(troco > 0 ? troco : 0);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const inputValor = document.getElementById('valor_recebido1');
        if (inputValor) {
            inputValor.addEventListener('input', calcularTroco);
        }
    });
</script>


 
 
          
    
    <!-- Botão Responsivo -->
<!-- Botão com tamanho controlado dentro da div -->
<div class="row">
    <div class="col-12 d-flex justify-content-center">
        <button type="button" 
                class="btn btn-primary p-3 mt-3" 
                data-bs-toggle="modal" 
                data-bs-target="#modal-formas-pagamento"
                style="width: 80%; max-width: 400px;">
            <i class="bx bx-credit-card"></i> Finalizar Vendas
        </button>
    </div>
</div>


    
    
                            <!--div class="col-md-12">
                            <button style="width: 96%; margin-top: 135px;" type="button" id="salvar_venda" disabled class="btn btn-success px-5" data-bs-toggle="modal" data-bs-target="#modal-finalizar_venda">
                                Finalizar Venda
                            </button-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>





@include('modals.frontBox._selecionar_cliente', ['not_submit' => true])
@include('modals.frontBox._observacoes_pdv', ['not_submit' => true])
@include('modals.frontBox._selecionar_vendedor', ['not_submit' => true])
@include('modals.frontBox._pag_multi_pdv', ['not_submit' => true])
@include('modals.frontBox._finalizar_venda')
@include('modals.frontBox._dados_cartao') 