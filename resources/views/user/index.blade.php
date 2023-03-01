<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Users') }}
            </span>

            <div class="flex justify-center items-center float-right">
                <form action="{{route('user.index')}}" method="get" class="flex flex-wrap justify-between md:flex-row rounded-lg overflow-hidden">
                    <input  type="search" name="searchq" value="{{request()->has('searchq') ? @request()->get('searchq'):'' }}" placeholder="Search Users" class="flex-1 px-4 py-2 text-gray-700 placeholder-gray-400 bg-white border-none appearance-none dark:text-gray-200 focus:outline-none focus:placeholder-transparent focus:ring-0 ">
                    <button class="flex justify-center px-4 py-2 bg-white text-gray-700 transition-colors duration-200 transform  lg:w-auto hover:bg-gray-100 focus:outline-none focus:bg-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
                <a href="{{url('dashboard')}}" class="flex items-center px-4 py-2 text-gray-600 bg-white border rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-200 transform dark:text-gray-200 dark:border-gray-200  dark:hover:bg-gray-700 ml-2" title="Home">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="hidden md:inline-block ml-2">Home</span>
                </a>

                @can('UserCreate')
                    <a href="{{url('user/create')}}"  class="flex items-center px-4 py-2 text-gray-600 bg-white border rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-200 transform dark:text-gray-200 dark:border-gray-200  dark:hover:bg-gray-700 ml-2" title="Add User">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        <span class="hidden md:inline-block ml-2">Add User</span>
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-max w-full table-auto">
                    <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-center w-2">S.No</th>
                        <th class="py-3 px-6 text-left">Name</th>
                        <th class="py-3 px-6 text-left">Mobile Number</th>
                        <th class="py-3 px-6 text-left">Department</th>
                        <th class="py-3 px-6 text-left">Role</th>
                        @canany(['UserEdit', 'UserDelete'])
                            <th class="py-3 px-6 text-center w-48">Actions</th>
                        @endcanany
                    </tr>
                    </thead>
                    <tbody class="text-black text-sm font-light">
                    @foreach($users as $user)
                        <tr class="border-b border-gray-200 bg-white text-black hover:bg-gray-100">
                            <td class="py-3 px-6 text-center">{{$loop->iteration}}</td>
                            <td class="py-3 px-6 text-left">
                                <span class="flex items-center">
                                    <div class="mr-2">
                                        @if(!empty($user->profile_photo_path))
                                            <img class="w-6 rounded-full"
                                                 src="{{url(Storage::url($user->profile_photo_path))}}"/>

                                        @else
                                            <img class="w-6 rounded-full"
                                                 src="{{url('img/default_user.png')}}"/>
                                        @endif
                                    </div>
                                    <span>{{$user->name}}</span>
                                </span>
                            </td>
                            <td class="py-3 px-6 text-left">{{$user->mobile_number}}</td>
                            <td class="py-3 px-6 text-left">@if(!empty($user->department)) {{$user->department}}@else N/A @endif</td>
                            <td class="py-3 px-6 text-left">
                                @if($user->hasRole('DepartmentAdmin'))
                                    Department Admin
                                @elseif($user->hasRole('DepartmentDispatchOfficer'))
                                    Dispatch Officer
                                @endif
                            </td>

                            @canany(['UserEdit', 'UserDelete'])
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        @can('UserEdit')
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="{{route('user.edit', $user->id)}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endcan
                                        @can('UserDelete')
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <form action="{{route('user.destroy', $user->id)}}" method="post" onSubmit="if(!confirm('Are you sure you want to delete?')){return false;}">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="w-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                             stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endcan
                                    </div>
                                </td>
                            @endcanany
                        </tr>
                    @endforeach
                    </tbody>
                </table>


                {{ $users->links() }}
            </div>


        </div>

    </div>
    <script type="text/javascript">
        const targetDiv = document.getElementById("filters");
        const btn = document.getElementById("toggle");
        btn.onclick = function () {
            if (targetDiv.style.display !== "none") {
                targetDiv.style.display = "none";
            } else {
                targetDiv.style.display = "block";
            }
        };

    </script>

</x-app-layout>
