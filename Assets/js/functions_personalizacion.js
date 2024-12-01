let tableSliders;
let tableNews;
document.addEventListener('DOMContentLoaded', function(){
    tableNews = $('#tableNews').DataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        "ajax":{
            "url": " "+base_url+"/Personalizacion/getNews",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_post"},
            {"data":"titulo"},
            {"data":"descripcion"},
            {"data":"fecha_post"},
            {"data":"options"}
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

    tableSliders = $('#tableSliders').DataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        "ajax":{
            "url": " "+base_url+"/Personalizacion/getSliders",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_slider"},
            {"data":"img_slider"},            
            {"data":"options"}
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

})