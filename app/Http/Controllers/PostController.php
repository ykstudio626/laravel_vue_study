<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;

class PostController extends Controller
{

    public function __construct(){
        //$this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('category')->paginate(8);
        return view('index' , ['posts' => $posts]);
    }

    public function search(Request $request){
        $word = $request->input('word');
        $posts = Post::where('content' , 'like' , "%{$word}%")
                ->orWhere('title' , 'like' , "%{$word}%")
                ->paginate(8);
        return view('index' , ['posts' => $posts , 'word' => $word]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = array(array());
        return view('create' , ['mode' => 'new' , 'post' => $post]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $vdata = $request->validate([
            'title' => 'required|max:100',
            'content' => 'required|max:200'
        ]);

        $title = $request->input('title');
        $content = $request->input('content');
        $image = $request->input('image');
        $category_id = $request->input('image');

        //file保存
        /*
        ajax方式なのでスキップ
        if(!empty($request->file('file'))){
            if($request->file('file')->isValid()){
                $ext = $request->file('file')->getClientOriginalExtension();//拡張子
                $original_name = $request->file('file')->getClientOriginalName();//元ファイル名
                $filename = $original_name;
                $file = $request->file('file')->move($new_path , $filename);
                //$request->file('file')->store('images');//これだとstorageに保存される
            }else{
                $error = $request->file('file')->getErrorMessage();
                return redirect('/')->with('error' , $error );
            }
        }
        */

        $data = [
                'title' => $title ,
                'content' => $content,
                'image' => $image,
                'category_id' => $category_id
                ];


        Post::insert($data);

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::where('id',$id)->first();
        $categories = Category::options();
        return view('show' , ['post' => $post , 'categories' => $categories ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::where('id',$id)->first();
        $categories = Category::options();
        $mode = 'edit';
        return view('create' , ['post' => $post , 'mode' => 'edit' , 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $vdata = $request->validate([
            'title' => 'required|max:100',
            'content' => 'required|max:200'
        ]);

        $new_path = public_path().'/user_images/';

        $title = $request->input('title');
        $content = $request->input('content');
        $image = $request->input('image');
        $category_id = $request->input('category_id');
        
        
        //file保存
        /*
        ajax方式につきスキップ
        if(!empty($request->file('file'))){
            if($request->file('file')->isValid()){
                $ext = $request->file('file')->getClientOriginalExtension();//拡張子
                $original_name = $request->file('file')->getClientOriginalName();//元ファイル名
                $filename = $original_name;
                $file = $request->file('file')->move($new_path , $filename);
                //$request->file('file')->store('images');//これだとstorageに保存される
            }else{
                $error = $request->file('file')->getErrorMessage();
                return redirect('/')->with('error' , $error );
            }
        }
        */

        $data = [
                'title' => $title ,
                'content' => $content,
                'image' => $image,
                'category_id' => $category_id
                ];

        //if($filename)$data['image'] = $filename;//ファイルが選択された時のみ付加

        Post::where('id' , $id)->update($data);

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::where('id' , $id)->delete();
        return redirect('/');   
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'タイトルは必須です',
            'content.required'  => '本文は必須です',
        ];
    }
}
