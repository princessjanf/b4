@extends('master')

@section('title', 'List Beasiswa')

@section('head')
<link href="{{ asset('css/multiple-select.css') }}" rel="stylesheet" />

@endsection

@section('content')

@if (session('namabeasiswa'))
    <div class="alert alert-success">
        Dokumen kerjasama untuk {{ session('namabeasiswa') }} telah <b> berhasil </b> diunggah: {{ session('namadokumen') }}
    </div>

@elseif (session('namabeasiswatimpa'))
    <div class="alert alert-success">
        Dokumen kerjasama untuk {{ session('namabeasiswatimpa') }} telah <b> berhasil </b> diperbaharui: {{ session('namadokumentimpa') }}
    </div>
@endif

@if($namarole=="Pegawai Universitas")
	<h2>Paket-Paket Beasiswa &nbsp;&nbsp;
		<a data-toggle="tooltip" title="Tambah beasiswa" role="button" id="add-beasiswa" class="btn btn-success" href="{{ url('add-beasiswa') }}"><span class="glyphicon glyphicon-plus">&nbsp;</span>Tambah Beasiswa</a>
		@if ($seleksichecker==1)
			<a data-toggle="tooltip" title="Buka Halaman Seleksi"  class="btn btn-info" href="{{ url('seleksi') }}">&nbsp;Seleksi Beasiswa</a>
  </h2>
		@endif

    <p>Sebagai Pegawai Universitas anda dapat membuat, memodifikasi, menghapus, mengumumkan beasiswa, dan menyeleksi beasiswa.</p>
    <p class="list-group-item list-group-item-info" style="font-size:8pt; font-weight: bold; font-style: italic; ">*Anda hanya dapat mengumumkan beasiswa apabila Direktorat Kerjasama sudah mengunggah dokumen kerjasama atas beasiswa tersebut.</p>
    <br>
@else
	<h2>Paket-Paket Beasiswa &nbsp;&nbsp;
		@if ($seleksichecker==1 AND $namarole!="Direktorat Kerjasama" AND $namarole!="Direktorat Kerjasama")
			<a data-toggle="tooltip" title="Buka Halaman Seleksi"  class="btn btn-info" href="{{ url('seleksi') }}">&nbsp;Seleksi Beasiswa</a>
			</h2>
		@elseif($namarole=="Direktorat Kerjasama")
		</h2>
			<p>Sebagai Direktorat Kerjasama anda dapat mengunggah dokumen kerjasama yang sudah disepakati.</p>
			<p class="list-group-item list-group-item-info" style="font-size:8pt; font-weight: bold; font-style: italic; ">*Dengan dokumen kerjasama yang telah diunggah, akan membuat beasiswa tersebut dapat diumumkan kepada publik oleh Pegawai Universitas.</p>
			<br>
		@endif
@endif
<table id="beasiswalist" class="table table-striped">
	<thead>
		<tr>
			@if($namarole=="Direktorat Kerjasama")
				<th>Waktu dibuat</th>
			@else
				<th>No</th>
			@endif
			<th>Nama Beasiswa</th>
			<th>Pendonor</th>
			@if($namarole=="Pendonor" || $namarole=="Pegawai Universitas" || $namarole=="Direktorat Kerjasama")
				<th>Status</th>
			@endif
			@if($namarole!="Direktorat Kerjasama")
				<th>Pendaftaran</th>
				<th>Tanggal Tutup</th>
			@else
				<th>Dokumen</th>
			@endif

			@if($namarole=="Mahasiswa" || $namarole=="Pegawai Universitas" || $namarole=="Direktorat Kerjasama")
				<th></th>
			@endif
		</tr>
	</thead>
	<tbody>
		@foreach ($beasiswas as $index => $beasiswa)
			<tr>
				@if($namarole!="Direktorat Kerjasama")
					<td>{{$index+1}}</td>
				@else
					@php
						$bulan = substr($beasiswa->timestamp, 5,2);
						$waktu = substr($beasiswa->timestamp, 11,8);
						$tanggal = substr($beasiswa->timestamp, 8,2);
						$tahun = substr($beasiswa->timestamp, 0,4);
						if($bulan=="01"){
							$bulan="Januari";
						}else if ($bulan=="02"){
							$bulan="Februari";
						}else if ($bulan=="03"){
							$bulan="Maret";
						}else if ($bulan=="04"){
							$bulan="April";
						}else if ($bulan=="05"){
							$bulan="Mei";
						}else if ($bulan=="06"){
							$bulan="Juni";
						}else if ($bulan=="07"){
							$bulan="Juli";
						}else if ($bulan=="08"){
							$bulan="Agustus";
						}else if ($bulan=="09"){
							$bulan="September";
						}else if ($bulan=="10"){
							$bulan="Oktober";
						}else if ($bulan=="11"){
							$bulan="November";
						}else if ($bulan=="12"){
							$bulan="Desember";
						}
					@endphp
				 <td> {{$waktu}} <br> {{$tanggal}}-{{$bulan}}-{{$tahun}}</td>
				@endif
				<td>
					<a href="{{ url('detail-beasiswa/'.$beasiswa->id_beasiswa) }}">{{$beasiswa->nama_beasiswa}}</a>
				</td>
				<td>
					{{$beasiswa->nama_instansi}}
				</td>
				@if($namarole=="Pendonor" || $namarole=="Pegawai Universitas" || $namarole=="Direktorat Kerjasama")
					<td>
						@if ($beasiswa->public == 1)
						<p><b><font color="green">Sudah Publik</font></b></p>
						@else
						<p><b><font color="red">Belum Publik</font></b></p>
						@endif
					</td>
				@endif

				@if($namarole!="Direktorat Kerjasama")
					<td>
						@if ($beasiswa->tanggal_buka <= Carbon\Carbon::now() AND Carbon\Carbon::now() <= $beasiswa->tanggal_tutup AND $beasiswa->public==1)
						      <p><b><font color="green">Dibuka</font></b></p>
						@else
						      <p><b><font color="red">Ditutup</font></b></p>
						@endif
					</td>
					@php
						$bulan = substr($beasiswa->tanggal_tutup, 5,2);
						$waktu = substr($beasiswa->tanggal_tutup, 11,8);
						$tanggal = substr($beasiswa->tanggal_tutup, 8,2);
						$tahun = substr($beasiswa->tanggal_tutup, 0,4);
						if($bulan=="01"){
							$bulan="Januari";
						}else if ($bulan=="02"){
							$bulan="Februari";
						}else if ($bulan=="03"){
							$bulan="Maret";
						}else if ($bulan=="04"){
							$bulan="April";
						}else if ($bulan=="05"){
							$bulan="Mei";
						}else if ($bulan=="06"){
							$bulan="Juni";
						}else if ($bulan=="07"){
							$bulan="Juli";
						}else if ($bulan=="08"){
							$bulan="Agustus";
						}else if ($bulan=="09"){
							$bulan="September";
						}else if ($bulan=="10"){
							$bulan="Oktober";
						}else if ($bulan=="11"){
							$bulan="November";
						}else if ($bulan=="12"){
							$bulan="Desember";
						}
					@endphp
				 <td> {{$waktu}} <br> {{$tanggal}}-{{$bulan}}-{{$tahun}}</td>
				@else
					@if($beasiswa->nama_dokumen==null)
						<td style="font-style: italic;">Belum ada</td>
					@else
						<td style="font-weight: bold; color: blue">
							<form action="{{url('unduh-dk')}}" method="POST">
							 <input type="text" value="{{$beasiswa->nama_dokumen}}" name="dk" hidden>
							 <input type="text" value="{{$beasiswa->id_beasiswa}}" name="idBeasiswa" hidden>
							 <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
							 <input type="submit" class="btn btn-default" name="submit" value="{{$beasiswa->nama_dokumen}}" />
						 </form>
						</td>
					@endif
				@endif
			</td>

        @if($namarole=="Pegawai Universitas")
          <td>
              <a href = "{{ url('edit-beasiswa/'.$beasiswa->id_beasiswa) }}" class="btn btn-warning" data-toggle="tooltip" title="Modifikasi" role="button">
                <span class="glyphicon glyphicon-pencil"></span>
              </a>

              <button class="btn btn-danger" type="submit" title="Hapus" data-toggle="modal" data-target="#confirmationDelete" data-username="{{$beasiswa->id_beasiswa}}" data-username2="{{$beasiswa->nama_beasiswa}}">
                <span class="glyphicon glyphicon-trash"></span>
              </button>

    				<!-- Modal -->
    				<div class="modal fade" id="confirmationDelete" role="dialog">
    					<div class="modal-dialog">
    						<!-- Modal content-->
    						<div class="modal-content">
    							<div class="modal-header">
    								<button type="button" class="close" data-dismiss="modal">&times;</button>
    								<h4 class="modal-title">Hapus Beasiswa</h4>
    							</div>
    							<div class="modal-body">
    								<p id='isi1'>Anda yakin ingin menghapus beasiswa?</p>
    							</div>
    							<div class="modal-footer">
    								<a href="#" id="linkHapus" ><button type="button" class="btn btn-success">Ya</button></a>
    								<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
    							</div>
    						</div>
    					</div>
    				</div>
    				@if($beasiswa->public==0)

      				<button class="btn btn-info" type="submit" title="Umumkan" data-toggle="modal" data-target="#confirmationPublic" data-username="{{$beasiswa->id_beasiswa}}" data-username2="{{$beasiswa->nama_beasiswa}}">
      					<span class="glyphicon glyphicon-eye-open"></span>
      				</button>

      				<!-- Modal -->
      				<div class="modal fade" id="confirmationPublic" role="dialog">
    					<div class="modal-dialog">
    						<!-- Modal content-->
    						<div class="modal-content">
    							<div class="modal-header">
    								<button type="button" class="close" data-dismiss="modal">&times;</button>
    								<h4 class="modal-title">Umumkan Beasiswa</h4>
    							</div>
    							<div class="modal-body">
    								<p id='isi2'>Anda yakin ingin mengumumkan beasiswa?</p>
    							</div>
    							<div class="modal-footer">
    								<a href="#" id="linkPublic" ><button type="button" class="btn btn-success">Ya</button></a>
    								<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
    							</div>
    						</div>
    					</div>
    				</div>
    				@else
              @foreach ($dokumenkerjasamas as $index => $dk)
    						@if($beasiswa->public==0 AND $dk->id_beasiswa==$beasiswa->id_beasiswa)
    						<a href = "{{ url('make-public-beasiswa/'.$beasiswa->id_beasiswa) }}" class="btn btn-info" data-toggle="tooltip" title="Buat Publik" role="button">
    							<span class="glyphicon glyphicon-eye-open"></span>
    						</a>
    						@else
    						@endif
              @endforeach
            @endif
    			</td>
  			@elseif($namarole=="Mahasiswa")
  				<td align="center">	@if ($beasiswa->tanggal_buka <= Carbon\Carbon::now() and Carbon\Carbon::now() <= $beasiswa->tanggal_tutup)
  					@if($beasiswa->id_jenis_seleksi=='1')
  					<a href= "{{url($beasiswa->link_seleksi)}}"><button class="btn"><b>Daftar</b></button></a>
  					@else
  					<a href= "{{url('daftar-beasiswa/'.$beasiswa->id_beasiswa)}}"><button class="btn"><b>Daftar</b></button></a>
  					@endif
  				</td>
  			@endif

			@elseif($namarole=="Direktorat Kerjasama")
				<td>
					<a data-toggle="tooltip" title="Unggah Dokumen Kerjasama" role="button" class="btn btn-success" href="{{ url('unggah-dokumen-kerjasama/'.$beasiswa->id_beasiswa) }}"><span class="glyphicon glyphicon-arrow-up"></span><br></a>
				</td>
			@endif
			</tr>
		@endforeach
	</tbody>
</table>
@endsection

@section('script')
<script>
	$('#confirmationDelete').on('show.bs.modal', function(e) {
		var idBeasiswa = e.relatedTarget.dataset.username;
		var namaBeasiswa = e.relatedTarget.dataset.username2;
		document.getElementById("isi1").innerHTML="Anda yakin ingin menghapus beasiswa "+namaBeasiswa+"?";
		var link = document.getElementById("linkHapus");
		var linkHapus = "./delete-beasiswa/"+idBeasiswa;
		link.setAttribute("href", linkHapus);
	});
</script>

<script>
	$('#confirmationPublic').on('show.bs.modal', function(e) {
		var idBeasiswa = e.relatedTarget.dataset.username;
		var namaBeasiswa = e.relatedTarget.dataset.username2;
		document.getElementById("isi2").innerHTML="Anda yakin ingin mengumumkan beasiswa "+namaBeasiswa+"?";
		var link = document.getElementById("linkPublic");
		var linkUmum = "./make-public-beasiswa/"+idBeasiswa;
		link.setAttribute("href", linkUmum);
	});
</script>
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#beasiswalist').DataTable({
			"paging": false
	});
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>

<style media="screen">
	.dataTables_filter {
		margin-left: 175px;
	}
</style>
@endsection