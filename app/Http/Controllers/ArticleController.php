<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $articles = Article::with(['highResolution']);

        //El metodo search pertenece a la libreria nicolaslopezj/searchable
        //la cual da compatibilidad de busqueda en las diferentes bases de datos

        $articles->search($request->input('query'), null, true, true);
        $articles->orderByDesc('id');

        return $articles->get();
    }
}
