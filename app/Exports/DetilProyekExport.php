<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

// use App\Controller
use App\Proyek;
use App\Investor;
use App\PendanaanAktif;

class DetilProyekExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Proyek::leftJoin('pendanaan_aktif','pendanaan_aktif.proyek_id','=','proyek.id')
                                ->leftJoin('investor','investor.id','=','pendanaan_aktif.investor_id')
                                ->leftJoin('rekening_investor','rekening_investor.investor_id','=','investor.id')
                                ->leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')
                                ->leftjoin('m_bank', function ($join) {
                                    $join->on('detil_investor.bank_investor', '=', 'm_bank.kode_bank')
                                         ->select('nama_bank');
                                  })
                                ->where('pendanaan_aktif.status', 1)
                                -whereNotIn('pendanaan_aktif.status', [0])
                                ->where('pendanaan_aktif.total_dana','>', 100000)
                                ->get(
                                    [
                                        'detil_investor.nama_investor',
                                        'rekening_investor.va_number',
                                        'investor.email',
                                        'investor.username',
                                        'detil_investor.phone_investor',
                                        'detil_investor.rekening',
                                        'm_bank.nama_bank',
                                        'detil_investor.nama_pemilik_rek',
                                        'pendanaan_aktif.total_dana',
                                        'pendanaan_aktif.tanggal_invest',
                                        'proyek.nama',
                                        'proyek.tgl_mulai',
                                        'proyek.tgl_selesai',
                                        'proyek.profit_margin',
                                        'proyek.tenor_waktu',
                                    ]
                                );
    }
    public function headings(): array
    {
        return [
                'Nama Investor',
                'Username',
                'Virtual Account Investor',
                'E-Mail Investor',
                'Telepon Investor',
                'No Rekening Investor',
                'Nama Bank Investor',
                'Nama Pemilik Bank',
                'Total Invest',
                'Tanggal Invest',
                'Nama Proyek',
                'Tanggal Mulai Proyek',
                'Tanggal Selsai Proyek',
                'Profit Margin Proyek',
                'Tenor Waktu Proyek',

        ];
    }
}
