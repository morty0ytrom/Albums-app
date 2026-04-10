<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    // функция отображения
    public function index()
    {
        // $albums = Album::all(); // берем все альбомы из базы
        $albums = Album::simplePaginate(4);

        return view('albums.index', compact('albums'));
    }

    // функция создания
    public function create()
    {
        return view('albums.create');
    }

    // функция сохранения
    public function store(Request $request)
    {
        $album = Album::create([
            'title' => $request->title,
            'artist' => $request->artist,
            'description' => $request->description,
            'year' => $request->year,
            'cover_url' => $request->cover_url,
        ]);

        Log::info('Создан альбом', [
            'id' => $album->id,
            'title' => $album->title,
            'user_id' => Auth::id(),
            'ip' => request()->ip()
        ]);

        return redirect('/albums');
    }

    // функция редактирования
    public function edit($id)
    {
        $album = Album::findOrFail($id);

        return view('albums.edit', compact('album'));
    }

    // функция обновления
    public function update(Request $request, $id)
    {
        $album = Album::findOrFail($id);

        // сохраняем старые данные
        $oldData = $album->toArray();

        $album->update([
            'title' => $request->title,
            'artist' => $request->artist,
            'description' => $request->description,
            'year' => $request->year,
            'cover_url' => $request->cover_url,
        ]);

        Log::info('Обновлён альбом', [
            'id' => $album->id,
            'user_id' => Auth::id(),
            'old' => $oldData,
            'new' => $album->toArray(),
            'ip' => request()->ip()
        ]);

        return redirect('/albums');
    }

    // функция удаления
    public function destroy($id)
    {
        $album = Album::findOrFail($id);

        // сохраняем данные до удаления
        $albumData = $album->toArray();

        $album->delete();

        Log::warning('Удалён альбом', [
            'id' => $id,
            'user_id' => Auth::id(),
            'data' => $albumData,
            'ip' => request()->ip()
        ]);

        return redirect('/albums');
    }

    // функция получения информации о альбоме
    // public function getAlbumInfo(Request $request)
    // {
    //     $title = $request->title;

    //     $response = Http::get('https://ws.audioscrobbler.com/2.0/', [
    //         'method' => 'album.search',
    //         'album' => $title,
    //         'api_key' => 'bb7b6c83408f8eb419952616c05daabc',
    //         'format' => 'json',
    //     ]);

    //     return response()->json($response->json());
    // }

    public function fetchFromApi(Request $request)
    {
        $album = $request->query('album');

        if (!$album) {
            return response()->json([
                'error' => 'Album name is required'
            ], 400);
        }

        $apiKey = env('LASTFM_API_KEY');

        $response = Http::get('http://ws.audioscrobbler.com/2.0/', [
            'method' => 'album.search',
            'album' => $album,
            'api_key' => $apiKey,
            'format' => 'json'
        ]);

        if (!$response->successful()) {
            return response()->json([
                'error' => 'API request failed'
            ], 500);
        }

        $data = $response->json();

        $results = $data['results']['albummatches']['album'][0] ?? null;

        if (!$results) {
            return response()->json([
                'error' => 'No album found'
            ], 404);
        }

        return response()->json([
            'artist' => $results['artist'],
            'image' => $results['image'][2]['#text'] ?? null,
            'name' => $results['name']
        ]);
    }
}
