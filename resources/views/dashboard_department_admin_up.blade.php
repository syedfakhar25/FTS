<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center">
            <span class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Under Process Files') }}
            </span>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-6 mt-5">
                <a href="{{ URL::to('file?status=Under+Process&indep=intransit') }}" class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-4 intro-y bg-white">
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-1">
                            <div class="col-span-2">
                                <div class="text-3xl font-bold leading-8">{{number_format($totalFilesIntransit,0)}}</div>

                                <div class="mt-1 text-base  font-bold text-gray-600">In Transit</div>
                            </div>
                            <div class="col-span-1 flex items-center justify-end">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ URL::to('file?status=Under+Process&indep=self') }}" class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-4 intro-y bg-white">
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-1">
                            <div class="col-span-2">
                                <div class="text-3xl font-bold leading-8">{{number_format($totalFilesReceivedBack,0)}}</div>

                                <div class="mt-1 text-base  font-bold text-gray-600">Received Back</div>
                            </div>
                            <div class="col-span-1 flex items-center justify-end">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ URL::to('file?status=Delayed') }}" class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-4 intro-y bg-white">
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-1">
                            <div class="col-span-2">
                                <div class="text-3xl font-bold leading-8">{{number_format($totalFilesdelayed,0)}}</div>

                                <div class="mt-1 text-base  font-bold text-gray-600">Delayed / Stuck</div>
                            </div>
                            <div class="col-span-1 flex items-center justify-end">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                @foreach($totalFilesOtherDeps as $depFiles)
                    <a href="{{ URL::to('file?status=Under+Process&indep='.$depFiles[0]->curr_department_id) }}" class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-4 intro-y bg-white">
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-1">
                            <div class="col-span-2">
                                <div class="text-3xl font-bold leading-8">{{number_format(count($depFiles),0)}}</div>

                                <div class="mt-1 text-base  font-bold text-gray-600">{{$depFiles[0]->currDepartment->title}}</div>
                            </div>
                            <div class="col-span-1 flex items-center justify-end">
                                @if(!empty($depFiles[0]->currDepartment->logo_path))
                                    <img class="w-12 rounded-full" src="{{url(Storage::url($depFiles[0]->currDepartment->logo_path))}}"/>
                                @else
                                    <img class="w-12 rounded-full" src="{{url('img/default_logo.png')}}"/>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
