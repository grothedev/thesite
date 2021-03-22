<?php

namespace App\Http\Controllers;

use App\Models\Podcast;
use Illuminate\Http\Request;

class PodcastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pods = Podcast::all()->sortBy('day', SORT_DESC, true);
        return view('pod.index', compact('pods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pod.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO obviously better auth
		if ($request->password != env('ADMIN_PASS')) return 'no auth' . redirect('pod');

		$p = new Podcast;
		$p->people = $request->people;
		$p->description = $request->description;
		$p->day = $request->day;

		//uploading recording to API
		$api_url = 'http://grothe.ddns.net:8090/api/files';
		$f = $request->file('f');
		$post = [];

		$path = realpath($f->path());
		$filename = 'pod_' . $p->day . '_' . $p->people . '.' . $f->extension();
		$post['f'] = curl_file_create($path, null, $filename);

        $p->filename = $filename;


		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$res = json_decode(curl_exec($ch));

		//var_dump($res);

		foreach ($res as $r){
			if ($r->success == true){
				$uploadPath = '/f/' . $r->filename;
				print('<a href = "' . $uploadPath . '">' . $r->filename . ' successfully uploaded</a><br>');
			} else {
				print($r->msg);
			}
		}

		//$p->filename = $res[0]->filename;


      return $p->save() . 'Podcast added.<br>' . redirect('podcasts');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Podcast  $podcast
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pod = Podcast::find($id)->first();
        return view('pod.show', compact($pod));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Podcast  $podcast
     * @return \Illuminate\Http\Response
     */
    public function edit(Podcast $podcast)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Podcast  $podcast
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Podcast $podcast)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Podcast  $podcast
     * @return \Illuminate\Http\Response
     */
    public function destroy(Podcast $podcast)
    {
        //
    }
}
