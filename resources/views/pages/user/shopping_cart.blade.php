@extends('layouts.user.sidebar')

@section('title', 'Keranjang')

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <h2>Keranjang</h2>
    </div>
    @if ($status)
      <div class="alert alert-danger col-sm-12">
          {{ $status }}
      </div>
    @endif
    @if (session('success'))
      <div class="alert alert-success col-sm-12">
          {{ session('success') }}
      </div>
    @endif
    @if (session('error'))
      <div class="alert alert-danger col-sm-12">
          {{ session('error') }}
      </div>
    @endif
  </div>
  <hr>
  <div class="row d-flex justify-content-center">
    <div class="col-12  mt-5">
        <div class="row my-5">
          <div class="col-sm-12 col-lg-6">
            <div class="card text-center card_dashboard" style="background-color: steelblue;">
              <div class="card-body">
                <h5 class="card-title">Dana Tersedia</h5>
                Rp. <span id="dana_tersedia">{{isset($rekening) ? number_format($rekening->unallocated,  0, '', '.') : 0}}</span>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-lg-6">
            <div class="card text-center card_dashboard" style="background-color: limegreen;">
              <div class="card-body">
                <h5 class="card-title">Dana setelah pembayaran</h5>
                @if ($status)
                Rp. 0.00
                @else
                Rp. <span id="bunga_diterima">{{isset($rekening) ? number_format($rekening->unallocated - $total,  0, '', '.') : 0}}</span>
                @endif
              </div>
            </div>
          </div>
        </div>
      <table class="table table-bordered table_shopping_cart table-responsive-sm">
        <thead class="table-success">
          <th>Judul Pendanaan</th>
          <th>Jumlah</th>
          <th>Harga</th>
          <th>Aksi</th>
        </thead>
        <tbody>
          @foreach($cart as $item)
              <tr>
                <form action="{{ route('cart.update', $item->rowId) }}" method="POST">
                  <input type="hidden" name="_method" value="PATCH">
                  {{-- <input type="hidden" value="{{ $item->rowId }}" name="rowId"> --}}
                  @csrf
                  <td>{{ $item->name }}</td>
                  <td><input type="number" value="{{ $item->qty }}" name="qty"></td>
                  <td>Rp. {{isset($rekening) ? number_format($item->price, 0, '','.') : 0}}</td>
                  <td><button class="btn btn-submit" type="submit">Ubah</td>
                </form>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="row d-flex justify-content-center">
    <div class="col-lg-8 col-xl-6 my-5">
      <div class="row">
        <div class="col-sm-12">
          <h4>Ringkasan Keranjang</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <table class="table table-sm">
            <thead class="table-success">
              <th>Nama Proyek</th>
              <th>Total Harga</th>
            </thead>
            <tbody>
              <form action="{{route('cart.checkout')}}" method="POST" id="checkout_form">
                @csrf

                @foreach ($cart as $item)
                <tr>
                  <td>{{$item->name}}</td>
                  <td>Rp. {{ number_format($item->subprice,  0, '', '.') }}</td>
                </tr>
                <input hidden value="{{$item->id[0]->id}}" name="id_proyek[{{$loop->index}}]">
                <input hidden value="{{$item->qty}}" name="qty[{{$loop->index}}]">
                @endforeach
              </form>
              <tr>
                <td><b>Total Bayar</b></td>
                <td><b>Rp. {{ number_format($total,  0, '', '.') }}</b></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-12 d-flex justify-content-between">
          <form method="POST" action="{{ route('cart.reset') }}">
            @csrf
            <button class="btn btn-sm btn-block" type="submit">Reset</button>
          </form>
          <form action="{{route('investation_feed')}}">
            <button type="submit" class="btn btn-sm mx-2"><i class="fas fa-plus"></i></button>
          </form>
          @if ($status || $cart->isEmpty())
            <button class="btn btn-sm btn-block" data-toggle="modal" data-target="#checkoutModal" disabled>Proses Pendanaan</button>
          @else
            <button class="btn btn-sm btn-block" data-toggle="modal" data-target="#checkoutModal">Proses Pendanaan</button>
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <p>Apakah anda yakin ingin melanjutkan?
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tidak</button>
          <button type="submit" form="checkout_form" class="btn btn-sm btn-success" id="confirmCheckout">Iya</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    $("#confirmCheckout").click(function() {
          $("#checkout_form").submit();
      });
  </script>

  @endsection
