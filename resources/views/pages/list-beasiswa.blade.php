@extends('master')

@section('title', 'Paket Beasiswa')

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

@elseif (session('beasiswabuatpublik'))
    <div class="alert alert-success">
        {{ session('beasiswabuatpublik') }} telah <b> berhasil </b> dibuat publik. Mahasiswa sudah bisa melihat dan mendaftar beasiswa ini.
    </div>
@endif

@if($namarole=="Pegawai Universitas")
	<h2>PAKET-PAKET BEASISWA &nbsp;&nbsp;
		<a data-toggle="tooltip" title="Tambah beasiswa" role="button" id="add-beasiswa" class="btn btn-success" href="{{ url('add-beasiswa') }}"><span class="glyphicon glyphicon-plus">&nbsp;</span>Tambah Beasiswa</a>
		@if ($seleksichecker==1)
			<a data-toggle="tooltip" title="Buka Halaman Seleksi"  class="btn btn-info" href="{{ url('seleksi') }}">&nbsp;Seleksi Beasiswa</a>
  </h2>
		@endif
  </h2>
    <p>Sebagai Pegawai Universitas anda dapat membuat, memodifikasi, menghapus, membuat publik beasiswa, dan menyeleksi beasiswa.</p>

    <br>
    <div class="list-group">
      <p class="list-group-item list-group-item-warning"  style="font-size:10pt; font-weight: bold;">
      Perhatian:
      </p>
      <p class="list-group-item list-group-item-warning" style="font-size:8pt; font-weight: bold; font-style: italic; ">*Anda hanya dapat membuat publik beasiswa apabila Direktorat Kerjasama sudah mengunggah dokumen kerjasama atas beasiswa tersebut.<br>
      *Beasiswa yang sudah anda buat publik tidak dapat dihapus dan membuat mahasiswa dapat mengakses dan mendaftar beasiswa tersebut.</p>
    </div>
@elseif($namarole=="Mahasiswa")
  <h2>Paket-Paket Beasiswa &nbsp;&nbsp;</h2>
@else
	<h2>Paket-Paket Beasiswa &nbsp;&nbsp;
		@if ($seleksichecker==1 AND $namarole!="Direktorat Kerjasama")
			<a data-toggle="tooltip" title="Buka Halaman Seleksi"  class="btn btn-info" href="{{ url('seleksi') }}">&nbsp;Seleksi Beasiswa</a>
			</h2>
		@elseif($namarole=="Direktorat Kerjasama")
		</h2>
			<p>Sebagai Direktorat Kerjasama anda dapat mengunggah dokumen kerjasama yang sudah disepakati.</p>
      <div class="list-group">
        <p class="list-group-item list-group-item-warning"  style="font-size:10pt; font-weight: bold;">
        Perhatian:
        </p>
        <p class="list-group-item list-group-item-warning" style="font-size:8pt; font-weight: bold; font-style: italic; ">*Dengan dokumen kerjasama yang telah diunggah, akan membuat beasiswa tersebut dapat diumumkan kepada publik oleh Pegawai Universitas.
        </p>
      </div>
		@endif
@endif
<label><font color='#4192f4'>*) Klik judul tabel untuk menyortir berdasar kolom yang dipilih</font></label>
<table id="beasiswalist" class="table table-striped">
	<thead>
		<tr>
			<th>Waktu dibuat</th>
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
				 <td>  {{$tanggal}}-{{$bulan}}-{{$tahun}} <br> {{$waktu}} </td>
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

              @if ($beasiswa->public == '0')
                <button class="btn btn-danger" type="submit" title="Hapus" data-toggle="modal" data-target="#confirmationDelete" data-username="{{$beasiswa->id_beasiswa}}" data-username2="{{$beasiswa->nama_beasiswa}}">
                  <span class="glyphicon glyphicon-trash"></span>
                </button>
              @endif

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
              <?php $set = 0; ?>
            @foreach ($dokumenkerjasamas as $index => $dk)
              @if($beasiswa->public==0 AND $dk->id_beasiswa==$beasiswa->id_beasiswa)
                <?php $set = 2; ?>
                @break
              @elseif($beasiswa->public==1)
                <?php $set = 0; ?>
              @else
                <?php $set = 1; ?>
              @endif
            @endforeach

            @if($set == 2)
            @php
              $bulan = substr($beasiswa->tanggal_buka, 5,2);
              $waktu = substr($beasiswa->tanggal_buka, 11,8);
              $tanggal = substr($beasiswa->tanggal_buka, 8,2);
              $tahun = substr($beasiswa->tanggal_buka, 0,4);
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
            <button class="btn btn-info" type="submit" title="Buat Publik" data-toggle="modal" data-target="#confirmationPublic" data-username="{{$beasiswa->id_beasiswa}}" data-username2="{{$beasiswa->nama_beasiswa}}"
              data-bulan="{{$bulan}}" data-waktu="{{$waktu}}" data-tanggal="{{$tanggal}}" data-tahun="{{$tahun}}">
              <span class="glyphicon glyphicon-eye-open"></span>
            </button>
            @elseif($set == 0)
            <p></p>
            @else
            <button disabled class="btn btn-default" type="submit" title="Dokumen kerjasama belum ada" data-toggle="modal" data-target="#confirmationPublic" data-username="{{$beasiswa->id_beasiswa}}" data-username2="{{$beasiswa->nama_beasiswa}}">
              <span class="glyphicon glyphicon-eye-open"></span>
            </button>
            @endif

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

    								<p id='isi2'>Yakin?</p>
    							</div>
    							<div class="modal-footer">
    								<a href="#" id="linkPublic" ><button type="button" class="btn btn-success">Ya</button></a>
    								<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
    							</div>
    						</div>
    					</div>
    				</div>
    			</td>
  			@elseif($namarole=="Mahasiswa")
  				<td align="center">	@if ($beasiswa->tanggal_buka <= Carbon\Carbon::now() and Carbon\Carbon::now() <= $beasiswa->tanggal_tutup)
  					@if($beasiswa->id_jenis_seleksi=='1')
  					     <a href= "{{ url($beasiswa->link_seleksi) }}"><button class="btn"><b>Daftar</b></button></a>
  					@else
  					     <a href= "{{ url('daftar-beasiswa/'.$beasiswa->id_beasiswa) }}"><button class="btn"><b>Daftar</b></button></a>
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
    var tanggal = e.relatedTarget.dataset.tanggal;
    var tahun = e.relatedTarget.dataset.tahun;
    var bulan = e.relatedTarget.dataset.bulan;
    var waktu = e.relatedTarget.dataset.waktu;
		document.getElementById("isi2").innerHTML="Anda yakin ingin mengumumkan "+namaBeasiswa+ " walaupun mahasiswa baru bisa mendaftar pada "+ tanggal + "-" + bulan + "-" + tahun + " " + waktu +"?";
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
			"paging": false,
      "order": [[ 0, "desc" ]]
      // ,"columnDefs": [
      // { "width": "100px", "targets": 0 },
      // { "width": "150px", "targets": 1 },
      // { "width": "100px", "targets": 2 },
      // { "width": "70px", "targets": 3 },
      // { "width": "20px", "targets": 4 },
      // { "width": "90px", "targets": 5 },
      // { "width": "120px", "targets": 6 }
    // ]
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
