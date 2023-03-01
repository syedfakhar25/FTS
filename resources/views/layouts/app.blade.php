<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="https://unpkg.com/flowbite@1.3.4/dist/flowbite.min.css" />
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{ url('css/daterangepicker.min.css') }}">
        <link rel="stylesheet" href="{{ url('css/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ url('css/apexcharts.css') }}">


        @livewireStyles

        <!-- Scripts -->
        <script src="{{ url('js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="{{ url('js/moment.min.js') }}"></script>
        <script src="{{ url('js/knockout-3.5.1.js') }}" defer></script>
        <script src="{{ url('js/daterangepicker.min.js') }}" defer></script>
        <script src="{{ url('js/datatables.min.js') }}" defer></script>
        <script src="{{ url('js/apexcharts.min.js') }}" defer></script>
        <script src="https://unpkg.com/flowbite@1.3.4/dist/flowbite.js"></script>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100 pb-8">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>

            @endif
            <x-alert/>
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <div class="fixed bottom-0 left-0 right-0 text-center mt-4 bg-white border-t border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="py-2 text-xs">
                        Powerd by <a href="https://itb.ajk.gov.pk" class="text-blue-500" target="_blank">AJ&K Information Technology Board</a>.
                    </div>
                </div>
            </div>
        </div>

        @stack('modals')

        @livewireScripts


        @if (session()->has('fileprintlabel'))
            <script>
                $(function(){
                    printPage("{{route('file.printlabel', session('fileprintlabel'))}}");
                });



            function closePrint () {
                document.body.removeChild(this.__container__);
            }

            function setPrint () {
                this.contentWindow.__container__ = this;
                this.contentWindow.onbeforeunload = closePrint;
                this.contentWindow.onafterprint = closePrint;
                this.contentWindow.focus(); // Required for IE
                this.contentWindow.print();
            }

            function printPage (sURL) {
                var oHideFrame = document.createElement("iframe");
                oHideFrame.onload = setPrint;
                oHideFrame.style.position = "fixed";
                oHideFrame.style.right = "0";
                oHideFrame.style.bottom = "0";
                oHideFrame.style.width = "0";
                oHideFrame.style.height = "0";
                oHideFrame.style.border = "0";
                oHideFrame.src = sURL;
                document.body.appendChild(oHideFrame);
            }
            </script>

        @endif

    </body>
</html>
