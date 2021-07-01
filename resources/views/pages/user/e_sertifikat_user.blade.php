<!DOCTYPE html>
<html>
<head>
	<title>{{$title}}</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="import" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<style type="text/css">
	.bg{
		width: 100%;
		position: fixed;
		z-index: 10;
	}
	.bg-text{
		z-index: 50;
	}
	.line-header-no-seri{
		z-index: 99;
		position: fixed;
		margin-top: 19.8899999%;
		margin-left: 40.5%;
        font-size: 18px !important;
	}
	.line-header-tanggal{
		z-index: 99;
		position: absolute;
		margin-top: 25.677777%;
		margin-left: 43.5%;
        font-size: 17px !important;
	}
	.line-header-jumlah{
		z-index: 99;
		position: absolute;
		margin-top: 36.8%;
		margin-left: 41.5%;
		font-size: 20px !important;
	}

	/*kiri*/
	.line-header-terbilang{
		z-index: 99;
		position: absolute;
		margin-top: 46.7%;
		margin-left: 30.5%;
		max-width: 245px;
		font-size: 12px !important;
	}

	.line-header-tanggal-value{
		z-index: 99;
		position: absolute;
		margin-top: 53.5%;
		margin-left: 30.5%;
		font-size: 12px !important;
	}
	.line-header-rekening{
		z-index: 99;
		position: absolute;
		margin-top: 60.7%;
		margin-left: 30.5%;
		max-width: 245px;
		font-size: 12px !important;
	}
	


	/*kanan*/
	
	.line-header-nama{
		z-index: 99;
		position: absolute;
		margin-top: 47.3%;
		margin-left: 73.5%;
		font-weight: bold;
		font-size: 12px !important;
	}
	/* .line-header-bagi-hasil{
		z-index: 99;
		position: absolute;
		margin-top: 46.5%;
		margin-left: 73.5%;
		font-size: 12px !important;
	} */

	.line-header-tanggal-tempo{
		z-index: 99;
		position: absolute;
		margin-top: 53.2%;
		margin-left: 73.5%;
		font-size: 12px !important;
	}
	.line-header-no-va{
		z-index: 99;
		position: absolute;
		margin-top: 60.68889999999%;
		margin-left: 73.5%;
		font-size: 12px !important;
	}


</style>

</head>
<body>
		<img class="bg" src="img/SertifikatMaster.png"/>
		
		<div class="bg-text">
			<div class="line-header-no-seri">
				<h5><b>{{$all_random}}</b></h5>
			</div>
			<div class="line-header-tanggal">
				<h5><b>{{ Carbon\Carbon::now()->formatLocalized('%d %B %Y')}}</b></h5>	
			</div>
			<div class="line-header-jumlah">
				<h3><b>Rp. {{$dana}}</b></h3>	
			</div>

			<div class="kiri">
				<div class="line-header-terbilang">
					<h5><b>{{$hasil_bilangan}}</b></h5>	
				</div>
				<div class="line-header-tanggal-value">
					<h5><b>{{ Carbon\Carbon::now()->formatLocalized('%d %B %Y')}}</b></h5>	
				</div>
				<div class="line-header-rekening">
					<div>
						<div>
							<h5><b>{{$alamat_investor}}</b></h5>
						</div>	
					</div>		
				</div>
				
			</div>

			<div class="kanan">
				<div class="line-header-nama">
					{{$nama_investor}}
				</div>
				{{-- <div class="line-header-bagi-hasil">
					<h5><b>15 %</b></h5>	
				</div> --}}
				<div class="line-header-tanggal-tempo">
					<h5><b>{{$bankinvestor}}</b></h5>	
					<h5><b>{{$rek_investor}}</b></h5>
				</div>
				<div class="line-header-no-va">
					<h5><b>{{$nomer_va}}</b></h5>	
				</div>
			</div>
		</div>
</body>
</html>