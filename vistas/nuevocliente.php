<?php
require_once "../config/Conexion.php";

$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_persona = "Cliente";
    $nombre = limpiarCadena($_POST["nombre"]);
    $tipo_documento = limpiarCadena($_POST["tipo_documento"]);
    $num_documento = limpiarCadena($_POST["num_documento"]);
    $direccion = limpiarCadena($_POST["direccion"]);
    $telefono = limpiarCadena($_POST["telefono"]);
    $email = limpiarCadena($_POST["email"]);

    $sql = "INSERT INTO persona (tipo_persona, nombre, tipo_documento, num_documento, direccion, telefono, email) 
            VALUES ('$tipo_persona', '$nombre', '$tipo_documento', '$num_documento', '$direccion', '$telefono', '$email')";

    $result = ejecutarConsulta_retornarID($sql);

    if ($result) {
        $message = "Cliente registrado con éxito";
    } else {
        $message = "Error al registrar el cliente";
    }
}
?>

<!--Modal-->
<div class="modal fade" id="modalcliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 65% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Registrar nuevo cliente</h4>
            </div>
            <div class="modal-body">
                <form id="formularioCliente" method="POST">
                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                        <label for="">Nombre</label>
                        <input class="form-control" type="hidden" name="idpersona" id="idpersona">
                        <input class="form-control" type="hidden" name="tipo_persona" id="tipo_persona" value="Cliente">
                        <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100"
                            placeholder="Nombre del cliente" required>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                        <label for="">Tipo Documento</label>
                        <select class="form-control select-picker" name="tipo_documento" id="tipo_documento" required>
                            <option value="DNI">DNI</option>
                            <option value="RUC">RUC</option>
                            <option value="CEDULA">CEDULA</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                        <label for="">Número Documento</label>
                        <input class="form-control" type="text" name="num_documento" id="num_documento" maxlength="20"
                            placeholder="Número de Documento">
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                        <label for="">Dirección</label>
                        <input class="form-control" type="text" name="direccion" id="direccion" maxlength="70"
                            placeholder="Dirección">
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                        <label for="">Teléfono</label>
                        <input class="form-control" type="text" name="telefono" id="telefono" maxlength="20"
                            placeholder="Número de Teléfono">
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                        <label for="">Email</label>
                        <input class="form-control" type="email" name="email" id="email" maxlength="50"
                            placeholder="Email">
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
        
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>
                    Guardar</button>
                <button class="btn btn-default" type="button" data-dismiss="modal">Cerrar</button>
            </div>
            </form>
            <div id="resultadoRegistro"><?php echo $message; ?></div>
        </div>
    </div>
</div>
<!-- fin Modal-->

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
                }
            },
            error: function() {
                
            }
        });
    });
});
</script>
