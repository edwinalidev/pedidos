function getPedidos() {
  fetch("../Api/v1/pedidos.php")
    .then((response) => response.json())
    .then((data) => {
      writePedidos(data);
    });
}
function writePedidos(data) {
  const items = data;
  const tableBody = document.getElementById("tblPedidosBody");
  tableBody.innerHTML = "";

  for (let i = 0; i < items.length; i++) {
    const row = `<tr>
                      <td>${items[i].fecha}</td>
                      <td>${items[i].usuario}</td>
                      <td>${items[i].fecha2}</td>
                      <td class="text-end">${items[i].monto.toFixed(2)}</td>
                      <td>
                      ${getEstadoPedido(items[i].estado)}
                      </td>
                      <td>
                        <button class="btn btn-danger" onclick="delPedido(${
                          items[i].idPedido
                        })">
                          <i class="bi bi-trash-fill"></i>
                        </button>
                        <button class="btn btn-primary" onclick="editPedido(${
                          items[i].idPedido
                        },${items[i].estado})">
                          <i class="bi bi-pencil-square"></i>
                        </button>
                        <button type="button" class="shadow-sm btn btn-success rounded-pill mb-2" data-bs-toggle="modal" data-bs-target="#modComprobante" >
                        <i class="bi bi-printer"></i>
                        </button>
                        <button class="btn btn-secondary"  onclick="editPedido(${
                          items[i].idPedido
                        })">
                          <i class="bi bi-printer"></i>
                      </button>
                      </td>
                  </tr>`;

    tableBody.innerHTML += row;
  }
}
function getEstadoPedido(estado) {
  if (estado == 1) {
    return '<span class="badge bg-primary">Enviado</span>';
  } else if (estado == 2) {
    return '<span class="badge bg-success">Recibido</span>';
  } else {
    return '<span class="badge bg-secondary">Finalizado</span>';
  }
}
document.addEventListener("DOMContentLoaded", function () {
  //    getDetalleItems();
  getPedidos();
});
function getDataPedido(idPedido) {
  fetch(`../Api/v1/getPedido.php?idPedido=${idPedido}`)
    .then((response) => response.json())
    .then((data) => {
      txtFecha.value = data[0].fecha;
      txtFecha2.value = data[0].fecha2;
      txtidPedido.value = data[0].idPedido;
      oDetalle = data[0].Detalle;
      getDetalleItems();
    });
}
