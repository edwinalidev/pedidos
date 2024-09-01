const txtFecha = document.getElementById("txtFecha1");
const txtFecha2 = document.getElementById("txtFecha2");
const txtidPedido = document.getElementById("idPedido");

let oDetalle  = [];
let DataItems = [];
let oDetalleFiltrado=[];
function editPedido(idPedido,estado) {
  if (estado!=1){
    Swal.fire('El pedido esta recibido');
    return false;
  }
  fetch(`../Api/v1/getPedido.php?idPedido=${idPedido}`)
    .then(response => response.json())
    .then(data => {
      txtFecha.value = data[0].fecha;
      txtFecha2.value = data[0].fecha2;
      txtidPedido.value = data[0].idPedido;
      oDetalle = data[0].Detalle;
      getDetalleItems();
    });

  urlClick(2);
}

function urlClick(n) {
  let secciones = document.getElementsByClassName('secciones');

  for (let i = 0; i < secciones.length; i++) {
    secciones[i].classList.remove('active');
  }
  switch (n) {
      case 1:
      secciones = document.getElementById('frmHome');
      break;
      case 2:
        secciones = document.getElementById('frmPedido');
        break;
      case 3:
      secciones = document.getElementById('frmPerfil');
      break;
      case 5:
        window.location.href = '../admin/';
        break;
    default:
      window.location.href = '../template/cerrarSesion.php';
    return false;
  }

  secciones.classList.add('active');
}

function writePedidos(data) {
  const items = data;
  const tableBody = document.getElementById('tblPedidosBody');
  tableBody.innerHTML = '';

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
                      <button class="btn btn-danger" onclick="delPedido(${items[i].idPedido})">
                        <i class="bi bi-trash-fill"></i>
                      </button>
                      <button class="btn btn-primary" onclick="editPedido(${items[i].idPedido},${items[i].estado})">
                        <i class="bi bi-pencil-square"></i>
                      </button>
                      <button class="btn btn-secondary" onclick="editPedido(${items[i].idPedido})">
                        <i class="bi bi-printer"></i>
                    </button>
                    </td>
                </tr>`;

    tableBody.innerHTML += row;
  }
}
function getEstadoPedido(estado) {
  if(estado==1){
  return '<span class="badge bg-primary">Enviado</span>'                    
  }else if(estado==2){
    return '<span class="badge bg-success">Recibido</span>'                    
  }else{
    return '<span class="badge bg-secondary">Finalizado</span>' 
  }
}

function delPedido(idPedido) {
  Swal.fire({
    title: '¿Est&#225;s seguro de eliminar el pedido?',
    text: 'Esta accion no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Si, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('../Api/v1/pedidos.php', {
          method: 'DELETE',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `idPedido=${idPedido}`
        })
        .then(response => response.json())
        .then(data => {
          if (!data.success) {
            Swal.fire(data.message);
          }
          writePedidos(data.data);
        });
    }
  });
}

const formListaItems = document.getElementById("formListaItems");
const form = document.getElementById('itemForm');

function addItem(idItem, Detalle, Precio, e,unidad) {
  let lb = true;

  oDetalle.forEach(item => {
    if (item.idItem === idItem) {
      item.Cantidad += 1;
      lb = false;
    }
  });

  if (lb) {
    const newItem = {
      idItem: idItem,
      Detalle: Detalle,
      Precio: Precio,
      Cantidad: 1,
      Unidad:unidad
    };
    oDetalle.push(newItem);
  }

  getDetalleItems();
  formItemsSalir();
}
function abrirItemsShow(){
    formListaItems.showModal();
}

function formItemsSalir(){
    formListaItems.close();
}

function vistaItems(Items){
  const tableVista=document.getElementById('tableVistaItems');
  tableVista.innerHTML='';
  for (let i = 0; i < Items.length; i++) {
    const row = `<tr class="rowItem">
                    <td>${Items[i].Cantidad}</td>
                    <td>${Items[i].Detalle}</td>
                    <td>${Items[i].Unidad}
                    </td>
                </tr>`;
    tableVista.innerHTML += row;
   }
}
function writeTbItems(data) {
  const items = data;
  const tableBody = document.getElementById('itemTableBody');
  tableBody.innerHTML = '';
  for (let i = 0; i < items.length; i++) {
    const row = `<tr class="rowItem">
                    <td>${items[i].Detalle}</td>
                    <td>${items[i].precio}</td>
                    <td>
                      <button class="btn btn-success" onclick="addItem(${items[i].idItem}, '${items[i].Detalle}', ${items[i].precio}, this,'${items[i].Detalle}');">
                        <i class="bi bi-plus-circle-fill"></i>
                      </button>
                    </td>
                </tr>`;

    tableBody.innerHTML += row;

    if (oDetalle.some(detalle => detalle.idItem === items[i].idItem)) {
      tableBody.lastChild.classList.add('Selected-item');
    }
  }
}
function btnVistaSalir() {
  formVista.close();
}
function btnVistaEnviar() {
  enviarServidor();
  enviarImagen();
  formVista.close();
  frmPedidoClose();
}
function enviarDatos() {
     oDetalleFiltrado = oDetalle.filter(function(item) {
      return item.Cantidad > 0;
  });
    if (oDetalleFiltrado.length === 0) {
      Swal.fire({
        title: "El detalle está vacío.",
        text: "El pedido no tiene cantidades.",
        icon: "info"
      });
      return false;
    }
    //vista previa de detalle
   vistaItems(oDetalleFiltrado);
   formVista.showModal();
  }
function enviarServidor() {
  const dFecha2 = document.getElementById("txtFecha2").value;
  const dFecha1 = document.getElementById("txtFecha1").value;
  const nTotal = document.getElementById("txtTotal").value;
  const nPedido = document.getElementById("idPedido").value;
  const cGlosa = document.getElementById("txtGlosa").value; 
    const jsonData = {
      pedidos: {
        idPedido: nPedido,
        fecha: dFecha1,
        monto: nTotal,
        estado: 1,
        glosa:cGlosa,
        fecha2: dFecha2,
        Detalles: oDetalleFiltrado
      }
    };
  
    const apiUrl = '../Api/v1/insertPedido.php';
    const requestOptions = {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(jsonData)
    };
  
    fetch(apiUrl, requestOptions)
      .then(response => response.json())
      .then(data => {
//        console.log(data);
        writePedidos(data.data);
        frmPedidoClose();
      })
      .catch(error => {
        console.error('Error al realizar la solicitud:', error);
      });
}
function frmPedidoClose() {
    oDetalle=[];
    oDetalleFiltrado=[];
    setDetalle(DataItems);
    document.getElementById("idPedido").value = 0;
    getDetalleItems();
    urlClick(1);
}
function getDetalleCantidad(id,nCantidad){
    const itemEncontrado = oDetalle.find(item => item.idItem === id);
    if (itemEncontrado) {
      itemEncontrado.Cantidad = nCantidad;
      getDetalleItems();  // Llamar a la función para actualizar la vista
    }
}
function getPedidos() {
    fetch('../Api/v1/pedidos.php')
      .then(response => response.json())
      .then(data => {
        writePedidos(data);
      });
} 
/* LOS DATOS A DETALLE  */
function getDetalleItems() {
  const items = oDetalle;
  let nSumaTotal = 0;
  let subTotal = 0;
  const tableBody = document.getElementById('DetalleItemsBody');

  tableBody.innerHTML = '';
  const nLen = items.length;

  for (let i = 0; i < nLen; i++) {
    subTotal = items[i].Cantidad * items[i].Precio;
    nSumaTotal = nSumaTotal + subTotal;

    const row = `<tr>
                    <td class="col-7" >${items[i].Detalle}</td>
                    <td class="col-1"><input type="number" onchange="getDetalleCantidad(${items[i].idItem}, this.value)" class="form-control" max="100" min="0" value="${items[i].Cantidad}" ></td>
                    <td class="text-end">${subTotal.toFixed(2)}</td>
                    <td class="text-end"><button class="btn btn-danger " onclick="delItem(${items[i].idItem})"><i class="bi bi-trash-fill"></i></button></td>
                </tr>`;

    tableBody.innerHTML += row;
  }

  writeTbItems(DataItems);

  const txtTotal = document.getElementById('txtTotal');
  txtTotal.value = nSumaTotal.toFixed(2);
}
function getItems() {
  fetch('../Api/v1/items.php')
    .then(response => response.json())
    .then(data => {
      DataItems=data;
      writeTbItems(data);
      setDetalle(data);
      getDetalleItems();
      });
}
function setDetalle(data){
  data.forEach(item =>{
    if(item.favorito==1){
      const newItem = {
        idItem: item.idItem,
        Detalle: item.Detalle,
        Precio: item.precio,
        Cantidad: 0,
        Unidad: item.unidad
      };
      oDetalle.push(newItem);
    }});
}
function getPerfil() {
  fetch('../Api/v1/getPerfil.php')
  .then(response => response.json())
  .then(data => {
      const Usuario = document.getElementById("Usuario");
      const Phone = document.getElementById("Phone");
      const Email = document.getElementById("Email");

      data.forEach(user => {
        Usuario.value = user.usuario;
        Phone.value = user.phone;
        Email.value = user.email;
      });
    });
}
function delItem(id) {
  oDetalle = oDetalle.filter(item => item.idItem !== id);
  getDetalleItems();
}

function filterItems() {
  const filterText = document.getElementById('filterInput').value.toLowerCase();
  const tableRows = document.getElementById('itemTableBody').getElementsByTagName('tr');

  for (let i = 0; i < tableRows.length; i++) {
    const detailColumn = tableRows[i].getElementsByTagName('td')[0];

    if (detailColumn) {
      const detailText = detailColumn.textContent || detailColumn.innerText;
      tableRows[i].style.display = (detailText.toLowerCase().indexOf(filterText) > -1) ? '' : 'none';
    }
  }
}
document.getElementById('formPerfil').addEventListener('submit', function(event) {
  event.preventDefault(); 
  const formData = new FormData(event.target);
  fetch('../Api/v1/getPerfil.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.json())
  .then(data => {
    if(data.status =='success'){
      msgShow(data.message,1);
      
    }else{
      msgShow(data.message,2);
    }
  })
  .catch(error => {
      console.error('Error:', error);
  });
});
function msgShow(message,tipoIcon) {  
  if(tipoIcon==1){
    icono='success';
  }else if(tipoIcon==2){
    icono='error';
  }else if(tipoIcon==3){
    icono='warning';
  }else if(tipoIcon==4){
    icono='question';
  }
  else{
    icono='info';
  }

  Swal.fire({
    title: message,
    text: "",
    icon: icono
  });
}
function enviarImagen() {
  var contenidoDiv = document.getElementById('tableVista');
  html2canvas(contenidoDiv, {
      background: '#FFFFFF',
      onrendered: function(canvas) {
          var img = canvas.toDataURL('image/png');
          canvas.toBlob(blob => {
            // Crear un archivo con el blob
            const files = [new File([blob], 'image.png', { type: blob.type })];
            if (navigator.share) {
              // Compartir la imagen usando la API de Web Share
                    navigator.share({
                    title: 'Pedidos Online',
                     text: 'Detalle de Pedido',
                      files,
                   })
                  .then(() => console.log('Imagen compartida exitosamente.'))
                  .catch((error) => console.error('Error al compartir la imagen:', error));
                  } else {
              // El navegador no admite la API de Web Share
                  alert('Tu navegador no admite la función de compartir.');
                  }
          });
 
      }
  });
}
document.addEventListener('DOMContentLoaded', function () {
  getItems();
  getDetalleItems();
  getPedidos();
  getPerfil();
  const dFecha = new Date().toISOString().split('T')[0];
  txtFecha.value = dFecha;
  txtFecha2.value = dFecha;

  window.addEventListener('click', function (event) {
    const dialog = document.getElementById('formListaItems');
    if (event.target === dialog) {
      formListaItems.close();
    }
  });
});
