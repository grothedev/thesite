<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KVController extends Controller
{

    public $dir='./kvs/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $d=$this->dir;
        $keys = scandir($this->d);
        $m = [];
        foreach ($keys as $k){
            $f=$d.$k;
            if ($k == '.' || $k == '..') continue;
            $v = fread( fopen($f, 'r'), filesize($f) );
            $m[$k]=$v;  
        }
        return $m;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    { //FUTURE appending? 
        if (is_null($req->auth)) return 'no auth';
        if ($req->auth != env('ADMIN_PASS')) return 'incorrect auth';
        $fn = $this->dir.$req->k;
        return file_put_contents($fn, $req->v); 
    }

    /**
     * Display the specified resource.
     *
     * @param  String k 
     * @return \Illuminate\Http\Response
     */
    public function show($k)
    {
        $d=$this->dir;
        $fn = $d.$k;
        $file = fopen($fn, 'r') or die('key not found');
        $v = fread($file, filesize($fn));
        return $v;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
