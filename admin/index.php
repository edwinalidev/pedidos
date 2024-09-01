<?php
include "template/header.php";
?>
<link rel="stylesheet" href="admin.css">


<body>
<div class="container mt-3 secciones active " id="frmHome">
    <div class="card border-secondary" style="height: 90vh;">
        <div class="card-header text-center">
            <h8 class="card-title">LISTA DE PEDIDOS</h8>
        </div>
        <div class="card-body p-2 overflow-auto">
        <button type="button"  class="btn btn-success rounded-pill"><i class="bi bi-plus-circle-fill"></i> Nuevo Pedido</button>
    <table class="table mt-2 table-hover table-sm table-bordered table-responsive">
            <thead class="table-secondary" >
            <tr>
                <th class="col-1 col-md-2">FECHA</th>
                <th class="col-2 col-md-4">CLIENTE</th>
                <th class="col-2 col-md-2">ENTREGA</th>
                <th class="text-center col-1 col-md-1">TOTAL</th>
                <th class="col-1 col-md-1">ESTADO</th>
                <th class="col-2"></th>
            </tr>
            </thead>
            <tbody id="tblPedidosBody">
            </tbody>
        </table>
    </div>
</div>
</div>
<div class="container secciones mt-5" id="formAdminItems">
    <h4 class="mb-4">Administracion Items</h4>
<div class=" mb-3">
    <label for="filterInput" class="form-label small m-0">Buscar</label>
    <input type="text" class="form-control" id="filterInput" oninput="filterItems()" placeholder="Ingrese el detalle...">
</div>
<div class="">
    <button type="button" class="btn btn-success rounded-pill" onclick="NuevoItem()" ><i class="bi bi-plus-circle-fill m-2"></i>Adicionar</button>
</div>
<!-- Formulario para agregar/editar elementos -->


<!-- Tabla para mostrar los elementos -->
<div style="overflow-x: auto;">
<table class="table mt-4 table-hover">
    <thead>
    <tr>
        <th>Detalle</th>
        <th>Unidad</th>
        <th>Precio</th>
        <th>Orden</th>
        <th>Categoría</th>
        <th>Favorito</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody id="itemTableBody">
    <!-- Aquí se mostrarán los datos de la tabla -->
    </tbody>
</table>
</div>
</div>
<!-- Modificar Item -->
<div class="modal fade" id="ModalItem"  tabindex="-1" aria-labelledby="items" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ADICIONAR O MODIFICAR ITEM</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form id="itemForm" class="form-group" >
            <div class="row">
                <label for="selectCategory">Seleccionar Categoría</label>
                <div class="input-group mb-3 col col-md-12 col-12">
                    <select class="form-select" id="selectCategory" name="selectCategory" aria-label="Categoría">
                    </select>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Category">
                        <button type="button" onclick="addCategory();" class="btn btn-success"><i class="bi bi-plus-circle-fill"></i></button>
                        <button type="button" onclick="editCategory();" class="btn btn-warning"><i class="bi bi-pencil-fill"></i></button>
                        <button type="button" onclick="delCategory();" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                    </div>
                </div>

            </div>
              <div class="row">
                  <div class="col col-md-12 col-12">
                      <div class="mb-3">
                          <label for="detalle" class="form-label small m-0">Detalle:</label>
                          <input type="text" class="form-control" id="detalle" name="detalle" required>
                        </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-12 col-md-6 mb-3">
                <label for="precio" class="form-label small m-0">Precio:</label>
                <input type="number" class="form-control" id="precio" name="precio" required>
            </div>
            <div class="form-group mb-3 col col-md-3 col-6">
                <label for="unidad" class="form-label small m-0">Unidad</label>
                <input type="text" class="form-control" id="unidad" name="unidad" required>
            </div>
            <div class="form-check form-switch mt-4 col col-md-3 col-6">
                <label class="form-check-label" for="favorito">Favorito</label>
                <input class="form-check-input" name="favorito" type="checkbox" id="favorito" checked>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-12">
              <div class="form-group mb-3">
                  <label for="orden" class="form-label">Orden del item</label>
                  <input type="range" class="form-range" min="0"  name="orden" max="100" step="1" id="orden">
              </div>
            </div>
        </div>
        <input type="hidden" id="idItem" name="idItem">
    </div>
      <div class="modal-footer">
        <button  type="submit" class="btn btn-success rounded-pill " ><i class="bi bi-floppy"></i> Guardar</button>
        <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal" ><i class="bi bi-x-circle"></i> Cancelar</button>
      </div>
    </form>
    </div>
  </div>
</div>
<div class="modal fade" id="modCategory" tabindex="-1" aria-labelledby="category" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <div class="modal-header bg-secondary text-white ">
        <h5 class="modal-title" id="titleCategory">Modificar Categor&iacute;a</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
          <!-- Aquí puedes colocar los campos para modificar los detalles del producto -->
          <form id="formCategory">
              <div class="mb-6">
                  <label for="Category" class="form-label">Categor&iacute;a</label>
                  <input type="text" class="form-control" id="catDetalle" name="catDetalle" required>
              </div>
                <input type="hidden" name="idCategory"  id="idCategory">
                <input type="hidden" name="catOrden"  id="catOrden">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success rounded-pill"><i class="bi bi-floppy"></i> Guardar</button>
          <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Cancelar</button>
        </div>
        </form>
      </div>
    </div>
  </div>

<div class="container secciones mt-5" style="overflow-x:auto" id="formUsuarios">
<div>
<h4 class="mb-4">Tabla de Usuarios</h4>
    <button class="btn btn-success rounded-pill mb-2" onclick="addUser();"><i class="bi bi-person-add m-2"></i>Nuevo usuario</button>
    <table class="table table-bordered table-responsive table-hover" id="userTable">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Teléfono</th>
                <th>Sucursal</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Los datos de la tabla se cargarán aquí dinámicamente -->
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col col-md-6 col-12">
        <button type="button" class="shadow-sm btn btn-success rounded-pill mb-2" data-bs-toggle="modal" data-bs-target="#modSucursal" onclick="addSucursal();" >Nueva Sucursal</button>
        <table class="table table-striped table-bordered table-hover" id="tableSucursales">
            <thead>
                <th>
                    Id
                </th>
                <th>
                    Sucursal
                </th>
                <th>
                    Acciones
                </th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="col col-md-6 col-12">
    <button type="button" class="shadow-sm btn btn-success rounded-pill mb-2" data-bs-toggle="modal" data-bs-target="#modCargo" onclick="addCargo();" >Nuevo cargo</button>
    <table class="table table-striped table-bordered table-hover" id="tableCargos">
            <thead>
                <th>
                    Id
                </th>
                <th>
                    Cargos
                </th>
                <th>
                    Acciones
                </th>
            </thead>
            <tbody id="tbodyCargos">
            </tbody>
        </table>
    </div>
</div>
</div>
<div class="modal fade" id="modSucursal" tabindex="-1" aria-labelledby="Modal Sucursal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header ">
        <h5 class="modal-title" id="modTitleSucursal">Nueva Sucursal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="formSucursal">
        <input type="hidden" id="idSucursal" name="idSucursal" value="-1">
        <div class="mb-3">
          <label for="sucDetalle" class="form-label">Detalle Sucursal:</label>
          <input type="text" class="form-control" id="sucDetalle" name="sucDetalle" required>
        </div>
      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-success rounded-pill">Guardar Cambios</button>
          <button type="reset" class="btn btn-danger rounded-pill" data-bs-dismiss="modal">Salir</button>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="modCargo" tabindex="-1" aria-labelledby="Modal Cargo" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header ">
        <h5 class="modal-title" id="modTitleCargo">Nuevo Cargo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formCargo">
        <input type="hidden" id="idCargo" name="idCargo">
        <div class="mb-3">
          <label for="carDetalle" class="form-label">Detalle Cargo:</label>
          <input type="text" class="form-control" id="carDetalle" name="carDetalle" required>
        </div>
      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-success rounded-pill" >Guardar Cambios</button>
          <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal">Salir</button>
      </div>
    </form>
    </div>
  </div>
</div>
<div class="modal fade" id="modComprobante" tabindex="-1" aria-labelledby="Modal Comprobante" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header ">
        <h5 class="modal-title" id="modTitleCargo">Comprobante</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="idPedido" name="idPedido">
        <table>
            <thead>
                <th>Detalle</th>
                <th>Cantidad</th>
                <th>Unidad</th>
            </thead>
            <tbody>

            </tbody>
        </table>
        <div class="mb-3">
          <label for="carDetalle" class="form-label">Detalle Cargo:</label>
          <input type="text" class="form-control" id="carDetalle" name="carDetalle" required>
        </div>
      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-success rounded-pill" >Recibir Pedido</button>
          <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>
<script src="../js/category.js"></script>
<script src="pedidos.js"></script>
<script>
var cursorItems=[];
var favDialog = document.getElementById("formularioItem");
var form = document.getElementById('itemForm');

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
        secciones = document.getElementById('formAdminItems');
        break;
      case 3:
      secciones = document.getElementById('formUsuarios');
      break;
    default:
      window.location.href = '../pedidos/pedidos.php';
    return false;
  }
  secciones.classList.add('active');
}
// Función para obtener y mostrar los elementos en la tabla
function getItems() {
    fetch('../Api/v1/items.php')
        .then(response => response.json())
        .then(data => {
            cursorItems = data;
            var tableBody = document.getElementById('itemTableBody');
            tableBody.innerHTML = '';
            for (var i = 0; i < cursorItems.length; i++) {
                var row = '<tr >';
                row += '<td>' + cursorItems[i].Detalle + '</td>';
                row += '<td>' + cursorItems[i].unidad + '</td>';
                row += '<td>' + cursorItems[i].precio + '</td>';
                row += '<td>' + cursorItems[i].orden + '</td>';
                row += '<td>' + cursorItems[i].Categoria + '</td>';
                row += '<td>' + cursorItems[i].favorito + '</td>';

                row += '<td><button class="btn btn-danger" onclick="deleteItem(' + cursorItems[i].idItem + ')"><i class="bi bi-trash"></i></button> <button class="btn btn-warning " onclick="editItem(' + cursorItems[i].idItem + ')"><i class="bi bi-pencil-square"></i></button></td>';
                row += '</tr>';
                tableBody.innerHTML += row;
            }
        });
}

// Función para guardar/agregar un elemento
form.addEventListener("submit", function(event) {
  // Prevenir el envío por defecto del formulario
  event.preventDefault();
  var myModalEl = document.getElementById('ModalItem');
  var modal = bootstrap.Modal.getInstance(myModalEl)
	modal.hide();
    saveItem();
}
);
function saveItem() {
    var formData = new FormData(form);
    fetch('../Api/v1/items.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        form.reset();
        getItems();
    });
}
function NuevoItem(){
    form.reset();
    var miModal = new bootstrap.Modal(document.getElementById('ModalItem'));
        miModal.show();
}
// Función para cargar datos en el formulario para editar
function editItem(id) {
    var miModal = new bootstrap.Modal(document.getElementById('ModalItem'));
        miModal.show();
        // Mostrar el modal
    var item = cursorItems.filter(function(objeto) {return objeto.idItem == id;});
    document.getElementById('detalle').value = item[0].Detalle;
    document.getElementById('precio').value = item[0].precio;
    document.getElementById('orden').value = item[0].orden;
    document.getElementById('selectCategory').value = item[0].idCategoria;
    document.getElementById('idItem').value = item[0].idItem;
    document.getElementById('unidad').value = item[0].unidad;
    if (item[0].favorito==1){
        document.getElementById('favorito').checked = true;
    }else{
        document.getElementById('favorito').checked = false;
    }
}

// Función para eliminar un elemento
function deleteItem(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí puedes agregar la lógica para eliminar
            fetch('../Api/v1/items.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'idItem=' + id
            })
            .then(response => response.text())
            .then(data => {
               // console.log(data);
                getItems();
            });
            const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                    }});
            Toast.fire({
            icon: "success",
             title: "El elemento fue eliminado"
            });
        }
    });
}

// Añade esta función para filtrar los items
function filterItems() {
    var filterText = document.getElementById('filterInput').value.toLowerCase();
    var tableRows = document.getElementById('itemTableBody').getElementsByTagName('tr');

    for (var i = 0; i < tableRows.length; i++) {
        var detailColumn = tableRows[i].getElementsByTagName('td')[0];
        if (detailColumn) {
            var detailText = detailColumn.textContent || detailColumn.innerText;

            // Oculta la fila si el texto no coincide con el filtro
            tableRows[i].style.display = (detailText.toLowerCase().indexOf(filterText) > -1) ? '' : 'none';
        }
    }
}

// Llamar a getItems al cargar la página
document.addEventListener('DOMContentLoaded', function () {
    getItems();
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var dataCargos=[];
    var dataSucursales=[];
    var dataUser=[];
function addUser() {
        const userData = {
        usuario: "",
        email: "",
        tipo: 1,
        phone: "",
        idSucursal:1,
        cargo:2,
        estado:1,
        idUser:null
         };
    // Crear un modal personalizado con SweetAlert2
    Swal.fire({
        title: 'Nuevo Usuario',
        html: `
        <div class="p-3">
            <form id="editForm" autocomplete="off">
                <div class="col col-12 mb-2">
                <div class="form-group">
                    <label class="small m-0" for="idSucursal">Sucursal</label>
                    <select class="form-select" name="idSucursal" id="idSucursal" aria-label="Sucursal">
                    ${getSelectSucursales(userData.idSucursal)}
                    </select>
                </div>
                </div>
                <div class="col col-12 mb-2">
                    <div class="form-group">
                    <label class="small m-0" for="Usuario">Nombre y apellido</label>
                    <input type="text" class="form-control" id="Usuario" placeholder="" name="Usuario"  onkeyup="javascript:this.value=this.value.toUpperCase();" value="${userData.usuario}" required>
                    </div>
                </div>
                <div mb-2">
                <div class="form-group">
                    <label class="small m-0" for="Email" >Correo electronico</label>
                    <input class="form-control" type="email" id="Email" name="Email" value="${userData.email}" required>
                </div>
                </div>
                <div class="row">
                <div class="col col-6 mb-3">
                 <div class="form-group">
                 <label class="small m-0" for="Password">Password</label>
                 <input class="form-control" placeholder="" type="password" id="Password" name="Password" value="" required>
                 </div>
                </div>
                <div class=" col col-6 mb-3">
                   <div class="form-group">
                    <label class="small m-0" for="phone">Telefono</label>
                    <input class="form-control" placeholder="" type="text" id="phone" name="Phone" value="${userData.phone}">
                    </div>
                 </div>
                </div>

                <div class="row">
                <div class="col col-8 mb-2">
                  <label class="small m-0" for="tipo">Cargo</label>
                  <select class="form-select" name="Tipo" id="tipo" aria-label="Floating label select example">
                  ${getSelectCargo(userData.cargo)}
                  </select>
                </div>
                <div  class="col col-4 pt-4 form-check form-switch">
                 <input class="form-check-input" type="checkbox" id="Estado" name="Estado" ${getEstado(userData.estado)}>
                 <label class="form-check-label" for="Estado">Estado</label>
                </div>
                </div>

            </form>
        </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            // Obtener los datos del formulario
            const formData = new FormData(document.getElementById('editForm'));

            // Convertir FormData a objeto JSON
            const formDataObject = {};
            formData.forEach((value, key) => {
                formDataObject[key] = value;
            });

            fetch('../Api/v1/user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formDataObject),
            })
            .then(response => response.json())
            .then(data => {
                // Puedes manejar la respuesta del servidor aquí
                TableUser(data);
            })
            .catch(error => {
                console.error('Error al enviar datos:', error);
                Swal.fire('Error al guardar', '', 'error');
            });
        }
    });
}
function getEstado(estado){
    if(estado==1){
        return "checked";
    }else{
        return "";
    }
}
function editUser(email,usuario,phone,idSucursal,estado,tipo,idUser) {
        var userData = {
        usuario: usuario,
        email: email,
        estado: estado,
        tipo: tipo,
        phone: phone,
        sucursal:idSucursal,
        idUser:idUser
         };
    // Crear un modal personalizado con SweetAlert2
    Swal.fire({
        title: 'Editar Usuario',
        html: `
            <form id="editForm" autocomplete="off">
            <input type="hidden" id="idUser" name="idUser" value="${userData.idUser}">
                <div class="col col-12 mb-3">
                   <select class="form-select" name="idSucursal" id="idSucursal" aria-label="Sucursal">
                    ${getSelectSucursales(userData.idSucursal)}
                    </select>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="Usuario" placeholder="Nombre y Apellido" name="Usuario"  onkeyup="javascript:this.value=this.value.toUpperCase();" value="${userData.usuario}" required>
                </div>
                <div class=" mb-3">
                 <input class="form-control" type="email" id="Email" name="Email" value="${userData.email}" required>
                </div>
                <div class="row">
                <div class="col col-6 mb-3">
                 <input class="form-control" placeholder="Password" type="password" id="Password" name="Password" value="" required>
                </div>
                 <div class="col col-6 mb-3">
                  <input class="form-control" placeholder="Telefono" type="text" id="phone" name="Phone" value="${userData.phone}">
                 </div>
                </div>
                <div class="row">
                <div class="col col-8 mb-3">
                  <select class="form-select" name="Tipo" id="tipo" aria-label="Floating label select example">
                  ${getSelectCargo(userData.tipo)}
                  </select>
                </div>
                <div  class="col col-4 mt-3 form-check form-switch">
                 <input class="form-check-input" type="checkbox" id="Estado" name="Estado" ${getEstado(userData.estado)}>
                 <label class="form-check-label" for="Estado">Estado</label>
                </div>
                </div>

            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            // Obtener los datos del formulario
            const formData = new FormData(document.getElementById('editForm'));

            // Convertir FormData a objeto JSON
            const formDataObject = {};
            formData.forEach((value, key) => {
                formDataObject[key] = value;
            });
            // Enviar datos al servidor (puedes usar Fetch API aquí)
            fetch('../Api/v1/user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formDataObject),
            })
            .then(response => response.json())
            .then(data => {
                // Puedes manejar la respuesta del servidor aquí
                TableUser(data);
            })
            .catch(error => {
                console.error('Error al enviar datos:', error);
                Swal.fire('Error al guardar', '', 'error');
            });
        }
    });
    }
function loadTableData() {
        fetch('../Api/v1/user.php')
            .then(response => response.json())
            .then(data => {
                dataUser=data;
                TableUser(data);
            });
}
function TableUser(data) {
    var tableBody = document.getElementById('userTable').getElementsByTagName('tbody')[0];
                tableBody.innerHTML = '';
                data.forEach(user => {
                    var row = `<tr>
                                   <td>${user.usuario}</td>
                                   <td>${user.email}</td>
                                   <td>${user.carDetalle}
                                    </td>
                                   <td>${user.phone}</td>
                                   <td>${user.sucDetalle}</td>
                                   <td>${user.estado}</td>
                                   <td>
                                       <button class="btn btn-warning btn-sm" onclick="editUser('${user.email}','${user.usuario}','${user.phone}','${user.idSucursal}','${user.estado}','${user.tipo}','${user.idUser}');"><i class="bi bi-pencil-square"></i></button>
                                       <button class="btn btn-danger btn-sm" onclick="deleteUser('${user.idUser}');"><i class="bi bi-trash-fill"></i></button>
                                   </td>
                               </tr>`;
                    tableBody.innerHTML += row;
                });

}
function tableSucursales(data){
    dataSucursales=data;
var tableBody=document.getElementById('tableSucursales').getElementsByTagName('tbody')[0];
    tableBody.innerHTML = '';
    data.forEach(Elemento => {
        var row = `<tr>
                                   <td>${Elemento.idSucursal}</td>
                                   <td>${Elemento.sucDetalle}</td>
                                   <td>
                                       <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modSucursal" onclick="editSucursal('${Elemento.idSucursal}','${Elemento.sucDetalle}');"><i class="bi bi-pencil-square"></i></button>
                                       <button class="btn btn-danger btn-sm" onclick="delSucursal('${Elemento.idSucursal}');"><i class="bi bi-trash-fill"></i></button>
                                   </td>
                               </tr>`;
                    tableBody.innerHTML += row;
    });
}
function tableCargos(data){
    dataCargos=data;
var tableBody=document.getElementById("tbodyCargos");
    tableBody.innerHTML = '';
    data.forEach(Elemento => {
        var row = `<tr>
                <td>${Elemento.idCargo}</td>
                <td>${Elemento.carDetalle}</td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modCargo" onclick="editCargo('${Elemento.idCargo}','${Elemento.carDetalle}');"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-danger btn-sm" onclick="delCargo('${Elemento.idCargo}');"><i class="bi bi-trash-fill"></i></button>
                </td>
                </tr>`;
    tableBody.innerHTML += row;
    });
}
function deleteUser(idUser) {
    const User={
        idUser:idUser
        };
    Swal.fire({
    title: '¿Estás seguro de eliminar el usuario?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
}).then((result) => {
    if (result.isConfirmed) {
        // Aquí puedes agregar la lógica para eliminar
        fetch('../Api/v1/user.php',{
        method:'DELETE',
        headers:{'Content-Type': 'application/x-www-form-urlencoded'},
        body:JSON.stringify(User)
    })
    .then(response=>response.json())
    .then(data=>{
        TableUser(data);
    });
    }
});
}
function delCargo(id) {
    Swal.fire({
    title: '¿Estas seguro de eliminar el cargo?',
    text: 'Esta accion no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Si, eliminar',
    cancelButtonText: 'Cancelar'
}).then((result) => {
    if (result.isConfirmed) {
        fetch('Api/cargos.php',{
        method:'DELETE',
        body:JSON.stringify({ idCargo: id }),
    })
    .then(response=>response.json())
    .then(data=>{
        tableCargos(data);
    });
    }
});
}
function delSucursal(id) {
    Swal.fire({
    title: '¿Estas seguro de eliminar el registro?',
    text: 'Esta accion no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Si, eliminar',
    cancelButtonText: 'Cancelar'
}).then((result) => {
    if (result.isConfirmed) {
        fetch('Api/sucursales.php',{
        method:'DELETE',
        body:JSON.stringify({ idSucursal: id }),
    })
    .then(response=>response.json())
    .then(data=>{
        tableSucursales(data);
    });
    }
});
}
function getSelectCargo(tipo){
    var selectHTML = '';
    dataCargos.forEach(function(cargo) {
        selectHTML += '<option value="' + cargo.idCargo + '"';
        if (cargo.idCargo == tipo) {
            selectHTML += ' selected';
        }
        selectHTML += '>' + cargo.carDetalle + '</option>';
    });
    selectHTML += '';
    return selectHTML;
}
function getSelectSucursales(idSucursal){
    var selectHTML = '';
    dataSucursales.forEach(function(sucursal) {
        selectHTML += '<option value="' + sucursal.idSucursal + '"';
        if (sucursal.idSucursal == idSucursal) {
            selectHTML += ' selected';
        }
        selectHTML += '>' + sucursal.sucDetalle + '</option>';
    });
    selectHTML += '';
    return selectHTML;
}
function loadData(){
    fetch('Api/cargos.php')
    .then(response=>response.json())
    .then(data=>{
        dataCargos=data;
        tableCargos(data);
    });
    fetch('Api/sucursales.php')
    .then(response=>response.json())
    .then(data=>{
        dataSucursales=data;
        tableSucursales(data);
    });
    return true;
}
var formSucursal= document.getElementById("formSucursal");
formSucursal.onsubmit=function(event){
    event.preventDefault();
    data=new FormData(formSucursal);
    fetch("Api/sucursales.php",
    {
        method:"POST",
        body:data
    })
    .then(response=>response.json())
    .then(data=>{
        tableSucursales(data);
    });
    formSucursal.reset();
    var myModal = document.getElementById('modSucursal');
    var modal = bootstrap.Modal.getInstance(myModal)
    modal.hide();
}
var formCargo= document.getElementById("formCargo");
formCargo.onsubmit=function(event){
    event.preventDefault();
    data=new FormData(formCargo);
    fetch("Api/cargos.php",
    {
        method:"POST",
        body:data
    })
    .then(response=>response.json())
    .then(data=>{
 //       console.log(data);
        tableCargos(data);
    });
    formCargo.reset();
    var myModal = document.getElementById('modCargo');
    var modal = bootstrap.Modal.getInstance(myModal)
    modal.hide();
}
function editSucursal(id,detalle){
var idSucursal=document.getElementById('idSucursal');
var sucDetalle=document.getElementById('sucDetalle');
    idSucursal.value=id;
    sucDetalle.value=detalle;
}
function editCargo(id,detalle){
var idCargo=document.getElementById('idCargo');
var carDetalle=document.getElementById('carDetalle');
    idCargo.value=id;
    carDetalle.value=detalle;
}
function addSucursal(){
    var idSucursal=document.getElementById('idSucursal');
    idSucursal.value="-1";
}
function addCargo(){
    formCargo.reset();
    var idCargo=document.getElementById('idCargo');
    idCargo.value="0";
}
document.addEventListener('DOMContentLoaded', function () {
    loadTableData();
    loadData();


});
</script>

<?php
include "../template/footer.php";
?>
</body>
</html>
