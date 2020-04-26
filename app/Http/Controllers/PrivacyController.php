<?php
namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use Illuminate\Support\Facades\DB;
class PrivacyController extends Controller 
{
	public function lihat()
	{
		return view('welcome/privacypolicy');
		
	}
}