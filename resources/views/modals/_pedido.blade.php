<!-- Modal -->
<div class="modal fade" id="modal-pedido" tabindex="-1" aria-labelledby="modalPedidoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalPedidoLabel">Selecione o Pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>

      <div class="modal-body">
        <form id="form-pedido">
          <div class="row g-3">
            <div class="col-md-4">
              <label for="numeroPedido" class="form-label">Número do Pedido</label>
              <input type="text" class="form-control" id="numeroPedido" name="numeroPedido" placeholder="Ex: 12345" required>
            </div>

            <div class="col-md-4">
              <label for="dataPedido" class="form-label">Data</label>
              <input type="date" class="form-control" id="dataPedido" name="dataPedido" required>
            </div>

            <div class="col-md-4">
              <label for="clientePedido" class="form-label">Cliente</label>
              <input type="text" class="form-control" id="clientePedido" name="clientePedido" placeholder="Nome do cliente" required>
            </div>
          </div>

          <hr>
          <h5>Pedidos Recentes</h5>
          <ul id="listaPedidosRecentes" class="list-group mb-3">
            <li class="list-group-item">Carregando...</li>
          </ul>

          <input class="form-check-input pedido-checkbox" type="checkbox" 
                 id="pedido-${pedido.idVendas}" 
                 name="pedidosSelecionados[]" 
                 value="${pedido.idVendas}"
                 onchange="carregarItensDoPedido(${pedido.idVendas}, this)">
          <div id="itens-pedido-${pedido.idVendas}" class="ml-4"></div>

          <h5>Itens do Pedido</h5>
          <table class="table table-sm table-bordered">
            <thead>
              <tr>
                <th>ID Produto</th>
                <th>Quantidade</th>
                <th>Valor</th>
              </tr>
            </thead>
            <tbody id="tabela-itens-pedido">
              <tr><td colspan="3" class="text-center">Nenhum item carregado.</td></tr>
            </tbody>
          </table>
        </form>
      </div>

      <!-- Toast -->
      <div id="toastMessage" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; bottom: 20px; right: 20px; display: none;">
        <div class="d-flex">
          <div class="toast-body">
            NFe enviada com sucesso!
          </div>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar...</button>
      </div>

    </div>
  </div>
</div>

<script>
  function carregarItensDoPedido(pedidoId, checkbox) {
    const tabela = document.getElementById('tabela-itens-pedido');
    const toastMessage = document.getElementById('toastMessage');

    if (checkbox.checked) {
        tabela.innerHTML = '<tr><td colspan="3">Carregando itens...</td></tr>';

        fetch(`/nfe_remessa/pedidos/${pedidoId}/itens`)
            .then(response => response.json())
            .then(itens => {
                if (itens.length === 0) {
                    tabela.innerHTML = '<tr><td colspan="3" class="text-center">Este pedido não possui itens.</td></tr>';
                } else {
                    let html = '';
                    itens.forEach(item => {
                        html += `
                            <tr>
                                <td>${item.produtos_id}</td>
                                <td>${item.quantidade}</td>
                                <td>R$ ${Number(item.valor).toFixed(2)}</td>
                            </tr>
                        `;
                    });
                    tabela.innerHTML = html;
                }

                // Exibir o Toast
                var toast = new bootstrap.Toast(toastMessage);
                toast.show(); // Exibir o Toast
            })
            .catch(() => {
                tabela.innerHTML = '<tr><td colspan="3" class="text-danger">Erro ao carregar itens.</td></tr>';
            });
    } else {
        tabela.innerHTML = '<tr><td colspan="3" class="text-center">Nenhum item carregado.</td></tr>';
    }
  }
</script>

