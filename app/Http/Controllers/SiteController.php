<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Requests;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SiteController extends Controller
{
	/** 
	* provide select environment variables to javascript
	*/
	public static function env(){
		$vars = [
			'FILEUPLOAD_URL' => env('FILEUPLOAD_URL'),
			'FILEUPLOAD_MAX_MB' => env('FILEUPLOAD_MAX_MB'),
			'FILEUPLOAD_CHUNK_MB' => env('FILEUPLOAD_CHUNK_MB')
		];
		return $vars;
	}

    public function uploadFiles(Request $request){
		$f = $request->file('f');

		$client = new Client([
			'base_uri' => env('FILES_API_URL') //'http://grothe.ddns.net'
		]); //GuzzleHttp\Client

		$mpData = [];
		for ($i = 0; $i < sizeof($f); $i++){
			array_push($mpData, [
				'name' => $request->f[$i]->getClientOriginalName(),
				'contents' => fopen($request->f[$i]->path(), 'r')
			]);
		}
		$req = $client->createRequest('POST', env('FILES_API_URL'), ['multipart' => [$mpData]]);
		$req->setPort(8090);

		$result = $client->send($req);

		/*$result = $client->post('grothe.ddns.net:8090/api/files', [
			'multipart' => [$mpData]

		]);*/


		return $result;

	}

	//modifies img dump files with 'tag' to be presented in the gallery
	public function uploadImgDump(Request $request){
		$files = $request->file('f');
		$api_url =   env('FILES_API_URL'); //'http://grothe.ddns.net:8090/api/files';
		// fileVar->getClientOriginalName() returns client filename
		
		$mpData = [];
		foreach ($files as $f){
			//var_dump($f);
			$filename = $f->getClientOriginalName();
			//print('<br>');
			array_push($mpData, [
				'name' => $filename,
				'contents' => fopen($f->path(), 'r')
				//? need header here?
			]);
		}
		//$req = $client->createRequest('POST', 'grothe.ddns.net/api/files', ['multipart' => [$mpData]]);
		//$req->setPort(8090);
		//? try with $client->request() instead of createRequest()
		//$result = $client->request('POST', 'http://grothe.ddns.net:8090/api/files', ['multipart' => $mpData]);
		//$result = $client->send($req);
		//return $result;
		//end guzzler stuff

		//rmccue requests attempt
		$resp = Requests::post($api_url, [], $mpData);
		return json_encode ( $resp );
	}

	//display the page to append some text to a "thought label" (e.g. todo, journal, poetry)
	public function writeThought($t){
		return view('note', compact('t'));
	}

	//add to queue to be pulled into my "working memory" document on laptop
	public function appendThought(Request $request){
		csrf_field();
		$tag = $request->tag;
		$text = $request->text;
		$text = $text . PHP_EOL;
		$f = fopen('t/' . $tag, "a") or die("cant open file");
		$s = 0;
		$s = fwrite($f, $text);
		fclose($f);
		return $s;
	}

	public function vidview($v){
		return view('vidview', compact('v'));
	}

	public function search4chan(Request $req){
		$bod = '';
		if ($req->b) $bod = $req->b;
		$shellcmd = escapeshellcmd('./search4chan.py ' . $req->q . ' ' . $bod);
		exec($shellcmd, $res, $ret);
		
		return view('4chan_search_res', compact('res'));
	}

	public function captureCameraImage(Request $req){
		#$p = new Process(['ffmpeg', '-f', 'v4l2', '-i', '/dev/video0', '-loglevel', 'quiet', '-vframes', '1', '-y', 'camcapture.png']);
		$p = new Process(['snapshot', '-loglevel', 'quiet', '-y', 'camcapture.png']);
		$p->run();

		if (!$p->isSuccessful()){
			throw new ProcessFailedException($p);
		}
		
		#exec('ffmpeg', $output, $ret);	
		#echo exec('ffmpeg -f v4l2 -i /dev/video0 -vframes 1 -y camcapture.png', $output, $ret);
		#var_dump($output);
		#var_dump($ret);
		#echo shell_exec('/usr/local/bin/snapshot -y camcapture.png');
		return view('cam');
	}

	/**
	 * get the json list of map points from API to pass into view
	 */
	public function getMap(Request $req){
		$wwp_api = ''; //TODO wwp rental property API URL
		$client = new Client();/*([
			'base_uri' => $wwp_api
		]);
		$req = $client->createRequest('GET', $wwp_api);
		$req->setPort(8080);
		$res = $client->send($req);
			*/
		$res = $client->request('GET', $wwp_api);
		return view('map', compact($res));
	}

	public function restartMCServer(Request $req){
		if ($req->restart){
			if ($req->password == env('MC_ADMIN_PASS')){
				exec('/srv/mc/scripts/shutdownMCServer.sh');
				return view('mc_admin');
			} else {
				return 'NOT AUTHENTICATED';
			}
		} else {
			return view('mc_admin');
		}
	}

	public function cancelRestartMCServer(Request $req){
		exec('/srv/mc/scripts/cancelShutdownMCServer.sh');
	}

	public function streamVideo(){
		//TODO auth
		//TODO accept from any client
		$cmd = "ffmpeg -f v4l2 -i /dev/video0 -f mpegts -"; //capture video from device and send to stdout
		return response()->stream(function() use ($cmd){
			$fh = popen($cmd, 'r'); //filehandle
			while (!feof($fh)){
				echo fread($fh, 1024);
				flush();
			}
			pclose($fh);
		}, 200, [
			'Content-Type' => 'video/mpeg',
		]);
	}
}
