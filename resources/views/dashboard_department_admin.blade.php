<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center">
            <span class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __(\Illuminate\Support\Facades\Auth::user()->department->title.' Files') }}
            </span>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-6 mt-5">
                <a href="{{ URL::to('file/') }}" class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-4 intro-y bg-white">
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-1">
                            <div class="col-span-2">
                                <div class="text-3xl font-bold leading-8">{{number_format($totalFilesCreated,0)}}</div>
                                <div class="mt-1 text-base font-bold text-gray-600">Files Created</div>
                            </div>
                            <div class="col-span-1 flex items-center justify-end">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ URL::to('fileup/') }}" class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-4 intro-y bg-white">
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-1">
                            <div class="col-span-2">
                                <div class="text-3xl font-bold leading-8">{{number_format($totalFilesUnderProcess,0)}}</div>

                                <div class="mt-1 text-base  font-bold text-gray-600">Files Under Process</div>
                            </div>
                            <div class="col-span-1 flex items-center justify-end">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ URL::to('file?status=Closed') }}" class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-4 intro-y bg-white">
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-1">
                            <div class="col-span-2">
                                <div class="text-3xl font-bold leading-8">{{number_format($totalFilesClosed,0)}}</div>

                                <div class="mt-1 text-base  font-bold text-gray-600">Files Closed</div>
                            </div>
                            <div class="col-span-1 flex items-center justify-end">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="col-span-12  xl:col-span-2">

                </div>
                <a href="{{ URL::to('file?status=Objection') }}" class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-4 intro-y bg-white">
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-1">
                            <div class="col-span-2">
                                <div class="text-3xl font-bold leading-8">{{number_format($totalFilesObjection,0)}}</div>

                                <div class="mt-1 text-base  font-bold text-gray-600">Objected</div>
                            </div>
                            <div class="col-span-1 flex items-center justify-end">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-12 w-12 text-red-800">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ URL::to('file?status=Speak') }}" class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-4 intro-y bg-white">
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-1">
                            <div class="col-span-2">
                                <div class="text-3xl font-bold leading-8">{{number_format($totalFilesSpeak,0)}}</div>

                                <div class="mt-1 text-base  font-bold text-gray-600">Speak</div>
                            </div>
                            <div class="col-span-1 flex items-center justify-end">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-12 w-12 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="flex justify-center my-8">
                <span class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Other Deprtments Files') }}
                </span>
            </div>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <a href="{{ URL::to('file?type=received') }}" class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-4 intro-y bg-white">
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-1">
                            <div class="col-span-2">
                                <div class="text-3xl font-bold leading-8">{{number_format($totalFilesReceived,0)}}</div>
                                <div class="mt-1 text-base font-bold text-gray-600">Files Received</div>
                            </div>
                            <div class="col-span-1 flex items-center justify-end">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ URL::to('file?type=received&status=out') }}" class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-4 intro-y bg-white">
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-1">
                            <div class="col-span-2">
                                <div class="text-3xl font-bold leading-8">{{number_format($totalFilesReceivedforwarded,0)}}</div>
                                <div class="mt-1 text-base  font-bold text-gray-600">Files Returned/Forwarded</div>
                            </div>
                            <div class="col-span-1 flex items-center justify-end">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500 scale-x-flip" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ URL::to('file?type=received&status=in') }}" class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-4 intro-y bg-white">
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-1">
                            <div class="col-span-2">
                                <div class="text-3xl font-bold leading-8">{{number_format($totalFilesReceivedstill,0)}}</div>

                                <div class="mt-1 text-base  font-bold text-gray-600">Still in Office</div>
                            </div>
                            <div class="col-span-1 flex items-center justify-end">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="col-span-12  xl:col-span-2">

                </div>
                <a href="{{ URL::to('file?status=Objection') }}" class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-4 intro-y bg-white">
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-1">
                            <div class="col-span-2">
                                <div class="text-3xl font-bold leading-8">{{number_format($mytotalFilesObjection,0)}}</div>

                                <div class="mt-1 text-base  font-bold text-gray-600">Objected</div>
                            </div>
                            <div class="col-span-1 flex items-center justify-end">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-12 w-12 text-red-800">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ URL::to('file?status=Speak') }}" class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-4 intro-y bg-white">
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-1">
                            <div class="col-span-2">
                                <div class="text-3xl font-bold leading-8">{{number_format($mytotalFilesSpeak,0)}}</div>

                                <div class="mt-1 text-base  font-bold text-gray-600">Speak</div>
                            </div>
                            <div class="col-span-1 flex items-center justify-end">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-12 w-12 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                {{--<a href="{{ URL::to('receivedfile?status=Under+Process&indep=intransit') }}" class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-4 intro-y bg-white">
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-1">
                            <div class="col-span-2">
                                <div class="text-3xl font-bold leading-8">{{number_format($totalFilesReceivedInTransit,0)}}</div>

                                <div class="mt-1 text-base  font-bold text-gray-600">In Transit</div>
                            </div>
                            <div class="col-span-1 flex items-center justify-end">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ URL::to('receivedfile?status=Under+Process&indep=self') }}" class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-4 intro-y bg-white">
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-1">
                            <div class="col-span-2">
                                <div class="text-3xl font-bold leading-8">{{number_format($totalFilesReceivedStillinOffice,0)}}</div>

                                <div class="mt-1 text-base  font-bold text-gray-600">Still in Office</div>
                            </div>
                            <div class="col-span-1 flex items-center justify-end">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ URL::to('receivedfile?status=Under+Process&indep=other') }}" class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-4 intro-y bg-white">
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-1">
                            <div class="col-span-2">
                                <div class="text-3xl font-bold leading-8">{{number_format($totalFilesReceivedReturenBack,0)}}</div>

                                <div class="mt-1 text-base  font-bold text-gray-600">Sent Back/Other Department</div>
                            </div>
                            <div class="col-span-1 flex items-center justify-end">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>--}}
            </div>
        </div>
    </div>
</x-app-layout>
