<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SiteController extends Controller
{
    public function uploadFiles(Request $request){
		$f = $request->file('f');

		$client = new Client([
			'base_uri' => 'http://grothe.ddns.net'
		]); //GuzzleHttp\Client

		$mpData = [];
		for ($i = 0; $i < sizeof($f); $i++){
			array_push($mpData, [
				'name' => $request->f[$i]->getClientOriginalName(),
				'contents' => fopen($request->f[$i]->path(), 'r')
			]);
		}
		$req = $client->createRequest('POST', 'grothe.ddns.net/api/files', ['multipart' => [$mpData]]);
		$req->setPort(8090);

		$result = $client->send($req);

		/*$result = $client->post('grothe.ddns.net:8090/api/files', [
			'multipart' => [$mpData]

		]);*/


		return $result;

	}

	//add to queue to be pulled into my "working memory" document on laptop
	public function appendThought(Request $request){
		$t = $request->t;
		$t = $t . PHP_EOL;
		$f = fopen("t", "a") or die("cant open file");
		$s = 0;
		$s = fwrite($f, $t);
		fclose($f);
		return $s;
	}

	public function search4chan(Request $req){
		$bod = '';
		if ($req->b) $bod = $req->b;
		//TODO sanitize input
		$res = shell_exec('python search4chan.py ' . $req->q . ' ' . $bod);
		return view('4chan_search_res', compact($res));
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

	/**
	 * display music folder if authenticated
	 */
	public function music(){
		if (Auth::check()){//} && Auth::user()->name == 'music'){
			return view('music');
		} else {
			return redirect('login');
		}
	}

	public function restartMCServer(Request $req){
		if ($req->restart){
			if ($req->password == env('MC_ADMIN_PASS')){
				exec('/srv/mc/vh/shutdownMCServer_VH.sh');
				return view('mc_admin');
			} else {
				return 'NOT AUTHENTICATED';
			}
		} else {
			return view('mc_admin');
		}
	}

	public function cancelRestartMCServer(){
		exec('/srv/mc/vh/cancelShutdownMCServer_VH.sh');
	}
}
