<?php 
namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserPolaTidurController extends Controller {

	public function polaTidur(Request $request) {
		$data = [
			'id_device' => $request->id_device,
			'waktu_tidur' => $request->waktu_tidur,
			'waktu_bangun'=> $request->waktu_bangun,
			'latensi_tidur'=> $request->latensi_tidur,
			'cahaya'=> $request->cahaya,
			'suhu'=> $request->suhu,
			'kebisingan'=> $request->kebisingan,
			'tanggal'=> date('Y-m-d')
		];

		$user_device = DB::table('user_device')->where('id_device',$data['id_device'])->first();
		if($user_device){
			$insert_pola_tidur = DB::table('pola_tidur')->insert($data);

			return response()->json(['status'=>200,'message'=>'Success','result'=>$data]);
		} else {
			//iddevicebelum ada di database
			return response()->json(['status'=>400,'message'=>'Failed. Gagal menyimpan pola tidur karena id device belum terdaftar']);
		}
		// if ($pola_tidur) {
		// 	if ($pola_tidur->waktu_tidur == '') {
		// 		$insert_pola_tidur = DB::table('pola_tidur')->where('id_device', $data['id_device'])->update([
		// 			'waktu_tidur'=>$data['waktu_tidur'],
		// 			'waktu_bangun'=>$data['waktu_bangun'],
		// 			'latensi_tidur'=>$data['latensi_tidur'],
		// 			'cahaya'=>$data['cahaya'],
		// 			'suhu'=>$data['suhu'],
		// 			'kebisingan'=>$data['kebisingan'],
		// 			'tanggal'=>$data['tanggal']
		// 		]);
		// 	} else {
		// 		$insert_pola_tidur = DB::table('pola_tidur')->insert($data);
		// 	}
		// }else {
		// 	$insert_pola_tidur = DB::table('pola_tidur')->insert(['id_device'=>$data['id_device']]);
		// }

		
	}
}