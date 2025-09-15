<!-- Modal Finalizar Venda -->
<div class="modal fade" id="modal-finalizar_venda" aria-modal="true" role="dialog" style="overflow:scroll;" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">** Finalizar Venda **</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <!-- Recebimento -->
                <div class="mb-3">
                    <strong>Valor total: R$ <span id="total_venda">0,00</span></strong>
                    <div>Pago: R$ <span id="total_pago">0,00</span></div>
                </div>

                <div id="pagamentos_container">
                    <div class="row g-2 align-items-end pagamento_item">
                        <div class="col-md-5">
                            <label class="form-label small">Forma</label>
                            <select class="form-select tipo_pagamento" name="tipo_pagamento[]">
                                <option value="dinheiro">Dinheiro</option>
                                <option value="debito">Cartão Débito</option>
                                <option value="credito">Cartão Crédito</option>
                                <option value="pix">PIX</option>
                                <option value="boleto">Boleto</option>
                            </select>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label small">Valor</label>
                            <input type="text" class="form-control valor_pagamento" name="valor_pagamento[]" value="0,00">
                        </div>

                        <div class="col-md-2 d-grid gap-1">
                             <button type="button" class="btn btn-success btn-receber">Receber</button>
                            <button type="button" class="btn btn-outline-primary btn-add">+</button>
                            <button type="button" class="btn btn-outline-danger btn-remove d-none">&times;</button>
                        </div>
                    </div>
                </div>

                <div class="text-danger" id="erro_pagamento" style="display:none;"></div>

                <!-- Botões de finalização -->
                <div class="row mt-3">
                    @if ($usuario->somente_fiscal == 1)
                    <div class="col-6 mb-2">
                        <button @if($config->arquivo == null) disabled @endif 
                                class="btn btn-success w-100" 
                                type="button" data-bs-toggle="modal" data-bs-target="#modal-cpf_nota">
                            <i class="bx bx-file"></i> CUPOM FISCAL
                            @if ($config->arquivo == null)
                                <br><h6 class="text-danger">Sem certificado</h6>
                            @endif
                            @if ($atalhos != null && $atalhos->finalizar_fiscal != '')
                                <br><h6 class="text-white">{{ $atalhos->finalizar_fiscal }}</h6>
                            @endif
                        </button>
                    </div>
                    @endif
                    <div class="col-6 mb-2">
                        <button type="button" class="btn btn-info w-100" id="btn_nao_fiscal">
                            <i class="bx bx-file-blank"></i> CONTINGÊNCIA
                            @if ($atalhos != null && $atalhos->finalizar_nao_fiscal != '')
                                <br><b class="text-white">{{ $atalhos->finalizar_nao_fiscal }}</b>
                            @endif
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Template para novos pagamentos -->
<template id="pagamento-template">
    <div class="row g-2 align-items-end pagamento_item">
        <div class="col-md-5">
            <label class="form-label small">Forma</label>
            <select class="form-select tipo_pagamento" name="tipo_pagamento[]">
                <option value="dinheiro">Dinheiro</option>
                <option value="debito">Cartão Débito</option>
                <option value="credito">Cartão Crédito</option>
                <option value="pix">PIX</option>
                <option value="boleto">Boleto</option>
            </select>
        </div>

        <div class="col-md-5">
            <label class="form-label small">Valor</label>
            <input type="text" class="form-control valor_pagamento" name="valor_pagamento[]" value="">
        </div>

        <div class="col-md-2 d-grid gap-1">
            <!-- Botão Receber -->
            <button type="button" class="btn btn-success btn-receber">Receber</button>

            <!-- Botões de adicionar/remover -->
            
            <button type="button" class="btn btn-outline-primary btn-add">+</button>
            <button type="button" class="btn btn-outline-danger btn-remove d-none">&times;</button>
        </div>
    </div>
</template>


<script>
(function(){
    function parseBr(value){
        // Converte "1.234,56" em float 1234.56
        return parseFloat(value.replace(/\./g, '').replace(',', '.')) || 0;
    }

    function formatBr(value){
        // Converte 1234.56 em "1.234,56"
        return value.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }

    const container = document.getElementById('pagamentos_container');
    const template = document.getElementById('pagamento-template').content;
    const totalVendaEl = document.getElementById('total_venda');
    const totalPagoEl = document.getElementById('total_pago');
    const erroBox = document.getElementById('erro_pagamento');

    let totalVenda = 0;

    const modalEl = document.getElementById('modal-finalizar_venda');
    modalEl.addEventListener('show.bs.modal', function(){
        const valorTelaEl = document.querySelector('.total-venda');
        totalVenda = parseBr(valorTelaEl ? valorTelaEl.innerText : '0,00');

        if(totalVendaEl) totalVendaEl.innerText = formatBr(totalVenda);

        // Preenche o primeiro input do pagamento
        const firstInput = container.querySelector('.valor_pagamento');
        if(firstInput) firstInput.value = formatBr(totalVenda);

        atualizarInterface();
        toggleRemoveButtons();
    });

    function sumPagamentos(){
        return Array.from(container.querySelectorAll('.valor_pagamento'))
                    .reduce((acc, el) => acc + parseBr(el.value), 0);
    }

    function atualizarInterface(){
        const soma = sumPagamentos();
        if(totalPagoEl) totalPagoEl.innerText = formatBr(soma);
    }

    function toggleRemoveButtons(){
        const itens = container.querySelectorAll('.pagamento_item');
        itens.forEach(it => {
            const btnRemove = it.querySelector('.btn-remove');
            if(btnRemove) btnRemove.classList.toggle('d-none', itens.length <= 1);
        });
    }

    // EVENTOS DOS BOTOES DENTRO DO CONTAINER
    container.addEventListener('click', function(e){
        // Botão +
        if(e.target.classList.contains('btn-add')){
            const totalPagoAtual = sumPagamentos();
            const restante = Math.max(totalVenda - totalPagoAtual, 0);

            const clone = document.importNode(template, true);
            clone.querySelector('.valor_pagamento').value = formatBr(restante);
            container.appendChild(clone);

            toggleRemoveButtons();
            atualizarInterface();
        }

        // Botão remove
        if(e.target.classList.contains('btn-remove')){
            e.target.closest('.pagamento_item').remove();
            toggleRemoveButtons();
            atualizarInterface();
        }

        // Botão Receber
        if(e.target.classList.contains('btn-receber')){
            const input = e.target.closest('.pagamento_item').querySelector('.valor_pagamento');
            const totalPagoAtual = sumPagamentos();
            const restante = Math.max(totalVenda - (totalPagoAtual - parseBr(input.value)), 0);
            input.value = formatBr(restante);
            atualizarInterface();
        }
    });

    // Atualiza total pago ao digitar manualmente
    container.addEventListener('input', function(e){
        if(e.target.classList.contains('valor_pagamento')){
            atualizarInterface();
        }
    });

})();
</script>



