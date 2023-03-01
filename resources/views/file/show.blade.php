<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('File Details') }}
            </span>

            <div class="flex justify-center items-center float-right">
                @can('FileEdit')
                    @if($file->department_id == \Illuminate\Support\Facades\Auth::user()->department_id && $file->department_id == $file->curr_department_id)
                        <a href="{{route('file.edit', $file->id)}}" class="flex items-center px-4 py-2 text-gray-600 bg-white border rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-200 transform dark:text-gray-200 dark:border-gray-200  dark:hover:bg-gray-700 ml-2" title="Home">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span class="hidden md:inline-block ml-2">Edit File</span>
                        </a>
                        @if($file->status == 'Under Process')
                            <a href="{{route('file.close', $file->id)}}" onclick="return confirm('Are you sure! you want to close the file.');" class="flex items-center px-4 py-2 text-gray-600 bg-white border rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-200 transform dark:text-gray-200 dark:border-gray-200  dark:hover:bg-gray-700 ml-2" title="Home">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <span class="hidden md:inline-block ml-2">Close File</span>
                            </a>
                        @else
                            <a href="{{route('file.reopen', $file->id)}}" onclick="return confirm('Are you sure! you want to reopen the file.');" class="flex items-center px-4 py-2 text-gray-600 bg-white border rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-200 transform dark:text-gray-200 dark:border-gray-200  dark:hover:bg-gray-700 ml-2" title="Home">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                </svg>
                                <span class="hidden md:inline-block ml-2">Reopen File</span>
                            </a>
                        @endif
                    @endif
                @endcan

                <a href="{{url('dashboard')}}" class="flex items-center px-4 py-2 text-gray-600 bg-white border rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-200 transform dark:text-gray-200 dark:border-gray-200  dark:hover:bg-gray-700 ml-2" title="Home">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="hidden md:inline-block ml-2">Home</span>
                </a>

                <a href="javascript:;" onclick="history.back()" class="flex items-center px-4 py-2 text-gray-600 bg-white border rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-200 transform dark:text-gray-200 dark:border-gray-200  dark:hover:bg-gray-700 ml-2" title="Back">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.333 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z" />
                    </svg>
                    <span class="hidden md:inline-block ml-2">Back</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="md:flex no-wrap  ">
                <!-- Left Side -->
                <div class="w-full md:w-3/12 md:mr-8">
                    <!-- Profile Card -->
                    <div class="bg-white p-3 border-t-4 border-green-400">
                        <img src="data:image/png;base64,{{\Milon\Barcode\Facades\DNS2DFacade::getBarcodePNG($file->tracking_no, 'QRCODE')}}" alt="barcode" style="width: 100%;height:auto;"   />
                        <h1 class="text-gray-900 font-bold text-xl leading-8 my-1">{{$file->title}}</h1>
                        <p class="text-sm text-gray-500 hover:text-gray-600 leading-6">{{$file->description}}</p>
                        <ul
                            class="bg-gray-100 text-gray-600 hover:text-gray-700 hover:shadow py-2 px-3 mt-3 divide-y rounded shadow-sm">

                            <li class="flex items-center py-3">
                                <span>File Created</span>
                                <span class="ml-auto">{{\Carbon\Carbon::parse($file->created_at)->format('M d, Y') }}</span>
                            </li>
                            <li class="flex items-center py-3">
                                <span>Status</span>
                                <span class="ml-auto">
                                    @if($file->status=='Closed')
                                    <span class="bg-green-500 py-1 px-2 rounded text-white text-sm">Closed</span>
                                    @else
                                        @if($file->curr_department_id == null )
                                            <span class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full block">Under Process</span>
                                        @elseif($file->delay_after_date < date('Y-m-d'))
                                            <span class="bg-red-200 text-red-600 py-1 px-3 rounded-full block text-center">Delayed<br><span class="text-xs">Since: {{\Carbon\Carbon::parse($file->delay_after_date)->diffForHumans()}}</span></span>
                                        @else
                                            <span class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full block">Under Process</span>
                                        @endif
                                    @endif
                                </span>
                            </li>
                            <li class="flex items-center py-3">
                                <span>Attachments</span>
                                <span class="ml-auto">{{$file->no_of_attachments}}</span>
                            </li>
                        </ul>
                    </div>
                    @if(!empty($file->attachments))
                        <!-- End of profile card -->
                        <div class="my-4"></div>
                        <!-- Friends card -->
                        <div class="bg-white p-3 hover:shadow">
                        <div class="flex items-center space-x-3 font-semibold text-gray-900 text-xl leading-8">
                        <span class="text-green-500">
                            <svg class="h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                        </span>
                            <span>Attachments</span>
                        </div>
                        <div class="grid grid-cols-3">
                            @php $file_files = explode(',', $file->attachments) @endphp
                            @foreach($file_files as $attach_file)
                                @if(!empty($attach_file))
                                    <div class="text-center my-2">
                                        <a href="{{\Illuminate\Support\Facades\Storage::url($attach_file)}}" target="_blank">
                                            @if(Str::endsWith(strtolower($attach_file),'.jpg') || Str::endsWith(strtolower($attach_file),'.png'))
                                                <img src="{{\Illuminate\Support\Facades\Storage::url($attach_file)}}" class="h-16 w-16 rounded-full mx-auto">
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 rounded-full mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                            @endif
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                <div class="w-full md:w-9/12 mb-8">
                    <div class="bg-white p-3 shadow-sm rounded-sm">
                        @if($file->filedetails)
                            <ol class="relative border-l border-gray-200 dark:border-gray-700 ml-8">
                                @foreach($file->filedetails as $detail)
                                    <li class="mb-10 ml-12">
                                        <span class="flex absolute -left-6 justify-center items-center w-12 h-12 bg-blue-200 rounded-full ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                                            <img class="rounded-full shadow-lg" src="{{!empty($detail->by_department->logo_path)?url(Storage::url($detail->by_department->logo_path)):url('img/default_logo.png')}}" alt="Bonnie image"/>
                                        </span>
                                        <div class="justify-between items-center p-4 bg-white rounded-lg border border-gray-200 shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600">
                                            <time data-tooltip-target="tooltip-top-{{$detail->id}}" data-tooltip-placement="top"  class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0 flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{$detail->created_at->diffForHumans()}}
                                            </time>
                                            <div id="tooltip-top-{{$detail->id}}" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                                {{\Carbon\Carbon::parse($detail->created_at)->format('M d, Y H:i A')}}
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                            <div class="text-sm font-normal text-gray-500 dark:text-gray-300">
                                                <b>{{$detail->by_department->title}}</b>
                                                @if($detail->type=='Send' || $detail->type=='Receive')
                                                    @if($detail->type=='Send')
                                                        Sent to
                                                    @else
                                                        Received from
                                                    @endif
                                                    <b>{{$detail->ref_department->title}}</b>
                                                    @if($detail->no_of_attachments>0)
                                                        including {{$detail->no_of_attachments}} attachment(s)
                                                    @endif
                                                    {{--with
                                                    @if($detail->type=='Send')
                                                        dispatch no:
                                                    @else
                                                        Receive no:
                                                    @endif
                                                    {{$detail->id}}--}}
                                                @elseif($detail->type=='Close')
                                                    Closed this file.
                                                @elseif($detail->type=='Reopen')
                                                    Reopened this file.
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                                {{--<li class="mb-10 ml-6">
                                    <span class="flex absolute -left-3 justify-center items-center w-6 h-6 bg-blue-200 rounded-full ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                                        <img class="rounded-full shadow-lg" src="/docs/images/people/profile-picture-5.jpg" alt="Thomas Lean image"/>
                                    </span>
                                    <div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm dark:bg-gray-700 dark:border-gray-600">
                                        <div class="justify-between items-center mb-3 sm:flex">
                                            <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">2 hours ago</time>
                                            <div class="text-sm font-normal text-gray-500 lex dark:text-gray-300">Thomas Lean commented on  <a href="#" class="font-semibold text-gray-900 dark:text-white hover:underline">Flowbite Pro</a></div>
                                        </div>
                                        <div class="p-3 text-xs italic font-normal text-gray-500 bg-gray-50 rounded-lg border border-gray-200 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300">Hi ya'll! I wanted to share a webinar zeroheight is having regarding how to best measure your design system! This is the second session of our new webinar series on #DesignSystems discussions where we'll be speaking about Measurement.</div>
                                    </div>
                                </li>
                                <li class="mb-10 ml-6">
                                    <span class="flex absolute -left-3 justify-center items-center w-6 h-6 bg-blue-200 rounded-full ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                                        <img class="rounded-full shadow-lg" src="/docs/images/people/profile-picture-1.jpg" alt="Jese Leos image"/>
                                    </span>
                                    <div class="justify-between items-center p-4 bg-white rounded-lg border border-gray-200 shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600">
                                        <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">1 day ago</time>
                                        <div class="text-sm font-normal text-gray-500 lex dark:text-gray-300">Jese Leos has changed <a href="#" class="font-semibold text-blue-600 dark:text-blue-500 hover:underline">Pricing page</a> task status to  <span class="font-semibold text-gray-900 dark:text-white">Finished</span></div>
                                    </div>
                                </li>--}}
                            </ol>
                        @else
                            No Details found.
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
