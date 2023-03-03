<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage User') }}
            </span>

            <div class="flex justify-center items-center float-right">
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
        <div class="max-w-7xl mx-auto py-5">

            {{--<x-alert/>--}}
            <form action="{{route('user.update',$user->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="container mx-auto px-5">
                    <div class=" overflow-hidden ">
                        <div class="py-6">
                            <div>
                                <div class="md:grid md:grid-cols-3 md:gap-6">
                                    <div class="md:col-span-1">
                                        <div class="px-4 sm:px-0">
                                            <h3 class="text-lg font-medium leading-6 text-gray-900">Edit User</h3>
                                            <p class="mt-1 text-sm text-gray-600">
                                                Enter department title and logo.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-5 md:mt-0 md:col-span-2">
                                        <div class="shadow overflow-hidden sm:rounded-md">
                                            <div class="px-4 py-5 bg-white sm:p-6">
                                                <div class="grid grid-cols-6 gap-6">
                                                    <div class="col-span-6">
                                                        <label for="name"
                                                               class="block text-sm font-medium text-gray-700">Name</label>
                                                        <input type="text" name="name" id="name" value="{{$user->name}}"
                                                               autocomplete="name" required="required"
                                                               class="border-gray-300 @error('name') border-red-500 @enderror mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm  rounded-md">
                                                        @error('name')<span class="text-red-500 mt-1 text-sm">{{ $message }}</span>@enderror
                                                    </div>
                                                    <div class="col-span-6 md:col-span-3">
                                                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                                        <select id="role" name="role" autocomplete="role"  class="mt-1 block w-full py-2 px-3 border border-gray-300 @error('role') border-red-500 @enderror bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                            {{--<option value="Administrator" @if( old('role') =='Administrator' ) selected="selected" @endif>Administrator</option>--}}
                                                            <option value="DepartmentAdmin" @if( $user->hasRole('DepartmentAdmin') ) selected="selected" @endif>Department Admin</option>
                                                            <option value="DepartmentDispatchOfficer" @if( $user->hasRole('DepartmentDispatchOfficer' )) selected="selected" @endif>Dispatch Officer</option>
                                                        </select>
                                                        @error('role')<span class="text-red-500 mt-1 text-sm">{{ $message }}</span>@enderror
                                                    </div>
                                                    <div class="col-span-6 md:col-span-3">
                                                        <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                                                        <select id="department_id" name="department_id" autocomplete="department_id"  class="mt-1 block w-full py-2 px-3 border border-gray-300 @error('department_id') border-red-500 @enderror bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                            @foreach($departments as $dep)
                                                                <option value="{{$dep->id}}" @if( $user->department_id == $dep->id ) selected="selected" @endif>{{$dep->title}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('department_id')<span class="text-red-500 mt-1 text-sm">{{ $message }}</span>@enderror
                                                    </div>
                                                    <div class="col-span-6 md:col-span-3">
                                                        <label for="mobile_number"
                                                               class="block text-sm font-medium text-gray-700">Mobile Number</label>
                                                        <input type="number" name="mobile_number" id="mobile_number" value="{{$user->mobile_number}}"
                                                               autocomplete="mobile_number" required="required"
                                                               class="border-gray-300 @error('mobile_number') border-red-500 @enderror mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm  rounded-md">
                                                        @error('mobile_number')<span class="text-red-500 mt-1 text-sm">{{ $message }}</span>@enderror
                                                    </div>
                                                    <div class="col-span-6 md:col-span-3">
                                                        <label for="password"
                                                               class="block text-sm font-medium text-gray-700">Password</label>
                                                        <input type="password" name="password" id="password" value=""
                                                               autocomplete="off"
                                                               class="border-gray-300 @error('password') border-red-500 @enderror mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm  rounded-md">
                                                        @error('password')<span class="text-red-500 mt-1 text-sm">{{ $message }}</span>@enderror
                                                    </div>

                                                    <div class="col-span-6">
                                                        <div aria-label="File Upload Modal" class="relative h-full flex flex-col" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);" ondragleave="dragLeaveHandler(event);" ondragenter="dragEnterHandler(event);">
                                                            <label for="status" class="block text-sm font-medium text-gray-700">Logo</label>
                                                            @if(!empty($user->profile_photo_path))
                                                                <ul class="flex flex-1 flex-wrap my-2">
                                                                    <li class="block p-1 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-1/8">
                                                                        <a href="{{\Illuminate\Support\Facades\Storage::url($user->profile_photo_path)}}" target="_blank" class="border border-gray-200 block p-2">
                                                                            @if(Str::endsWith(strtolower($user->profile_photo_path),'.jpg') || Str::endsWith(strtolower($user->profile_photo_path),'.png'))
                                                                                <img src="{{\Illuminate\Support\Facades\Storage::url($user->profile_photo_path)}}" class="block w-24">
                                                                           @endif
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            @endif

                                                            <header class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center">
                                                                <p class="mb-3 font-semibold text-gray-900 flex flex-wrap justify-center">
                                                                    <span>Drag and drop your</span>&nbsp;<span>profile picture anywhere or</span>
                                                                </p>
                                                                <input id="hidden-input" name="profile_photo" type="file"  class="hidden" />
                                                                <button id="button" type="button" class="mt-2 rounded-sm px-3 py-1 bg-gray-200 hover:bg-gray-300 focus:shadow-outline focus:outline-none">
                                                                    Upload a logo
                                                                </button>
                                                            </header>

                                                            <h2 class="pt-8 pb-3 font-semibold sm:text-lg text-gray-900">
                                                                To Upload
                                                                <div id="clear_wrapper" class="hidden ml-5 inline-block">
                                                                    <a href="javascript:;" id="cancel" class="text-blue-500 hover:text-blue-600 text-sm border py-1 px-2 m-1">Clear All</a>
                                                                </div>
                                                            </h2>

                                                            <ul id="gallery" class="flex flex-1 flex-wrap -m-1">
                                                                <li id="empty" class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                                                                    <img class="mx-auto w-32" src="{{url('images/no-file.png')}}" alt="" />
                                                                    <span class="text-small text-gray-500">No profile picture selected</span>
                                                                </li>
                                                            </ul>
                                                            <div id="overlay" class="w-full h-full absolute top-0 left-0 pointer-events-none z-50 flex flex-col items-center justify-center rounded-md">
                                                                <i>
                                                                    <svg class="fill-current w-12 h-12 mb-3 text-blue-700" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                                        <path d="M19.479 10.092c-.212-3.951-3.473-7.092-7.479-7.092-4.005 0-7.267 3.141-7.479 7.092-2.57.463-4.521 2.706-4.521 5.408 0 3.037 2.463 5.5 5.5 5.5h13c3.037 0 5.5-2.463 5.5-5.5 0-2.702-1.951-4.945-4.521-5.408zm-7.479-1.092l4 4h-3v4h-2v-4h-3l4-4z" />
                                                                    </svg>
                                                                </i>
                                                                <p class="text-lg text-blue-700">Drop profile picture to upload</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                                <button type="submit"
                                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="hidden sm:block" aria-hidden="true">
                                <div class="py-5">
                                    <div class="border-t border-gray-200"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- using two similar templates for simplicity in js code -->
    <template id="file-template">
        <li class="block p-1 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-1/8 h-24">
            <article tabindex="0" class="group w-full h-full rounded-md focus:outline-none focus:shadow-outline elative bg-gray-100 cursor-pointer relative shadow-sm">
                <img alt="upload preview" class="img-preview hidden w-full h-full sticky object-cover rounded-md bg-fixed" />

                <section class="flex flex-col rounded-md text-xs break-words w-full h-full z-20 absolute top-0 py-2 px-3">
                    <h1 class="flex-1 group-hover:text-blue-800"></h1>
                    <div class="flex">
                        <span class="p-1 text-blue-800">
                            <i>
                              <svg class="fill-current w-4 h-4 ml-auto pt-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M15 2v5h5v15h-16v-20h11zm1-2h-14v24h20v-18l-6-6z" />
                              </svg>
                            </i>
                        </span>
                        <p class="p-1 size text-xs text-gray-700"></p>
                        <button class="delete ml-auto focus:outline-none hover:bg-gray-300 p-1 rounded-md text-gray-800">
                            <svg class="pointer-events-none fill-current w-4 h-4 ml-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path class="pointer-events-none" d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z" />
                            </svg>
                        </button>
                    </div>
                </section>
            </article>
        </li>
    </template>

    <template id="image-template">
        <li class="block p-1 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-1/8 h-24">
            <article tabindex="0" class="group hasImage w-full h-full rounded-md focus:outline-none focus:shadow-outline bg-gray-100 cursor-pointer relative text-transparent hover:text-white shadow-sm">
                <img alt="upload preview" class="img-preview w-full h-full sticky object-cover rounded-md bg-fixed" />

                <section class="flex flex-col rounded-md text-xs break-words w-full h-full z-20 absolute top-0 py-2 px-3">
                    <h1 class="flex-1"></h1>
                    <div class="flex">
                        <span class="p-1">
                            <i>
                              <svg class="fill-current w-4 h-4 ml-auto pt-" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M5 8.5c0-.828.672-1.5 1.5-1.5s1.5.672 1.5 1.5c0 .829-.672 1.5-1.5 1.5s-1.5-.671-1.5-1.5zm9 .5l-2.519 4-2.481-1.96-4 5.96h14l-5-8zm8-4v14h-20v-14h20zm2-2h-24v18h24v-18z" />
                              </svg>
                            </i>
                        </span>

                        <p class="p-1 size text-xs"></p>
                        <button class="delete ml-auto focus:outline-none hover:bg-gray-300 p-1 rounded-md">
                            <svg class="pointer-events-none fill-current w-4 h-4 ml-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path class="pointer-events-none" d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z" />
                            </svg>
                        </button>
                    </div>
                </section>
            </article>
        </li>
    </template>

    <script type="text/javascript">

        const fileTempl = document.getElementById("file-template"),
            imageTempl = document.getElementById("image-template"),
            clear_wrapper = document.getElementById("clear_wrapper"),
            empty = document.getElementById("empty");

        // use to store pre selected files
        let FILES = {};
        // check if file is of type image and prepend the initialied
        // template to the target element
        function addFile(target, file) {
            const isImage = file.type.match("image.*"),
                objectURL = URL.createObjectURL(file);

            const clone = isImage
                ? imageTempl.content.cloneNode(true)
                : fileTempl.content.cloneNode(true);

            clone.querySelector("h1").textContent = file.name;
            clone.querySelector("li").id = objectURL;
            clone.querySelector(".delete").dataset.target = objectURL;
            clone.querySelector(".size").textContent =
                file.size > 1024
                    ? file.size > 1048576
                        ? Math.round(file.size / 1048576) + "mb"
                        : Math.round(file.size / 1024) + "kb"
                    : file.size + "b";

            isImage &&
            Object.assign(clone.querySelector("img"), {
                src: objectURL,
                alt: file.name
            });

            empty.classList.add("hidden");
            clear_wrapper.classList.remove("hidden");
            target.prepend(clone);

            FILES[objectURL] = file;
        }

        const gallery = document.getElementById("gallery"),
            overlay = document.getElementById("overlay");

        // click the hidden input of type file if the visible button is clicked
        // and capture the selected files
        const hidden = document.getElementById("hidden-input");
        document.getElementById("button").onclick = () => hidden.click();

        hidden.onchange = (e) => {
            document.getElementById("cancel").click();
            for (const file of e.target.files) {
                addFile(gallery, file);
            }
        };

        // use to check if a file is being dragged
        const hasFiles = ({ dataTransfer: { types = [] } }) =>
            types.indexOf("Files") > -1;

        // use to drag dragenter and dragleave events.
        // this is to know if the outermost parent is dragged over
        // without issues due to drag events on its children
        let counter = 0;

        // reset counter and append file to gallery when file is dropped
        function dropHandler(ev) {
            ev.preventDefault();
            document.getElementById("cancel").click();
            for (const file of ev.dataTransfer.files) {
                addFile(gallery, file);
                overlay.classList.remove("draggedover");
                counter = 0;
            }
        }

        // only react to actual files being dragged
        function dragEnterHandler(e) {
            e.preventDefault();
            if (!hasFiles(e)) {
                return;
            }
            ++counter && overlay.classList.add("draggedover");
        }

        function dragLeaveHandler(e) {
            1 > --counter && overlay.classList.remove("draggedover");
        }

        function dragOverHandler(e) {
            if (hasFiles(e)) {
                e.preventDefault();
            }
        }

        // event delegation to caputre delete events
        // fron the waste buckets in the file preview cards
        gallery.onclick = ({ target }) => {
            if (target.classList.contains("delete")) {
                const ou = target.dataset.target;
                document.getElementById(ou).remove(ou);
                gallery.children.length === 1 && empty.classList.remove("hidden");
                gallery.children.length === 1 && clear_wrapper.classList.add("hidden");
                delete FILES[ou];
            }
        };

        // print all selected files
        /*document.getElementById("submit").onclick = () => {
            alert(`Submitted Files:\n${JSON.stringify(FILES)}`);
            console.log(FILES);
        };*/

        // clear entire selection
        document.getElementById("cancel").onclick = () => {
            while (gallery.children.length > 0) {
                gallery.lastChild.remove();
            }
            FILES = {};
            empty.classList.remove("hidden");
            clear_wrapper.classList.add("hidden");
            gallery.append(empty);
        };

    </script>

    <style>
        .hasImage:hover section {
            background-color: rgba(5, 5, 5, 0.4);
        }
        .hasImage:hover button:hover {
            background: rgba(5, 5, 5, 0.45);
        }

        #overlay p,
        i {
            opacity: 0;
        }

        #overlay.draggedover {
            background-color: rgba(255, 255, 255, 0.7);
        }
        #overlay.draggedover p,
        #overlay.draggedover i {
            opacity: 1;
        }

        .group:hover .group-hover\:text-blue-800 {
            color: #2b6cb0;
        }
    </style>

</x-app-layout>
