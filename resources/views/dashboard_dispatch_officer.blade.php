<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center">
            <span class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </span>
        </div>
    </x-slot>
    {{--@include('vendor.jetstream.components.message')--}}

    <div class="pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-16 md:px-32 lg:px-48">
                <div class="flex flex-col sm:flex-row">
                    <!-- Card 2 -->
                    <div class="sm:w-1/2 p-2">
                        <div class="bg-white px-6 py-8 rounded-lg shadow-lg text-center">
                            <div class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 mx-auto rounded-full text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-medium text-gray-700 mb-8">Send File</h2>
                            @can('FileCreate')
                                <a href="{{url('file/create')}}" class="inline-block py-2 px-8 mx-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-800 hover:bg-green-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" >Create New</a>
                            @endcan
                            <a href="javascript:;" id="send_open" class="inline-block py-2 px-8 mx-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-700 hover:bg-green-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" >Existing</a>

                        </div>
                    </div>
                    <!-- Card 1 -->
                    <div class="sm:w-1/2 p-2">
                        <div class="bg-white px-6 py-8 rounded-lg shadow-lg text-center">
                            <div class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 mx-auto rounded-full text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-medium text-gray-700 mb-8">Recieve File</h2>

                            <a href="javascript:;" id="receive_open" class="inline-block py-2 px-8 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-700 hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >Receive</a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <div id="send_modal" class="mymodal hidden z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{route('file.send')}}" class="ajaxform" method="get">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="ajax_result"></div>
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left grow">
                                <div class="">
                                    <input autocomplete="off" type="password" name="tracking_code" required id="tracking_code" value=""  placeholder="Scan QR Code" class="bg-gray-50 w-full h-10 px-5 rounded-full text-sm focus:outline-none border-0">
                                </div>
                                <div class="mt-4">
                                    <input autocomplete="off" type="number" name="no_of_attachments" required id="no_of_attachments" min="0" value=""  placeholder="No.of Attachments" class="bg-gray-50 w-full h-10 px-5 rounded-full text-sm focus:outline-none border-0">
                                </div>
                                <div class="mt-4">
                                    <select  name="send_to" id="send_to" required  class="bg-gray-50 w-full h-10 px-5 pr-10 rounded-full text-sm focus:outline-none border-0">
                                        <option value="">Send To Department</option>
                                        @foreach($departments as $dep)
                                            <option value="{{$dep->id}}">{{$dep->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <input type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-500 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm" value="Send File">
                        <button type="button" class="closedialog mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="receive_modal" class="mymodal hidden z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{route('file.receive')}}" class="ajaxform" method="get">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="ajax_result"></div>
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left grow">
                                <div class="">
                                    <input autocomplete="off" type="password" name="tracking_code" required id="r_tracking_code" value=""  placeholder="Scan QR Code" class="bg-gray-50 w-full h-10 px-5 pr-10 rounded-full text-sm focus:outline-none border-0">
                                </div>
                                <div class="mt-4">
                                    <input autocomplete="off" type="number" name="no_of_attachments" required id="r_no_of_attachments" min="0" value=""  placeholder="No.of Attachments" class="bg-gray-50 w-full h-10 px-5 rounded-full text-sm focus:outline-none border-0" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <input type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" value="Receive File">
                        <button type="button" class="closedialog mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        //send_modal,send_open
        //receive_open
    </script>

    <script>
        $(function(){
            $('#send_open').click(function(){
                $("#send_modal").toggleClass('hidden');
                $("#send_modal").toggleClass('fixed');
                $("#send_modal #tracking_code").focus();
            });

            $('#receive_open').click(function(){
                $("#receive_modal").toggleClass('hidden');
                $("#receive_modal").toggleClass('fixed');
                $("#receive_modal #tracking_code").focus();
            });


            $('.closedialog').click(function (){
                $(this).parents(".mymodal").toggleClass('hidden');
                $(this).parents(".mymodal").toggleClass('fixed');
            });
            $('#r_tracking_code').change(function(){
                var form = $(this).parents('form');
                if($(this).val() != '' )
                {
                    $.ajax({
                        url : "{{route('file.checkattachments')}}?tracking_code="+$(this).val(),
                        type: 'get',
                        beforeSend: function( xhr ) {
                            //xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                            form.find('input[type=submit]').prop('disabled', true);
                        }
                    })
                    .done(function( data ) {
                        console.log(data);
                        form.find('input[type=submit]').prop('disabled', false);
                        if(data.status)
                        {
                            form.find("#r_no_of_attachments").val(data.no_of_attachments);
                        }
                        else
                        {
                            form.find(".ajax_result").html(data.message);
                        }
                    });
                }
            });
            $('.ajaxform').submit(function(e){
                e.preventDefault();
                var form = $(this);
                var post_url = $(this).attr("action"); //get form action url
                var request_method = $(this).attr("method"); //get form GET/POST method
                var form_data = $(this).serialize(); //Encode form elements for submission


                $.ajax({
                    url : post_url,
                    type: request_method,
                    data : form_data,
                    beforeSend: function( xhr ) {
                        //xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                        form.find('input[type=submit]').prop('disabled', true);
                    }
                })
                .done(function( data ) {
                    /*if ( console && console.log ) {
                        console.log( "Sample of data:", data.slice( 0, 100 ) );
                    }*/
                    form.find('input[type=submit]').prop('disabled', false);
                    form.find(".ajax_result").html(data.message);
                    if(data.status)
                    {
                        form.trigger("reset");
                        form.find("#tracking_code").focus();
                    }
                });
            });
        })
    </script>
</x-app-layout>
