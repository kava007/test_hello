$(document).ready(function(){
       $("#alert").hide();

	   //console.log("hola desde script js");
     //alert('holaaa');


	   $(".btn-delete").click(function(e){

	   	  //alert("voy a eliminar..");

	   	  e.preventDefault();

	   	  if(!confirm('Está seguro que desea eliminar?')){
             return false;
          }

          var row   = $(this).parents('tr');
          var form  = $(this).parents('form');
          var url   = form.attr('action');

          $("#alert").show();

          $.post(url, form.serialize(), function(result){

          	 row.fadeOut();
          	 $("#products-total").html(result.total);
          	 $("#alert").html(result.message);

          }).fail(function(){

          	  $("#alert").html("Algo salió mal.");
          });

	   });


    $('.openBtn').on('click',function(){
        $('.modal-body').load('content.html',function(){
            $('#myModal').modal({show:true});
        });
    });

    //$(".miModal").modal("show");



});

function traerDepositos(id, folio){

    //alert('traer depositos de la cotizacion ' + id + ", folio " + folio);
    $(".miModal").modal("show");
    var url_api = "api/v1/traerDepositos/"+id;

    $.ajax({
        url: url_api,
        /*data: "token={{ csrf_token()}}",*/
        dataType: "json",
        method: "GET",
        success: function(result)
        {

          var tabla = "<table class='table table-hover table-striped'>";
              tabla += "<tr>";
                tabla += "<th>ID</th>";
                tabla += "<th>Monto</th>";
                tabla += "<th>Fecha</th>";
              tabla += "</tr>";

         $.each(result, function(index, element) {

          var numero = new oNumero(element.monto_deposito_asignado);


             tabla += "<tr>";
                tabla += "<th>"+element.deposito_id+"</th>";
                tabla += "<th>$ "+numero.formato(2, true)+"</th>";
                tabla += "<th>"+element.created_at+"</th>";
             tabla += "</tr>";   
          });

          tabla += "</table>";

          
          $('#folio').html(folio);
          $('#contenido_tabla').html(tabla);
          
            
        },
        fail: function(){

           alert('fail');
        },
        beforeSend: function(){

          
        }
    });

}



function oNumero(numero)

      {

//Propiedades 

this.valor = numero || 0

this.dec = -1;

//Métodos 

this.formato = numFormat;

this.ponValor = ponValor;

//Definición de los métodos


function ponValor(cad)

{

if (cad =='-' || cad=='+') return

if (cad.length ==0) return

if (cad.indexOf('.') >=0)

    this.valor = parseFloat(cad);

else 

    this.valor = parseInt(cad);

} 

function numFormat(dec, miles)

{

var num = this.valor, signo=3, expr;

var cad = ""+this.valor;

var ceros = "", pos, pdec, i;

for (i=0; i < dec; i++)

ceros += '0';

pos = cad.indexOf('.')

if (pos < 0)

    cad = cad+"."+ceros;

else

    {

    pdec = cad.length - pos -1;

    if (pdec <= dec)

        {

        for (i=0; i< (dec-pdec); i++)

            cad += '0';

        }

    else

        {

        num = num*Math.pow(10, dec);

        num = Math.round(num);

        num = num/Math.pow(10, dec);

        cad = new String(num);

        }

    }

pos = cad.indexOf('.')

if (pos < 0) pos = cad.lentgh

if (cad.substr(0,1)=='-' || cad.substr(0,1) == '+') 

       signo = 4;

if (miles && pos > signo)

    do{

        expr = /([+-]?\d)(\d{3}[\.\,]\d*)/

        cad.match(expr)

        cad=cad.replace(expr, RegExp.$1+','+RegExp.$2)

        }

while (cad.indexOf(',') > signo)

    if (dec<0) cad = cad.replace(/\./,'')

        return cad;

}

}//Fin del objeto oNumero:
