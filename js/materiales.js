var Opciones = {
    Crear: 1,
    Modificar: 2,
    CompletarModificar: 3,
    Eliminar: 4
};

//UNICIALIAMOS LA FUNCION PARA USAR JQUERY
$(function(){

//INICIALIZAMOS EL PAGINADO
$('#tbl_materiales').dataTable();

//MUESTRA EL FORMULARIO DE CREAR USUARIO
$('#bt_mostrar_form_crear_usuario').click(function(event) {
    $('#tabla-materiales, #bt_mostrar_form_crear_usuario').fadeOut('normal');
    $('#formulario-crear-usuario').fadeIn('normal');
});

//CANCELA EL FORMULARIO DE CREAR USUARIO
$('#bt_regregar').click(function(event) {
    $('#formulario-crear-usuario').fadeOut('normal');
    $('#tabla-materiales, #bt_mostrar_form_crear_usuario').fadeIn('normal');
});

//BOTON PARA REDIRECCIONAR A LA PAGINA Y SE RECARGE EL PAGINADO
$('#bt_mensaje_ok').click(function(event) {
    $(location).attr('href', 'materiales.php');
});

$('#form-crear').validate({
    rules : {
        'codigo_producto' : { required : true },
        'descripcion_producto' : { required : true },
        'nombre_producto' : { required : true },
        'fecha_adquisicion' : { required : true },
        'monto_original' : { required : true },
        'porcentaje_depreciacion' : { required : true },
        'clave_factura' : { required : true },
        'factura_pdf' : { required : true },
        'factura_xml' : { required : true },
        'id_clasificacion' : { required : true },
        'id_proveedor' : { required : true },
        'id_estado' : { required : true },
        'id_responsable_departament' : { required : true },
        'id_responsable_activo' : { required : true },
        'ubicacion_id_departamento' : { required : true },
        'foto' : { required : true }
    },
    errorClass : 'campo-invalido',
    submitHandler : function () {

        var datos = $('#form-crear').serialize() + '&opcion='+Opciones.Crear;
        var url =  $('#form-crear').attr('action');

        $.ajax({
            url:  url,
            type: "POST",
            data: datos,
            dataType: "json",
            beforeSend: function(XMLHttpRequest){  
            	$('#info-cargando_up').html('<span class="label label-success">Creando materiales....</span>');
	        },
	        error: function(XMLHttpRequest, textStatus, errorThrown){
	        	$('#info-cargando_up').html('<span class="label label-danger">Ocurrio un error extraño...</span>');
	        },
            success:function(response){
                $('#info-cargando_up').html('');
            	$('#respuesta').html('<div class="'+response.clase+'">'+response.mensaje+'</div>');
                $('#modal_info').modal('show');

            }
       });//fin funcion .ajax
    }
});

$('#form-modificar').validate({
    rules : {
        'codigo_producto' : { required : true },
        'descripcion_producto' : { required : true },
        'nombre_producto' : { required : true },
        'fecha_adquisicion' : { required : true },
        'monto_original' : { required : true },
        'porcentaje_depreciacion' : { required : true },
        'clave_factura' : { required : true },
        'factura_pdf' : { required : true },
        'factura_xml' : { required : true },
        'id_clasificacion' : { required : true },
        'id_proveedor' : { required : true },
        'id_estado' : { required : true },
        'id_responsable_departament' : { required : true },
        'id_responsable_activo' : { required : true },
        'ubicacion_id_departamento' : { required : true },
        'foto' : { required : true }
    },
    errorClass : 'campo-invalido',
    submitHandler : function () {

        var datos = $('#form-modificar').serialize() + '&opcion='+Opciones.CompletarModificar;
        var url =  $('#form-modificar').attr('action');
        $.ajax({
            url:  url,
            type: "POST",
            data: datos,
            dataType: "json",
            beforeSend: function(XMLHttpRequest){  
                $('#info-cargando').html('<span class="label label-success">Creando Usuarios....</span>');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                $('#info-cargando').html('<span class="label label-danger">Ocurrio un error extraño...</span>');
            },
            success:function(response){
                $('#info-cargando').html('');
                $('#respuesta').html('<div class="'+response.clase+'">'+response.mensaje+'</div>');
                $('#modal_update_usuario').modal('hide');
                $('#modal_info').modal('show');
            }
       });//fin funcion .ajax
    }
});



});
//FIN DE LA FUNCION PARA USAR JQUERY


function modificar_usuario(id){
    $.ajax({
        url:  "php/materiales.php?opcion="+Opciones.Modificar,
        type: "POST",
        data: {id:id},
        dataType: "json",
        beforeSend: function(XMLHttpRequest){  
            $('#info-cargando').html('<span class="label label-success">Cargando...</span>');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
            $('#info-cargando').html('<span class="label label-danger">Ocurrio un error extraño...</span>');
        },
        success:function(response){
            $.each(response, function(i, datos)
            {
                $('#id_usuario').val(datos.id_usuario);
                $('#nombres_up').val(datos.nombres);
                $('#apellidos_up').val(datos.apellidos);
                $('#usuario_up').val(datos.usuario);
                $('#perfil_up').val(datos.perfil);
            });
            $('#modal_update_usuario').modal('show');
        }
   });//fin funcion .ajax
}

function eliminar_usuario(id){
     $.ajax({
        url:  "php/materiales.php?opcion="+Opciones.Eliminar,
        type: "POST",
        data: {id:id},
        dataType: "json",
        beforeSend: function(XMLHttpRequest){  
            $('#info-cargando').html('<span class="label label-success">Cargando...</span>');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
            $('#info-cargando').html('<span class="label label-danger">Ocurrio un error extraño...</span>');
        },
        success:function(response){
            $('#info-cargando').html('');
            $('#respuesta').html('<div class="'+response.clase+'">'+response.mensaje+'</div>');
            $('#modal_info').modal('show');
        }
   });//fin funcion .ajax
}
