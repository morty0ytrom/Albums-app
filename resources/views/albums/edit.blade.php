<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Справочник</title>

    @vite('resources/css/app.css')
</head>

<body>
    <a class="btn-back" href="/albums">Назад</a>

    <div class="container">
        <h1>✏️ Редактирование альбома</h1>
        <div class="form-card">
            <!-- Превью обложки -->
            <div class="cover-preview">
                <img src="{{ $album->cover_url }}" alt="Обложка отсутствует">
            </div>
            <form method="POST" action="/albums/{{ $album->id }}" class="form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Название</label>
                    <input type="text" name="title" value="{{ $album->title }}" placeholder="Введите название">
                </div>
                <div class="form-group">
                    <label>Исполнитель</label>
                    <input type="text" name="artist" value="{{ $album->artist }}" placeholder="Введите исполнителя">
                </div>
                <div class="form-group">
                    <label>Описание</label>
                    <textarea name="description" placeholder="Краткое описание">{{ $album->description }}</textarea>
                </div>
                <div class="form-group">
                    <label>Год выпуска</label>
                    <input type="text" name="year" value="{{ $album->year }}" placeholder="Например: 2020">
                </div>
                <div class="form-group">
                    <label>Ссылка на обложку</label>
                    <input type="text" name="cover_url" value="{{ $album->cover_url }}" placeholder="Введите ссылку">
                </div>
                <button class="btn edit" type="submit">💾 Обновить</button>
            </form>
        </div>
    </div>
</body>
</html>