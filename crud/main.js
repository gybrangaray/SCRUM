$(document).ready(function(){
   tablaPersonas =  $("#tablaPersonas").DataTable({
       "ColumnDefs":[{
        "targets": -1,
        "data":null,
       "defaultContent": "<div class='text-center'> <div class='btn-group'><button class='btn btn-primary btnEditar'> <i class='fa fa-edit'></i></button> <button class='btn btn-danger btnEliminar'><i class='fas fa-trash-alt'></i></button></div></div> "
       }], 
        "language":{ //Aquí cambiamos a lenguaje español todos los elementos del dataTable
            "lengthMenu": "Mostrar _MENU_ ",
            "zeroRecords": "No se encontraron registros",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty":"Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(Filtrando de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
            },
            "processing": "Procesando...",
        }
   });
   //Función para boton  Agregar
   $("#btnNuevo").click(function(){
       $("#formPersonas").trigger("reset")  //En esta función llamamos al formulario, para que resetee los campos y no se quede con los valores anteriores
       $(".modal-header").css("background-color", "#28a745");
       $(".modal-title").text("Agregar cliente");
       $(".modal-title").css("color", "white");
       $("#modalCRUD").modal("show");
       id=null; //no enviamos ningun id ya que se genera con el autoincrementable de sql
       opcion = 1; // NUEVO
   });
   var fila; //Esta variable va capturar la fila para editar o eliminar el regitro
   //Función para boton  Editar 
   $(document).on("click", ".btnEditar", function(){
      fila = $(this).closest("tr");    //con closest("tr") hacemos referencia a fila
      id = parseInt(fila.find('td:eq(0)').text()); // De esta manera capturamos el "id"
      nombre = fila.find('td:eq(1)').text(); //Se captura nombre
      calle = fila.find('td:eq(2)').text(); //Se captura calle
      numero = parseInt(fila.find('td:eq(3)').text());   //Se captura numero
      colonia = fila.find('td:eq(4)').text(); //Se captura colonia
      municipio = fila.find('td:eq(5)').text(); //Se captura municipio
      estado = fila.find('td:eq(6)').text(); //Se captura estado
      postal = parseInt(fila.find('td:eq(7)').text());  //Se captura postal
      pais = fila.find('td:eq(8)').text();  //Se captura país
      edad = parseInt(fila.find('td:eq(9)').text());  //Se captura edad
      curp = fila.find('td:eq(10)').text();  //Se captura curp
      
      $("#nombre").val(nombre);  //capturamos el valor que hace referiencia a nombre
      $("#calle").val(calle);  //capturamos el valor que hace referiencia a calle
      $("#numero").val(numero);  //capturamos el valor que hace referiencia a numero
      $("#colonia").val(colonia);  //capturamos el valor que hace referiencia a colonia
      $("#municipio").val(municipio);  //capturamos el valor que hace referiencia a municipio
      $("#estado").val(estado);  //capturamos el valor que hace referiencia a estado
      $("#postal").val(postal);  //capturamos el valor que hace referiencia a postal
      $("#pais").val(pais);      //capturamos el valor que hace referiencia a pais
      $("#edad").val(edad);      //capturamos el valor que hace referiencia a edad
      $("#curp").val(curp);      //capturamos el valor que hace referiencia a curp
      opcion = 2 ;   //EDITAR    --variable opcion se crea para cuando mandemos a nuestro archivo crud vamos a utilizar un switch donde de acuerdo con la operacion Nuevo=1, Editar=2, Eliminar=3 
      $(".modal-header").css("background-color", "#007bff");
      $(".modal-title").text("Editar cliente");
      $(".modal-title").css("color", "white");
      $("#modalCRUD").modal("show");
   });
   //Función para boton  Eliminar
   $(document).on("click", ".btnEliminar", function(){
    fila = $(this);   //solo capturaremos el "id"
    id = parseInt($(this).closest("tr").find('td:eq(0)').text());
    opcion = 3; //Eliminar

    var respuesta = confirm("¿Esta seguro que desea eliminar el registro " + id + "?");
    if(respuesta){
        $.ajax({
            url: "bd/crud.php", 
            type: "POST",       
            dataType: "json",   
            data: {
                opcion:opcion,
                id:id
            },
            success: function(){ //si todo es exitoso se elimina
                tablaPersonas.row(fila.parents('tr')).remove().draw();    //remove es de dataTables
             }
        });
    }
    });

   $("#formPersonas").submit(function(e){  //Aquí se hace referencia al forulario que esta compartido por el mismo modal para el "ABC o CRUD"
    e.preventDefault  //para que todo sea sobre la misma pagina y no se recargue
    //Se crean variables para tomar los valores que se cargan en el formulario
                                            //cada uno se asigna a su variable correspondiete "id, nombre,calle,numero,colonia,municipio,estado,postal, pais,edad,curp"
    nombre = $.trim($("#nombre").val());  //con .val() se obtiene el valor que el usuario ingresa en los inputs 
    calle = $.trim($("#calle").val());// con trim se obtienen los inputs sin espacios
    numero= $.trim($("#numero").val());
    colonia = $.trim($("#colonia").val());
    municipio = $.trim($("#municipio").val());
    estado = $.trim($("#estado").val());
    postal = $.trim($("#postal").val());
    pais = $.trim($("#pais").val());  
    edad = $.trim($("#edad").val()); 
    curp = $.trim($("#curp").val());     
   //codigo ajax
   $.ajax({
       url: "bd/crud.php",  //archivo con el que se va interactuar es decir enviar y recibir datos 
       type: "POST",        //metodo para enviar y recibir "POST"
       dataType: "json",    //datos enviados en formato json
       data: {            //Aquí se envian las variables "nombre,calle,numero,colonia,municipio,estado,postal, pais,edad,curp" 
         nombre:nombre,
         calle:calle,
         numero:numero,
         colonia:colonia,
         municipio:municipio,
         estado:estado,
         postal:postal,
         pais:pais,
         edad:edad,
         curp:curp,
         id:id,
         opcion:opcion
       },
       success: function(data){  //si es exitoso nos devolvera un array situado en archivo crud.php
      /*  var datos = JSON.parse(data); en este caso no es necesario*/
       id = data[0].id; // para tener individualizado cada uno (id, "nombre","calle", numero, "colonia", "municipio", "estado",codigopostal, "pais", edad,curp)
       nombre = data[1].nombre; 
       calle = data[2].calle;
       numero = data[3].numero;
       colonia = data[4].colonia;
       municipio = data[5].municipio;
       estado = data[6].estado;
       postal = data[7].postal;
       pais = data[8].pais;
       edad = data[9].edad;
       curp = data[10].curp;
       if(opcion == 1){
           tablaPersonas.row().add([id,nombre,calle,numero,colonia,municipio,estado,postal,pais,edad,curp]).draw(); // Aquí se dibujan los datos dinamicamente sin la necesidad de recargar la pagina
        }else{  //sino realizara una modificación
            tablaPersonas.row(fila).data([id,nombre,calle,numero,colonia,municipio,estado,postal,pais,edad,curp]).draw(); 
        }
    }
    });
    $("#modalCRUD").modal("hide"); 
});  
});