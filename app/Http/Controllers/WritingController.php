<?php

namespace App\Http\Controllers;

use App\Writing;
use App\Comment;
use Illuminate\Http\Request;

class WritingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $writings = Writing::all();
        return view('blog.index', compact('writings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->input('password') != env('ADMIN_PASS')){
            return 'no auth' . redirect('writings');
        }

        
        $w = new Writing;
        $w->title = $request->input('title');
        $w->content = htmlentities($request->input('content'));
        $w->save();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Writing  $writing
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $w = Writing::find($id);
        $comments = Comment::where('w_id', '=', $id)->get();
        return view('blog.show', compact('w', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Writing  $writing
     * @return \Illuminate\Http\Response
     */
    public function edit(Writing $writing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Writing  $writing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Writing $writing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Writing  $writing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Writing $writing)
    {
        //
    }
}
