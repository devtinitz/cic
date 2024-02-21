<div class="profile-header has-text-centered">
                @include('parts.profilecompanyfooter')
            </div>

        </div>
    </div>
</div>
        </div>
    </div>
</div>

<!--GTCI Scripts-->
<!--Load Mapbox-->

<!-- Concatenated plugins -->
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>--}}
{{--<script src="js/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>--}}
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>--}}

<script src="{{asset('/js/jquery-3.2.1.slim.min.js')}}" crossorigin="anonymous"></script>
<script src="{{asset('/js/popper.min.js')}}" crossorigin="anonymous"></script>
<script src="{{asset('/js/bootstrap.min.js')}}"></script>


<script src="{{asset('/js/app.js')}}"></script>
<script src="{{asset('/js/wizard-v1.js')}}"></script>
<!-- GTCI js -->
<script src="{{asset('/js/functions.js')}}"></script>
<script src="{{asset('/js/main.js')}}" async></script>
<script src="{{asset('/js/components.js')}}" async></script>
<script src="{{asset('/js/popover.js')}}" async></script>
<script src="{{asset('/js/widgets.js')}}" async></script>

<!-- Additional Features -->
<script src="{{asset('/js/touch.js')}}" async></script>

<script src="{{asset('/js/syntax.js')}}" async></script>

<!--<script src="{{asset('/js/datatables.js')}}" async></script>-->

{{--<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>--}}
{{--<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bulma.min.js"></script>--}}
{{--<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>--}}
{{--<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.bulma.min.js"></script>--}}
{{--<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>--}}
{{--<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>--}}
{{--<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>--}}
{{--<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>--}}
{{--<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>--}}
{{--<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.colVis.min.js"></script>--}}

<script type="text/javascript" language="javascript" src="{{asset('/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{asset('/js/dataTables.bulma.min.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{asset('/js/dataTables.buttons.min.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{asset('/js/buttons.bulma.min.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{asset('/js/jszip.min.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{asset('/js/pdfmake.min.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{asset('/js/vfs_fonts.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{asset('/js/buttons.html5.min.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{asset('/js/buttons.print.min.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{asset('/js/buttons.colVis.min.js')}}"></script>

<script src="{{asset('/js/selectize.min.js')}}"></script>
<script src="{{asset('/js/select2.min.js')}}"></script>
<script src="{{asset('/js/jquery.inputmask.bundle.js')}}" async></script>
<script src="{{asset('/js/chart.js')}}"></script>
@stack('scripts')
    <script>
        function soumettrecomplement(action) {
            $('#'+action).click();
        }
    </script>
    <script>
        $(document).ready(function(){
            $(document).on('click', '.h-modal-close.ml-auto', function(e){
                e.preventDefault();
                $('.modal').removeClass('is-active');
            })

            $('.select-pays').select2();
        });

        $(function () {
            $(".conteneur").inputmask("AAAA-999999-9");
        });

        jQuery(function ($) {
            $(".conteneur").inputmask("AAAA-999999-9");
        });

    </script>

    <script>
        $(document).ready(function(){
            $(document).on('change', '.select-departement', function(){
                const url = "{{ route('getServiceDepartement') }}";
                const id = {id : $("option:selected", $(this)).val()};
                //$(".select-service").empty();

                fetch(url, {
                    method: 'POST',
                    body: JSON.stringify(id),
                    headers: {
                        'X-CSRF-TOKEN' : document.querySelector('input[name=_token]').value,
                        'Content-type' : 'application/json',
                        'Accept' : 'application/json'
                    }
                })
                .then(response => response.json())
                .then(function(data){
                    const services = data.services
                    if (services.length > 0){
                        let selectService = $(".select-service").empty();
                        $('<option>', {
                            value : '',
                            text : 'Selectionnez un service'
                        }).appendTo(selectService)

                        $.each(services, function (i, service) {
                            $('<option>', {
                                value : service.id,
                                text : service.libelle
                            }).appendTo(selectService)
                        })
                    }
                })
                .catch(error => console.log(error));
            })
        })
    </script>

@stack('thesescripts')
</div>
{{--<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>--}}
{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>--}}
@stack('js')
</body>
</html>
