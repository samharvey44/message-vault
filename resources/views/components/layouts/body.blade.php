<body>
    <div>
        @include('components.layouts.navbar')

        <div class="container-fluid p-3">
            {{ $slot }}
        </div>
    </div>

    {{-- Ensure that Livewire scripts are loaded before page JS, so that we can access Livewire functionality --}}
    @livewireScripts

    <script src={{ mix('build/js/app.js') }} type="text/javascript"></script>
    {{ $js }}
</body>