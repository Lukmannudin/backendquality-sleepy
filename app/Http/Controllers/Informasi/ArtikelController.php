<?php 
namespace App\Http\Controllers\Informasi;
use Symfony\Component\HttpFoundation\Request;
use Input;
use DB;
use Redirect;
use App\Http\Controllers\Controller;
use View;
use Session;
use File;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;
use FCM;

class ArtikelController extends Controller
{

	public function index(Request $request){
		$data = DB::table('artikel')->orderBy('tanggal','DESC')->paginate(8);
		$page = $request->page;
		return view('artikel.view', ['artikel'=>$data, 'page'=>$page]);
	}

	public function lihat(){
		if(Session::has('username')){
			$data = DB::table('artikel')->get();
			return View::make('artikel.view')->with('artikel',$data);
		} else {
			return view('login');
		}
	}

	public function detail($id){
		if(Session::has('username')){
			$data = DB::table('artikel')
				->where('id',$id)
				->first();
			return View::make('artikel.detail')->with('artikel',$data);
		} else {
			return view('login');
		}
	}

	public function buat(){
		if(Session::has('username')){
			return View::make('artikel.create');
		} else {
			return view('login');
		}
	}


	public function create(Request $request)
	{
	    if(Session::has('username')){
			$this->validate($request, [
				        'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
				    ]);


		    if($request->file('gambar') == ''){
                $fileName = 'diamondsleep.jpg';
            }else{
			  	$a = @getimagesize($request->file('gambar'));
	    		$image_type = $a[2];

			  	if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP))) {
			  		$destinationPath = public_path('/uploads/images');
				    $extension = $request->file('gambar')->getClientOriginalExtension(); // getting image extension
	              
	                $fileName = 'artikel'.str_slug($request->input('judul'), "-").'.'.$extension; // renameing image
	                $request->file('gambar')->move($destinationPath, $fileName);
			  	} 		    
            }

            $notificationBuilder = new PayloadNotificationBuilder($request->input('judul'));
            
            	if($request->input('sumber') == ''){
		            	$sumber = "-";
		            	$notificationBuilder->setBody('Artikel Baru')
							    ->setSound('default');
		        } else {
		          	$sumber = $request->input('sumber');
		          	$artikelsumber = 'Artikel - '.$sumber;
		          	$notificationBuilder->setBody($artikelsumber)
							    ->setSound('default');
		        }

				$data = [
					'email' => Session::get('username'),
					'judul' => $request->input('judul'),
					'gambar' => $fileName,
					'isi' => $request->input('isi'),
					'sumber' => $sumber,
					'tanggal' => date('Y-m-d')
				];

//push notif
			
			
							    
			$notification = $notificationBuilder->build();

			$topic = new Topics();
			$topic->topic('posting');

			$topicResponse = FCM::sendToTopic($topic, null, $notification, null);
				$topicResponse->isSuccess();
				$topicResponse->shouldRetry();
				$topicResponse->error();			
//push notif

				$insert_artikel = DB::table('artikel')->insert($data);
			    Session::flash('success', 'Artikel berhasil ditambah!');
			    return Redirect::to('/admin/artikel')->with('status','Artikel dengan judul '.$request->input('judul').' berhasil ditambah!');
		} else {
			return view('login');
		}
	}

	public function delete($id)
	{
		if(Session::has('username')){
			$check = DB::table('artikel')->where('id', $id)->first();
			$judul = $check->judul;
	        $delete = DB::table('artikel')->where('id', $id);
	                    if($check->gambar != 'diamondsleep.jpg'){
	                        File::delete('/uploads/images/' . $check->gambar);
	                     }   
	                
	        $delete->delete();
	        if($delete){
	        	Session::flash('success', 'Artikel berhasil dihapus.');
				return Redirect::to('/admin/artikel')->with('status','Artikel berjudul '.$judul.' berhasil dihapus!');
	        } else {
	        	Session::flash('failed', 'Artikel gagal dihapus.');
				return Redirect::to('/admin/artikel')->with('status','Artikel berjudul '.$judul.' gagal dihapus!');
	        }

			
		} else {
			return view('login');
		}
	}

	public function ubah($id)
	{
		if(Session::has('username')){
			$data = DB::table('artikel')
				->where('id',$id)
				->first();
			return View::make('artikel.edit')->with('artikel',$data);
		} else {
			return view('login');
		}
	}

	public function edit($id,Request $request)
	{
		if(Session::has('username')){
			$check = DB::table('artikel')->where('id',$id)->get();
	        $edit = DB::table('artikel')->where('id',$id);
	        if($request->file('gambar') == ''){
	            foreach ($check as $gambar) {
	            	$fileName = $gambar->gambar;
	            }
	        }else{
	        	foreach ($check as $gambar) {
	            	File::delete('/uploads/images/' . $gambar->gambar);
	            }
	            $destinationPath = '/uploads/images'; // upload path
	            $extension = $request->file('gambar')->getClientOriginalExtension(); // getting image extension
	            $fileName = 'artikel'.str_slug($request->input('judul'), "-").'.'.$extension; // renameing image
	            $request->file('gambar')->move($destinationPath, $fileName);
	        }

	        $data = [
	                    'judul' => $request->input('judul'),
	                    'gambar' => $fileName,
	                    'isi' => $request->input('isi'),
	                    'sumber' => $request->input('sumber')
	                ];

	        $edit->update($data);
	       	if($edit){
	       		Session::flash('success', 'Artikel berhasil diubah.');
				return Redirect::to('/admin/artikel')->with('status','Artikel berhasil diubah!');
	       	} else {
	       		Session::flash('failed', 'Artikel gagal diubah.');
				return Redirect::to('/admin/artikel')->with('status','Artikel gagal diubah!');
	       	}
		} else {
			return view('login');
		}
	}

}