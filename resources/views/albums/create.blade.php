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
        <h1>➕ Создание альбома</h1>

        <div class="form-card">
            <!-- Заглушка вместо превью -->
            <div class="cover-preview">
                <img id="preview" src="https://via.placeholder.com/180" alt="Обложка отсутствует">
            </div>

            <form method="POST" action="/albums" class="form">
                @csrf

                <div class="form-group">
                    <label>Название</label>
                    <input type="text" id="title" name="title" placeholder="Введите название">
                </div>

                <button type="button" class="btn-api" onclick="loadAlbum()">🔍 Заполнить из API</button>

                <div class="form-group">
                    <label>Исполнитель</label>
                    <input type="text" name="artist" placeholder="Введите исполнителя">
                </div>

                <div class="form-group">
                    <label>Описание</label>
                    <textarea name="description" placeholder="Краткое описание"></textarea>
                </div>

                <div class="form-group">
                    <label>Год выпуска</label>
                    <input type="text" name="year" placeholder="Например: 2020">
                </div>

                <div class="form-group">
                    <label>Ссылка на обложку</label>
                    <input type="text" name="cover_url" id="cover_url" placeholder="URL изображения">            </div>

                <button class="btn edit" type="submit">💾 Сохранить</button>
            </form>
        </div>
    </div>

<script>
    const input = document.getElementById('cover_url');
    const preview = document.getElementById('preview');

    input.addEventListener('input', () => {
        const url = input.value;

        if (url) {
            preview.src = url;
        } else {
            preview.src = 'https://via.placeholder.com/180';
        }
    });
</script>

</body>
</html>

<script>
// function loadAlbum() {
//     let title = document.getElementById('title').value;

//     if (!title) {
//         alert('Введи название альбома');
//         return;
//     }

//     fetch('/api/album-info?title=' + encodeURIComponent(title))
//         .then(res => res.json())
//         .then(data => {
//             console.log(data);

//             let album = data.results?.albummatches?.album[0];

//             if (!album) {
//                 alert('Альбом не найден');
//                 return;
//             }

//             // заполняем форму
//             document.querySelector('[name="artist"]').value = album.artist || '';

//             let image = album.image?.[2]?.['#text'] || '';

//             document.querySelector('[name="cover_url"]').value = image;

//             // обновляем превью
//             if (image) {
//                 document.getElementById('preview').src = image;
//             }
//         })
//         .catch(err => {
//             console.error(err);
//             alert('Ошибка при загрузке данных');
//         });
// }

async function fillFromApi() {
    const album = document.querySelector('#album_name').value;

    const res = await fetch(`/albums/fetch?album=${album}`);
    const data = await res.json();

    if (data.error) {
        alert(data.error);
        return;
    }

    document.querySelector('#artist').value = data.artist;
    document.querySelector('#image').value = data.image;

    // превью
    document.querySelector('#preview').src = data.image;
}
</script>