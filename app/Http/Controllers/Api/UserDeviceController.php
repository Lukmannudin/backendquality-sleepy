<?php 
namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserDeviceController extends Controller {

	public function storeDevice(Request $request) {
		$data = [
			'id_device' => $request->id_device,
			'nama_device' => $request->nama_device
		];

		$user_device = DB::table('user_device')->where('id_device',$data['id_device'])->first();
		$insert_user_device = false;

		if (!$user_device) {
			$insert_user_device = DB::table('user_device')->insert($data);
		}
		if($insert_user_device==false){
			return response()->json(['status'=>400,'message'=>'Failed save, because user device already in database','result'=>$insert_user_device]);
		} else {
			return response()->json(['status'=>200,'message'=>'Success','result'=>$insert_user_device]);
		}
		
	}
}