<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KVController extends Controller
{

    public $dir='./kvs/'; //the directory where all the files (keys) storing the values are located

    /**
     * 
     * 
     * @return String a json associative array (map) of all the key-value pairs
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
     *
     * @param  String k
     * @return String the text representation of data stored in file (k), or an empty string if that key doesn't exist
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
     * 
     * @param String $k key
     * @return String the last modified time of the file representing key k 
     */
    public function getTimestamp($k){
        $d=$this->dir;
        $fn = $d.$k;
        if (file_exists($fn) && filesize($fn) > 0){
            return filemtime($fn);
        }
        return -1;
    }

    /**
     * Stores a new key & value as a file (k) with contents (v) in the directory configured in this class.
     * requires admin password (auth)
     *
     * @param  \Illuminate\Http\Request  $req  a POST request with the values: k, v, auth
     * @return int number of bytes written
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
}
