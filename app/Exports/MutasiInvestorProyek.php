<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Proyek;
use App\PendanaanAktif;
class MutasiInvestorProyek implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection

    */
    use Exportable;
    public function __construct($id)
    {
        $this->id = $id;
    }
    public function view():view
    {   
        $id = $this->id;
        $data_proyek =  Proyek::where('id',$id)
                        ->select([
                            'proyek.nama',
                            'proyek.tgl_mulai',
                            'proyek.tgl_selesai',
                            'proyek.profit_margin'

                        ])
                        ->first();
        $data_pendana = PendanaanAktif::where('proyek_id',$id)
                        ->where('total_dana','>',100000)
                        ->where('status',1)
                        ->leftJoin('detil_investor','detil_investor.investor_id','=','pendanaan_aktif.investor_id')
                        ->select([
                            'detil_investor.nama_investor',
                            'tanggal_invest',
                            'total_dana',
                        ])
                        ->get();
        $dana_sum = PendanaanAktif::where('proyek_id',$id)->sum('total_dana');
        $view = view('export_report.report_detil_proyek',compact('data_proyek','data_pendana','dana_sum'));
        return $view;
    }
}
