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
    public function index(Request $req)
    {
        $d=$this->dir;
        $m = []; //map to return
        
        $keys = scandir($d);
        if ($req->k){ //use custom requested keys
            $keys = explode(',', $req->k);
        }
        
        $ts = false; //retrieve timestamp?
        if ($req->t && $req->t != '0'){
            $ts = true;
        } 
        
        foreach ($keys as $k){
            $f=$d.$k;
            if ($k == '.' || $k == '..') continue;
            if (filesize($f)==0) continue;
            $v = fread( fopen($f, 'r'), filesize($f) );
            if ($ts){
                $m[$k] = ['v' => $v, 't' => filemtime($f)];
            } else {
                $m[$k]=$v; 
            } //? should the structure of the returned map remain the same whether including timestamp or not? reason not to is i like the simplicity of response[key] = value, instead of response[key][v] = value.
        }
        return $m;
    }

    /** 
     *
     * @param  String k
     * @return String the text representation of data stored in file (k), or an empty string if that key doesn't exist
     */
    public function show($k, Request $req)
    {
        $d=$this->dir;
        $fn = $d.$k;
        if (file_exists($fn) && filesize($fn)>0){
            $file = fopen($fn, 'r');
            $v = fread($file, filesize($fn));
            if ($req->t && $req->t != "0"){ //return with timestamp
                $res = array();
                $res['v'] = $v;
                $res['ts'] = filemtime($fn);
                return $res;
            } else {
                return $v;
            }
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
        if (Auth::user()!=null && Auth::user()->admin) { //for now only admin, but can set up users later
            $fn = $this->dir.$req->k;
            if (file_exists($fn)){
                copy($fn, $fn.Carbon::now()); //keep old versions
                $num_entries = substr_count( shell_exec('ls | grep ' . $fn), '\n' );
                if ($num_entries > 5){ //TODO age off old entries
                    shell_exec('i=0; for f in `ls -lrt | grep'.$fn.'`; do  if [[ i < '.$num_entries.'-5 ]]; then rm $f; i=i+1; fi; done; ');
                }
            }
            return file_put_contents($fn, $req->v);
        } else {
            return 'no auth';
        }
    }
}
