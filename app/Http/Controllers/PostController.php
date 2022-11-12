<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Models\Post;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = QueryBuilder::for(Post::class)
            ->allowedSorts("id")
            ->allowedFilters('name', 'text')
            // ->allowedFilters(AllowedFilter::)
            // dd($users->toSql());
            ->toSql();
        dd($users);
        return new PostCollection($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:5'],
            'text' => ['required', 'min:5']
        ]);
        $post = new Post;
        $post->name = $request->name;
        $post->text = $request->text;
        $post->save();

        // return ['message' => "success"];
        return ['message' => "success", "data" => $post];
        // return response("1", 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $request->validate([
            'name' => ['required', 'min:5', 'alpha'],
            'text' => ['required', 'min:20']
        ]);
        $post = Post::findOrFail($id);
        $post->name = $request->name;
        $post->text = $request->text;
        $post->save();

        return ['message' => "success", "data" => $post];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id)->delete();
        return ['message' => "success", "data" => $post];
    }
}
