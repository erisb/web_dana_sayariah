<?php

namespace App\Exports;
use App\Investor;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;



class DanaInvestorProyek implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Investor::leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')->where('investor.status','active')
                       ->leftJoin('rekening_investor','rekening_investor.investor_id','=','investor.id')
                       ->leftJoin('pendanaan_aktif','pendanaan_aktif.investor_id','=','investor.id')
                       ->where('pendanaan_aktif.status',1)
                       -whereNotIn('pendanaan_aktif.status', [0])
                       ->leftJoin('proyek','proyek.id','=','pendanaan_aktif.proyek_id')
                       ->orderby('id','asc')
                       ->get([
                           'investor.id',
                           'detil_investor.nama_investor',
                           'rekening_investor.va_number',
                           'pendanaan_aktif.tanggal_invest',
                           'pendanaan_aktif.total_dana',
                           'proyek.nama',
                           'proyek.tgl_mulai',
                           'proyek.tgl_selesai',
                           'proyek.profit_margin',
                       ]);
    }

    public function headings(): array
    {
        return [

                'ID Investor',
                'Nama Investor',
                'Virtual Account Investor',
                'Tanggal Transfer',
                'Total Transfer',
                'Nama Proyek',
                'Tanggal Mulai Proyek',
                'Tanggal Selesai Proyek',
                'Profit Margin Proyek / %',

        ];
    }
}
