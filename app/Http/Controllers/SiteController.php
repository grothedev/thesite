<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

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
		
		$result = $client-send($req);
		
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
}

?>
