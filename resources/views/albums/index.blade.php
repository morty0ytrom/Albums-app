<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Справочник</title>

    @vite('resources/css/app.css')
</head>

<body>
<header>
    <h1 class="m-1">🎵 Список альбомов</h1>

    <div class="header-btn">
        <a class="btn-create" href="/albums/create">Создать альбом</a>
        <a class="btn-profile" href="/profile">Профиль</a>
    </div>
</header>

<div class="container">
    <div class="grid">
        @foreach ($albums as $album)
            <div class="card">
                <img class="cover" src="{{ $album->cover_url }}">

                <div class="content">
                    <div class="title">{{ $album->title }}</div>
                    <div class="artist">{{ $album->artist }}</div>
                    <div class="desc">{{ $album->description }}</div>
                    <div class="year">{{ $album->year }} год</div>
                </div>

                <div class="actions">
                    <a class="btn edit" href="/albums/{{ $album->id }}/edit">Редактировать</a>

                    <form action="/albums/{{ $album->id }}" method="POST" onsubmit="return confirm('Точно удалить этот альбом?')">
                        @csrf
                        @method('DELETE')

                        <button class="btn delete" type="submit">
                            Удалить
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="paginator">
    {{ $albums->links() }}
</div>
</body>
</html>