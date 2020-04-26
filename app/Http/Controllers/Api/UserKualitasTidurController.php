<?php 
namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserKualitasTidurController extends Controller 
{
	
	public function kualitasTidur(Request $request) {
		$data = [
			'id_device' => $request->id_device,
			'subjektif_kualitas_tidur' => $request->subjektif_kualitas_tidur,
			'latensi_tidur' => $request->latensi_tidur,
			'durasi_tidur'=> $request->durasi_tidur,
			'efisiensi_kebiasaan_tidur'=> $request->efisiensi_kebiasaan_tidur,
			'gangguan_tidur'=> $request->gangguan_tidur,
			'obat_tidur'=> $request->obat_tidur,
			'disfungsi_siang_hari'=> $request->disfungsi_siang_hari,
			'tanggal'=> date('Y-m-d')
		];

		$user_device = DB::table('user_device')->where('id_device',$data['id_device'])->first();
		if($user_device){
			$insert_kualitas_tidur = DB::table('kualitas_tidur')->insert($data);
			return response()->json(['status'=>200,'message'=>'Success','result'=>$data]);
		} else {
			return response()->json(['status'=>400,'message'=>'Failed Id Device Not FOund. Gagal menyimpan kualitas tidur pengguna karena id device belum terdaftar']);
		}
	}
}