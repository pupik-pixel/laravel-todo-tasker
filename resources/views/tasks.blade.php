<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('js/app.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tasks</title>
</head>

<body>
    @foreach ($tasks as $task)
        <form method="POST" action="/updateTask"
            class="task-element d-flex flex-column justify-content-center align-items-center">
            @csrf
            <input type="string" name="id" hidden value="{{ $task->id }}">
            <div class="input-group mb-3">
                <span class="input-group-text">Название</span>
                <input class="form-control" type="string" name="title" value="{{ $task->title }}">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Описание</span>
                <input class="form-control" type="string" name="description" value="{{ $task->description }}">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Дата постановки</span>
                <input class="form-control" type="datetime-local" name="staging_date" value="{{ $task->staging_date }}">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Дата завершения</span>
                <input class="form-control" type="datetime-local" name="deadline" value="{{ $task->deadline }}">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Статус</span>
                <select class="form-select" name="status">
                    <option @if ($task->status == 'Активная') selected @endif value="Активная">Активная</option>
                    <option @if ($task->status == 'Отложена') selected @endif value="Отложена">Отложена</option>
                    <option @if ($task->status == 'Завершена') selected @endif value="Завершена">Завершена</option>
                </select>
            </div>
            <input class="btn btn-success" type="submit">
        </form>
    @endforeach
    <form method="POST" action="/saveTask" width="50%"
        class="task-element d-flex flex-column justify-content-center align-items-center">
        @csrf
        <div class="input-group mb-3">
            <span class="input-group-text">Название</span>
            <input class="form-control" type="string" name="title">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Описание</span>
            <input class="form-control" type="string" name="description">
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
        <input class="btn btn-success" type="submit">
    </form>
</body>

</html>
