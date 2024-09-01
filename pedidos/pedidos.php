<?php
include_once "../template/header.php";
include_once "../template/menu.php";
include_once "../template/session.php";
?>
<link rel="stylesheet" href="pedidos.css">
<body>
<div class="container mt-3 secciones active " id="frmHome">
    <div class="card border-secondary" style="height: 90vh;">
        <div class="card-header text-center">
            <h8 class="card-title">LISTA DE PEDIDOS</h8>
        </div>
    <div class="card-body p-2 overflow-auto">

    <button type="button" onclick="urlClick(2);" class="rounded-pill btn btn-success">
    <i class="bi bi-plus-circle-fill"></i> Nuevo Pedido</button>
    <table class="table mt-2 table-hover table-sm table-bordered table-responsive">
            <thead class="table-secondary" >
            <tr>
                <th class="col-1 col-md-2">Fecha</th>
                <th class="col-2 col-md-4">Usuario</th>
                <th class="col-2 col-md-2">Entrega</th>
                <th class="text-center col-1 col-md-1">TOTAL</th>
                <th class="col-1 col-md-1">Estado</th>
                <th class="col-2"></th>
            </tr>
            </thead>
            <tbody id="tblPedidosBody">
            </tbody>
        </table>
    </div>
</div>
</div>
<div class="container secciones mt-3" id="frmPedido">
    <div class="card mt-3">
  <div class="accordion  " id="accordionFlushExample">
  <div class="accordion-item bg-light">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed pt-2 pb-0 " type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
       <p>Pedido Detalle</p>
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">
        <div class="row mt-0">
        <div class="col-6 col-sm-6 col-md-6 col-lg-2">
              <div class="form-group">
                  <input type="hidden" value="0" id="idPedido">
                  <label class="small mb-1" for="txtFecha1">Fecha</label>
                  <input class="form-control py-2" name="txtFecha1" id="txtFecha1" type="date" />
              </div>
          </div>
          <div class="col-6 col-md-6 col-sm-6 col-lg-2 ">
              <div class="form-group">
                  <label class="small mb-1" for="txtFecha2">Fecha de Entrega</label>
                  <input class="form-control py-2" name="txtFecha2" id="txtFecha2" type="date" />
              </div>
          </div>
          <div class="col-md-8">
              <div class="form-group">
                  <label class="small mb-1" for="Glosa">Comentarios</label>
                  <input class="form-control py-2" name="Glosa" id="txtGlosa" type="text" />
              </div>
          </div>
      </div>
    </div>          
    </div>
  </div>
    </div>
        <div class="card-body">
        <div class="row mt-0 shadow-sm px-4 mb-3" >
                <table class="table table-bordered table-hover table-sm table-responsive">
                    <thead class="table-light">
                    <tr>
                        <th>Detalle</th>
                        <th>Cantidad</th>
                        <th class="text-end">SubTotal</th>
                        <th class="text-end">Acciones</th>        
                    </tr>
                    </thead>
                    <tbody id="DetalleItemsBody">
                    </tbody>
                    <tfoot>
                        <tr>
                        <td>
                            <button type="button" class="btn btn-outline-success" onclick="abrirItemsShow()" ><i class="bi bi-plus-circle"> Agregar</i></button>
                        </td>
                            <td>Total:</td>
                            <td colspan="2"><input id="txtTotal" class="form-control text-end" type="text" value="0.00" disabled></td>
                        </tr>
                    </tfoot>
                </table>           
        </div>
        <div class="row">
        <div class="col text-center">
            <button type="button" class="col-md-6 btn btn-outline-primary rounded-pill p-2 fs-5 fw-semibold" onclick="enviarDatos()" ><img src="../img/ok2.png" class="px-2" alt="">Enviar</button>
        </div>    
        <div class="col text-center">
            <button type="button" onclick="frmPedidoClose();"  class="col-md-6 btn btn-outline-danger p-2 rounded-pill fs-5 fw-semibold" ><img src="../img/salir.png" class="px-2" alt="">Cancelar</button>
        </div>
        </div>
    </div>
</div>

</div>

<div class="container p-0 mt-3 secciones " id="frmPerfil">
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow-sm border-rounded-lg">
                    <div class="card-header"><h4 class="text-center ">Datos del Usuario</h4></div>
                    <div class="card-body">
                        <form class="needs-validation" method="post" action="form" id="formPerfil" autocomplete="off">
                            <div class="row" >
                            <div class="col-md-12">
                            <div class="row mb-3">
                                <input type="hidden" id="idUser" value="">
                                <div class="form-group">
                                        <label class="small m-0" for="Usuario">Nombre y Apellido</label>
                                        <input class="form-control py-2" name="Usuario" id="Usuario" type="text" placeholder="Ingrese su Nombre y Apellido" required/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="small m-0" for="Email">Correo electrónico</label>
                                        <input class="form-control py-2" name="Email" id="Email" type="email" placeholder="Correo electrónico" aria-describedby="emailHelp" disabled />
                                    </div>
                                </div>
                                
                                <div class="col-12 col-md-6">
                                    <div class="form-group m-0">
                                        <label class="small m-0" for="Phone">Numero de Celular</label>
                                        <input class="form-control py-2" id="Phone" name="Phone" type="text"  placeholder="Numero de Celular" aria-describedby="Celular" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small m-0" for="Password">Contraseña</label>
                                        <input class="form-control py-2" name="Password" id="Password" type="password"  placeholder="Ingrese la contraseña" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small m-0" for="ConfirmPassword">Nueva Contraseña</label>
                                        <input class="form-control py-2" name="newPassword" id="ConfirmPassword" type="password" placeholder="Nueva Contraseña" />
                                    </div>
                                </div>
                            </div>
                        </div>
            
                    </div>
                            <div class="form-group mt-4 mb-0">
                                <button type="submit" class="col-12 btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
    
                </div>
    
            </div>
        </div>
</div>
<!--lista de items-->
<dialog id="formListaItems" class="dialogo">
<div class="row">
    <div class="col col-8">
        <input type="text" class="input-buscar col-12" autocomplete="off" id="filterInput" oninput="filterItems()" placeholder="Buscar">
    </div>
    <div class="col col-4">
        <button onclick="formItemsSalir();" class="btn btn-secondary col-12"type="button">salir</button>
    </div>
</div>

<div style="overflow-x:auto; max-height: 90vh;" >
    <table class="table mt-0" style="height:50px;">
        <thead>
        <tr>
            <th class="col-8">Detalle</th>
            <th class="col-2">Precio</th>
            <th class="col-2">Agregar</th>
        </tr>
        </thead>
        <tbody id="itemTableBody" >
        <!-- Aquí se mostrarán los datos de la tabla -->
        </tbody>
    </table>
</div>
</dialog>
<dialog id="formVista"  >
<div id="tableVista" class="overflow-x:auto; max-height: 90vh;" >
    <table class="table table-bordered table-hover table-sm table-responsive" >
        <thead>
        <tr>
            <th class="col-2">Cant.</th>
            <th class="col-8">Detalle</th>
            <th class="col-2">Unidad</th>
        </tr>
        </thead>
        <tbody id="tableVistaItems" >
        <!-- Aquí se mostrarán los datos de la tabla -->
        </tbody>
    </table>
</div>
<div class="row">
    <div class="d-grid gap-2 col-6 mx-auto">
        <button type="button" onclick="btnVistaEnviar()" class="btn btn-success">Enviar</button>
    </div>
    <div class="d-grid gap-2 col-6 mx-auto">
        <button type="button" onclick="btnVistaSalir()" class="btn btn-danger">Cancelar</button>
    </div>
</div>
</dialog>
</body>
<script type="text/javascript" src="../js/html2canvas.js"></script>
<script type="text/javascript" src="pedidos.js"> </script>
<?php
include_once "../template/footer.php";
?>