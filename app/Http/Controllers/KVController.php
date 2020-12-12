<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $keys = scandir($d);
        $m = [];
        foreach ($keys as $k){
            $f=$d.$k;
            if ($k == '.' || $k == '..') continue;
            if (filesize($f)==0) continue;
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
        //csrf_field();
        if (is_null($req->auth)) return 'no auth';
        if ($req->auth != env('ADMIN_PASS')) return 'incorrect auth';
        $fn = $this->dir.$req->k;
        if (file_exists($fn)){
            copy($fn, $fn.Carbon::now()); //keep old versions
            $num_entries = substr_count( shell_exec('ls | grep ' . $fn), '\n' );
            if ($num_entries > 5){ //TODO age off old entries
                shell_exec('i=0; for f in `ls -lrt | grep'.$fn.'`; do  if [[ i < '.$num_entries.'-5 ]]; then rm $f; i=i+1; fi; done; ');
            }
        }

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
        if (file_exists($fn) && filesize($fn)>0){
            $file = fopen($fn, 'r');
            $v = fread($file, filesize($fn));
            return $v;
        } else{
            return '';
        }
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
