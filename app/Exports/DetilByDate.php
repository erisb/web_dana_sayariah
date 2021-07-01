<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
// use App\Controller
use App\Proyek;
use App\Investor;
use App\PendanaanAktif;
use Carbon\Carbon;

class DetilByDate implements FromArray, ShouldAutoSize, WithHeadings
{
    
    /**
    * @return \Illuminate\Support\Collection
    */

    private $data_arr;
    public function __construct(array $data){
        $this->data_arr = array(
            "tgl_m"=>$data['tgl_m'],
            "tgl_s"=>$data['tgl_s'],
        );
        
    }

    public function array(): array
    {
        
        $tgl_m = $this->data_arr['tgl_m'];
        $tgl_s = $this->data_arr['tgl_s'];
        if($tgl_m != null && $tgl_s != null)
        {
                $data = PendanaanAktif::whereBetween('tanggal_invest', array($tgl_m,$tgl_s))
                                      ->where('pendanaan_aktif.status',1)
                                      ->whereNotIn('pendanaan_aktif.status', [0])
                                      ->where('pendanaan_aktif.total_dana','>',100000)
                                      ->leftJoin('detil_investor','detil_investor.investor_id','=','pendanaan_aktif.investor_id')
                                      ->leftJoin('investor','investor.id','=','pendanaan_aktif.investor_id')
                                      ->leftJoin('rekening_investor','rekening_investor.investor_id','=','pendanaan_aktif.investor_id')
                                      ->leftjoin('m_bank', function ($join) {
                                        $join->on('detil_investor.bank_investor', '=', 'm_bank.kode_bank')
                                             ->select('nama_bank');
                                      })
                                      ->leftJoin('proyek','proyek.id','=','pendanaan_aktif.proyek_id')
                                      ->leftJoin('marketer','marketer.ref_code','=','investor.ref_number')
                                      ->leftJoin('detil_marketer','detil_marketer.marketer_id','=','marketer.id')
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
                                              'investor.ref_number',
                                              'detil_marketer.nama_lengkap'
                                          ]
                                      );
                $dataExport = array();
                foreach($data as $row)
                {
                    $dataExport[] = [
                                        'nama_investor' => $row['nama_investor'],
                                        'username' => $row['username'],
                                        'va_number' => "'".$row['va_number'],
                                        'email' => $row['email'],
                                        'phone_investor' => $row['phone_investor'],
                                        'rekening' => "'".$row['rekening'],
                                        'nama_bank' => $row['nama_bank'],
                                        'nama_pemilik_rek' => $row['nama_pemilik_rek'],
                                        'total_dana' => $row['total_dana'],
                                        'tanggal_invest' => $row['tanggal_invest'],
                                        'nama_proyek' => $row['nama'],
                                        'tgl_mulai' => $row['tgl_mulai'],
                                        'tgl_selesai' => $row['tgl_selesai'],
                                        'profit_margin' => $row['profit_margin'],
                                        'tenor_waktu' => $row['tenor_waktu'],
                                        'status_proyek' => $row['tgl_selesai'] <= Carbon::now()->format('Y-m-d') ? 'Selesai' : 'Aktif',
                                        'ref_number' => $row['ref_number'],
                                        'nama_lengkap' => $row['nama_lengkap']
                                    ];
                }
                // var_dump($dataExport);die;
                return $dataExport;
        }
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
                'Status Proyek',
                'Kode Refferal',
                'Nama Refferal'

        ];
    }
}
