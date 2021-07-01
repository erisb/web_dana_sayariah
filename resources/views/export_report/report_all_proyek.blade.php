<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
    <table>
      <thead>
      <tr>
          <th>Nama Proyek</th>
          <th>Alamat Proyek</th>
          <th>Margin Keuntungan</th>
          <th>Akad</th>
          <th>Total Dibutuhkan</th>
          <th>Minimal Mendanai</th>
          <th>Tenor Waktu Proyek</th>
          <th>Pemilik Proyek</th>
          <th>Tanggal Mulai Proyek</th>
          <th>Tanggal Selesai Proyek</th>
          <th>Tanggal Mulai Penggalangan</th>
          <th>Tanggal Selesai Penggalangan</th>
      </tr>
      </thead>
      <tbody>
      @foreach($dataExport as $dt)
          <tr>
            <td>{{$dt->nama}}</td>
            <td>{{$dt->alamat}}</td>
            <td>{{$dt->profit_margin}} % / Tahun</td>
            <td>{{$dt->akad == 1 ? 'Murabahah' : 'Mudharabah'}}</td>
            <td>{{number_format($dt->total_need)}}</td>
            <td>{{number_format($dt->harga_paket)}}</td>
            <td>{{$dt->tenor_waktu}}</td>
            <td>{{$dt->deskripsi_pemilik}}</td>
            <td>{{Carbon\Carbon::parse($dt->tgl_mulai)->format('d-m-Y')}}</td>
            <td>{{Carbon\Carbon::parse($dt->tgl_selesai)->format('d-m-Y')}}</td>
            <td>{{Carbon\Carbon::parse($dt->tgl_mulai_penggalangan)->format('d-m-Y')}}</td>
            <td>{{Carbon\Carbon::parse($dt->tgl_selesai_penggalangan)->format('d-m-Y')}}</td>
          </tr>
      @endforeach
      </tbody>
    </table>
</body>
</html>