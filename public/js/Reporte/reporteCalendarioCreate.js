reportes = $(document);
reportes.ready(iniciar);

var baseUrl = baseUrl;
var baseUrlGate;
var currentPage = 1;
var pageSize = 5;
var totalCount = 0;
var totalPage = 0;
var tipo = "";
var per_page = 1000;
var reporteID = 0;
var reports = [];

function iniciar()
{

    baseUrlGate = $("#baseUrlGate").val();

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
    });

    $('#demoDate2').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });

    $("#demeDateTrigger2").click(function() {
        $('#demoDate2').datepicker('show');
    });

    $("#demeDateTrigger1").click(function() {
        $('#demoDate1').datepicker('show');
    });

    limpiar();

    $("#selectLaboratory").on('change', function () {
        laboratorio = $("#selectLaboratory option:selected").val();
        consultaSelectItems(laboratorio);
    });

    $("#selectFilterTipo").on('change',function(){
        tipo = $("#selectFilterTipo option:selected").val();
        currentPage = 1;
        $("#inputSearch").val("");
        filterByTipoReporte(tipo);
        getPaging(1);
        fillPagination(totalPage);
    });

    $("#registrarActividad").click(function () {
        registrarActividad();
    });

    $("#cancelarReporte").click(function (){
        reporteID = 0;
        $("#containerReport").show();
        $("#idSelectReporte").show();
        $("#cancelarReporte").hide();
        $("#reporteActual").text("NO SELECCIONADO").css('color','black');
    });

    $(document).on('keypress',function(e) {
        if(e.which == 13) {
            nombre = $("#inputSearch").val()
            filterByName(nombre);
        }
    });
}

function filterByName(nombre){

    var filtrado = reports.filter(item => item.name.indexOf(nombre) > -1);
    fillTableReport(filtrado);
}

function registrarActividad(){

    item = $("#selectItem option:selected").val();
    fechaInicio = $("#demoDate1").val();
    fechaFinal = $("#demoDate2").val();
    horaInicio = $('#horaInicio').val();
    horaFinal = $('#horaFinal').val();

    token = $('#tokenUser').val();
    dateStart = fechaInicio + " " + horaInicio;
    dateEnd = fechaFinal + " " + horaFinal;

    $.ajax({
        url: baseUrlGate+'/schedularies',
        type: "POST",
        headers:{'Authorization': token},
        data: {'dateStart':dateStart, 'dateEnd':dateEnd, 'report_id':reporteID, 'item_id':item},
        beforeSend: function (){},
        error: function (data){
            console.log(data.responseText);
            if(data.responseText != ""){
                addAlert(data.responseText,4);
            }
        },
        success: function (data){}
    }).done(function (data){
        if(data != null){
            addAlert("Creado Correctamente",1);
            $("#containerReport").show();
            $("#idSelectReporte").show();
            $("#reporteActual").text("NO SELECCIONADO").css('color','black');
            $("#overlayLoading2").show();
            limpiar();
        }
    });

}
function limpiar(){
    $('#reportTable tbody').html("");
    $("#selectLaboratory")[0].selectedIndex  = 0;
    $("#selectFilterTipo")[0].selectedIndex = 0;
    $("#selectItem").val("");
    $("#demoDate1").val("");
    $("#demoDate2").val("");
    $('#datetimepicker3').datetimepicker('clear');
    $("#datetimepicker4").datetimepicker('clear');
    $("#cancelarReporte").hide();
    $("#inputSearch").val("");
    currentPage = 1;
    pageSize = 5;
    totalCount = 0;
    totalPage = 0;
    tipo = "";
    per_page = 1000;
    reporteID = 0;
    reports = [];
    fillPagination(totalPage)

}
function seleccionarReporte(idReporte,reporte){

    reporteID = idReporte;

    $("#containerReport").hide();
    $("#idSelectReporte").hide();
    $("#reporteActual").text(reporte).css('color','red');
    $("#cancelarReporte").show();

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
        addAlert("¡No hay items registrados en la universdad!",4)
    }

}
function filterByTipoReporte(tipo){
    if(tipo != ""){
        $.ajax({
            type: "GET",
            dataType: 'json',
            async: false,
            beforeSend: function (){
                $("#overlayLoading2").show();
            },
            url: baseUrl + '/api/reports?reportType_id='+tipo+'&per_page='+per_page,
        }).done(function(data) {
            reports = data;
            totalCount = data.length;
            totalPage = Math.ceil(totalCount / pageSize);
        });
    }
}
function fillTableReport(reportes){
    var html="";
    $.each(reportes,function(index,report){
        html +=
            "<tr><td>"+'<a class="btn btn-sm btn-primary" href="'+baseUrl+'/panel/reports/'+report['id']+'">'+report['id']+'</a>'+ "</td>"+
                "<td>"+report['name']+"</td>"+
                "<td>"+report['description']+"</td>"+
                "<td>"+report['tipo']+"</td>"+
                "<td>"+report['status']+"</td>"+
                "<td>"+report['created_at']+"</td>"+
                "<td>"+'<a onclick="seleccionarReporte(\''+report['id']+'\','+'\''+report['name']+'\')" href="#" class="btn btn-sm btn-success"</a>AGREGAR'+"</td>"+
            "</tr>";
    });
    $('#reportTable tbody').html(html);
    $("#overlayLoading2").hide();
    $("#"+currentPage).addClass('active');
}
function fillPagination(pages){
    var html = "";
    for (var i = 1; i <= pages; i++) {
        html += '<li onclick="getPaging(this.id)" id="'+i+'" class="paginate_button page-item"><a href="#" aria-controls="sampleTable" data-dt-idx="1" tabindex="0" class="page-link">'+i+'</a></li>';
    }
    $("#pagination").html(html);
    $("#"+currentPage).addClass('active');
}
function getPaging(page){
    $("#"+currentPage).removeClass('active');
    currentPage =  page;
    $.ajax({
        type: "GET",
        dataType: 'json',
        async: false,
        beforeSend: function (){
            $("#overlayLoading2").show();
        },
        url: baseUrl + '/api/reports?reportType_id='+tipo+'&per_page='+pageSize+'&page='+currentPage,
    }).done(function(data) {
        fillTableReport(data);
    });

}
function addAlert(message,tipo=3) {
    var html=""
    switch(tipo){
        case 1: //success
            html += '<div class="alert alert-success" role="alert"">' +
            '<h4>¡Satisfactorio!</h4>'+
            '<button type="button" class="close" data-dismiss="alert">' +
            '&times;</button>' + message + '</div>';
        break;
        case 2: //Info
            html += '<div class="alert alert-info" role="alert"">' +
                '<h4>¡Error!</h4>'+
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
