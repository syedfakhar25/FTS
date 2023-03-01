<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Receive Register') }}
            </span>

            <div class="flex justify-center items-center float-right">
                <div id="tableActions"></div>
                <a href="{{url('dashboard')}}" class="flex items-center px-4 py-2 text-gray-600 bg-white border rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-200 transform dark:text-gray-200 dark:border-gray-200  dark:hover:bg-gray-700 ml-2" title="Home">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="hidden md:inline-block ml-2">Home</span>
                </a>
                <a href="{{url('reports')}}" class="flex items-center px-4 py-2 text-gray-600 bg-white border rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-200 transform dark:text-gray-200 dark:border-gray-200  dark:hover:bg-gray-700 ml-2" title="Back">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.333 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z"></path>
                    </svg>
                    <span class="hidden md:inline-block ml-2">Back</span>
                </a>
            </div>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ URL::to('reports/receive') }}" method="get" class="flex flex-wrap mb-4 md:flex-row rounded-lg overflow-hidden">
                <input  type="search" name="q" value="{{request()->has('q') ? @request()->get('q'):'' }}" placeholder="Search Register" class="grow  text-gray-700 placeholder-gray-400 bg-white border-l-0 border-r border-t-0 border-b-0 border-gray-100 focus:border-gray-100 appearance-none dark:text-gray-200 focus:outline-none focus:placeholder-transparent focus:ring-0">
                <input  type="search" name="date_range" id="date_range" value="{{request()->has('date_range') ? @request()->get('date_range'):'' }}" placeholder="Date Range" class="border-l border-r border-t-0 border-b-0 border-gray-100 focus:border-gray-100 text-gray-700 placeholder-gray-400 bg-white appearance-none dark:text-gray-200 focus:outline-none focus:placeholder-transparent focus:ring-0  w-52">
                <select name="department_id" class=" border-l border-r border-gray-100 border-t-0 border-b-0  text-gray-700 placeholder-gray-400 bg-white appearance-none dark:text-gray-200 focus:outline-none focus:border-gray-100 focus:ring-0 w-40">
                    <option value="">Departments</option>
                    @foreach($departments as $dep)
                        <option {{request()->has('department_id') &&  @request()->get('department_id')== $dep->id  ? 'selected':'' }} value="{{$dep->id}}">{{$dep->title}}</option>
                    @endforeach
                </select>
                <select name="status" class="border-l border-r border-gray-100 border-t-0 border-b-0  text-gray-700 placeholder-gray-400 bg-white appearance-none dark:text-gray-200 focus:outline-none focus:border-gray-100 focus:ring-0 w-32">
                    <option value="">Statuses</option>
                    <option {{request()->has('status') &&  @request()->get('status')== 'Closed'  ? 'selected':'' }} value="Closed">Closed</option>
                    <option {{request()->has('status') &&  @request()->get('status')== 'Under Process'  ? 'selected':'' }} value="Under Process">Under Process</option>
                    <option {{request()->has('status') &&  @request()->get('status')== 'Delayed'  ? 'selected':'' }} value="Delayed">Delayed</option>
                </select>
                <button class="flex justify-center p-2 bg-white text-gray-700 transition-colors duration-200 transform  lg:w-auto hover:bg-gray-100  focus:outline-none focus:bg-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>
        @if(count($filesDetails)>0)

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-max w-full table-auto datatable-export">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="p-3 text-center w-2">S.No</th>
                            <th class="p-3 text-center w-48">Date</th>
                            <th class="p-3 text-left">Subject</th>
                            <th class="p-3 text-center  w-2">Attachments</th>
                            <th class="p-3 text-left">Received From</th>
                            <th class="p-3 text-center">Reference</th>
                            <th class="p-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-black text-sm font-light">
                    @foreach($filesDetails as $file)
                        <tr class="border-b border-gray-200 bg-white text-black hover:bg-gray-100">
                            <td class="p-3 text-center">{{$loop->iteration}}</td>
                            <td class="p-3 text-center">{{\Carbon\Carbon::parse($file->created_at)->format('M d, Y')}}</td>
                            <td class="p-3 text-left">{{$file->title}}</td>
                            <td class="p-3 text-center">{{$file->no_of_attachments}}</td>
                            <td class="p-3 text-left">{{$file->department_name}}</td>
                            <td class="p-3 text-center">{{$file->ref_file_detail}}</td>
                            <td class="p-3 text-center">{{$file->status}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="p-8 text-center bg-white shadow-xl sm:rounded-lg">No record found.</div>
            @endif
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $("#date_range").daterangepicker({
                minDate: moment().subtract(10, 'years'),
                orientation:'left',
                callback: function (startDate, endDate, period) {
                    $(this).val(startDate.format('L') + ' – ' + endDate.format('L'));
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var reports = $('.datatable-export').DataTable({
                //dom: '<"top"Incomes><"export"B>t',
                //buttons: ['excel', 'pdf', 'print'],
                searching: false,
                paging: false,
                info: false
            });
            new $.fn.dataTable.Buttons( reports, {
                buttons: [
                    {
                        extend:    'excel',
                        text:      '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg> <span class="hidden md:inline-block ml-2">Excel</span>  ',
                        titleAttr: 'Excel',
                        className: 'inline px-4 py-2 text-gray-600 bg-white border rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-200 transform dark:text-gray-200 dark:border-gray-200  dark:hover:bg-gray-700',
                        exportOptions: {
                            columns: ':visible'
                        },
                        footer: true,
                        filename:  "Receive Report {{(request()->has('date_range') && !empty(request()->get('date_range'))) ? str_replace('/','-',str_replace('–','to',request()->get('date_range'))):'Overall' }}",
                        title: "Receive Report",
                        messageTop: '{{(request()->has('date_range') && !empty(request()->get('date_range'))) ? str_replace('/','-',str_replace('–','to',request()->get('date_range'))):'Overall' }}'
                    },
                    {
                        extend:    'pdf',
                        text:      '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg> <span class="hidden md:inline-block ml-2">PDF</span>',
                        titleAttr: 'PDF',
                        className: 'inline px-4 py-2 text-gray-600 bg-white border rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-200 transform dark:text-gray-200 dark:border-gray-200  dark:hover:bg-gray-700 ml-2',
                        exportOptions: {
                            columns: ':visible'
                        },
                        footer: true,
                        filename:  "Receive Report {{(request()->has('date_range') && !empty(request()->get('date_range'))) ? str_replace('/','-',str_replace('–','to',request()->get('date_range'))):'Overall' }}",
                        title: "Receive Report ",
                        messageTop: '{{(request()->has('date_range') && !empty(request()->get('date_range'))) ? str_replace('/','-',str_replace('–','to',request()->get('date_range'))):'Overall' }}',
                        customize : function(doc) {
                            doc.styles['message']['alignment']='center';

                            doc.content[2].table.widths = [ '5%', '10%', '30%','10%','25%','10%','10%'];
                            var rowCount = doc.content[2].table.body.length;

                            for (i = 1; i < rowCount; i++) {
                                doc.content[2].table.body[i][0].alignment = 'center';
                                doc.content[2].table.body[i][1].alignment = 'center';
                                doc.content[2].table.body[i][3].alignment = 'center';
                                doc.content[2].table.body[i][5].alignment = 'center';
                                doc.content[2].table.body[i][6].alignment = 'center';
                            }

                            doc.content[2].table.body[0][2].alignment = 'left';
                            doc.content[2].table.body[0][4].alignment = 'left';
                        }
                    },
                    {
                        extend:    'print',
                        text:      '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg> <span class="hidden md:inline-block ml-2">Print</span>',
                        titleAttr: 'Print',
                        className: 'inline px-4 py-2 text-gray-600 bg-white border rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-200 transform dark:text-gray-200 dark:border-gray-200  dark:hover:bg-gray-700 ml-2',
                        exportOptions: {
                            columns: ':visible'
                        },
                        footer: true,
                        filename:  "Receive Report {{(request()->has('date_range') && !empty(request()->get('date_range'))) ? str_replace('/','-',str_replace('–','to',request()->get('date_range'))):'Overall' }}",
                        title: "Receive Report ",
                        messageTop: '{{(request()->has('date_range') && !empty(request()->get('date_range'))) ? str_replace('/','-',str_replace('–','to',request()->get('date_range'))):'Overall' }}',
                        customize: function ( win ) {
                            $(win.document.body).find('h1').css('text-align', 'center');
                            $(win.document.body).find('div').css('text-align', 'center');

                            $(win.document.body).find('table thead th:nth-child(3)').css('text-align', 'left');
                            $(win.document.body).find('table thead th:nth-child(5)').css('text-align', 'left');

                            $(win.document.body).find('table tbody td:nth-child(1)').css('text-align', 'center');
                            $(win.document.body).find('table tbody td:nth-child(2)').css('text-align', 'center');
                            $(win.document.body).find('table tbody td:nth-child(4)').css('text-align', 'center');
                            $(win.document.body).find('table tbody td:nth-child(6)').css('text-align', 'center');
                            $(win.document.body).find('table tbody td:nth-child(7)').css('text-align', 'center');
                        }
                    },
                ]
            } );
            reports.buttons().container().appendTo('#tableActions');

        } );
    </script>
</x-app-layout>
