<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ $page['props']['title'] ?? ucfirst(str_replace('-', ' ', $page['component'])) }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia

        {{-- Remove app name or Laravel from title if present --}}
        @push('inertiaHead')
            <script>
                document.addEventListener('inertia:finish', function() {
                    if (document.title.includes(' - ')) {
                        document.title = document.title.split(' - ')[0];
                    }
                });
            </script>
        @endpush
    </body>
</html>
