<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center">
            <span class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Received Files Still in Our Office') }}
            </span>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-6 mt-5">
                @foreach($totalFilesReceived as $depFiles)
                    <a href="{{ URL::to('file?type=received&at=myoffcie&fromdep='.$depFiles[0]->department_id) }}" class="transform  hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-4 intro-y bg-white">
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-1">
                            <div class="col-span-2">
                                <div class="text-3xl font-bold leading-8">{{number_format(count($depFiles),0)}}</div>

                                <div class="mt-1 text-base  font-bold text-gray-600">{{$depFiles[0]->department->title}}</div>
                            </div>
                            <div class="col-span-1 flex items-center justify-end">
                                @if(!empty($dep->logo_path))
                                    <img class="w-12 rounded-full" src="{{url(Storage::url($depFiles[0]->department->logo_path))}}"/>
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
