<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tasks</title>
</head>

<body>
    <div class="accordion mt-5" id="accordionParent">
        <div class="accordion-item task-element bg-body-secondary">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed bg-body-secondary" type="button" data-bs-toggle="collapse"
                    data-bs-target="#newTask" aria-expanded="true">
                    Создать новую задачу
                </button>
            </h2>
            <div id="newTask" class="accordion-collapse collapse" aria-labelledby="headingOne"
                data-bs-parent="#accordionParent">
                <form method="POST" action="/saveTask" width="50%" enctype="multipart/form-data"
                    class="d-flex flex-column justify-content-center align-items-center accordion-body mt-3 mb-3">
                    @csrf
                    <div class="input-group mb-3">
                        <span class="input-group-text">Название</span>
                        <input class="form-control" type="string" name="title">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Описание</span>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Дата постановки</span>
                        <input class="form-control" type="datetime-local" name="staging_date">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Дата завершения</span>
                        <input class="form-control" type="datetime-local" name="deadline">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Статус</span>
                        <select class="form-select" name="status">
                            <option value="Активная">Активная</option>
                            <option value="Отложена">Отложена</option>
                            <option value="Завершена">Завершена</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <input name="file" type="file" class="form-control">
                    </div>
                    <input class="btn btn-success" type="submit" value="Сохранить">
                </form>
            </div>
        </div>
        @foreach ($tasks as $task)
            <div
                class="accordion-item task-element @if ($task->status == 'Активная') bg-warning
            @elseif ($task->status == 'Отложена')
                bg-secondary
            @elseif ($task->status == 'Завершена')
                bg-success @endif">
                <h2 class="accordion-header">
                    <button
                        class="accordion-button collapsed @if ($task->status == 'Активная') bg-warning
                    @elseif ($task->status == 'Отложена')
                    text-light bg-secondary
                    @elseif ($task->status == 'Завершена')
                    text-light bg-success @endif"
                        type="button" data-bs-toggle="collapse" data-bs-target="#task{{ $task->id }}"
                        aria-expanded="true">
                        {{ $task->title }}
                    </button>
                </h2>
                <div id="task{{ $task->id }}" class="accordion-collapse collapse" aria-labelledby="headingOne"
                    data-bs-parent="#accordionParent">
                    <form method="POST" action="/updateTask" enctype="multipart/form-data"
                        class="d-flex flex-column justify-content-center align-items-center accordion-body mt-3 mb-3">
                        @csrf
                        <input type="string" name="id" hidden value="{{ $task->id }}">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Название</span>
                            <input class="form-control" type="string" name="title" value="{{ $task->title }}">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Описание</span>
                            <textarea class="form-control" name="description">{{ $task->description }}</textarea>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Дата постановки</span>
                            <input class="form-control" type="datetime-local" name="staging_date"
                                value="{{ $task->staging_date }}">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Дата завершения</span>
                            <input class="form-control" type="datetime-local" name="deadline"
                                value="{{ $task->deadline }}">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Статус</span>
                            <select class="form-select" name="status">
                                <option @if ($task->status == 'Активная') selected @endif value="Активная">Активная
                                </option>
                                <option @if ($task->status == 'Отложена') selected @endif value="Отложена">Отложена
                                </option>
                                <option @if ($task->status == 'Завершена') selected @endif value="Завершена">Завершена
                                </option>
                            </select>
                        </div>
                        <div class="alert alert-secondary align-self-start" role="alert">
                            <p>Предыдущий загруженный файл</p>
                            <a download href="{{ asset('storage/' . $task->file_name) }}">{{ $task->file_name }}</a>
                        </div>
                        <div class="input-group mb-3">
                            <input name="file" type="file" class="form-control">
                        </div>
                        <div>
                            <input class="btn btn-primary" type="submit" value="Сохранить">
                            <button csrf-token="{{ csrf_token() }}" type="button"
                                class="delete-button btn btn-danger bi bi-trash">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                    <path fill-rule="evenodd"
                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                </svg>
                                Удалить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</body>
<script src="{{ asset('js/app.js') }}"></script>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

</html>
