$('#formLogin').submit(function(e)//Referencia al formulario
{
    e.preventDefault()
    var usuario =$.trim($("#usuario").val()); //trim para limpiar los campos
    var contraseña = $.trim($("#contraseña").val());
    if(usuario.length == "" || contraseña == ""){
        alert("Campos vacios");
    }
});
