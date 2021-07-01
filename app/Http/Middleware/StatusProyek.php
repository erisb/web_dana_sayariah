<?php

namespace App\Http\Middleware;

use Closure;
use App\Proyek;
use App\PendanaanAktif;
use App\BorrowerPendanaan;
use Carbon\Carbon;

class StatusProyek
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private function updateProyek($id,$status)
    {
        if ($id)
        {
            $update = Proyek::where('id',$id)->update(['status' => $status]);

            return $update;
        }
    }
    public function handle($request, Closure $next)
    {
        $dataProyek = Proyek::all();
        if ($dataProyek)
        {
            foreach ($dataProyek as $proyeks)
            {
                $proyekTerkumpul = $proyeks->terkumpul;
                $proyekDanaDibutuhkan = $proyeks->total_need;
                $proyekSelesaiPenggalangan = Carbon::parse($proyeks->tgl_selesai_penggalangan)->format('Y-m-d');
                $proyekSelesai = Carbon::parse($proyeks->tgl_selesai)->format('Y-m-d');
                $jumlahInvestasi = PendanaanAktif::where('proyek_id',$proyeks->id)->sum('nominal_awal');
                $tglSekarang = Carbon::now()->format('Y-m-d');
                $totalDana = $proyekTerkumpul + $jumlahInvestasi;

                if ($tglSekarang > $proyekSelesaiPenggalangan && $tglSekarang < $proyekSelesai)
                {
                    $getStatus = Proyek::where('id',$proyeks->id)->first(['status']);
                    $cekStatus = $getStatus->status;
                    if ($cekStatus != 2)
                    {
                        $this->updateProyek($proyeks->id,2);//status closed
						//$update = BorrowerPendanaan::where('id_proyek',$proyeks->id)->update(['status' => 6]);
                    }
                }
                elseif($totalDana >= $proyekDanaDibutuhkan && $tglSekarang < $proyekSelesai)
                {
                    $getStatus = Proyek::where('id',$proyeks->id)->first(['status']);
                    $cekStatus = $getStatus->status;
                    if ($cekStatus != 3)
                    {
                        $this->updateProyek($proyeks->id,3);//status fully funded
						//$update = BorrowerPendanaan::where('id_proyek',$proyeks->id)->update(['status' => 6]);
                    }
                }
                elseif($tglSekarang > $proyekSelesaiPenggalangan && $tglSekarang >= $proyekSelesai)
                {
                    $getStatus = Proyek::where('id',$proyeks->id)->first(['status']);
                    $cekStatus = $getStatus->status;
                    if ($cekStatus != 4)
                    {
                        $this->updateProyek($proyeks->id,4);//status finis
                    }
                }
                elseif($totalDana >= $proyekDanaDibutuhkan && $tglSekarang >= $proyekSelesai)
                {
                    $getStatus = Proyek::where('id',$proyeks->id)->first(['status']);
                    $cekStatus = $getStatus->status;
                    if ($cekStatus != 4)
                    {
                        $this->updateProyek($proyeks->id,4);//status finis
                    }
                }
                else
                {
                    $getStatus = Proyek::where('id',$proyeks->id)->first(['status']);
                    $cekStatus = $getStatus->status;
                    if ($cekStatus != 1)
                    {
                        $this->updateProyek($proyeks->id,1);//status aktif
                    }
                }
            }
        }
        return $next($request);
    }
}
