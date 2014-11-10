$(function(){

	var Opciones = {
	    Iniciar: 1
	};

	var Perfiles = {
	    Administrador: 1,
	    Invitado: 2
	};

	var Areas = {
	    Administrador: 'admin.php',
	    Invitado: 'invitado.php'
	};

    $('#form-login').validate({
        rules : {
            'usuario' : { required : true },
            'contrasena' : { required : true }
        },
        errorClass : 'campo-invalido',
        submitHandler : function () {

            var datos = $('#form-login').serialize() + '&opcion='+Opciones.Iniciar;
            var url =  $('#form-login').attr('action');

            $.ajax({
                url:  url,
                type: "POST",
                data: datos,
                dataType: "json",
                beforeSend: function(XMLHttpRequest){  
                	$('#info-cargando').html('<span class="label label-success">Iniciando Sesión....</span>');
		        },
		        error: function(XMLHttpRequest, textStatus, errorThrown){
		        	$('#info-cargando').html('<span class="label label-danger">Ocurrio un error extraño...</span>');
		        },
                success:function(response){
                	if (response.perfil == Perfiles.Administrador && response.estado == true) {
                		$(location).attr('href', Areas.Administrador);
                	}else if (response.perfil == Perfiles.Invitado && response.estado == true) {
                		$(location).attr('href', Areas.Invitado);
                	}else{
                		$('#info-cargando').html('<div class="alert alert-danger" role="alert">El Nombre de usuario y/o la contraseña no son correctos.</div>');
                	}
                }
           });//fin funcion .ajax
        }
    });


$('#cerrar_sesion').click(function(event) {
	$(location).attr('href', "php/cerrar_sesion.php");
});


});//Fin function