<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mutasi Proyek {{$data_proyek->nama}}</title>
</head>
<body>
    <div class="header">
        <h3 colspan="4">Danasyariah.id</h3>
        <h4 style="line-height: 0px;">Mutasi Proyek {{$data_proyek->nama}}</h4>
        <p><small style="opacity: 0.5;"></small></p>
        <p></p>
    </div>
    <div class="customer">
        <table>
            <tr>
                <td>Nama Proyek</td>
                <td>: {{$data_proyek->nama}}</td>
            </tr>
            <tr>
                <td>Tanggal Mulai</td>
                <td>: {{\Carbon\Carbon::parse($data_proyek->tgl_mulai)->format('d/m/Y')}}</td>
            </tr>
            <tr>
                <td>Tanggal Selesai</td>
                <td>: {{\Carbon\Carbon::parse($data_proyek->tgl_selesai)->format('d/m/Y')}}</td>
            </tr>
            <tr>
                <td>Margin Keuntungan</td>
                <td>: {{$data_proyek->profit_margin}}%</td>
            </tr>
            <tr>
                <td>Margin Keuntungan</td>
                <td>: {{$data_proyek->profit_margin}}%</td>
            </tr>
        </table>
    </div>
    <div class="page">
        <table class="layout display responsive-table">
            <thead>
                <tr>
                    {{-- <th>#</th> --}}
                    <th>Nama Pendana</th>
                    <th>Tanggal Pendanaan</th>
                    {{-- <th>Tanggal Transfer</th> --}}
                    <th>Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_pendana as $data)
                <tr>
                    <td>{{$data->nama_investor}}</td>
                    <td>{{\Carbon\Carbon::parse($data->tanggal_invest)->format('d/m/Y')}}</td>
                    {{-- <td>{{$data->nama_investor}}</td> --}}
                    <td>{{$data->total_dana}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="align:left"><strong>Total</strong></td>
                    <td>{{$dana_sum}}</td>                    
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>