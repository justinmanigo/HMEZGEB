    <div id="toast-container" class="toast-container position-fixed bottom-0 start-0 p-3"></div>

    <!-- Custom scripts for all pages-->
    @if (App::environment(['local']))
        <script src="{{URL::asset('js/sb-admin-2.min.js')}}"></script>
    @else
        <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/js/sb-admin-2.min.js"></script>
    @endif

    <!-- Page level custom scripts -->
    <script src="{{URL::asset('js/demo/datatables-demo.js')}}"></script>

    <!-- Page level plugins -->

    {{-- The following script allows nested modals. --}}
    <script>
        $(document).on('show.bs.modal', '.modal', function() {
            const zIndex = 1040 + 10 * $('.modal:visible').length;
            $(this).css('z-index', zIndex);
            setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack'));
        });
    </script>

    {{-- The following script will allow abortController to work. --}}
    <script>
        var controller;
    </script>

    <script src="{{ url('/js/form-submit-ajax.js') }}"></script>
    <script src="{{ url('/js/ajax-submit-updated.js') }}"></script>

    {{-- The following script will allow auto-reload of page after page's inactivity. --}}
    <script src="{{ url('/js/periodic-auth-check.js') }}"></script>
    <script src="{{ url('/js/dynamic-logo.js') }}"></script>

    <!-- Dump all dynamic scripts into template -->
    @stack('scripts')




</body>

</html>
