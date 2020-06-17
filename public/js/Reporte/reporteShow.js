reportes = $(document);
reportes.ready(iniciar);

var baseUrl = baseUrl;
var reportID = reportID;

function iniciar() {

    $("#containerReport").hide();

    $("#agregarItem").click(function (){
        $("#containerReport").show();
        limpiar();
        consultaSelectLaboratorios();
    });

    $("#cancelar").click(function (){
        limpiar();
        $("#containerReport").hide();
    });


    $('#datetimepicker3').datetimepicker({
        format: "HH:mm"
    });

    $('#datetimepicker4').datetimepicker({
        format: "HH:mm"
    });

    $('#demoDate1').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    }).on('changeDate', function () {
        minDate = $("#demoDate1").val();
    });

    $('#demoDate2').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    }).on('changeDate', function () {
        minDate = $("#demoDate2").val();
    });

    $("#demeDateTrigger2").click(function() {
        $('#demoDate2').datepicker('show');
    });

    $("#demeDateTrigger1").click(function() {
        $('#demoDate1').datepicker('show');
    });

    $("#selectLaboratory").on('change', function () {
        laboratorio = $("#selectLaboratory option:selected").val();
        consultaSelectItems(laboratorio);
    });

    $("#guardar").click(function () {
        registrarEvento();
    });

}

function registrarEvento(){
    item = $("#selectItem option:selected").val();
    fechaInicio = $("#demoDate1").val();
    fechaFinal = $("#demoDate2").val();
    horaInicio = $('#horaInicio').val();
    horaFinal = $('#horaFinal').val();
    csrfToken = $('#token').val();

    dateStart = fechaInicio + " " + horaInicio;
    dateEnd = fechaFinal + " " + horaFinal;

    console.log(dateStart,dateEnd,reportID,item,csrfToken);

    $.ajax({
        type: "POST",
        crossDomain: true,
        data: {'dateStart':dateStart, 'dateEnd':dateEnd, 'report_id':reportID, 'item_id':item},
        url: baseUrl + '/panel/schedularies',
        headers:{ 'X-CSRF-TOKEN':csrfToken},
        error: function(data) {},
        beforeSend: function() {},
        success:function(data){
            console.log(data)
        }
    }).done(function (data){
        console.log(data);
    });
}

function limpiar(){
    $("#selectLaboratory")[0].selectedIndex  = 0;
    $("#selectItem")[0].selectedIndex  = 0;
    $("#demoDate1").val("");
    $("#demoDate2").val("");
    $('#datetimepicker3').datetimepicker('clear');
    $("#datetimepicker4").datetimepicker('clear');
}
function consultaSelectLaboratorios(){
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: baseUrl + '/api/laboratories?institution_id=1',
        error: function() {},
        beforeSend: function() {},
    }).done(function (dato){
        fillSelectLaboratorios(dato);
    });
}
function fillSelectLaboratorios(laboratorios){
    var html = "<option disabled selected>Selecciona laboratorio</option>";
    if(laboratorios.length > 0){
        $(laboratorios).each(function(i,val){
            html += '<option value=' + val.id + '>'+val.name+'</option>';
        });
        $('#selectLaboratory').html(html);
    }else{
        addAlert("¡No hay laboratorios registrados en la universdad!",4)
    }
}

function consultaSelectItems(laboratorio){
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: baseUrl + '/panel/itemsapi?laboratory_id='+laboratorio,
        error: function() {},
        beforeSend: function() {},
    }).done(function (dato){
        fillSelectItems(dato);
    });
}
function fillSelectItems(items){
    var html = "<option disabled selected>Selecciona Item</option>";
    if(items.length > 0){
        $(items).each(function(i,val){
            html += '<option value=' + val.id + '>'+val.name+'</option>';
        });
        $('#selectItem').html(html);
    }else{
        addAlert("¡No hay items registrados en el laboratorio!",4)
    }

}
function addAlert(message,tipo=3) {
    var html=""
    switch(tipo){
        case 1: //success
            html += '<div class="alert alert-success" role="alert"">' +
            '<h4>¡Alerta!</h4>'+
            '<button type="button" class="close" data-dismiss="alert">' +
            '&times;</button>' + message + '</div>';
        break;
        case 2: //Info
            html += '<div class="alert alert-info" role="alert"">' +
                '<h4>¡Alerta!</h4>'+
                '<button type="button" class="close" data-dismiss="alert">' +
                '&times;</button>' + message + '</div>';
        break;
        case 3: // warning
            html += '<div class="alert alert-warning" role="alert"">' +
            '<h4>¡Alerta!</h4>'+
            '<button type="button" class="close" data-dismiss="alert">' +
            '&times;</button>' + message + '</div>';
        break;
        case 4: // Error
            html += '<div class="alert alert-danger" role="alert"">' +
            '<h4>¡Alerta!</h4>'+
            '<button type="button" class="close" data-dismiss="alert">' +
            '&times;</button>' + message + '</div>';
        break;
    }

    $('#alerts').append(html);
}
