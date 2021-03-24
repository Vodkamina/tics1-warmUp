$(document).ready(function () {
      var opcion = 9; //envia la opcion al backend para aplicar un switch
      var fila; //captura en que fila se hara la edicion o eliminacion
      var c;
      var v;

      tablaPersonas = $("#tablaDatos").DataTable({
            "columnDefs": [{
                  "targets": -1,
                  "data": null,
                  "defaultContent": "<div class='text-center'><div class='btn-group'><button type='button' class='btn btn-danger btnEliminar'>Eliminar</button></div></div>"
            }],
            //Lenguaje a Español
            "language": {
                  "processing": "Procesando...",
                  "lengthMenu": "Mostrar _MENU_ registros",
                  "zeroRecords": "No se encontraron resultados",
                  "emptyTable": "Ningún dato disponible en esta tabla",
                  "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                  "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                  "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                  "search": "Buscar:",
                  "infoThousands": ",",
                  "loadingRecords": "Cargando...",
                  "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                  },
            }
      });
     
      $("#btnCalcular").click(function () {
            opcion = 1;
            //e.preventDefault();
            nombreProducto = $.trim($("#nombreProducto").val());
            tienda = $.trim($("#tienda").val());
            PrecioAlContado = $.trim($("#PrecioAlContado").val());
            valorCuotaMensual = $.trim($("#valorCuotaMensual").val());
            cuotas = $.trim($("#cuotas").val());
            if(valorCuotaMensual*cuotas <= PrecioAlContado){
                  alert("El valor de las cuotas multiplicadas por su cantidad no coinciden con el precio al contado");
            }
            $.post("backend.php", { opcion: opcion, PrecioAlContado: PrecioAlContado, valorCuotaMensual: valorCuotaMensual, cuotas: cuotas}, function(resultado){
                  a = resultado.split("/");
                  c= a[0];
                  v= a[1];
                  error = a[2];
                  if(error == 1){
                        alert("Error en el calculo");
                  }
                  else{
                        //$("#cae").html(c+" %");
                        c = parseFloat(c);
                        $("#cae").html(Number(c.toFixed(2)) + " %");
                        
                        $("#valor").html(" $ "+v);
                  }
            });

      
      });

      $("#btnGuardar").click(function () {
            if(nombreProducto!="[object HTMLInputElement]" && tienda!="[object HTMLInputElement]" && PrecioAlContado!="[object HTMLInputElement]" && valorCuotaMensual!="[object HTMLInputElement]" && cuotas!="[object HTMLInputElement]" && c!="undefined" && v!="undefined"){
                  opcion = 2;
                  location.reload();
            } else {
                  alert("Faltan datos para guardar en la base de datos");
            }
            
      });



      //codigo para el boton Eliminar
      $(document).on("click", ".btnEliminar", function () {
            fila = $(this).closest("tr");
            id = parseInt(fila.find("td:eq(0)").text());
            opcion = 3;//opc eliminar
            var respuesta = confirm("¿Esta seguro que desea eliminar el registro con id: " + id + " ?");
            if (respuesta) {
                  $.ajax({
                        url: "backend.php",
                        type: "POST",
                        dataType: "json",
                        data: {
                              opcion: opcion,
                              id: id
                        },
                        success: function () {
                              location.reload();
                        }
                  });
            }

            location.reload();

      });


      $("#formDatos").submit(function (e) {
            e.preventDefault();
            nombreProducto = $.trim($("#nombreProducto").val());
            tienda = $.trim($("#tienda").val());
            PrecioAlContado = $.trim($("#PrecioAlContado").val());
            valorCuotaMensual = $.trim($("#valorCuotaMensual").val());
            cuotas = $.trim($("#cuotas").val());

            $.ajax({
                  url: "backend.php",
                  type: "POST",
                  dataType: "json",
                  data: {
                        nombreProducto: nombreProducto,
                        tienda: tienda,
                        PrecioAlContado: PrecioAlContado,
                        valorCuotaMensual: valorCuotaMensual,
                        cuotas: cuotas,
                        opcion: opcion,
                        c: c,
                        v: v
                  },
                  success: function (data) {
                        location.reload();
                  }
            });
      });
});
