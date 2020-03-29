$('#formLogin').submit(function(e)//Referencia al formulario
{
    e.preventDefault()
    var usuario =$.trim($("#usuario").val()); //trim para limpiar los campos
    var contraseña = $.trim($("#contraseña").val());
    
    if(usuario.length == "" || contraseña == ""){
        let timerInterval
        swal.fire({          //logeo warning
            icon:'warning',
            title:"Debe ingresar usuario y/o contraseña",
            // html: ' <b></b> ', //no se si dejar el contador o quitarlo
            timer: 2000,
             timerProgressBar: true,
              onBeforeOpen: () => {
                Swal.showLoading()
                timerInterval = setInterval(() => {
                  const content = Swal.getContent()
                  if (content) {
                    const b = content.querySelector('b')
                    if (b) {
                      b.textContent = Swal.getTimerLeft()
                    }
                  }
                }, 100)
              },
              onClose: () => {
                clearInterval(timerInterval)
              }
            }).then((result) => {
              /* Read more about handling dismissals below */
              if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
              }
            })
        return false; //para que no haga ningun tipo de envio
    }else{
        $.ajax({
            url:"bd/login.php", //envio de datos a archivo "login.php"
            type:"POST",       
            datatype:"json",
            data: {usuario:usuario, contraseña:contraseña},
            success:function(data) //este data es lo que vamos a generar en login.php y enviar por JSON
            {
                if(data == "null"){   //logeo error
                    Swal.fire({
                        icon: 'error',
                        title:  'Usuario y/o contraseña incorrectos',
                        footer: '<a href>Recordar usuario y/o contraseña</a>'
                      })
                }else{
                    swal.fire({          //logeo exitoso
                        icon:'success',
                        title:"¡Exito!",
                        confirmButtonColor:"#114c99",
                        confirmButtonText:"Ingresar",
                    }).then((result) =>  //aqui se captura el resultado
                     {
                        if(result.value){
                            window.location.href = "vistas/pagina_inicio.php";//redireccionamiento a pagina_inicio.php
                        }
                     })  
                }
            }
        });
    }
});
