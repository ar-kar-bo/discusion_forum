@if ($errors->any)
@foreach ($errors as $e)
    <script>
        toastr.error("{{$e}}")
    </script>
@endforeach
@endif


@if (session()->has('success'))
<script>
    toastr.success("{{session()->get('success')}}")
</script>
@endif


@if (session()->has('warning'))
<script>
    toastr.warning("{{session()->get('warning')}}")
</script>
@endif



