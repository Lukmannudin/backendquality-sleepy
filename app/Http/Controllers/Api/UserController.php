<?php 
namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use Carbon\Carbon;

class UserController extends Controller {
	public function loginDaftarUser(Request $request){
		$data = [
			'email' => $request->email,
			'nama' => $request->nama
		];
		$user_cek = DB::table('user')->where('email',$data['email'])->first();
		$insert_user = false;
		if($user_cek) {
			return response()->json(['status'=>201,'message'=>'Welcome back!','result'=>[$data]]);
		} else {
			$insert_user = DB::table('user')->insert($data);
			return response()->json(['status'=>200,'message'=>'Success saved!','result'=>[$data]]);
		}
	}
	public function simpanTidur(Request $request){
		$data = [
			'email' => $request->email,
			'waktu_ke_tempat_tidur' => $request->waktu_ke_tempat_tidur,
			'waktu_tidur' => $request->waktu_tidur,
			'waktu_bangun' => $request->waktu_bangun,
			'waktu_bangun_dari_tempat_tidur' => $request->waktu_bangun_dari_tempat_tidur,
			'tanggal' => $request->tanggal
		];
		$sudahada = DB::table('tidur')
						->where([
						    ['email', '=', $data['email']],
						    ['waktu_bangun', '=', $data['waktu_bangun']]
						])
						->first();
		if($sudahada){
			return response()->json(['status'=>201,'message'=>'Data tidur sudah disimpan sebelumnya','result'=>$data]);
		} else {
			$jumlahdata = DB::table('tidur')
					->select(DB::raw('count(*) as totalDataTidur'))
					->where('email',$data['email'])
					->first();

			if($jumlahdata->totalDataTidur > 30){
				$deleteData = DB::table('tidur')
							->where([
							    ['email',$data['email']],
							    ['tanggal' ,'=', Carbon::now()->subDays(30)->toDateString()]
							])
							->delete();
			}
			$insert_tidur = DB::table('tidur')->insert($data);
			if($insert_tidur){
				return response()->json(['status'=>200,'message'=>'Success','result'=>$data]);
			} else {
				return response()->json(['status'=>400,'message'=>'Failed to Save Sleep Data!','result'=>$data]);
			}
		}			
	}

	public function tampilTidur(Request $request) {
		$data = [
			'email' => $request->email
		];
		$jumlahdata = DB::table('tidur')
					->select(DB::raw('count(*) as totalDataTidur'))
					->where('email',$data['email'])
					->first();
		$tidur = null;
		if($jumlahdata->totalDataTidur <= 0){
			return response()->json(['status'=>400,'message'=>'There is no sleep data','result'=>$tidur]);
		} else {
			$tidur = DB::table('tidur')
                   ->where('email',$data['email'])
                   ->orderBy('tanggal','desc')
                   ->get();
			return response()->json(['status'=>200,'message'=>'Success','result'=>$tidur]);
		}	
	}

	public function tampilTidurPageList(Request $request) {
		$data = [
			'email' => $request->email,
			'page' => $request->page
		];
		$limit = 8;
		$jumlahdata = DB::table('tidur')
					->select(DB::raw('count(*) as totalDataTidur'))
					->where('email',$data['email'])
					->first();
		$tidur = null;
		if($jumlahdata->totalDataTidur <= 0){
			return response()->json(['status'=>400,'message'=>'There is no sleep data','result'=>$tidur]);
		} else {
			$tidur = DB::table('tidur')
                   ->where('email',$data['email'])
                   ->orderBy('tanggal','desc')
                   ->offset($data['page'])
                   ->limit($limit)->get();
			return response()->json(['status'=>200,'message'=>'Success','result'=>$tidur]);
		}	
	}

	public function tampilTidurHariIni(Request $request)
	{
		$data = [
			'email' => $request->email
		];
		$jumlahdata = DB::table('tidur')
					->select(DB::raw('count(*) as totalDataTidurHariIni'))
					->where([
						    ['tanggal', date('Y-m-d')],
						    ['email',$data['email']]
						])
					->first();
		$tidur = null;
		if($jumlahdata->totalDataTidurHariIni <= 0){
			return response()->json(['status'=>400,'message'=>'Belum ada data tidur hari ini!','result'=>$tidur]);
		} else {
			$datatidur = DB::table('tidur')
					->where([
						    ['tanggal', date('Y-m-d')],
						    ['email',$data['email']]
						])
					->get();
			if($datatidur){
				return response()->json(['status'=>200,'message'=>'Success','result'=>$datatidur]);
			} else {
				return response()->json(['status'=>201,'message'=>'Failed get data tidur','result'=>$tidur]);
			}	
		}
	}

	public function simpanKualitasTidur(Request $request){
		$data = [
			'email' => $request->email,
			'subjektif_kualitas_tidur' => $request->subjektif_kualitas_tidur,
			'latensi_tidur' => $request->latensi_tidur,
			'durasi_tidur' => $request->durasi_tidur,
			'efisiensi_kebiasaan_tidur' => $request->efisiensi_kebiasaan_tidur,
			'gangguan_tidur' => $request->gangguan_tidur,
			'penggunaan_obat' => $request->penggunaan_obat,
			'disfungsi_siang_hari' => $request->disfungsi_siang_hari,
			'tanggal' => date('Y-m-d')
		];
		$insertdata = DB::table('kualitas_tidur_psqi')->insert($data);
		
		return response()->json(['status'=>200,'message'=>'Success','result'=>$data]);
	}

	public function tampilHistoriHitungKualitas(Request $request){
		$data = [
			'email' => $request->email
		];
		$limit = 5;
		$jumlahdata = DB::table('kualitas_tidur_psqi')
					->select(DB::raw('count(*) as totalDataHitung'))
					->where('email',$data['email'])
					->first();
		$kualitastidur = null;
		if($jumlahdata->totalDataHitung <= 0){
			return response()->json(['status'=>404,'message'=>'Belum ada histori hitung kualitas tidur','result'=>$kualitastidur]);
		} else {
			$kualitastidur = DB::table('kualitas_tidur_psqi')
					->where('email',$data['email'])
                    ->orderBy('tanggal','desc')
                    ->limit($limit)
                    ->get();
			if($kualitastidur){
				return response()->json(['status'=>200,'message'=>'Success','result'=>$kualitastidur]);
			} else {
				return response()->json(['status'=>400,'message'=>'Gagal mendapatkan data histori penghitungan kualitas tidur','result'=>$kualitastidur]);
			}
		}		
	}

	public function hapusPenghitunganKualitasTidur(Request $request){
		$data = [
			'email' => $request->email,
			'tanggal' => $request->tanggal
		];
		$deleteData = DB::table('kualitas_tidur_psqi')
					->where([
						    ['tanggal', $data['tanggal']],
						    ['email',$data['email']]
						])
					->delete();
		if($deleteData){
			return response()->json(['status'=>200,'message'=>'Success']);
		} else {
			return response()->json(['status'=>400,'message'=>'Tidak ada data penghitungan kualitas tidur yang dapat dihapus']);
		}
	}

}