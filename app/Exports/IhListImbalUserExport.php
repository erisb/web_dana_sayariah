<?php

namespace App\Exports;

use App\Proyek;
use App\MasterAgama;
use App\ListImbalUser;
use App\IhListImbalUser;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromArray;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IhListImbalUserExport implements FromQuery, ShouldAutoSize, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return MasterAgama::all();
    // }

    public function __construct(string $name)
    {
        $this->name = $name;
    }
    public function query()
    { 
        
        return IhlistImbalUser::query()->select('proyek.nama','detil_investor.nama_investor','ih_list_imbal_user.tanggal_payout','ih_list_imbal_user.imbal_payout',DB::raw('CONCAT("`",detil_investor.rekening) as rekening'),'m_bank.nama_bank','detil_investor.nama_pemilik_rek','investor.email',DB::raw('CASE WHEN ih_list_imbal_user.keterangan_payout = 1 THEN "Imbal Hasil" WHEN ih_list_imbal_user.keterangan_payout = 2 THEN "Sisa Imbal Hasil" ELSE "Dana Pokok" END AS keterangan'))
                                ->rightJoin('ih_detil_imbal_user','ih_list_imbal_user.detilimbaluser_id','=','ih_detil_imbal_user.id')
                                ->rightJoin('ih_pendanaan_aktif','ih_detil_imbal_user.pendanaan_id','=','ih_pendanaan_aktif.id')
                                ->rightJoin('proyek','ih_detil_imbal_user.proyek_id','=','proyek.id')
                                ->leftJoin('detil_investor','ih_pendanaan_aktif.investor_id','=','detil_investor.investor_id')
                                ->leftJoin('investor','ih_pendanaan_aktif.investor_id','=','investor.id')
                                ->leftJoin('m_bank','detil_investor.bank_investor','=','m_bank.kode_bank')
                                ->where('ih_detil_imbal_user.proyek_id', $this->name)
                                ->orderBy('ih_list_imbal_user.detilimbaluser_id', 'ASC')
                                ->orderBy('ih_list_imbal_user.tanggal_payout', 'ASC')
                                ->orderBy('ih_list_imbal_user.keterangan_payout', 'ASC'); 
    }

    public function headings(): array
    {
        return [
                'Proyek',
                'Nama Lender',
                'Tanggal Imbal Hasil',
                'Nilai Imbal Hasil',
                'No Rek',
                'Bank',
                'Nama Account',
                'Email',
                'Keterangan'
        ];
    }

}
