@extends('adminlte::page')

@section('title', 'Notificaciones ')
@section('post_title', config('app.name'))

@section('content_header')
    <div class="section-header">
        <div class="row">
            <h1 class="mr-3">Notificaciones</h1>
            <div class="btn-group btn-group-toggle filter_notification" data-toggle="buttons">
                <label class="btn btn-secondary">
                    <input type="radio" name="options" id="option_all" autocomplete="off" checked> Todas
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="options" id="option_notread" autocomplete="off"> No Leidas
                </label>
            </div>
        </div> 
    </div>  
@stop

@section('css')
    
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var type = 0;
        $(document).ready(function(){  
            $.get('dashboard/'+moment().utcOffset()+'/getnotifications/'+type, function(data){
                $(".timeline").html(data); 
            })
        });

        /* READMORE BUTTON */
        $(document).on('click', '.readmore', function(){ 
            var notification_id=$(this).data('id');
            var url = '{{ route("notification.dashboard.readmore", ":notification_id" )}}';
            url = url.replace(':notification_id', notification_id);
            $.get(url, function(data){
                location.reload();
            })
        });      
        /* READMORE BUTTON */
    

        /* DELETE BUTTON */  
        $(document).on('click', '.delete', function() {
            var notification_id=$(this).data('id');
            var url = '{{ route("notification.dashboard.delete", ":notification_id" )}}';
            url = url.replace(':notification_id', notification_id);
            const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: true
            })

            swalWithBootstrapButtons.fire({
            title: 'Estas seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: 'delete',
                    data:{_token: $('input[name="_token"]').val()},
                    success: function () { 
                        $.get('dashboard/'+moment().utcOffset()+'/getnotifications/'+type, function(data){
                            $(".timeline").html(data);                             
                            swalWithBootstrapButtons.fire(
                                'Borrado!',
                                'La notificacion fue eliminada con exito.',
                                'success'
                            )
                        })
                    },
                    error: function (data){
                        swalWithBootstrapButtons.fire(
                            'Error!',
                            'El registro no puede ser borrado! Hay recursos usandolo.',
                            'warning'
                        )
                    }
                });
               
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'Tu registro esta a salvo :)',
                    'error'
                )
            }
            })


        });
        /* DELETE BUTTON */

        /* READMORE BUTTON */

        /* NOTIFICATION FILTER */
        $('#option_all').click(function(){
            type = 0; //0 = todas
            console.log('todas');
            $.get('dashboard/'+moment().utcOffset()+'/getnotifications/'+type, function(data){
                $(".timeline").html(data);                
            });
        });

        $('#option_notread').click(function(){
            console.log("no leidas");
            type = 1; //0 = no leidas
            $.get('dashboard/'+moment().utcOffset()+'/getnotifications/'+type, function(data){
                $(".timeline").html(data);                
            });
        });
        /* NOTIFICATION FILTER */



    </script>
@stop

@section('content')

<section class="content">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="timeline"></div>
        </div>

    </div>
</div>
</section>
@stop

