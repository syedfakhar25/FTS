<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Files') }}
            </span>
            <div class="flex justify-center items-center float-right">
                <form action="{{route('file.index')}}" method="get" class="flex flex-wrap justify-between md:flex-row rounded-lg overflow-hidden">
                    <input  type="search" name="searchq" value="{{request()->has('searchq') ? @request()->get('searchq'):'' }}" placeholder="Search Files" class="flex-1 px-4 py-2 text-gray-700 placeholder-gray-400 bg-white border-none appearance-none dark:text-gray-200 focus:outline-none focus:placeholder-transparent focus:ring-0 ">
                    @if(Auth::user()->hasRole('Administrator'))
                        <select name="department_id" class="border-l border-r border-gray-100 border-t-0 border-b-0 flex-1 text-gray-700 placeholder-gray-400 bg-white appearance-none dark:text-gray-200 focus:outline-none focus:border-gray-100 focus:ring-0 max-w-48">
                            <option value="">All Department Files</option>
                            @foreach($departments as $dep)
                                <option {{request()->has('department_id') &&  @request()->get('department_id')== $dep->id  ? 'selected':'' }} value="{{$dep->id}}">{{$dep->title}}</option>
                            @endforeach
                        </select>
                    @endif
                    <select name="status" class="border-l border-r border-gray-100 border-t-0 border-b-0 flex-1 text-gray-700 placeholder-gray-400 bg-white appearance-none dark:text-gray-200 focus:outline-none focus:border-gray-100 focus:ring-0 max-w-48">
                        <option value="">All Statuses</option>
                        <option {{request()->has('status') &&  @request()->get('status')== 'Closed'  ? 'selected':'' }} value="Closed">Closed</option>
                        <option {{request()->has('status') &&  @request()->get('status')== 'Under Process'  ? 'selected':'' }} value="Under Process">Under Process</option>
                        <option {{request()->has('status') &&  @request()->get('status')== 'Delayed'  ? 'selected':'' }} value="Delayed">Delayed</option>
                        <option {{request()->has('status') &&  @request()->get('status')== 'Objection'  ? 'selected':'' }} value="Objection">Objected</option>
                        <option {{request()->has('status') &&  @request()->get('status')== 'Speak'  ? 'selected':'' }} value="Speak">Speak</option>
                    </select>
                    <button class="flex justify-center px-4 py-2 bg-white text-gray-700 transition-colors duration-200 transform  lg:w-auto hover:bg-gray-100  focus:outline-none focus:bg-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
                <a href="{{url('dashboard')}}" class="flex items-center px-4 py-2 text-gray-600 bg-white border rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-200 transform dark:text-gray-200 dark:border-gray-200  dark:hover:bg-gray-700 ml-2" title="Home">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="hidden md:inline-block ml-2">Home</span>
                </a>
                {{--@can('FileCreate')
                    <a href="{{url('file/create')}}"  class="flex items-center px-4 py-2 text-gray-600 bg-white border rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-200 transform dark:text-gray-200 dark:border-gray-200  dark:hover:bg-gray-700 ml-2" title="Add Master File">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="hidden md:inline-block ml-2">Add File</span>
                    </a>
                @endcan--}}
            </div>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="overflow: auto">
                <table class="min-w-max w-full table-auto" >
                    <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-center w-2">S.No</th>
                        <th class="py-3 px-6 text-left">File Title</th>
                        @if(Auth::user()->hasRole('Administrator'))
                            <th class="py-3 px-6 text-left">Department</th>
                        @endif
                        <th class="py-3 px-6 text-left">Curr. Department</th>
                        <th class="py-3 px-6 text-center w-48">Status</th>
                    </tr>
                    </thead>
                    <tbody class="text-black text-sm font-light">
                    @foreach($files as $file)
                        <tr class="border-b border-gray-200 bg-white text-black hover:bg-gray-100">
                            <td class="py-3 px-6 text-center">{{$loop->iteration}}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <a href="{{route('file.show', $file->id)}}" class="text-blue-500 font-bold">{{$file->title}}</a><br>
                                <span class="text-xs" data-tooltip-target="tooltip-right-{{$file->id}}" data-tooltip-placement="right">{{$file->created_at->diffForHumans()}}</span>
                                <div id="tooltip-right-{{$file->id}}" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    {{\Carbon\Carbon::parse($file->created_at)->format('M d, Y H:i A')}}
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </td>
                            @if(Auth::user()->hasRole('Administrator'))
                                <td class="py-3 px-6 text-left">{{$file->department->title}}</td>
                            @endif
                            <td class="py-3 px-6 text-left whitespace-nowrap">@if($file->curr_department_id) <span class="font-bold">{{$file->currDepartment->title}}</span><br><span class="text-xs">Received: {{$file->curr_received_date}}</span> @else In Transit @endif</td>
                            <td class="py-3 px-6 text-center w-48">
                                @if($file->status=='Closed')
                                    <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full block">Closed</span>
                                @else
                                    @if($file->curr_department_id == null )
                                    <span class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full block">Under Process</span>
                                    @elseif($file->delay_after_date < date('Y-m-d'))
                                        <span class="bg-red-200 text-red-600 py-1 px-3 rounded-full block">Delayed<br><span class="text-xs">Since: {{\Carbon\Carbon::parse($file->delay_after_date)->diffForHumans()}}</span></span>
                                    @else
                                        <span class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full block">Under Process</span>
                                    @endif
                                @endif

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="p-4">{{ $files->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
