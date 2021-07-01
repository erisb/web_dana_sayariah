<?php
namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Investor;
use App\Proyek;
use App\MasterProvinsi;
use DB;
use Illuminate\Support\Facades\Auth;
use Storage;
use Image;
//use Carbon\Carbon;
//use App\Http\Middleware\UserCheck;

class BorrowerProsesController extends Controller
{
    //private const  url = 'http://103.28.23.203/borrower/';
    private const  url = 'http://127.0.0.1:8000/borrower/';
	public function new_upload_gambar_1(Request $request){
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
        //var_dump($_FILES['webcam']['tmp_name']) ;
        if ($request->file('file')) {
			$file = $request->file('file');
			$filename = 'pic_brw' . '.' . $file->getClientOriginalExtension();
			//var_dump($filename);die();
			$resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save(); 
			
			// $resize = Image::make($file)->resize(480,640, function ($constraint) {
                // $constraint->aspectRatio();
            // })->save($filename);
			
			// save nama file berdasarkan tanggal upload+nama file
            $store_path = 'borrower/' . $brw_id; 
            $path = $file->storeAs($store_path, $filename, 'public');
			// save gambar yang di upload di public storage
            
			// Storage::disk('public')->delete('user/'.$investor_id.'/'.$filename);

			if(Storage::disk('public')->exists('borrower/'.$brw_id.'/'.$filename)){
				return response()->json([
					'success' => 'Berhasil di upload',
					'url' => "borrower/".$brw_id."/".$filename,
					'filename' => $filename
				]);
			}else{
				return response()->json([
					'failed' => 'File gagal di upload'
				]);
			}
		}
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
        }
		
	}
	
	public function new_upload_gambar_2 (Request $request){
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
        
        if ($request->file('file')) {
            $file = $request->file('file');
            $filename = 'pic_brw_ktp' . '.' . $file->getClientOriginalExtension();
            $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
			
			// $resize = Image::make($file)->resize(480,640, function ($constraint) {
                // $constraint->aspectRatio();
            // })->save($filename);
			// save nama file berdasarkan tanggal upload+nama file
            $store_path = 'borrower/' . $brw_id; 
            $path = $file->storeAs($store_path, $filename, 'public');
			// save gambar yang di upload di public storage
            
			// Storage::disk('public')->delete('user/'.$investor_id.'/'.$filename);

			if(Storage::disk('public')->exists('borrower/'.$brw_id.'/'.$filename)){
				return response()->json([
					'success' => 'Berhasil di upload',
					'url' => "borrower/".$brw_id."/".$filename,
					'filename' => $filename
				]);
			}else{
				return response()->json([
					'failed' => 'File gagal di upload'
				]);
			}
		}
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
        }
		
	}
	
	public function new_upload_gambar_3 (Request $request){
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
        
        if ($request->file('file')) {
            $file = $request->file('file');
            $filename = 'pic_brw_dan_ktp' . '.' . $file->getClientOriginalExtension();
            $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
			
			// $resize = Image::make($file)->resize(480,640, function ($constraint) {
                // $constraint->aspectRatio();
            // })->save();
			// save nama file berdasarkan tanggal upload+nama file
            $store_path = 'borrower/' . $brw_id; 
            $path = $file->storeAs($store_path, $filename, 'public');
			// save gambar yang di upload di public storage
            
			// Storage::disk('public')->delete('user/'.$investor_id.'/'.$filename);

			if(Storage::disk('public')->exists('borrower/'.$brw_id.'/'.$filename)){
				return response()->json([
					'success' => 'Berhasil di upload',
					'url' => "borrower/".$brw_id."/".$filename,
					'filename' => $filename
				]);
			}else{
				return response()->json([
					'failed' => 'File gagal di upload'
				]);
			}
		}
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
        }
		
	}

	
	public function new_upload_gambar_4(Request $request){
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
        
        if ($request->file('file')) {
            $file = $request->file('file');
            $filename = 'pic_brw_npwp' . '.' . $file->getClientOriginalExtension();
            $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
			
			
			// $resize = Image::make($file)->resize(480,640, function ($constraint) {
                // $constraint->aspectRatio();
            // })->save($filename);
			// save nama file berdasarkan tanggal upload+nama file
            $store_path = 'borrower/' . $brw_id; 
            $path = $file->storeAs($store_path, $filename, 'public');
			// save gambar yang di upload di public storage
            
			// Storage::disk('public')->delete('user/'.$investor_id.'/'.$filename);

			if(Storage::disk('public')->exists('borrower/'.$brw_id.'/'.$filename)){
				return response()->json([
					'success' => 'Berhasil di upload',
					'url' => "borrower/".$brw_id."/".$filename,
					'filename' => $filename
				]);
			}else{
				return response()->json([
					'failed' => 'File gagal di upload'
				]);
			}
		}
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
        }
		
	}

	public function webcam_picture_1(Request $request)
	{
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
	
		if($request)
		{
			$image_foto_diri = explode(";base64,", $request);
			$image_decode_foto_diri = base64_decode($image_foto_diri[1]);
			$fileName_foto_diri = uniqid() . '.png';
			$path_foto_diri = 'borrower/'.$brw_id.'/'.'pic_brw.'.'png';
			$path = Storage::disk('public')->put($path_foto_diri, $image_decode_foto_diri);

			return response()->json([
				'success' => 'Berhasil di upload',
				'url' => $path_foto_diri,
			]);
		}
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
		}	
	}

	public function webcam_picture_2(Request $request)
	{
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
	
		if($request)
		{
			$image_foto_ktp = explode(";base64,", $request);
			$image_decode_foto_ktp = base64_decode($image_foto_ktp[1]);
			$fileName_foto_ktp = uniqid() . '.png';
			$path_foto_ktp = 'borrower/'.$brw_id.'/'.'pic_brw_ktp.'.'png';
			$path = Storage::disk('public')->put($path_foto_ktp, $image_decode_foto_ktp);

			return response()->json([
				'success' => 'Berhasil di upload',
				'url' => $path_foto_ktp,
			]);
		}
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
		}
	}

	public function webcam_picture_3(Request $request)
	{
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
	
		if($request)
		{
			$image_foto_ktp_diri = explode(";base64,", $request);
			$image_decode_foto_ktp_diri = base64_decode($image_foto_ktp_diri[1]);
			$fileName_foto_ktp_diri = uniqid() . '.png';
			$path_foto_ktp_diri = 'borrower/'.$brw_id.'/'.'pic_brw_dan_ktp.'.'png';
			$path = Storage::disk('public')->put($path_foto_ktp_diri, $image_decode_foto_ktp_diri);

			return response()->json([
				'success' => 'Berhasil di upload',
				'url' => $path_foto_ktp_diri,
			]);
		}
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
		}	
	}

	public function webcam_picture_4(Request $request)
	{
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
	
		if($request)
		{
			$image_foto_npwp = explode(";base64,", $request);
			$image_decode_foto_npwp = base64_decode($image_foto_npwp[1]);
			$fileName_foto_npwp = uniqid() . '.png';
			$path_foto_npwp = 'borrower/'.$brw_id.'/'.'pic_brw_npwp.'.'png';
			$path = Storage::disk('public')->put($path_foto_npwp, $image_decode_foto_npwp);

			return response()->json([
				'success' => 'Berhasil di upload',
				'url' => $path_foto_npwp,
			]);
		}
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
		}
	}

	public function update_webcam_picture_1(Request $request)
	{
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
	
		if($request)
		{
			$image_foto_diri = explode(";base64,", $request);
			$image_decode_foto_diri = base64_decode($image_foto_diri[1]);
			$fileName_foto_diri = uniqid() . '.png';
			$path_foto_diri = 'borrower/'.$brw_id.'/'.'pic_brw.'.'png';
			$path = Storage::disk('public')->put($path_foto_diri, $image_decode_foto_diri);

			return response()->json([
				'success' => 'Berhasil di update',
				'url' => $path_foto_diri,
			]);
		}
        else {
            return response()->json([
				'failed' => 'File Kosong',
            ]);
		}	
	}

	public function update_webcam_picture_2(Request $request)
	{
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
	
		if($request)
		{
			$image_foto_ktp = explode(";base64,", $request);
			$image_decode_foto_ktp = base64_decode($image_foto_ktp[1]);
			$fileName_foto_ktp = uniqid() . '.png';
			$path_foto_ktp = 'borrower/'.$brw_id.'/'.'pic_brw_ktp.'.'png';
			$path = Storage::disk('public')->put($path_foto_ktp, $image_decode_foto_ktp);

			return response()->json([
				'success' => 'Berhasil di update',
				'url' => $path_foto_ktp,
			]);
		}
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
		}
	}

	public function update_webcam_picture_3(Request $request)
	{
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
	
		if($request)
		{
			$image_foto_ktp_diri = explode(";base64,", $request);
			$image_decode_foto_ktp_diri = base64_decode($image_foto_ktp_diri[1]);
			$fileName_foto_ktp_diri = uniqid() . '.png';
			$path_foto_ktp_diri = 'borrower/'.$brw_id.'/'.'pic_brw_dan_ktp.'.'png';
			$path = Storage::disk('public')->put($path_foto_ktp_diri, $image_decode_foto_ktp_diri);

			return response()->json([
				'success' => 'Berhasil di update',
				'url' => $path_foto_ktp_diri,
			]);
		}
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
		}	
	}

	public function update_webcam_picture_4(Request $request)
	{
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
	
		if($request)
		{
			$image_foto_npwp = explode(";base64,", $request);
			$image_decode_foto_npwp = base64_decode($image_foto_npwp[1]);
			$fileName_foto_npwp = uniqid() . '.png';
			$path_foto_npwp = 'borrower/'.$brw_id.'/'.'pic_brw_npwp.'.'png';
			$path = Storage::disk('public')->put($path_foto_npwp, $image_decode_foto_npwp);

			return response()->json([
				'success' => 'Berhasil di update',
				'url' => $path_foto_npwp,
			]);
		}
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
		}
	}

	public function webcam_picture_hukum_1(Request $request)
	{
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
	
		if($request)
		{
			$image_foto_diri_hukum = explode(";base64,", $request);
			$image_decode_foto_diri_hukum = base64_decode($image_foto_diri_hukum[1]);
			$fileName_foto_diri_hukum = uniqid() . '.png';
			$path_foto_diri_hukum = 'borrower/'.$brw_id.'/'.'pic_brw.'.'png';
			$path = Storage::disk('public')->put($path_foto_diri_hukum, $image_decode_foto_diri_hukum);

			return response()->json([
				'success' => 'Berhasil di upload',
				'url' => $path_foto_diri_hukum,
			]);
		}
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
		}	
	}

	public function webcam_picture_hukum_2(Request $request)
	{
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
	
		if($request)
		{
			$image_foto_ktp_hukum = explode(";base64,", $request);
			$image_decode_foto_ktp_hukum = base64_decode($image_foto_ktp_hukum[1]);
			$fileName_foto_ktp_hukum = uniqid() . '.png';
			$path_foto_ktp_hukum = 'borrower/'.$brw_id.'/'.'pic_brw_ktp.'.'png';
			$path = Storage::disk('public')->put($path_foto_ktp_hukum, $image_decode_foto_ktp_hukum);

			return response()->json([
				'success' => 'Berhasil di upload',
				'url' => $path_foto_ktp_hukum,
			]);
		}
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
		}
	}

	public function webcam_picture_hukum_3(Request $request)
	{
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
	
		if($request)
		{
			$image_foto_ktp_diri_hukum = explode(";base64,", $request);
			$image_decode_foto_ktp_diri_hukum = base64_decode($image_foto_ktp_diri_hukum[1]);
			$fileName_foto_ktp_diri_hukum = uniqid() . '.png';
			$path_foto_ktp_diri_hukum = 'borrower/'.$brw_id.'/'.'pic_brw_dan_ktp.'.'png';
			$path = Storage::disk('public')->put($path_foto_ktp_diri_hukum, $image_decode_foto_ktp_diri_hukum);

			return response()->json([
				'success' => 'Berhasil di upload',
				'url' => $path_foto_ktp_diri_hukum,
			]);
		}
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
		}	
	}

	public function webcam_picture_hukum_4(Request $request)
	{
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
	
		if($request)
		{
			$image_foto_npwp_hukum = explode(";base64,", $request);
			$image_decode_foto_npwp_hukum = base64_decode($image_foto_npwp_hukum[1]);
			$fileName_foto_npwp_hukum = uniqid() . '.png';
			$path_foto_npwp_hukum = 'borrower/'.$brw_id.'/'.'pic_brw_npwp.'.'png';
			$path = Storage::disk('public')->put($path_foto_npwp_hukum, $image_decode_foto_npwp_hukum);

			return response()->json([
				'success' => 'Berhasil di upload',
				'url' => $path_foto_npwp_hukum,
			]);
		}
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
		}
		
	}

	public function update_webcam_picture_1_bdn_hukum(Request $request)
	{
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
	
		if($request)
		{
			$image_foto_diri_bdn_hukum = explode(";base64,", $request);
			$image_decode_foto_diri_bdn_hukum = base64_decode($image_foto_diri_bdn_hukum[1]);
			$fileName_foto_diri_bdn_hukum = uniqid() . '.png';
			$path_foto_diri_bdn_hukum = 'borrower/'.$brw_id.'/'.'pic_brw.'.'png';
			$path = Storage::disk('public')->put($path_foto_diri_bdn_hukum, $image_decode_foto_diri_bdn_hukum);

			return response()->json([
				'success' => 'Berhasil di update',
				'url' => $path_foto_diri_bdn_hukum,
			]);
		}
        else {
            return response()->json([
				'failed' => 'File Kosong',
            ]);
		}	
	}

	public function update_webcam_picture_2_bdn_hukum(Request $request)
	{
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
	
		if($request)
		{
			$image_foto_ktp_bdn_hukum = explode(";base64,", $request);
			$image_decode_foto_ktp_bdn_hukum = base64_decode($image_foto_ktp_bdn_hukum[1]);
			$fileName_foto_ktp_bdn_hukum = uniqid() . '.png';
			$path_foto_ktp_bdn_hukum = 'borrower/'.$brw_id.'/'.'pic_brw_ktp.'.'png';
			$path = Storage::disk('public')->put($path_foto_ktp_bdn_hukum, $image_decode_foto_ktp_bdn_hukum);

			return response()->json([
				'success' => 'Berhasil di update',
				'url' => $path_foto_ktp_bdn_hukum,
			]);
		}
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
		}
	}

	public function update_webcam_picture_3_bdn_hukum(Request $request)
	{
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
	
		if($request)
		{
			$image_foto_ktp_diri_bdn_hukum = explode(";base64,", $request);
			$image_decode_foto_ktp_diri_bdn_hukum = base64_decode($image_foto_ktp_diri_bdn_hukum[1]);
			$fileName_foto_ktp_diri_bdn_hukum = uniqid() . '.png';
			$path_foto_ktp_diri_bdn_hukum = 'borrower/'.$brw_id.'/'.'pic_brw_dan_ktp.'.'png';
			$path = Storage::disk('public')->put($path_foto_ktp_diri_bdn_hukum, $image_decode_foto_ktp_diri_bdn_hukum);

			return response()->json([
				'success' => 'Berhasil di update',
				'url' => $path_foto_ktp_diri_bdn_hukum,
			]);
		}
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
		}	
	}

	public function update_webcam_picture_4_bdn_hukum(Request $request)
	{
		
		$brw_id = Auth::guard('borrower')->user()->brw_id;
	
		if($request)
		{
			$image_foto_npwp_bdn_hukum = explode(";base64,", $request);
			$image_decode_foto_npwp_bdn_hukum = base64_decode($image_foto_npwp_bdn_hukum[1]);
			$fileName_foto_npwp_bdn_hukum = uniqid() . '.png';
			$path_foto_npwp_bdn_hukum = 'borrower/'.$brw_id.'/'.'pic_brw_npwp.'.'png';
			$path = Storage::disk('public')->put($path_foto_npwp_bdn_hukum, $image_decode_foto_npwp_bdn_hukum);

			return response()->json([
				'success' => 'Berhasil di update',
				'url' => $path_foto_npwp_bdn_hukum,
			]);
		}
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
		}
	}
    
    
}