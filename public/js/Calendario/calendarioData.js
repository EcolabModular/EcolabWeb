var calendarios = $(document);
var baseUrl = baseUrl;
var eventos = [];
var today = "";
var filterDay = "";
var universidad = "";
var laboratorio = "";
var itemsLaboratorio = [];
var schedulariesLab = [];
var calendariosLab = []; // CALENDARIOS DE ITEMS DE LABORATORIO ESPECIFICO
var schedularies = [];
var schedulariesFilter = [];
var schedulariesTipoReporteFilter = [];

var schedulariesEstatusFilter = [];

calendarios.ready(iniciarCalendario);

function iniciarCalendario() {
    $("#containerItem").hide();
    $("#containerReport").hide();
    $("#containerNote").hide();

    consultaSelectUniversidades();

    $('#demoDate1').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
      	todayHighlight: true
    }).on('changeDate',function(){
        minDate = $("#demoDate1").val();
        filterByfecha(minDate);
        $("#selectFilterTipo")[0].selectedIndex  = 0;
        $("#selectFilterEstatus")[0].selectedIndex  = 0;
    });

    $("#selectFilterEstatus").on('change',function(){
        estatus = $("#selectFilterEstatus option:selected").val();
        filterByTipoEstatus(estatus);
        filterByEstatus();
        $("#selectFilterTipo")[0].selectedIndex  = 0;
        $("#demoDate1").val("");
    });

    $("#selectFilterTipo").on('change',function(){
        tipo = $("#selectFilterTipo option:selected").val();
        filterByTipoReporte(tipo);
        filterByReporte(tipo);
        $("#selectFilterEstatus")[0].selectedIndex  = 0;
        $("#demoDate1").val("");
    });

    $("#selectFilterUniversidad").on('change',function(){

        universidad = $("#selectFilterUniversidad option:selected").val();
        universidadActual = $("#selectFilterUniversidad option:selected").text();
        $("#universidadActual").text(universidadActual);
        consultaSelectLaboratorios(universidad);
    });

    $("#selectFilterLab").on('change',function(){
        $("#selectFilterTipo")[0].selectedIndex  = 0;
        $("#selectFilterEstatus")[0].selectedIndex  = 0;
        $("#selectFilterItem")[0].selectedIndex  = 0;
        $("#demoDate1").val("");

        laboratorio = $("#selectFilterLab option:selected").val();
        consultaSelectItems(laboratorio);
    });

    $("#selectFilterItem").on('change',function(){
        $("#selectFilterTipo")[0].selectedIndex  = 0;
        $("#selectFilterEstatus")[0].selectedIndex  = 0;
        $("#demoDate1").val("");
        item = $("#selectFilterItem option:selected").val();
        schedulariesLab = [];
        getItemSchedulary(item);
        parseSchedulary(schedulariesLab);
    });

    loadSchedularies();
}
function filterByReporte(tipo){
    console.log("FilterByReporte",schedulariesFilter)
    makeevents(getArrayMatches(schedulariesFilter,schedulariesTipoReporteFilter),true)

}
function filterByfecha(fecha){
    $("#overlayLoadingTotal").show();
    var filtrado = schedulariesFilter.filter(item => item.dateStart.indexOf(fecha) > -1);
    makeevents(filtrado,true);
}
function filterByEstatus(){
    console.log("FilterByEstatus",schedulariesFilter)
    makeevents(getArrayMatches(schedulariesFilter,schedulariesEstatusFilter),true)

}
function filterByItemsLaboratorio(){
    schedulariesLab = [];
    $(itemsLaboratorio).each(function (index,val){
        getItemSchedulary(val.id);
    });
    parseSchedulary(schedulariesLab); // CONVIERTE EL CALENDARIO(ARRAY OF ARRAYS) A UN SOLO ARRAY DE RESULTADO
}
function getItemSchedulary(item){
    $.ajax({
        type: "GET",
        dataType: 'json',
        async:false,
        url: baseUrl + '/panel/itemschedularies/'+item,
        beforeSend: function (){
            $("#overlayLoading").show();
            $("#overlayLoadingTotal").show();
        },
    }).done(function (data){
        schedulariesLab.push(data);
    });
}
function parseSchedulary(schedulary) {
    schedulariesFilter = [];
    $(schedulary).each(function (i,e){
        $(e).each(function (key,val){
            schedulariesFilter.push(val);
        });
    });
    console.log("Filter",schedulariesFilter)
    makeevents(schedulariesFilter,true);
}
function filterByTipoEstatus(estatus){
    reports = [];
    schedulariesEstatusFilter = [];
    if(estatus != ""){
        $.ajax({
            type: "GET",
            dataType: 'json',
            async: false,
            url: baseUrl + '/api/reports?status='+estatus+'&per_page=1000',
            beforeSend: function (){
                $("#overlayLoading").show();
                $("#overlayLoadingTotal").show();
            },
        }).done(function(data) {
            reports = data;

            $.ajax({
                type: "GET",
                url: baseUrl+'/api/schedularies',
                dataType: 'json',
                async: false,
                beforeSend: function (){
                    $("#overlayLoading").show();
                    $("#overlayLoadingTotal").show();
                },
            }).done(function(data) {
                schedularies = data;
                $(reports).each(function(idr,report){
                    $(schedularies).each(function (ids,schedule){
                        if(schedule.report_id == report.id){
                            schedulariesEstatusFilter.push(schedule);
                        }
                    });
                });
            });
        });
    }
}
function filterByTipoReporte(tipo){
    reports = [];
    schedulariesTipoReporteFilter = [];
    if(tipo != ""){
        $.ajax({
            type: "GET",
            dataType: 'json',
            async: false,
            beforeSend: function (){
                $("#overlayLoadingTotal").show();
                $("#overlayLoading").show();

            },
            url: baseUrl + '/api/reports?reportType_id='+tipo+'&per_page=1000',
        }).done(function(data) {
            reports = data;
            $.ajax({
                type: "GET",
                url: baseUrl+'/api/schedularies',
                async: false,
                dataType: 'json',
                beforeSend: function (){
                    $("#overlayLoadingTotal").show();
                    $("#overlayLoading").show();
                },
            }).done(function(data) {
                schedularies = data;
                $(reports).each(function(idr,report){
                    $(schedularies).each(function (ids,schedule){
                        if(schedule.report_id == report.id){
                            schedulariesTipoReporteFilter.push(schedule);
                        }
                    });
                });
            });
        });
    }
}
function loadSchedularies(filter = "") {
    reload = false;
    if(filter != ""){
        reload = true;
    }
    $.ajax({
        type: "GET",
        url: baseUrl+'/api/schedularies'+filter,
        dataType: 'json',
        beforeSend: function (){
            $("#overlayLoading").show();
            $("#overlayLoadingTotal").show();
        },
    }).done(function(data) {
        schedulariesFilter = data;
        makeevents(schedulariesFilter,reload);
    });
}
function makeevents(schedularies,reload){
    evento = {};
    eventos = [];

    $(schedularies).each(function(i,val) {
        c = '#'+Math.floor(Math.random()*16777215).toString(16);
        evento = {
            title: 'Reporte ' + val.report_id,
            start:val.dateStart,
            end:val.dateEnd,
            color:c,
            item:val.item_id,
            report:val.report_id
        }
        eventos.push(evento);
    });
    if(eventos.length > 0){

        $("#total").text(eventos.length).css("color", "red");

        today = schedularies[0].dateStart;
        JSON.stringify(eventos);

        if(reload){
            $('#calendar').fullCalendar('removeEventSources');
            $('#calendar').fullCalendar('addEventSource', eventos);
            $('#calendar').fullCalendar('gotoDate', today);
            $("#overlayLoading").hide();
            $("#overlayLoadingTotal").hide();
        }else{
            loadCalendar();
            $("#overlayLoading").hide();
            $("#overlayLoadingTotal").hide();
        }

    }else{
        $("#total").text(0).css("color", "red");
        addAlert("No hay eventos");
        $("#overlayLoading").hide();
        $("#overlayLoadingTotal").hide();
    }
}
function loadCalendar(){
    $('#calendar').fullCalendar({
        eventClick: function(eventObj) {

            showItemInfo(eventObj.item,eventObj.color);
            showReportInfo(eventObj.report,eventObj.start,eventObj.end,eventObj.color);
            showNotesItem(eventObj.item);
            $("#containerReport").show();
            $("#containerItem").show();
            $("#containerNote").show();
        },
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultView: 'agendaWeek',
        defaultDate: today,
        events:eventos
    })
}
function showItemInfo(item,color){
    $("#overlayLoading1").show();
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: baseUrl + '/api/items?id='+item,
    }).done(function(data) {
        $('#itemTitle').text(data[0]["name"]);
        $('#itemTitle').css("color",color);
        $('#itemTable tbody').html(fillTableItem(data));
        $("#overlayLoading1").hide();
    });
}
function showNotesItem(item){
    $("#overlayLoading3").show();
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: baseUrl + '/api/notes?item_id='+item,
    }).done(function(data) {
        $('#noteTable tbody').html(fillTableItemNotes(data));
        $("#overlayLoading3").hide();
    });
}
function showReportInfo(report,inicio,fin,color){
    $("#overlayLoading2").show();
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: baseUrl + '/api/reports?id='+report,
    }).done(function(data) {
        $('#reportTitle').text(data[0]["name"]);
        $('#reportTitle').css("color",color);
        $('#reportTable tbody').html(fillTableReport(data,inicio,fin));
        $("#overlayLoading2").hide();
    });
}
function fillTableItem(item){
    var html="";
    html +=
    "<tr><td>"+'<a class="btn btn-sm btn-primary" href="'+baseUrl+'/panel/items/'+item[0]['id']+'">'+item[0]['id']+'</a>'+ "</td>"+
    "<td>"+item[0]['description']+"</td>" +
    "<td>"+'<a class="btn btn-sm btn-primary" href="'+baseUrl+'/panel/laboratories/'+item[0]['laboratory_id']+'">'+item[0]['laboratory_id']+'</a>'+ "</td></tr>";
    return html;
}
function fillTableItemNotes(notes){
    var html="";
    $.each(notes,function(index,val){
        html +=
        "<tr><td>"+'<a class="btn btn-sm btn-primary" href="'+baseUrl+'/panel/notes/'+val['id']+'">'+val['id']+'</a>'+ "</td>"+
        "<td>"+val['name']+"</td>"+
        "<td>"+val['description']+"</td></tr>";
    })

    return html;
}
function fillTableReport(report,inicio,fin){
    var html="";
    html +=
    "<tr><td>"+'<a class="btn btn-sm btn-primary" href="'+baseUrl+'/panel/reports/'+report[0]['id']+'">'+report[0]['id']+'</a>'+ "</td>"+
        "<td>"+report[0]['description']+"</td>"+
        "<td>"+report[0]['tipo']+"</td>"+
        "<td>"+report[0]['status']+"</td>"+
        "<td>"+inicio.toISOString()+"</td>"+
        "<td>"+fin.toISOString()+"</td>"+
    "</tr>";
    return html;
}
function consultaSelectUniversidades(){
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: baseUrl + '/api/institutions',
        error: function() {},
        beforeSend: function() {},
    }).done(function (dato){
        fillSelectUniversidades(dato);
    });
}
function fillSelectUniversidades(institutos){
    var html = "<option disabled selected>Selecciona universidad</option>";
    $(institutos).each(function(i,val){
        html += '<option value=' + val.id + '>'+val.name+'</option>';
    });
    $('#selectFilterUniversidad').html(html);
}
function consultaSelectLaboratorios(){
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: baseUrl + '/api/laboratories?institution_id='+universidad,
        error: function() {},
        beforeSend: function() {},
    }).done(function (dato){
        fillSelectLaboratorios(dato);
    });
}
function fillSelectLaboratorios(laboratorios){
    var html = "<option disabled selected>Selecciona laboratorio</option>";
    if(laboratorios.length > 0){

        $("#selectFilterTipo")[0].selectedIndex  = 0;
        $("#selectFilterEstatus")[0].selectedIndex  = 0;
        $("#selectFilterItem")[0].selectedIndex  = 0;
        $("#selectFilterLab")[0].selectedIndex  = 0;
        $("#demoDate1").val("");

        $(laboratorios).each(function(i,val){
            html += '<option value=' + val.id + '>'+val.name+'</option>';
        });
        $('#selectFilterLab').html(html);
    }else{
        addAlert("¡No hay laboratorios registrados en la universdad!",4)
    }

}
function consultaSelectItems(laboratorio){
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: baseUrl + '/api/items?laboratory_id='+laboratorio,
        error: function() {},
        beforeSend: function() {},
    }).done(function (dato){
        itemsLaboratorio = dato;
        fillSelectItems(itemsLaboratorio);
        filterByItemsLaboratorio(); // LLENADO DE ACTIVIDADES POR ITEMS DE LABORATORIO
    });
}
function fillSelectItems(items){
    var html = "<option disabled selected>Selecciona Item</option>";
    if(items.length > 0){
        $(items).each(function(i,val){
            html += '<option value=' + val.id + '>'+val.name+'</option>';
        });
        $('#selectFilterItem').html(html);
    }else{
        addAlert("¡No hay laboratorios registrados en la universdad!",4)
    }

}
function getArrayMatches(arr1,arr2){
    var matches = [];

    $(arr2).each(function(idr,scheduleGlobal){
        $(arr1).each(function (ids,schedule){
            if(schedule.id == scheduleGlobal.id){
                matches.push(schedule);
            }
        });
    });

    return matches;
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
