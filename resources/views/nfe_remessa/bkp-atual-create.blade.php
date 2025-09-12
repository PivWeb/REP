@extends('default.layout', ['title' => 'Nova NFe - Emissor Piv-Web'])
@section('content')
<div class="page-content">
    <div class="card">
        
       {{-- Exibir a mensagem de sucesso com Toast --}}
        @if(session('flash_sucesso'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: '{{ session("flash_sucesso") }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            </script>
        @endif
    <!-- Adicione o link para o SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
        {!! Form::open()->post()->route('nferemessa.store')
        ->multipart() !!}
        
        
        
        <div class="pl-lg-4">
            @include('nfe_remessa._forms')
            
            
        </div>
        {!! Form::close() !!}
    </div>
</div>

@section('js')
<script>
    function salvar(t) {
        $("#type").val(t)
        $('#form-venda').submit()
    }

    function selectDiv2(ref) {
        $('.btn-outline-primary').removeClass('active')
        if (ref == 'transporte') {
            $('.div-transporte').removeClass('d-none')
            $('.div-itens').addClass('d-none')
            $('.div-pagamento').addClass('d-none')
            $('.btn-transporte').addClass('active')
        }
    }

    function salvar(t) {
        $("#type").val(t)
        $('#form-venda').submit()
    }

    function selectDiv2(ref) {
        $('.btn-outline-primary').removeClass('active')
        if (ref == 'transporte') {
            $('.div-transporte').removeClass('d-none')
            $('.div-itens').addClass('d-none')
            $('.div-pagamento').addClass('d-none')
            $('.btn-transporte').addClass('active')
        } else if (ref == 'itens') {
            $('.div-transporte').addClass('d-none')
            $('.div-itens').removeClass('d-none')
            $('.div-pagamento').addClass('d-none')
            $('.btn-itens').addClass('active')
        } else {
            $('.div-transporte').addClass('d-none')
            $('.div-itens').addClass('d-none')
            $('.div-pagamento').removeClass('d-none')
            $('.btn-pagamento').addClass('active')
        }
    }

</script>

<script type="text/javascript" src="/js/client.js"></script>
{{-- <script type="text/javascript" src="/js/vendas.js"></script> --}}
<!--script type="text/javascript" src="/js/product.js"></script-->
<script type="text/javascript" src="/js/nfeRemessa.js"></script>
<script type="text/javascript" src="/js/transportadora.js"></script>


<script>
$(document).ready(function() {
    // Quando selecionar um cliente no Select2, atualiza o atributo data-cliente-id do botão "Buscar Pedido"
    $('#inp-cliente_id').on('select2:select', function(e) {
        var clienteId = e.params.data.id;
        $('#btn-buscar-pedido').attr('data-cliente-id', clienteId);
    });

    // Ao abrir o modal, busca os pedidos recentes do cliente selecionado
    $('#modal-pedido').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // botão que abriu o modal
        var clienteId = button.data('cliente-id'); // pega o cliente selecionado

        var modalBody = $(this).find('.modal-body');

        if (clienteId) {
            modalBody.html('<p>Carregando pedidos...</p>');

            $.ajax({
                url: `/nfe_remessa/clientes/${clienteId}/pedidos-recentes`,
                method: 'GET',
                success: function(pedidos) {
                    var html = '';

                    if (pedidos.length === 0) {
                        html = '<p>Não há pedidos recentes para este cliente.</p>';
                    } else {
                        pedidos.forEach(function(pedido) {
                            html += `
                                <div class="pedido-item mb-3">
                                    <strong>Pedido:</strong> ${pedido.numero_pedido} <br>
                                    <strong>Data:</strong> ${new Date(pedido.data_pedido).toLocaleDateString()} <br>
                                    <strong>Total:</strong> R$ ${Number(pedido.valor_total).toFixed(2)}
                                </div>
                                <hr>
                            `;
                        });
                    }

                    modalBody.html(html);
                },
                error: function() {
                    modalBody.html('<p>Erro ao carregar pedidos.</p>');
                }
            });
        } else {
            modalBody.html('<p>Selecione um cliente antes de buscar pedidos.</p>');
        }
    });
});
</script>



<script>
$(document).ready(function() {

    // Inicializa o Select2 do cliente
    $('#inp-cliente_id').select2({
        placeholder: 'Digite o Nome Fantasia, Razão, CPF ou CNPJ...',
       
        ajax: {
            url: '{{ route("nfe_remessa.buscar_clientes") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    termo: params.term,
                    empresa_id: '{{ request()->empresa_id }}'
                };
            },
            processResults: function (data) {
                return {
                    results: data.map(cliente => ({
                        id: cliente.idClientes,
                        text: cliente.nomeCliente + ' - ' + cliente.documento
                    }))
                };
            },
            cache: true
        },
        minimumInputLength: 2
    });

    // Quando selecionar um cliente, buscar pedidos recentes e abrir modal
    $('#inp-cliente_id').on('select2:select', function(e) {
        var clienteId = e.params.data.id;

        $('#modal-pedido .modal-body').html('<p>Carregando pedidos...</p>');
        $('#modal-pedido').modal('show');

        $.ajax({
            url: `/nfe_remessa/clientes/${clienteId}/pedidos-recentes`,
            method: 'GET',
            success: function(pedidos) {
                var html = '';

                if (pedidos.length === 0) {
                    html = '<p>Não há pedidos recentes para este cliente.</p>';
                } else {
                    pedidos.forEach(function(pedido) {
                        let itensHtml = '<ul style="list-style:none; padding-left:0;">';
                        pedido.itens.forEach(function(item) {
                            itensHtml += `
                                <div class="item-pedido" 
                                     style="cursor:pointer; margin-left: 1rem;"
                                     data-produto_id="${item.idProdutos}"
                                     data-id="${item.produtos_id}"
                                     data-nome="${item.descricao}"
                                     data-cfop="${item.cfop}"
                                     data-ncm="${item.ncm}"
                                     data-cst="${item.cst}"
                                     data-quantidade="${item.quantidade}"
                                     data-venda="${item.valor}">
                                    - ${item.descricao} (${item.quantidade} x R$ ${item.valor})
                                </div>
                            `;
                        });
                        itensHtml += '</ul>';

                        // Monta inputs hidden dos itens para enviar junto no form
                        let hiddenItensInputs = '';
                        pedido.itens.forEach(function(item) {
                            // Escapar aspas simples para evitar problema no HTML
                            const itemJson = JSON.stringify(item).replace(/'/g, "&#39;");
                            hiddenItensInputs += `
                                <input type="hidden" 
                                       name="itensPedido[${pedido.idVendas}][]" 
                                       value='${itemJson}'>
                            `;
                        });

                        html += `
                            <div class="form-check mb-2">
                                <input class="form-check-input pedido-checkbox" type="checkbox" 
                                       id="pedido-${pedido.idVendas}" 
                                       name="pedidosSelecionados[]" 
                                       value="${pedido.idVendas}">
                                <label class="form-check-label" for="pedido-${pedido.idVendas}">
                                    <strong>Pedido:</strong> ${pedido.idVendas} — 
                                    <strong>Data:</strong> ${new Date(pedido.dataVenda).toLocaleDateString()} — 
                                    <strong>Total:</strong> R$ ${Number(pedido.valorTotal).toFixed(2)}
                                </label>
                                <div class="ml-4 itens-pedido">${itensHtml}</div>
                                ${hiddenItensInputs}
                            </div>
                        `;
                    });
                }

                $('#modal-pedido .modal-body').html(html);

                // Adiciona clique nos itens para marcar/desmarcar checkbox do pedido
                $('.item-pedido').on('click', function() {
                    var pedidoDiv = $(this).closest('.form-check');
                    var checkbox = pedidoDiv.find('.pedido-checkbox');
                    checkbox.prop('checked', !checkbox.prop('checked'));
                });
            },
            error: function() {
                $('#modal-pedido .modal-body').html('<p>Erro ao carregar pedidos.</p>');
            }
        });

    });

});

</script>

<script>

let indiceProduto = 0;

$(document).on('change', '.pedido-checkbox', function () {
    if (this.checked) {
        const $itens = $(this).closest('.form-check').find('.item-pedido');

        $itens.each(function () {
            const item = $(this);

            const linha = `
<tr>
  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][produto_id]" class="form-control" style="min-width: 50px; height: 30px; font-size: 13px;" value="${item.data('id')}" readonly></td>
  <td><input type="text" name="produtos[${indiceProduto}][nome]" class="form-control" style="min-width: 300px; height: 30px; font-size: 13px;" value="${item.data('nome')}" readonly></td>
  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][quantidade]" class="form-control input-quantidade" style="height: 30px;width: 70px; font-size: 13px;" value="${item.data('quantidade')}"></td>
  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][valor_unitario]" class="form-control input-valor" style="height: 30px; font-size: 13px;" value="${item.data('venda')}"></td>
  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][subtotal]" class="form-control input-subtotal" style="height: 30px; font-size: 13px;" value="${(item.data('quantidade') * item.data('venda')).toFixed(2)}" readonly></td>

  <!-- Continue igual, substituindo todos os produtos[][campo] por produtos[${indiceProduto}][campo] -->
  <!-- Impostos -->
  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][icms_aliq]" class="form-control input-icms-aliq" style="height: 30px; font-size: 13px;" value="18.00"></td>
  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][icms_valor]" class="form-control input-icms-valor" style="height: 30px; font-size: 13px;" readonly></td>

  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][pis_aliq]" class="form-control input-pis-aliq" style="height: 30px; font-size: 13px;" value="1.65"></td>
  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][pis_valor]" class="form-control input-pis-valor" style="height: 30px; font-size: 13px;" readonly></td>

  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][cofins_aliq]" class="form-control input-cofins-aliq" style="height: 30px; font-size: 13px;" value="7.60"></td>
  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][cofins_valor]" class="form-control input-cofins-valor" style="height: 30px; font-size: 13px;" readonly></td>

  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][ipi_aliq]" class="form-control input-ipi-aliq" style="height: 30px; font-size: 13px;" value="5.00"></td>
  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][ipi_valor]" class="form-control input-ipi-valor" style="height: 30px; font-size: 13px;" readonly></td>

  <!-- demais campos -->
  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][red_bc]" class="form-control" style="height: 30px; font-size: 13px;"></td>
  <td><input type="text" name="produtos[${indiceProduto}][cfop]" class="form-control" style="height: 30px; font-size: 13px;" value="${item.data('cfop')}"></td>
  <td><input type="text" name="produtos[${indiceProduto}][ncm]" class="form-control" style="height: 30px; font-size: 13px;" value="${item.data('ncm')}"></td>
  <td><input type="text" name="produtos[${indiceProduto}][cest]" class="form-control" style="height: 30px; font-size: 13px;"></td>
  <td><input type="text" name="produtos[${indiceProduto}][modbcst]" class="form-control" style="height: 30px; font-size: 13px;"></td>

  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][vbc_icms]" class="form-control" style="height: 30px; font-size: 13px;"></td>
  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][vbc_pis]" class="form-control" style="height: 30px; font-size: 13px;"></td>
  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][vbc_cofins]" class="form-control" style="height: 30px; font-size: 13px;"></td>
  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][vbc_ipi]" class="form-control" style="height: 30px; font-size: 13px;"></td>

  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][vbcstret]" class="form-control" style="height: 30px; font-size: 13px;"></td>
  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][vfrete]" class="form-control" style="height: 30px; font-size: 13px;"></td>
  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][vbcst]" class="form-control" style="height: 30px; font-size: 13px;"></td>
  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][picmsst]" class="form-control" style="height: 30px; font-size: 13px;"></td>
  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][vicmsst]" class="form-control" style="height: 30px; font-size: 13px;"></td>
  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][pmvast]" class="form-control" style="height: 30px; font-size: 13px;"></td>

  <td><input type="number" step="0.01" name="produtos[${indiceProduto}][desconto]" class="form-control" style="height: 30px; font-size: 13px;"></td>
  <td><input type="text" name="produtos[${indiceProduto}][numero_item]" class="form-control" style="height: 30px; font-size: 13px;"></td>

  <!-- Selects CST -->
  <td>
    <select name="produtos[${indiceProduto}][cst_csosn]" class="form-control" style="height: 30px; font-size: 13px;">
      <option value="">Selecione..</option>
      <option value="101" selected>101 - Tributada com crédito</option>
      <option value="102">102 - Tributada sem crédito</option>
      <option value="103">103 - Isenção</option>
    </select>
  </td>

  <td>
    <select name="produtos[${indiceProduto}][cst_pis]" class="form-control" style="height: 30px; font-size: 13px;">
      <option value="">Selecione..</option>
      <option value="01" selected>01 - Alíquota Básica</option>
      <option value="02">02 - Alíquota Diferenciada</option>
      <option value="03">03 - Isenção</option>
    </select>
  </td>

  <td>
    <select name="produtos[${indiceProduto}][cst_cofins]" class="form-control" style="height: 30px; font-size: 13px;">
      <option value="">Selecione..</option>
      <option value="01" selected>01 - Alíquota Básica</option>
      <option value="02">02 - Alíquota Diferenciada</option>
      <option value="03">03 - Isenção</option>
    </select>
  </td>

  <td>
    <select name="produtos[${indiceProduto}][cst_ipi]" class="form-control" style="height: 30px; font-size: 13px;">
      <option value="">Selecione..</option>
      <option value="50" selected>50 - Saída Tributada</option>
      <option value="51">51 - Isenta</option>
      <option value="52">52 - Não Tributada</option>
    </select>
  </td>

  <td><button type="button" class="btn btn-danger btn-sm btn-remover">Remover</button></td>
</tr>
`;

            $('.table-produtos tbody').append(linha);
            calcularImpostos($('.table-produtos tbody tr').last());

            indiceProduto++; // incrementa o índice para o próximo produto
        });

        alert("Item(s) enviado com sucesso!");
    }
});

// Remover linha
$(document).on('click', '.btn-remover', function () {
    $(this).closest('tr').remove();
    
    atualizarTotalProdutos();
});

//$('.table-produtos tbody').empty(); // remove só as linhas, mantendo o cabeçalho
   // const $itens = $(this).closest('.form-check').find('.item-pedido');
            

// Recalcular impostos ao alterar os campos
$(document).on('input', '.input-quantidade, .input-valor, .input-icms-aliq, .input-pis-aliq, .input-cofins-aliq, .input-ipi-aliq', function () {
    const row = $(this).closest('tr');
    calcularImpostos(row);
});



// Atualiza subtotal, impostos e total geral
function calcularImpostos(row) {
    const qtd = parseFloat(row.find('.input-quantidade').val()) || 0;
    const valorUnit = parseFloat(row.find('.input-valor').val()) || 0;
    const subtotal = qtd * valorUnit;
    row.find('.input-subtotal').val(subtotal.toFixed(2));

    const icmsAliq = parseFloat(row.find('.input-icms-aliq').val()) || 0;
    const pisAliq = parseFloat(row.find('.input-pis-aliq').val()) || 0;
    const cofinsAliq = parseFloat(row.find('.input-cofins-aliq').val()) || 0;
    const ipiAliq = parseFloat(row.find('.input-ipi-aliq').val()) || 0;

    row.find('.input-icms-valor').val((subtotal * icmsAliq / 100).toFixed(2));
    row.find('.input-pis-valor').val((subtotal * pisAliq / 100).toFixed(2));
    row.find('.input-cofins-valor').val((subtotal * cofinsAliq / 100).toFixed(2));
    row.find('.input-ipi-valor').val((subtotal * ipiAliq / 100).toFixed(2));

    atualizarTotalProdutos();
}

function atualizarTotalProdutos() {
    let subtotal = 0;

    $('.input-subtotal').each(function () {
        subtotal += parseFloat($(this).val()) || 0;
    });

    const subtotalFormatado = subtotal.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    $('.total_prod').text(subtotalFormatado);

    const desconto = parseFloat($('.desconto').val()) || 0;
    const acrescimo = parseFloat($('.acrescimo').val()) || 0;

    let total = subtotal;
    if (desconto > 0 && acrescimo === 0) {
        total = subtotal - desconto;
    } else if (acrescimo > 0 && desconto === 0) {
        total = subtotal + acrescimo;
    }

    if (total < 0) total = 0;

    const totalFormatado = total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    $('.total-venda').text(totalFormatado);
    $('.total-geral').val(total.toFixed(2));
}

// Eventos de atualização do total
$(document).on('input', '.desconto, .acrescimo', atualizarTotalProdutos);
$(document).on('input', '.input-subtotal', atualizarTotalProdutos);



</script>



@endsection
@include('modals._pedido', ['not_submit' => true])

@include('modals._produto', ['not_submit' => true])
@include('modals._client', ['not_submit' => true])
@include('modals._transportadora', ['not_submit' => true])
@include('modals._pagamento_personalizado', ['not_submit' => true])

@endsection
