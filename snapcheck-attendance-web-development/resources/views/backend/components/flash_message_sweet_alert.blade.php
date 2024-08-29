<!--begin::Alert-->
@if($message = Session::get('success'))
    {{--Alert sucess--}}
    <script>
        Swal.fire({
            text: "{{ $message }}",
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: 'Okay, got it!!',
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
    </script>
@endif
{{--Alert failed--}}
@if($message = Session::get('error'))
    <script>
        Swal.fire({
            icon: 'error',
            text: "{{ $message }}",
            iconColor: '#d33',
            confirmButtonText: 'Okay, got it!!',
            confirmButtonColor: '#70757E',
        })
    </script>
@endif
<!--end::Alert-->
