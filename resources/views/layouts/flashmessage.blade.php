@if(session()->has('message'))
    <div class="notification {{session()->get('type')}}">
        <a class="delete"></a>
        {{session()->get('message')}}
    </div>
@endif

@if($errors->any())
    <div class="notification is-danger">
        <a class="delete"></a>
        @foreach($errors->all() as $error)
            <p style="color: #fff">- {{$error}}</p>
        @endforeach
    </div>
@endif

@push('js')
    <script>
        $(document).ready(function(){
            $(document).on('click', '.delete', function(){
                console.log('ok');
                $('.delete').parent('.notification').hide();
            });
        })
    </script>
@endpush
