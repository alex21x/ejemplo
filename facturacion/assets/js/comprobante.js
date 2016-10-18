   
// Validacion
    
//    function items(){
//        this.Items = [];
//    }        
//
//    items.prototype.cargarData = function(item){        
//	this.Items.push(item);	
//        return this.Items;        
//    };
//    
//    items.prototype.mostrarData = function(arrayItem){
//        console.log(arrayItem);
//        var cadena  = '';        
//        
//        var total_igv = 0;
//        var total_a_pagar = 0;        
//        var total_gravada = 0;
//        var total_exonerada = 0;
//        var total_inafecta  = 0;
//                
//        for(var i=0;i<this.Items.length;i++){                                        
//            
//            total_igv += parseFloat(this.Items[i]['igv']);
//            total_a_pagar += parseFloat(this.Items[i]['total']);
//                        
//            // CALCULANDO TOTALES                        
//            var tipoIgv = this.Items[i]['tipo_igv_id'];            
//                if(tipoIgv < 8)
//                    total_gravada += parseFloat(this.Items[i]['subtotal']);
//                else if(tipoIgv < 9)
//                    total_exonerada += parseFloat(this.Items[i]['subtotal']);
//                    else
//                    total_inafecta  += parseFloat(this.Items[i]['subtotal']);
//            
//            if(i==0){                
//                cadena = cadena + '<br>'+
//                        '<div class="row"><div class="col-xs-12 col-md-12 col-lg-12">'+
//                        '<table class="table table-hover" id="tabla">'+
//                            '<tr>'+
//                                '<th>Tipo Venta</th>' +
//                                '<th>Descripción</th>'+
//                                '<th>Cant</th>'       +
//                                '<th>Tipo Igv</th>'   +
//                                '<th>Importe</th>'    +
//                                '<th>SubTotal</th>'   +
//                                '<th>Igv</th>'        +
//                                '<th>Total</th>'      +
//                                '<th>Eliminar</th>'   +
//                            '</tr>'    ;
//                    
//            }        
//            cadena = cadena + '<tr class="active" id = "idfila_'+ i +'"><td>'+this.Items[i]['tipo_item_id']+
//                                '</td><td><textarea id = "'+ i +'" rows = "1">'+this.Items[i]['descripcion']+'</textarea>'+
//                                '</td><td>'+this.Items[i]['cantidad']   +
//                                '</td><td>'+llenaCombo()+
//                                '</td><td>'+this.Items[i]['importe']    +
//                                '</td><td>'+this.Items[i]['subtotal']   +
//                                '</td><td>'+this.Items[i]['igv']        +
//                                '</td><td>'+this.Items[i]['total']      +
//                                '</td><td><div class="glyphicon glyphicon-remove-circle" onClick="item.eliminarFila('+ i +')"></div>'+
//                                '</td></tr>';
//            if(i == (this.Items.length-1)){
//                    cadena = cadena + '</table></div></div>';
//            }   
//        };
//        
//        
//        // DETRACCION
//        if(total_a_pagar > 700){
//            $('#detraccion').prop('checked',true);            
//            cmp.detraccion();
//        } else {
//            $('#detraccion').prop('checked',false);            ;
//            cmp.detraccion();
//        }                    
//        
//        $('#mostrar').html(cadena);                
//        $('#total_igv').val(total_igv.toFixed(2));
//        $('#total_a_pagar').val(total_a_pagar.toFixed(2));
//        $('#total_gravada').val(total_gravada.toFixed(2));
//        $('#total_exonerada').val(total_exonerada.toFixed(2));
//        $('#total_inafecta').val(total_inafecta.toFixed(2));
//    }
//
//    items.prototype.eliminarFila = function(id){        
//        for(var i=0;i<this.Items.length;i++)            
//            id == i ? this.Items.splice(i,1) : false;
//                            
//        item.mostrarData(this.Items);        
//    }        
//    
//    items.prototype.modificarFila = function(name,val){        
//        $('#'+name).val(val);
//    }
//        
//    items.prototype.get = function(){
//        return this.Items;
//    }
//    
//    items.prototype.set = function(items){
//        return this.Items = items ;
//    }    
//    
//    items.prototype.getTotal = function() {            
//    var total = 0;        
//    $.each(this.Items, function(key, value) {
//        total = parseFloat(total) + parseFloat(value.total);        
//               
//    });   
//    return total;
//};
    
    
    // Creando un nuevo Objeto
//    item = new items();     
//    //
//    $(document).on('ready',function(){
                
    // CAPTURANDO EVENTOS     
//    $('#adjuntar').on('click',function(e){           
//        //e.preventDefault();
//        //var tot  = item.getTotal();
//        //alert(tot);
//        
//        var x = validar_item();
//        if(x>0)
//            return false;
//        
//        var y = checkDecimals($('#importe'),$('#importe').val());
//        if(y>0)
//            return false;
//                                                                
//        var itemm = {
//        'tipo_item_id': $('#tipo_venta').val(),
//        'descripcion' : $('#descripcion').val(),
//        'cantidad'    : $('#cantidad').val(),
//        'tipo_igv_id' : $('#tipo_igv').val(),
//        'importe'     : parseFloat($('#importe').val()).toFixed(2),
//        'subtotal'    : parseFloat($('#subtotal').val()).toFixed(2),
//        'igv'         : parseFloat($('#igv').val()).toFixed(2),
//        'total'       : parseFloat($('#total').val()).toFixed(2)                               
//        }                    
//                                  
//        var arrayItem = item.cargarData(itemm);        
//        item.mostrarData(arrayItem);
//        
//        $('#valida input[type=text],textarea').not('#cantidad').val('');  
//        $('#tipo_igv')[0].selectedIndex = 0;        
//        $('#descripcion').focus();
//    });                                   
// });
    
    // Validacion    
    
    
   (function ($) {
        $.widget("ui.combobox", {
            _create: function () {
                var input,
                  that = this,
                  wasOpen = false,
                  select = this.element.hide(),
                  selected = select.children(":selected"),
                  defaultValue = selected.text() || "",
                  wrapper = this.wrapper = $("<span>")
                    .addClass("ui-combobox")
                    .insertAfter(select);

                function removeIfInvalid(element) {
                    var value = $(element).val(),
                      matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(value) + "$", "i"),
                      valid = false;
                    select.children("option").each(function () {
                        if ($(this).text().match(matcher)) {
                            this.selected = valid = true;
                            return false;
                        }
                    });

                    if (!valid) {
                        // remove invalid value, as it didn't match anything
                        $(element).val(defaultValue);
                        select.val(defaultValue);
                        input.data("ui-autocomplete").term = "";
                    }
                }

                input = $("<input>")
                  .appendTo(wrapper)
                  .val(defaultValue)
                  .attr("title", "")
                  .addClass("ui-state-default ui-combobox-input")
                  .width(select.width())
                  .autocomplete({
                      delay: 0,
                      minLength: 0,
                      autoFocus: true,
                      source: function (request, response) {
                          var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                          response(select.children("option").map(function () {
                              var text = $(this).text();
                              if (this.value && (!request.term || matcher.test(text)))
                                  return {
                                      label: text.replace(
                                        new RegExp(
                                          "(?![^&;]+;)(?!<[^<>]*)(" +
                                          $.ui.autocomplete.escapeRegex(request.term) +
                                          ")(?![^<>]*>)(?![^&;]+;)", "gi"
                                        ), "<strong>$1</strong>"),
                                      value: text,
                                      option: this
                                  };
                          }));
                      },
                      select: function (event, ui) {
                          ui.item.option.selected = true;
                          that._trigger("selected", event, {
                              item: ui.item.option
                          });
                      },
                      change: function (event, ui) {
                          if (!ui.item) {
                              removeIfInvalid(this);
                          }
                      }
                  })
                  .addClass("ui-widget ui-widget-content ui-corner-left");

                input.data("ui-autocomplete")._renderItem = function (ul, item) {
                    return $("<li>")
                      .append("<a>" + item.label + "</a>")
                      .appendTo(ul);
                };

                $("<a>")
                  .attr("tabIndex", -1)
                  .appendTo(wrapper)
                  .button({
                      icons: {
                          primary: "ui-icon-triangle-1-s"
                      },
                      text: false
                  })
                  .removeClass("ui-corner-all")
                  .addClass("ui-corner-right ui-combobox-toggle")
                  .mousedown(function () {
                      wasOpen = input.autocomplete("widget").is(":visible");
                  })
                  .click(function () {
                      input.focus();

                      // close if already visible
                      if (wasOpen) {
                          return;
                      }

                      // pass empty string as value to search for, displaying all results
                      input.autocomplete("search", "");
                  });
            },

            _destroy: function () {
                this.wrapper.remove();
                this.element.show();
            }
        });                 
    })(jQuery);
        
        
    
    function validar_item(){
        var campos = $('#valida input[type=text],textarea').serializeArray();                        
        var mensaje  = "";
        var contador = 0;
        var cmp = '';        
        
        // Campos Vacios                        
        $.each(campos,function(){
            if(this.value === ''){
                mensaje +=  "\n- " + this.name;
                contador++;
                cmp += this.name + '-';
            }                                                
        });  
        cmp = cmp.split('-');        
        $('#'+cmp[0]).focus();
        
        //console.log(contador);
        if (contador > 0){                                                
            alert('Campos Requeridos :'+ mensaje);            
            return contador;
        }                
    }
                
    
    function checkDecimals(fieldName, fieldValue) {
        decallowed = 2; // how many decimals are allowed?

        if (isNaN(fieldValue) || fieldValue == "") {            
            alert("El número no es válido. Prueba de nuevo.");        
            fieldName.select();
            fieldName.focus();        
            return 5;
        }
        else {
        if (fieldValue.indexOf('.') === -1) fieldValue += ".";
            dectext = fieldValue.substring(fieldValue.indexOf('.')+1, fieldValue.length);

        if (dectext.length > decallowed)
        {           
            alert ("Por favor, entra un número con " + decallowed + " números decimales.");        
            fieldName.select();
            fieldName.focus();        
            return 5;        
              }
           }
    }

    function validDecimals(e,str){
        var decallowed = 2; // how many decimals are allowed?
        var valorNum = str.value;

        //alert(str.value);                          
        if (e.shiftKey || e.ctrlKey || e.altKey)           
                e.preventDefault();           
          //alert(event.keyCode);                              
          
           if (e.keyCode === 8 || e.keyCode === 9 || e.keyCode === 110) {    
               
               if (e.keyCode === 110 && isNaN(valorNum+'.')) {            
                    e.preventDefault();
                }                                                
           }
           else {
                if (e.keyCode < 95) {
                  if (e.keyCode < 48 || e.keyCode > 57) {
                        e.preventDefault();
                  }
                  else {
                        if (valorNum.indexOf('.') === -1) valorNum += ".";
                            dectext = valorNum.substring(valorNum.indexOf('.')+1, valorNum.length);                            
                                if (dectext.length >= decallowed){                                                               
                                    e.preventDefault();
                                }                                                            
                  }
                } 
                else {
                      if (e.keyCode < 96 || e.keyCode > 105) {
                          e.preventDefault();
                      }                      
                      else{
                          if (valorNum.indexOf('.') === -1) valorNum += ".";
                            dectext = valorNum.substring(valorNum.indexOf('.')+1, valorNum.length);                            
                                if (dectext.length >= decallowed){                                                               
                                    e.preventDefault();
                                }                                                        
                      }
                }
              }                                                                                
    }    
    
    
    function validNumericos(e){
               
        if (e.shiftKey || e.ctrlKey || e.altKey)           
                e.preventDefault();                   
          
           if (e.keyCode === 8 || e.keyCode === 9) {}                                         
           else {
                if (e.keyCode < 95) {
                  if (e.keyCode < 48 || e.keyCode > 57) {
                        e.preventDefault();
                  }                  
                } 
                else {
                      if (e.keyCode < 96 || e.keyCode > 105) {
                          e.preventDefault();
                      }                                            
                }
              }                                                                                
    }    
    
    
    
  