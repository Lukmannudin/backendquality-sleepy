<?php 
namespace App\Http\Controllers\Informasi;
use Symfony\Component\HttpFoundation\Request;
use DB;
use Redirect;
use App\Http\Controllers\Controller;
use View;
use Session;

class DashboardController extends Controller
{
	public function lihat(){
		if(Session::has('username')){
			$artikel = DB::table('artikel')
					->select(DB::raw('count(*) as totalArtikel'))
					->first();
			$tips = DB::table('tips')
					->select(DB::raw('count(*) as totalTips'))
					->first();

			$data = [
					'totalArtikel' => $artikel->totalArtikel,
					'totalTips' => $tips->totalTips
				];
			return View::make('dashboard')->with('dashboard',$data);
		} else {
			return view('login');
		}
	}
}