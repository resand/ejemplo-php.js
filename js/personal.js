var Opciones = {
    Crear: 1,
    Modificar: 2,
    CompletarModificar: 3,
    Eliminar: 4
};

//UNICIALIAMOS LA FUNCION PARA USAR JQUERY
$(function(){

//INICIALIZAMOS EL PAGINADO
$('#tbl_personal').dataTable();

//MUESTRA EL FORMULARIO DE CREAR USUARIO
$('#bt_mostrar_form_crear_personal').click(function(event) {
    $('#tabla-personal, #bt_mostrar_form_crear_personal').fadeOut('normal');
    $('#formulario-crear-personal').fadeIn('normal');
});

//CANCELA EL FORMULARIO DE CREAR USUARIO
$('#bt_regregar').click(function(event) {
    $('#formulario-crear-personal').fadeOut('normal');
    $('#tabla-personal, #bt_mostrar_form_crear_personal').fadeIn('normal');
});

//BOTON PARA REDIRECCIONAR A LA PAGINA Y SE RECARGE EL PAGINADO
$('#bt_mensaje_ok').click(function(event) {
    $(location).attr('href', 'personal.php');
});

$('#form-crear').validate({
    rules : {
        'nombres' : { required : true },
        'apellidos' : { required : true },
        'clave_elector' : { required : true },
        'clave_partido' : { required : true },
        'puesto' : { required : true },
        'departamento' : { required : true },
        'correo' : { required : true },
        'telefono' : { required : true },
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
            mimeType: "multipart/form-data",
       
       
            
            dataType: "json",
            
            
            beforeSend: function(XMLHttpRequest){  
                $('#info-cargando').html('<span class="label label-success">Creando espere....</span>');
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
});

$('#form-modificar').validate({
    rules : {
        'nombres' : { required : true },
        'apellidos' : { required : true },
        'clave_elector' : { required : true },
        'clave_partido' : { required : true },
        'puesto' : { required : true },
        'departamento' : { required : true },
        'correo' : { required : true },
        'telefono' : { required : true },
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
                $('#info-cargando_up').html('<span class="label label-success">Creando espere....</span>');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                $('#info-cargando_up').html('<span class="label label-danger">Ocurrio un error extraño...</span>');
            },
            success:function(response){
                $('#info-cargando_up').html('');
                $('#respuesta').html('<div class="'+response.clase+'">'+response.mensaje+'</div>');
                $('#modal_update_proveedor').modal('hide');
                $('#modal_info').modal('show');
            }
       });//fin funcion .ajax
    }
});



});
//FIN DE LA FUNCION PARA USAR JQUERY


function modificar_personal(id){
    $.ajax({
        url:  "php/personal.php?opcion="+Opciones.Modificar,
        type: "POST",
        data: {id:id},
        dataType: "json",
        beforeSend: function(XMLHttpRequest){  
            $('#info-cargando').html('<span class="label label-success">Creando espere...</span>');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
            $('#info-cargando').html('<span class="label label-danger">Ocurrio un error extraño...</span>');
        },
        success:function(response){
            $.each(response, function(i, datos)
            {
                $('#id_proveedor').val(datos.id_proveedor);
                $('#direccion_up').val(datos.direccion);
                $('#razon_up').val(datos.razon_social);
                $('#rfc_up').val(datos.rfc);
                $('#codigop_up').val(datos.codigo_postal);
                $('#correo_up').val(datos.correo);
                $('#telefono_up').val(datos.telefono);
            });
            $('#modal_update_proveedor').modal('show');
        }
   });//fin funcion .ajax
}

function eliminar_personal(id){
     $.ajax({
        url:  "php/personal.php?opcion="+Opciones.Eliminar,
        type: "POST",
        data: {id:id},
        dataType: "json",
        beforeSend: function(XMLHttpRequest){  
            $('#info-cargando').html('<span class="label label-success">Cargando...</span>');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
            $('#info-cargando').html('<span class="label label-danger">ops! ha ocurrido  un error extraño...</span>');
        },
        success:function(response){
            $('#info-cargando').html('');
            $('#respuesta').html('<div class="'+response.clase+'">'+response.mensaje+'</div>');
            $('#modal_info').modal('show');
        }
   });//fin funcion .ajax
}
