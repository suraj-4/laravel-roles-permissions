<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;



class articleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware ('permission:view articles', only :['showArticle']), 
            new Middleware ('permission:edit articles', only :['editArticle']), 
            new Middleware ('permission:create articles', only :['createArticle']), 
            new Middleware ('permission:delete articles', only :['destroyArticle']), 
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function showArticle()
    {
        $articles = Article::orderby('created_at', 'asc')->paginate(4);
        return view('articles.list',['articles' => $articles]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function createArticle()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeArticle(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|unique:articles|min:5',
            'author' => 'required|min:5',
        ]);

        if($validator->passes()) {
            Article::create([
                'title' => $request->title,
                'description' => $request->description,
                'author' => $request->author,
            ]);
            return redirect()->route('article.index')->with('success','Articles created successfully.');
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editArticle(string $id)
    {
        $article = Article::find($id);
        return view('articles.edit', ['article' => $article]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateArticle(Request $request, string $id)
    {
        $article = Article::find($id);
        $validator = Validator::make($request->all(),[
            'title' => 'required|min:5,'.$id.',id',
            'author' => 'required|min:5',
        ]);

        if($validator->passes()) {
            $article->title = $request->title;
            $article->description = $request->description;
            $article->author = $request->author;
            $article->save();
            return redirect()->route('article.index')->with('success','Article updated successfully.');
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyArticle(Request $request)
    {
        $id = $request->id;
        $article = Article::find($id);

        if ($article == null){
            session()->flash('error', 'Article not found');
            return response()->json(['status' => false]);
        }

        $article->delete();

        session()->flash('success', 'Article deleted Successfully');
        return response()->json(['status' => true]);
    }
}
