<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name', 'My Laravel App'))</title>

    {{-- Breeze / Vite assets (if built) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js for interactive components --}}
    <script defer src="{{ asset('vendor/alpinejs/alpine.min.js') }}"></script>

    {{-- Bootstrap 5 CSS --}}
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}">

    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap5.min.css') }}">

</head>

<body class="font-sans antialiased">

    {{-- Modern Navbar --}}
    @auth
        @include('layouts.navigation')
    @endauth

    <main class="container my-4" style="margin-top: 2rem !important;">
        {{-- If used as a component layout (<x-app-layout>), use $slot --}}
        @if (isset($slot))
            {{ $slot }}
        @else
            {{-- If used with @extends('layouts.app'), use sections --}}
            @yield('content')
        @endif
    </main>

    <footer class="text-center py-3">
        <small>&copy; {{ date('Y') }} My Laravel App</small>
    </footer>

    {{-- jQuery (required for DataTables) --}}
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    {{-- Bootstrap 5 JS bundle (includes Popper) --}}
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    {{-- DataTables JS (core + Bootstrap 5 integration) --}}
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap5.min.js') }}"></script>

   <script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof $ === 'undefined' || !$.fn.DataTable) {
            return; // jQuery or DataTables not loaded
        }

        // Apply DataTables to ALL tables by default,
        // except ones with .no-datatable
        $('table').each(function () {
            var $table = $(this);

            // Skip if explicitly opted out
            if ($table.hasClass('no-datatable')) {
                return;
            }

            // If already initialized (e.g. via another script), skip
            if ($.fn.DataTable.isDataTable(this)) {
                return;
            }

            $table.DataTable({
                pageLength: 25,
                order: [], // no initial ordering
            });
        });
    });
</script>

 




    {{-- NOTE: we removed MDB-specific toast JS (mdb.Toast) since we’re on pure Bootstrap now. --}}
    {{-- Your pages can still define #successToast / #global-toast elements; we handle them with vanilla JS below. --}}

    {{-- Custom vanilla JS modal handling (works with data-mdb-* OR data-bs-* attributes) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function openModal(modal) {
                if (!modal) return;

                modal.classList.add('show');
                modal.style.display = 'block';
                modal.removeAttribute('aria-hidden');
                modal.setAttribute('aria-modal', 'true');

                // Backdrop
                var backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                backdrop.setAttribute('data-modal-backdrop', modal.id);
                document.body.appendChild(backdrop);
            }

            function closeModal(modal) {
                if (!modal) return;

                modal.classList.remove('show');
                modal.style.display = 'none';
                modal.setAttribute('aria-hidden', 'true');
                modal.removeAttribute('aria-modal');

                var selector = '.modal-backdrop[data-modal-backdrop="' + modal.id + '"]';
                var backdrop = document.querySelector(selector);
                if (backdrop) {
                    backdrop.remove();
                }
            }

            // Open on trigger click (support both old data-mdb-* and new data-bs-*)
            document.querySelectorAll('[data-mdb-toggle="modal"], [data-bs-toggle="modal"]').forEach(function (trigger) {
                trigger.addEventListener('click', function (event) {
                    event.preventDefault();
                    var targetSelector = trigger.getAttribute('data-mdb-target') || trigger.getAttribute('data-bs-target');
                    if (!targetSelector) return;
                    var modal = document.querySelector(targetSelector);
                    openModal(modal);
                });
            });

            // Close on dismiss buttons (support data-mdb-dismiss & data-bs-dismiss)
            document.querySelectorAll('[data-mdb-dismiss="modal"], [data-bs-dismiss="modal"]').forEach(function (btn) {
                btn.addEventListener('click', function (event) {
                    event.preventDefault();
                    var modal = btn.closest('.modal');
                    closeModal(modal);
                });
            });

            // Optional: click outside modal content closes it
            document.querySelectorAll('.modal').forEach(function (modal) {
                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        closeModal(modal);
                    }
                });
            });
        });
    </script>

    {{-- Simple global toast auto-hide (for any #global-toast used in your pages) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toast = document.getElementById('global-toast');
            if (!toast) return;

            // show with animation
            setTimeout(function () {
                toast.classList.add('show');
            }, 100);

            // auto-hide after 3.5 seconds
            var hide = function () {
                toast.classList.remove('show');
            };

            setTimeout(hide, 3500);

            // close button
            var closeBtn = document.getElementById('toast-close-btn');
            if (closeBtn) {
                closeBtn.addEventListener('click', hide);
            }
        });
    </script>

    {{-- Extra scripts from views --}}
    @stack('scripts')
</body>
</html>
