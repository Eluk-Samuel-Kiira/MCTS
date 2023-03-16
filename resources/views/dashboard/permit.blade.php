@if(auth()->user()->role==1 || auth()->user()->status==0)
    <script>
        window.location.href = "{{route('devices')}}";
    </script>
@endif