@extends('adminlte::page')

@section('title', 'Notificaciones ')
@section('post_title', config('app.name'))

@section('content_header')
    <div class="section-header">
        <div>
            <h1>Notificaciones</h1>
        </div> 
    </div>  
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/fontawesome.min.css" integrity="sha512-RvQxwf+3zJuNwl4e0sZjQeX7kUa3o82bDETpgVCH2RiwYSZVDdFJ7N/woNigN/ldyOOoKw8584jM4plQdt8bhA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/brands.min.css" integrity="sha512-+oRH6u1nDGSm3hH8poU85YFIVTdSnS2f+texdPGrURaJh8hzmhMiZrQth6l56P4ZQmxeZzd2DqVEMqQoJ8J89A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/solid.min.css" integrity="sha512-uj2QCZdpo8PSbRGL/g5mXek6HM/APd7k/B5Hx/rkVFPNOxAQMXD+t+bG4Zv8OAdUpydZTU3UHmyjjiHv2Ww0PA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/regular.min.css" integrity="sha512-aNH2ILn88yXgp/1dcFPt2/EkSNc03f9HBFX0rqX3Kw37+vjipi1pK3L9W08TZLhMg4Slk810sPLdJlNIjwygFw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Section content-header */
        .section-header {
            display: flex; 
            justify-content: center; 
            margin-top: .5rem;
        }
        .section-header > div{
            display: flex;
            flex-direction: column;
            justify-content: center;
            flex: 0 0 100%;
            max-width: 83rem;
        }
        @media(min-width:300px) {
            .section-header > div{
                flex-direction: row;
                justify-content: space-between;
                flex: 0 0 98%;
            }
        }
        @media(min-width:450px) {
            .section-header > div{
                flex: 0 0 90%;
            }
        }

        .modal-head {
            display: flex;
            padding: 1rem;
            background-color: #0F62AC;
            /* border-bottom: 1px solid #e9ecef; */
            border-top-left-radius: calc(.3rem - 1px);
            border-top-right-radius: calc(.3rem - 1px);
        }
        .modal-head > h5 {
            margin: 0 auto;
            color: white;
            font-size: 1.5rem;
            line-height: 1.5;
        }
        .modal-head > button {
            margin: -1rem -1rem -1rem -1rem;
            color: white;
            padding: 1rem;
        }
        .modal-bod {
            flex: 1 1 auto;
            padding: 1rem 1rem 0 1rem;
        }
        .modal-foot {
            display: flex;
            justify-content: center;
            padding: 1.4rem 0 1.7rem 0;
        }
        .alert-error {
            color: #fff;
            background: #dc3545;
            border-color: #d32535;
            padding: 1rem 1rem .5rem 1.5rem;
            display: flex;
            justify-content: space-between;
            display: none;
        }
        @media(min-width:760px) {
            .alert-error {
                padding: 2rem 1rem .5rem 3rem;
            }
        }
        .alert-error .print-error-msg h4 {
            font-size: 1.25rem;
        }
        @media(min-width:760px) {
        .alert-error .print-error-msg h4 {
                font-size: 1.5rem;
            }
        }
        .alert-error .print-error-msg ul {
            margin-left: .6rem;
        }
        @media(min-width:760px) {
            .alert-error .print-error-msg ul {
                font-size: 1.1rem;
            }
        }
        .alert-error > button {
            align-self: end;
            margin-top: .5rem;
        }
        @media(min-width:760px) {
        .alert-error > button {
                margin: -.5rem .3rem 0 0;
            }
        }

        .container-fluid {
            padding:0 .2rem;
        }
        .generic-card {
            width: 100%;
            min-width: 21rem;
            max-width: 83rem;
        }
        @media(min-width:450px) {
            .generic-card {
                width: 90%;
                margin-top: 1rem;
            }
        }
        .generic-body {
            flex: 1 1 auto;
        }


        /* DATATABLES */
        .datatables-p {
            display: flex;
            justify-content: center;
            padding: 0 .5rem;
            margin-top: 1rem;
        }
        @media(min-width:750px) {
            .datatables-p {
                margin-top: 2rem;
            }
        }
        .dt-buttons .btn-secondary {
            background-color: #0f62ac;
            border-color: #0f62ac;
        }
        @media(min-width:750px) {
            .dt-buttons .btn-secondary {
                font-size: 1.15rem;
            }
        }
        .datatables-s {
            display: flex;
            flex-direction: column;
        }

        @media(min-width:750px) {
            .datatables-s {        
                margin-top: .5rem;
                margin-bottom: .5rem;
                flex-direction: row;
                justify-content: space-between;
            }
        }

        .datatables-s .datatables-length{
            padding-top: 0.4rem;
        }

        /* PROPIOS VISTA */
        #vble-table_wrapper
        {
            width: 95%;
        }
        div.dataTables_wrapper div.dataTables_paginate ul.pagination
        {
            justify-content: center!important;
            margin-top: 1.5rem!important;
        }

        @media(min-width:400px) {

            .datatables-length{
                display: none!important;
            }

            #fieldset-permisos
            {
                width: 85%;
                margin: 2rem auto;
                max-width: 968px!important;
            }


        }

        @media(min-width:768px) {

            .datatables-length{
                display: flex!important;
            }

            #fieldset-permisos
            {
                width: 90%;
            }  

        }



        /* PROPIOS DE LA VISTA*/
        .dtrg-level-0 > td{
            background-color: #525C66;     
            color: white;
            font-size: 1.1rem;
        }
        .dtrg-level-1 > td{
            background-color: #D6D6D6;
        }

        .thcenter{
            text-align:center;
            vertical-align: inherit!important;
        }

        .table-bord td, .table-bord th {
            border: 1.2px solid #dee2e6;
        }

        /*SCROLLBALL HIDDEN */
        .dataTables_scrollBody {
            -ms-overflow-style: none;  
            scrollbar-width: none; 
        }
        .dataTables_scrollBody::-webkit-scrollbar { 
            display: none;  
        }

    </style> 
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const temporal = {!! json_encode($temporal) !!};
        /*PRESS NAV-LINK BUTTON*/
        $('.nav-link').click(function (){ 
            setTimeout(
                function() {
                    var oTable = $('#data-table').dataTable();
                    oTable.fnAdjustColumnSizing();
                }, 
            350);
        });
        /*PRESS NAV-LINK BUTTON*/

        /* DATATABLES */
        $(document).ready(function(){  
            $("#data-table").DataTable({
                dom: "<'datatables-s'<'datatables-length'f><'datatables-filter'>>" +
                         "<'datatables-t'<'datatables-table'tr>>",
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                processing: true,
                bInfo: true,
                serverSide: true,
                responsive: true,
                scrollX : false,
                paging: false,
                ajax:{                
                    url: "/notification/setting",
                    type: 'GET',
                },
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sSearch": "Buscar:",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast":"Último",
                        "sNext": "<i class='fas fa-angle-right'></i>",
                        "sPrevious": "<i class='fas fa-angle-left'></i>"
                    },
                    "sProcessing":"Procesando...",
                },
                columns: [
                    {data:'module', title:'module', name:'module', orderable: false, visible: false},
                    {data:'module_action', title:'module_action',  name:'module_action', orderable: false, width: "82%"},
                    {data:'whatsapp', title:'<i class="fa-brands fa-whatsapp"></i>', name:'whatsapp', orderable: false, searchable: false, width: "6%"},
                    {data:'email', name:'email', title:'<i class="fa-regular fa-envelope"></i>', orderable: false, searchable: false, width: "6%"},
                    {data:'phone', name:'phone', title:'<i class="fa-solid fa-mobile-screen"></i>', orderable: false, searchable: false, width: "6%"}
                ],
                rowGroup: {
                    dataSrc: 'module',  

                },

                order: [[1, 'asc']]            
            });
            $(".datatables-filter").html('<button type="button" class="btn btn-success" id="form-button">Cargar</button>');
        });
        /* DATATABLES */

        /* CLOSE ALERT */
        $(document).on('click', '#close-alert', function(){       
            $(".alert-error").css('display','none');
        });        
        /* CLOSE ALERT */

        /* ACTION TO CLOSE MODAL */
        $('#modal').on('hidden.bs.modal', function () {
            $("#modal-form").validate().resetForm();
            $(".alert-error").css('display','none');
        });
        /* ACTION TO CLOSE MODAL */

        /* ACTION CLICK SWITCH */
        $(document).on('click', '.switch_channel', function(){         
            if ($(this).is(':checked')) {
                index = temporal.findIndex(x => x.id === $(this).attr('id'));
                if (index ==-1)
                {
                    var ch_mod = ($(this).attr('id')).split('_',2);
                    var data = {
                        id: $(this).attr('id'),
                        channel_id: parseInt(ch_mod[0]),
                        module_action_id: parseInt(ch_mod[1]),
                    }; 
                    temporal.push(data);
                }
            } else {
                index = temporal.findIndex(x => x.id === $(this).attr('id'));
                if (index > -1) {
                    temporal.splice(index, 1);
                } 
            }
            console.log(temporal);
        }); 
        /* ACTION CLICK SWITCH */

        /* ACTION CLICK FORM-BUTTON */
        $(document).on('click', '#form-button', function(){
            $.ajax({
                    url:"{{route('notification.setting.load') }}",
                    method:"POST",
                    data:{
                        user_id: <?php echo auth()->user()->id ?>, 
                        temporal: temporal,
                        _token: $('input[name="_token"]').val()
                    },
                    success:function(data)
                    {  
                        if($.isEmptyObject(data.error)){
                            toastr.options = {
                                closeButton: true,
                                newestOnTop: true,
                                positionClass: 'toast-top-right',
                                preventDuplicates: true,
                                timeOut: '5000'
                            };
                            toastr.success("Preferencias Actualizadas con Exito", "AlliotecCattle");                                                
                        }
                    }
                });
        });
        /* ACTION CLICK FORM-BUTTON */

    </script>
@stop

@section('content')
    <div class="row" style="justify-content: center; overflow:auto;">
        <div class="generic-card">
            <div class="card">
                <div class="generic-body"> 
                <div class="card-body">                        
                        <table style="width:100%" class="table table-striped table-bordered table-hover datatable" id="data-table"></table>
                    </div>                                    
                </div>
            </div>
        </div> 
        @csrf
    </div> 

@stop

