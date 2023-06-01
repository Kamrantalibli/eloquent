<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Article;
use App\Models\User;
use App\Http\Requests\ArticleCreateRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Http\Requests\ArticleFilterRequest;

class ArticleController extends Controller
{

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware('language');
    }

    public function index(ArticleFilterRequest $request) {
        $users = User::all();
        $categories = Category::all();

        $list = Article::query()
                        ->with(['category', 'user'])
                        ->where(function($query) use ($request) {
                            $query->orWhere('title', 'LIKE', '%' . $request->search_text)
                                  ->orWhere('slug', 'LIKE', '%' . $request->search_text)
                                  ->orWhere('body', 'LIKE', '%' . $request->search_text)
                                  ->orWhere('tags', 'LIKE', '%' . $request->search_text);
                        })
                        ->status($request->status)
                        ->category($request->category_id)
                        ->user($request->user_id)
                        ->publishDate($request->publish_date)
                        ->paginate(5);
        return view('admin.articles.list', compact('users', 'categories', 'list'));
    }

    public function create() {

        $categories = Category::all();

        return view('admin.articles.create-update', compact('categories'));
    }

    public function store(ArticleCreateRequest $request) {

        $imageFile = $request->file('image');
        $originalName = $imageFile->getClientOriginalName();
        $originalExtension = $imageFile->getClientOriginalExtension();
        // $originalExtension = $imageFile->extension();
        $explodeName = explode('.', $originalName)[0];
        $fileName = Str::slug($explodeName) . '.' . $originalExtension;

        $folder = 'articles';
        $publicPath = 'storage/'. $folder;

        if(file_exists(public_path($publicPath . $fileName))) {
            
            return redirect()->back()->withErrors([
                'image' => 'Same image already uploaded.'
            ]);

        }

        $data = $request->except('_token');
        $slug = $data['slug'] ?? $data['title'];
        $slug = Str::slug($slug);
        $slugTitle = Str::slug($data['title']);   


        $checkSlug = $this->slugCheck($slug);

        if(!is_null($checkSlug)) {
            $checkTitleSlug = $this->slugCheck($slugTitle);
            if(!is_null($checkTitleSlug)) {
                // If title Slug is not empty
                $slug = Str::slug($slug . time());
            }
            else {
                $slug = $slugTitle;
            }
        }

        $data['slug'] = $slug;
        $data['image'] = $publicPath . '/' . $fileName;
        $data['user_id'] = auth()->id();
        // $data['user_id'] = auth()->user()->id;
        // $data['user_id'] = \Auth::id();
        // $data['user_id'] = \Auth::user()->id;

        Article::create($data);
        $imageFile->storeAs($folder, $fileName, 'public'); /** storage/app/public/articles/$fileName  create */

        alert()
            ->success("Successful", "Category Saved")
            ->showConfirmButton('OK', '#3085d6')
            ->autoClose(5000);

        return redirect()->back();



        dd($fileName);
        dd($request->all());
    }

    public function edit(Request $request, int $articleID) {
        // $article = Article::find($articleID);
        // $article = Article::where('id', $articleID)->firstOrFail();
        $article = Article::query()->where('id', $articleID)->first();
        $categories = Category::all();
        $users = User::all();

        if(is_null($article)) {
            $statusText = 'Article not found';

            alert()->error('Error', $statusText)->showConfirmButton('OK', '#3085d6')->autoClose(5000);
            return redirect()->route('article.index');
        }

        return view('admin.articles.create-update', compact('article', 'categories', 'users'));
        dd($article);
    }

    public function update(ArticleUpdateRequest $request) {

        $data = $request->except('_token');
        $slug = $data['slug'] ?? $data['title'];
        $slug = Str::slug($slug);
        $slugTitle = Str::slug($data['title']);   


        $checkSlug = $this->slugCheck($slug);

        if(!is_null($checkSlug)) {
            $checkTitleSlug = $this->slugCheck($slugTitle);
            if(!is_null($checkTitleSlug)) {
                // If title Slug is not empty
                $slug = Str::slug($slug . time());
            }
            else {
                $slug = $slugTitle;
            }
        }
        
        $data['slug'] = $slug;

        if(!is_null($request->image)) {
            $imageFile = $request->file('image');
            $originalName = $imageFile->getClientOriginalName();
            $originalExtension = $imageFile->getClientOriginalExtension();
            // $originalExtension = $imageFile->extension();
            $explodeName = explode('.', $originalName)[0];
            $fileName = Str::slug($explodeName) . '.' . $originalExtension;
    
            $folder = 'articles';
            $publicPath = 'storage/'. $folder;

            if(file_exists(public_path($publicPath . $fileName))) {
            
                return redirect()->back()->withErrors([
                    'image' => 'Same image already uploaded.'
                ]);
    
            }

            $data['image'] = $publicPath . '/' . $fileName;
        }

        $data['user_id'] = auth()->id();

        $articleQuery = Article::query()
                 ->where('id', $request->id);

        $articleFind = $articleQuery->first();

        $articleQuery->update($data);

        if(!is_null($request->image)) {
            // Storage::delete(public_path($articleFind->image));
            if(file_exists(public_path($articleFind->image))) {
                \File::delete(public_path($articleFind->image));
            }
            $imageFile->storeAs($folder, $fileName);
        }

        alert()
            ->success("Successful", "Article Updated")
            ->showConfirmButton('OK', '#3085d6')
            ->autoClose(5000);

        return redirect()->route('article.index');
    }
    
    public function slugCheck(string $text) {
        return Article::where('slug',$text)->first();
    }
}
