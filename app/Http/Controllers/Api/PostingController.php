<?php 
namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostingController extends Controller 
{	
	// ->join('contacts', 'users.id', '=', 'contacts.user_id')
 //            ->join('orders', 'users.id', '=', 'orders.user_id')
 //            ->select('users.*', 'contacts.phone', 'orders.price')
	
	public function tampilArtikel($page) {
		$limit = 8;
		$artikel = DB::table('artikel')
				   ->join('user', 'artikel.email', '=', 'user.email')
				   ->select('id_artikel','judul','gambar','isi','sumber','tanggal','user.nama as pengirim')
				   ->orderBy('tanggal','DESC')
				   ->offset($page)
                   ->limit($limit)
                   ->get();

		return response()->json(['status'=>200,'message'=>'Success','result'=>$artikel]);
	}
	
	public function getKualitasTidurTerakhir(Request $request)
	{
		$data = [
			'email' => $request->email
		];
		$kualitastidur = DB::table('kualitas_tidur_psqi')
					   ->where('email',$data['email'])
					   ->orderBy('tanggal','desc')
					   ->first();
		
		if($kualitastidur){
			$arraykualitas = array($kualitastidur->subjektif_kualitas_tidur." subjektif_kualitas_tidur",$kualitastidur->latensi_tidur." latensi_tidur",$kualitastidur->durasi_tidur." durasi_tidur",$kualitastidur->efisiensi_kebiasaan_tidur." efisiensi_kebiasaan_tidur",$kualitastidur->gangguan_tidur." gangguan_tidur",$kualitastidur->penggunaan_obat." penggunaan_obat",$kualitastidur->disfungsi_siang_hari." disfungsi_siang_hari");
			rsort($arraykualitas);

			//jika ada penghitungan kualitas tidur pengguna
			// $subjektif_kualitas_tidur = $kualitastidur->subjektif_kualitas_tidur;
			// $latensi_tidur = $kualitastidur->latensi_tidur;
			// $durasi_tidur = $kualitastidur->durasi_tidur;
			// $efisiensi_kebiasaan_tidur = $kualitastidur->efisiensi_kebiasaan_tidur;
			return response()->json(['status'=>200,'message'=>'Success','result'=>$arraykualitas]);
		} else {
			return response()->json(['status'=>400,'message'=>'Data not found']);
		}
	}

	public function tampilTips(Request $request) {
		$limit = 12;
		$data = [
			'email' => $request->email
		];
		$kualitastidur = DB::table('kualitas_tidur_psqi')
					   ->where('email',$data['email'])
					   ->orderBy('tanggal','desc')
					   ->first();
		
		if($kualitastidur){
			//jika ada penghitungan kualitas tidur pengguna
			$arraykualitas = array($kualitastidur->latensi_tidur."Latensi Tidur",
								$kualitastidur->durasi_tidur."Durasi Tidur",
								$kualitastidur->efisiensi_kebiasaan_tidur."Efisiensi Kebiasaan Tidur",
								$kualitastidur->gangguan_tidur."Gangguan Tidur",
								$kualitastidur->penggunaan_obat."Penggunaan Obat",
								$kualitastidur->disfungsi_siang_hari."Disfungsi Siang Hari");
			rsort($arraykualitas);

			//replace number from array
			$arraykualitas[0] = preg_replace('/[0-9]+/', '', $arraykualitas[0]);
			$arraykualitas[1] = preg_replace('/[0-9]+/', '', $arraykualitas[1]);
			$arraykualitas[2] = preg_replace('/[0-9]+/', '', $arraykualitas[2]);
			$arraykualitas[3] = preg_replace('/[0-9]+/', '', $arraykualitas[3]);
			$arraykualitas[4] = preg_replace('/[0-9]+/', '', $arraykualitas[4]);
			$arraykualitas[5] = preg_replace('/[0-9]+/', '', $arraykualitas[5]);

			// $tips = DB::table('tips')
			// 		->orderByRaw("FIELD(kategori , '$arraykualitas[1]', '$arraykualitas[2]', '$arraykualitas[3]', '$arraykualitas[4]', '$arraykualitas[5]', '$arraykualitas[6]') ASC")
			// 		->join('user', 'tips.email', '=', 'user.email')
			// 	   	->select('id','judul','gambar','isi','kategori','sumber','tanggal','user.nama as pengirim')
			// 		->get();

			$tips1 = DB::select("SELECT id_tips,judul,gambar,kategori,isi,sumber,tanggal, user.nama as pengirim FROM tips INNER JOIN user ON tips.email = user.email WHERE kategori='$arraykualitas[0]' ORDER BY tanggal DESC LIMIT 3");
			$tips2 = DB::select("SELECT id_tips,judul,gambar,kategori,isi,sumber,tanggal,user.nama as pengirim FROM tips INNER JOIN user ON tips.email = user.email WHERE kategori='$arraykualitas[1]' ORDER BY tanggal DESC LIMIT 2");
			$tips3 = DB::select("SELECT id_tips,judul,gambar,kategori,isi,sumber,tanggal,user.nama as pengirim FROM tips INNER JOIN user ON tips.email = user.email WHERE kategori='$arraykualitas[2]' ORDER BY tanggal DESC LIMIT 2");
			$tips4 = DB::select("SELECT id_tips,judul,gambar,kategori,isi,sumber,tanggal,user.nama as pengirim FROM tips INNER JOIN user ON tips.email = user.email WHERE kategori='$arraykualitas[3]' ORDER BY tanggal DESC LIMIT 2");
			$tips5 = DB::select("SELECT id_tips,judul,gambar,kategori,isi,sumber,tanggal,user.nama as pengirim FROM tips INNER JOIN user ON tips.email = user.email WHERE kategori='$arraykualitas[4]' ORDER BY tanggal DESC LIMIT 2");
			$tips6 = DB::select("SELECT id_tips,judul,gambar,kategori,isi,sumber,tanggal,user.nama as pengirim FROM tips INNER JOIN user ON tips.email = user.email WHERE kategori='$arraykualitas[5]' ORDER BY tanggal DESC LIMIT 2");
			
			$data = array_merge_recursive($tips1,$tips2,$tips3,$tips4,$tips5,$tips6);	
			
			return response()->json(['status'=>200,'message'=>'Success','result'=>$data]);
		} else {
			//jika tidak ada penghitungan kualitas tidur pengguna
			$durasi_tidur = DB::select("SELECT id_tips,judul,gambar,kategori,isi,sumber,tanggal,user.nama as pengirim FROM tips INNER JOIN user ON tips.email = user.email  WHERE kategori='Durasi Tidur' ORDER BY tanggal DESC LIMIT 3");
			$efesiensi = DB::select("SELECT id_tips,judul,gambar,kategori,isi,sumber,tanggal,user.nama as pengirim FROM tips INNER JOIN user ON tips.email = user.email WHERE kategori='Efisiensi Kebiasaan Tidur' ORDER BY tanggal DESC LIMIT 2");
			$gangguan = DB::select("SELECT id_tips,judul,gambar,kategori,isi,sumber,tanggal,user.nama as pengirim FROM tips INNER JOIN user ON tips.email = user.email WHERE kategori='Gangguan Tidur' ORDER BY tanggal DESC LIMIT 2");
			$latensi = DB::select("SELECT id_tips,judul,gambar,kategori,isi,sumber,tanggal,user.nama as pengirim FROM tips INNER JOIN user ON tips.email = user.email WHERE kategori='Latensi Tidur' ORDER BY tanggal DESC LIMIT 2");
			$disfungsi = DB::select("SELECT id_tips,judul,gambar,kategori,isi,sumber,tanggal,user.nama as pengirim FROM tips INNER JOIN user ON tips.email = user.email WHERE kategori='Disfungsi Siang Hari' ORDER BY tanggal DESC LIMIT 2");
			$obat = DB::select("SELECT id_tips,judul,gambar,kategori,isi,sumber,tanggal,user.nama as pengirim FROM tips INNER JOIN user ON tips.email = user.email WHERE kategori='Penggunaan Obat' ORDER BY tanggal DESC LIMIT 2");

			$data = array_merge_recursive($durasi_tidur,$latensi,$efesiensi,$gangguan,$disfungsi,$obat);

			return response()->json(['status'=>200,'message'=>'Success','result'=>$data]);
		}
	}

	public function tampilTipsByKategori($kategori,$page){
		$limit = 8;
		$data = [
			'kategori' => $kategori
		];
		$tips = DB::table('tips')
					->join('user', 'tips.email', '=', 'user.email')
					->select('id_tips','judul','gambar','kategori','isi','sumber','tanggal','user.nama as pengirim')
					->orderBy('tanggal','desc')
					->where('kategori',$data['kategori'])
					->offset($page)
                   	->limit($limit)
					->get();
		return response()->json(['status'=>200,'message'=>'Success','result'=>$tips]);
	}

	public function tes() {
		$durasi_tidur = DB::select("SELECT * FROM tips WHERE kategori='Durasi Tidur' ORDER BY tanggal DESC LIMIT 3");
		$disfungsi = DB::select("SELECT * FROM tips WHERE kategori='Disfungsi Siang Hari' ORDER BY tanggal DESC LIMIT 3");
		$efesiensi = DB::select("SELECT * FROM tips WHERE kategori='Efisiensi Kebiasaan Tidur' ORDER BY tanggal DESC LIMIT 3");
		$gangguan = DB::select("SELECT * FROM tips WHERE kategori='Gangguan Tidur' ORDER BY tanggal DESC LIMIT 3");
		$latensi = DB::select("SELECT * FROM tips WHERE kategori='Latensi Tidur' ORDER BY tanggal DESC LIMIT 3");

		$data = array_merge_recursive($durasi_tidur,$disfungsi,$efesiensi,$gangguan,$latensi);

		return response()->json(['status'=>200,'message'=>'Success','result'=>$data]);
	}
}