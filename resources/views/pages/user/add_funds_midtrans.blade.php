@extends('layouts.user.sidebar')

@section('title', 'Tambah Dana')

@section('content')

<div class="content mt-3">
  <div class="row">
    <div class="alert alert-danger col-sm-12" id = "msg_error" style="display: none;"></div>
  </div>

  <div class="row">
    <div class="col-sm-8 center">
      <div class="card">
        <div class="card-header text-center">
            <strong class="card-title">Tambah Dana</strong>
        </div>
        <div class="card-body">
            <form onsubmit="return submitForm();">
            {{-- @csrf --}}
            <input type="hidden" class="form-control" name="investor_id" id="investor_id" value="{{ $investor_id }}">
            <div class="form-group row">
              <label for="Total Dana" class="col-sm-4 col-form-label">Total Dana</label>
              <div class="col-sm-8">
                <input type="number" class="form-control" name="total_dana" id="total_dana">
              </div>
            </div>
            <div class="float-right">
                <button type="submit" class="btn btn-success">Tambah</button>
            </div>
            
            </form>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .center {
     width: 21.5em;
     margin:0 auto;
  }
</style>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="{{ !config('services.midtrans.isProduction') ? 'https://app.sandbox.midtrans.com/snap/snap.js' : 'https://app.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

<script type="text/javascript">
  
  function submitForm() {
        // Kirim request ajax
        $.post("{{ route('user.proses.tambah') }}",
        {
            _method: 'POST',
            _token: '{{ csrf_token() }}',
            investor_id: $('#investor_id').val(),
            total_dana: $('#total_dana').val()
            // amount: $('input#amount').val(),
            // note: $('textarea#note').val(),
            // donation_type: $('select#donation_type').val(),
            // donor_name: $('input#donor_name').val(),
            // donor_email: $('input#donor_email').val(),
        },
        function (data, status) {
            snap.pay(data.snap_token, {
                // Optional
                onSuccess: function (result) {
                    // location.reload();
                    console.log(result)
                    $('#msg_error').attr('style','display: block').text(result.status_message+'. Silahkan Cek Email Anda.')
                },
                // Optional
                onPending: function (result) {
                    // location.reload();
                    $('#msg_error').attr('style','display: block').text(result.status_message+'. Silahkan Cek Email Anda.')
                },
                // Optional
                onError: function (result) {
                    // location.reload();
                    $('#msg_error').attr('style','display: block').text(result.status_message+'.')
                },
                onClose: function()
                {
                  alert('customer closed the popup without finishing the payment');
                }
            });
        });
        return false;
    }

</script>

@endsection
