<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if(session()->has('message'))
            <div class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800"
                 role="alert">
                {{ session()->get('message') }}
            </div>
        @endif

            @if(session()->has('error'))
                <div class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-red-800"
                     role="alert">
                    {{ session()->get('error') }}
                </div>
            @endif

        @if($errors->count())
            <div class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($is_admin)
            <div class="max-w-8xl mx-auto sm:px-7 lg:px-9">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="overflow-x-auto relative">

                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    Название
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Описание
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Имя клиента
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Почта клиента
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Ссылка на файл
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Дата создания
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Время старта
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Время завершения
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Пометить выполненым
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tasks as $task)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $task->theme }}
                                    </th>
                                    <td class="py-4 px-6">
                                        {{ $task->description  }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $task->user->name }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $task->user->email }}
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($task->file)
                                            <a href="{{ route('download.file') }}?path={{ $task->file  }}" target="_blank">Открыть</a>
                                        @else
                                            Нет файла
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $task->created_at->diffForHumans() }}
                                    </td>

                                    <td class="py-4 px-6">
                                        {{ $task->created_at->format('Y-m-d h:i:s') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $task->created_at->format('Y-m-d h:i:s') }}
                                    </td>

                                    <td class="py-4 px-6">
                                        @if($task->is_completed)
                                            Выполнено
                                        @else
                                            <a href="{{ route('tasks.complete', [$task->id]) }}" type="button"
                                               class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                Выполнено
                                            </a>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <br>
                        {{ $tasks->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="max-w-4xl mx-auto sm:px-4 lg:px-4">
                <form method="POST" action="{{ route('tasks.create') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="relative z-0 mb-6 w-full group">
                        <input type="text" name="title" id="title"
                               class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                               placeholder=" " required/>
                        <label for="title"
                               class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            Title
                        </label>
                    </div>
                    <div class="relative z-0 mb-6 w-full group">
                        <input type="text" name="description" id="title"
                               class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                               placeholder=" " required/>
                        <label for="title"
                               class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            Description
                        </label>
                    </div>

                    <div class="relative z-0 mb-6 w-full group">
                        <input type="file" name="file" id="file"
                               class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                               placeholder=" " required/>
                        <label for="file"
                               class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            Файл
                        </label>
                    </div>

                    <div class="relative z-0 mb-6 w-full group">
                        <input type="text" name="start_date" id="start_date"
                               class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                               placeholder=" " required/>
                        <label for="start_date"
                               class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            Время старта задачи
                        </label>
                    </div>

                    <div class="relative z-0 mb-6 w-full group">
                        <input type="text" name="end_date" id="end_date"
                               class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                               placeholder=" " required/>
                        <label for="end_date"
                               class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            Время конца задачи
                        </label>
                    </div>

                    <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Создать
                    </button>
                </form>
            </div>
        @endif
    </div>

    <script>
        const startDate = document.querySelector('[name="start_date"]');
        const startDatepicker = new Datepicker(startDate, {
            // ...options
        });

        const endDate = document.querySelector('[name="end_date"]');
        const endDatepicker = new Datepicker(endDate, {
            // ...options
        });
    </script>
</x-app-layout>
