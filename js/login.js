$(function(){

    $('#form').validate({
        rules : {
            'usuario' : { required : true },
            'contrasena' : { required : true }
        },
        errorClass : 'campo-invalido',
        submitHandler : function () {
            $.ajax({
                url:  $('#form').attr('action'),
                type: "POST",
                data: $('#form').serialize(),
                dataType: "json",
                success:function(response){
                	//alert(response);
                    $.each(response, function(i, data)
                    {
                       alert(data.perfil);              
                    });
                }
           });
        }
    });

});//Fin function