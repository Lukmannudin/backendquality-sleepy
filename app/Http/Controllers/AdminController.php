<?php
namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller 
{
	
	public function login(Request $request)
	{	
		$data = [
			'email' => $request->email,
			'password' => $request->password
		];
		$userAdmin = DB::table('user')
						->where('jenis','Admin')
						->where('email',$data['email'])
						->first();

		$username = $data['email'];
		$name = "Bayu Wijaya";
		$password = "bayubayyz";

		if($userAdmin && $data['password'] === $password){
			Session::put('username', $data['email']);
			Session::put('name', $userAdmin->nama);
			return Redirect::to('/admin/home');
		} else if ($userAdmin && $data['password'] !== $password){
			Session::flash('message', 'Pasword yang Anda masukkan tidak sesuai!');
			return view('login')->with('message','Pasword yang Anda masukkan tidak sesuai!');
		} else if (!$userAdmin && $data['password'] === $password){
			Session::flash('message', 'Email yang Anda masukkan tidak sesuai!');
			return view('login')->with('message','Email yang Anda masukkan tidak sesuai!');
		} else {
			Session::flash('message', 'Email dan Password yang Anda masukkan tidak sesuai!');
			return view('login')->with('message','Email dan Password yang Anda masukkan tidak sesuai!');
		}
	}
	
	public function ceklogin()
	{
		if(Session::has('username')){
			return Redirect::to('/admin/home');
		} else {
			return view('login');
		}
	}
}