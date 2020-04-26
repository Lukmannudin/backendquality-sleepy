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

class TipsController extends Controller
{
	public function index(Request $request){
		$tips = DB::table('tips')->orderBy('tanggal','DESC')->paginate(8);
		
		$page = $request->page;
		return view('tips.view', ['tips'=>$tips, 'page'=>$page]);
	}

	public function lihat(){
		if(Session::has('username')){
			$data = DB::table('tips')->get();
			return View::make('tips.view')->with('tips',$data);
		} else {
			return view('login');
		}
	}

	public function detail($id) {
		if(Session::has('username')){
			$data = DB::table('tips')
				->where('id',$id)
				->first();
			return View::make('tips.detail')->with('tips',$data);
		} else {
			return view('login');
		}
	}

	public function buat(){
		if(Session::has('username')){
			return View::make('tips.create');
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
			    $destinationPath = public_path('/uploads/images');
			    $extension = $request->file('gambar')->getClientOriginalExtension();
                $fileName = 'tips'.str_slug($request->input('judul'), "-").'.'.$extension;
                $request->file('gambar')->move($destinationPath, $fileName);
            }
            if($request->input('sumber') == ''){
            	$sumber = '-';
            } else {
            	$sumber = $request->input('sumber');
            }
		    $data = [
				'email' => Session::get('username'),
				'judul' => $request->input('judul'),
				'kategori' => $request->input('kategori'),
				'gambar' => $fileName,
				'isi' => $request->input('isi'),
				'sumber' => $sumber,
				'tanggal' => date('Y-m-d')
			];

			$tipskategori = 'Tips - '.$request->input('kategori');
			$notificationBuilder = new PayloadNotificationBuilder($request->input('judul'));
			$notificationBuilder->setBody($tipskategori)
							    ->setSound('default');
							    
			$notification = $notificationBuilder->build();

			$topic = new Topics();
			$topic->topic('posting');

			$topicResponse = FCM::sendToTopic($topic, null, $notification, null);
				$topicResponse->isSuccess();
				$topicResponse->shouldRetry();
				$topicResponse->error();	

		    $insert_tips = DB::table('tips')->insert($data);
		    Session::flash('success', 'tips berhasil ditambah!');

		    return Redirect::to('/admin/tips')->with('status','Tips dengan judul '.$request->input('judul').' berhasil ditambah!');
		} else {
			return view('login');
		}
	}

	public function delete($id)
	{
		if(Session::has('username')){

			$check = DB::table('tips')->where('id', $id)->first();
			$judul = $check->judul;

	        $delete = DB::table('tips')->where('id', $id);
	                    if($check->gambar != 'diamondsleep.jpg'){
	                        File::delete('/uploads/images/' . $check->gambar);
	                     }   
	        $delete->delete();
	        if($delete){
	        	Session::flash('success', 'Tips berhasil dihapus.');
				return Redirect::to('/admin/tips')->with('status','Tips berjudul '.$judul.' berhasil dihapus!');
	        } else {
	        	Session::flash('failed', 'Tips gagal dihapus.');
				return Redirect::to('/admin/tips')->with('status','Tips berjudul '.$judul.' gagal dihapus!');
	        }
		} else {
			return view('login');
		}
	}

	public function ubah($id)
	{
		if(Session::has('username')){
			$data = DB::table('tips')
				->where('id',$id)
				->first();
			return View::make('tips.edit')->with('tips',$data);
		} else {
			return view('login');
		}
	}

	public function edit($id,Request $request)
	{
		if(Session::has('username')){
			$check = DB::table('tips')->where('id',$id)->get();
	        $edit = DB::table('tips')->where('id',$id);
	        if($request->file('gambar') == ''){
	            foreach ($check as $gambar) {
	            	$fileName = $gambar->gambar;
	            }
	        }else{
	        	foreach ($check as $gambar) {
	            	File::delete('/uploads/images' . $gambar->gambar);
	            }
	            $destinationPath = '/uploads/images'; 
	            $extension = $request->file('gambar')->getClientOriginalExtension();
	            $fileName = 'tips'.str_slug($request->input('judul'), "-").'.'.$extension; 
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
	       		Session::flash('success', 'Tips berhasil diubah.');
				return Redirect::to('/admin/tips')->with('status','Tips berhasil diubah!');
	       	} else {
	       		Session::flash('failed', 'Tips gagal diubah.');
				return Redirect::to('/admin/tips')->with('status','Tips gagal diubah!');
	       	}
		} else {
			return view('login');
		}
	}

}