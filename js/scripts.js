
window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

function open_modal(){
    $("#modal_upload").modal();
}

function validate_(){
    if(($("#tally_facility").val().replace(/ +/g, "")) != ""){
        $("#upload_files").prop("disabled", false);
    }else{
        $("#upload_files").prop("disabled", true);
    }
}

function upload_data(){
    var file = $(".file");
    file.trigger('click');
}

$(document).on('change', '.file', function(){
    //$(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
    prepareUpload(event);
});

function prepareUpload(event){
    files = event.target.files;
    uploadFiles(event);
}

function uploadFiles(event) {
    event.stopPropagation();
    event.preventDefault();
    var data = new FormData();
    $.each(files, function(key, value){
        data.append(key, value);
    });
    $("#modal_upload .close").click()
    $("#loader_shit").html("<h1><i class=\"fa fa-spinner fa-spin\"></i></h1>");
    $.ajax({
        url: 'php/upload.php?files&filen='+$("#tally_facility").val(),
        type: 'POST',
        data: data,
        cache: false,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        success: function(data){
            if($.fn.DataTable.isDataTable('#datatablesSimple')){
                $('#datatablesSimple').DataTable().destroy();
            }
            $("table#datatablesSimple").html(data["table"]);
            $(document).prop('title', 'Tally Sheet - '+data["filename"]);
            $("#hf_name").html(data["filename"]);
            create_datatable();
        }
    });
}

function create_datatable(){
    $('#datatablesSimple').DataTable( {
        destroy: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
}

function get_tally_sheets(){
    $.ajax({
        url: "php/reports.php",
        type: "POST",
        data: {call_func: "get_tally_sheets"},
        success: function(data){
            $("#select_tally").html(data);
        }
    });
}

$("#select_tally").change(function(){
    $("#loader_shit").html("<h1><i class=\"fa fa-spinner fa-spin\"></i></h1>");
    $.ajax({
        type: "POST",
        url: "php/reports.php",
        data: {call_func: "get_tally",
                filen: $("#select_tally option:selected").text()
            },
        dataType: "JSON",
        success: function(data){
            if($.fn.DataTable.isDataTable('#datatablesSimple')){
                $('#datatablesSimple').DataTable().destroy();
            }
            $("table#datatablesSimple").html(data["table"]);
            $(document).prop('title', 'Tally Sheet - '+data["filename"]);
            $("#hf_name").html(data["filename"]);
            create_datatable();
        }
    });
});