<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Carbon\Carbon;
use App\Proyek;

class ProyekAllData implements FromArray, ShouldAutoSize, WithHeadings
{

    public function array(): array
    {
        $datas = Proyek::leftJoin('pemilik_proyeks','pemilik_proyeks.id','=','id_pemilik')
                       ->select(
                            [
                            'pemilik_proyeks.deskripsi_pemilik',
                            'proyek.nama',
                            'proyek.alamat',
                            'proyek.profit_margin',
                            'proyek.total_need',
                            'proyek.harga_paket',
                            'proyek.tgl_mulai',
                            'proyek.tgl_selesai',
                            'proyek.tgl_mulai_penggalangan',
                            'proyek.tgl_selesai_penggalangan',
                            'proyek.terkumpul',
                            'proyek.tenor_waktu',
                            'proyek.akad',
                            ]
                       )
                       ->get();
        
        $dataExport = array();
        foreach($datas as $row)
        {
            $dataExport[] = [
                                'nama' => $row['nama'],
                                'alamat' => $row['alamat'],
                                'profit_margin' => $row['profit_margin'],
                                'total_need' => number_format($row['total_need']),
                                'tenor_waktu' => $row['tenor_waktu'],
                                'akad' => ($row['akad'] == 1 ? 'Murabahah' : 'Mudharabah'),
                                'deskripsi_pemilik' => strip_tags($row['deskripsi_pemilik']),
                                'tgl_mulai_penggalangan' => Carbon::parse($row['tgl_mulai_penggalangan'])->format('d-m-Y'),
                                'tgl_selesai_penggalangan' => Carbon::parse($row['tgl_selesai_penggalangan'])->format('d-m-Y'),
                                'tgl_mulai' => Carbon::parse($row['tgl_mulai'])->format('d-m-Y'),
                                'tgl_selesai' => Carbon::parse($row['tgl_selesai'])->format('d-m-Y'),
                            ];
        }

        return $dataExport;
        
        // return view('export_report.report_all_proyek', compact('dataExport'));

    }
    public function headings(): array
    {
        return [
                'Nama Proyek',
                'Alamat Proyek',
                'Profit Margin',
                'Total Dibutuhkan',
                'Tenor Waktu',
                'Akad',
                'Pemilik Proyek',
                'Tanggal Mulai Penggalangan',
                'Tanggal Selsai Penggalangan',
                'Tanggal Mulai Proyek',
                'Tanggal Selesai Proyek',
        ];
    }
}
