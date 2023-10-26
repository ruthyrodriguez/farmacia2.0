<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
} else {
  require 'header.php';

  if ($_SESSION['ventas'] == 1) {
?>
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <!-- Default box -->
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Ventas <button class="btn btn-success" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i>Agregar</button></h1>
                <div class="box-tools pull-right">

                </div>
              </div>
              <!--box-header-->
              <!--centro-->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Opciones</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Usuario</th>
                    <th>Documento</th>
                    <th>Número</th>
                    <th>Total Venta</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Usuario</th>
                    <th>Documento</th>
                    <th>Número</th>
                    <th>Total Venta</th>
                    <th>Estado</th>
                  </tfoot>
                </table>
              </div>
              <div class="panel-body" id="formularioregistros">
                <form action="" name="formulario" id="formulario" method="POST">
                  
                  <div class="form-group col-lg-8 col-md-8 col-xs-12">
                    <label for="">Cliente(*):</label>
                    <a data-toggle="modal" href="#modalcliente">
                      <button id="btncliente" type="button" class="btn btn-primary"><span class="fa fa-plus"></span>Nuevo cliente</button>
                    </a>
                    <input class="form-control" type="hidden" name="idventa" id="idventa">
                    <select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true" required>

                    </select>
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-xs-12">
                    <label for="">Fecha(*): </label>
                    <input class="form-control" type="date" name="fecha_hora" id="fecha_hora" readonly required>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Tipo Comprobante(*): </label>
                    <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required>
                      <option value="Boleta">Boleta</option>
                      <option value="Factura">Factura</option>
                      <option value="Ticket">Ticket</option>
                    </select>
                  </div>
                  <div class="form-group col-lg-3 col-md-2 col-xs-6">
                    <label for="">Serie: </label>
                    <input class="form-control" type="text" name="serie_comprobante" id="serie_comprobante" maxlength="7" placeholder="Serie">
                  </div>
                  <div class="form-group col-lg-3 col-md-2 col-xs-6">
                    <label for="">Número: </label>
                    <input class="form-control" type="text" name="num_comprobante" id="num_comprobante" maxlength="10" placeholder="Número" required>
                  </div>
                  <div class="form-group col-lg-3 col-md-2 col-xs-6">
                    <label for="">Impuesto: </label>
                    <input class="form-control" type="text" name="impuesto" id="impuesto">
                  </div>
                  <div class="form-group col-lg-3 col-md-2 col-xs-6">
                    <label for="">Tipo de pago: </label>
                    <select name="tipo_pago" id="tipo_pago" onchange="verocultar();" class="form-control selectpicker" required>
                      <option value="Efectivo">Efectivo</option>
                      <option value="Depósito">Depósito</option>
                      <option value="Credito">Credito</option>
                      <option value="Debito">Debito</option>
                      <option value="Transferencias">Transferencia</option>
                    </select>
                  </div>
                  <div id="operaciones" class="form-group col-lg-3 col-md-6 col-xs-6">
                    <label for="">N° de operación: </label>
                    <input class="form-control" type="text" name="n_operacion" id="n_operacion">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <a data-toggle="modal" href="#myModal">
                      <button id="btnAgregarArt" type="button" class="btn btn-primary"><span class="fa fa-plus"></span>Agregar Articulos</button>
                    </a>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-xs-12">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color:#A9D0F5">
                        <th>Opciones</th>
                        <th>Articulo</th>
                        <th>Stock</th>
                        <th>Cantidad</th>
                        <th>Precio Venta</th>
                        <th>Descuento</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                      </thead>
                      <tbody>

                      </tbody>
                      <tfooter>
                        <th>
                          <ul style="list-style:none">
                            <li>Sub Total</li>
                            <li id="inpuesto_name">Impuesto(18%)</li>
                            <li>TOTAL</li>
                          </ul>
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>
                          <ul style="list-style:none">
                            <li id="_subtotal">S/. 0.00</li>
                            <li id="_impuesto">S/. 0.00</li>
                            <li id="total">S/. 0.00</li>
                          </ul>
                          <input type="hidden" name="total_venta" id="total_venta">
                        </th>
                        <th></th>
                      </tfooter>
                    </table>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                    <button class="btn btn-danger" onclick="cancelarform()" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!--Modal-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="width: 65% !important;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Seleccione un Articulo</h4>
          </div>
          <div class="modal-body">
            <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
              <thead>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Código</th>
                <th>Stock</th>
                <th>Precio Venta</th>
                <th>Imagen</th>
              </thead>
              <tbody>

              </tbody>
              <tfoot>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Código</th>
                <th>Stock</th>
                <th>Precio Venta</th>
                <th>Imagen</th>
              </tfoot>
            </table>
          </div>
          <div class="modal-footer">
            <button class="btn btn-default" type="button" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- fin Modal-->
    <?php include('nuevocliente.php');?>
  <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script src="scripts/venta.js"></script>




<!--Subtotales automaticos-->

<script>
document.addEventListener("DOMContentLoaded", function() {
  document.addEventListener("input", function (e) {
    if (e.target.matches("input[name='cantidad[]'], input[name='precio_venta[]'], input[name='descuento[]']")) {
      var fila = e.target.closest("tr");
      var cantidad = parseFloat(fila.querySelector("input[name='cantidad[]']").value);
      var precioVenta = parseFloat(fila.querySelector("input[name='precio_venta[]']").value);
      var descuento = parseFloat(fila.querySelector("input[name='descuento[]']").value);
      var stock = parseInt(fila.querySelector("input[name='stock[]']").value);

      // Verificar si la cantidad supera el stock disponible
      if (cantidad > stock) {
        alert("Stock insuficiente");
        // Restablecer la cantidad al stock disponible
        fila.querySelector("input[name='cantidad[]']").value = stock;
        cantidad = stock; // Actualizar la cantidad con el valor corregido
      }

      // Calcular el subtotal
      var subtotal = (cantidad * precioVenta) - descuento;

      // Verificar si no se ha seleccionado ningún producto
      if (isNaN(subtotal)) {
        subtotal = 0;
      }

      fila.querySelector("span[name='subtotal']").textContent = subtotal.toFixed(2);
      fila.querySelector("input[name='subar[]']").value = subtotal.toFixed(2);
      calcularTotales();
    }
  });
});
</script>



<!--RECARGAR EL FORMULARIO VENTA-->
<script>
  $(document).ready(function() {
    $("#formularioCliente").submit(function(e) {
        e.preventDefault(); 

        $.ajax({
            url: "nuevocliente.php", 
            type: "POST",
            data: $(this).serialize(), 
            success: function(response) {
                
                $("#resultadoRegistro").html(response);
                
                if (response.includes("éxito")) {
                    var clientName = $("#nombre").val();
                    $("#idcliente").append("<option value='" + clientName + "' selected>" + clientName + "</option>");
                    $("#modalcliente").modal("hide");

                    // Redirige a la vista de ventas
                    window.location.href = '#formularioregistros';
                    
                }
            },
            error: function() {
                
            }
        });
    });
     // Escuchamos el evento keyup del elemento #nombre
    $("#nombre").on("keyup", function() {
        
        // Obtenemos el valor del input
        var nombre = $(this).val();
        
        // Cargamos el contenido de la lista de clientes
        $("#listaClientes").load("listaclientes.php", {
            "cliente": nombre
        });
    });
});

</script>




<?php
}


ob_end_flush();
?>
