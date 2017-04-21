@extends('master')

@section('title', 'Edit Profil')

@section('content')
    <div class="col-sm-9">
    
    @if($namarole=='Pegawai Universitas'||$namarole=='Pegawai Fakultas'||$namarole=='Direktorat Kerjasama')
    <label for="namaBeasiswa">NAMA</label>
     <p>{{$pengguna->nama}}</p>
     NIK:
     <p>{{$pegawai->no_identitas}}</p>
     JABATAN:
      <p>{{$jabatan->nama_jabatan}}</p>
    
    @elseif($namarole=='Pendonor')
    NAMA INSTANSI:
     <p>{{$pendonor->nama_instansi}}</p>
     NAMA:
      <p>{{$pengguna->nama}}</p>

      NAMA BEASISWA YANG DI DONORKAN:
       @foreach($beasiswas as $index => $beasiswa)
    <p>{{$index+1}} {{$beasiswa->nama_beasiswa}}</p>
    @endforeach

   @elseif($namarole=='Mahasiswa')
   <form id='editProfil' action = "{{ url('update-profil') }}" onsubmit="return validateForm()" method = "post" data-parsley-validate="">
   <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
   <input type = "hidden" name = "idUser" value= {{$mahasiswa->id_user}}>
   NAMA:
 <p><label> {{$pengguna->nama}}</label></p>
   FAKULTAS
   <p><label>{{$fakultas->nama_fakultas}}</label></p>
   PROGRAM STUDI
   <p><label>{{$prodi->nama_prodi}}</label></p>
   JENJANG:
<p><label>{{$jenjangmahasiswa->nama_jenjang}}</label></p>
   IPK:
   <p><label>{{$mahasiswa->IPK}}</label></p>
   NOMOR REKENING:
   <p><label>{{$mahasiswa->nomor_rekening}}</label></p>
   NAMA BANK:
   <div class="form-group">
   <!--  <label for="namaBank"></label> -->
    <div class="input-group col-sm-4">
      <select class="form-control" name="namaBank" id="namaBank" required>
        <option> {{ $mahasiswa->nama_bank }}</option>
       @if( $mahasiswa->nama_bank  != 'BNI')
        <option value= "BNI"> BNI </option>
       @endif
       @if( $mahasiswa->nama_bank  != 'BRI')
        <option value= "BRI"> BRI </option>
       @endif
       @if( $mahasiswa->nama_bank  != 'Mandiri')
        <option value= "Mandiri"> Mandiri </option>
       @endif
        @if( $mahasiswa->nama_bank  != 'BCA')
        <option value= "BCA"> BCA </option>
       @endif
       @if( $mahasiswa->nama_bank  != 'CIMB Niaga')
        <option value= "CIMB Niaga"> CIMB Niaga </option>
       @endif
        @if( $mahasiswa->nama_bank  != 'DKI')
        <option value= "DKI"> DKI </option>
       @endif
        @if( $mahasiswa->nama_bank  != 'Danamon')
        <option value= "Danamon"> Danamon </option>
       @endif
        @if( $mahasiswa->nama_bank  != 'OCBC NISP')
        <option value= "OCBC NISP"> OCBC NISP </option>
       @endif
        @if( $mahasiswa->nama_bank  != 'Bukopin')
        <option value= "Bukopin"> Bukopin </option>
       @endif
      </select>
    </div>
  </div>
  
   JENIS IDENTITAS:
   <div class="form-group">
   <!--  <label for="jenisIdentitas"></label> -->
    <div class="input-group col-sm-4">
      <select class="form-control" name="jenisIdentitas" id="jenisIdentitas" required>
        <option> {{ $mahasiswa->jenis_identitas }}</option>
       @if( $mahasiswa->jenis_identitas  != 'KTP')
        <option value= "KTP"> KTP </option>
       @endif
       @if( $mahasiswa->jenis_identitas  != 'SIM')
        <option value= "SIM"> SIM </option>
       @endif
       @if( $mahasiswa->jenis_identitas  != 'Kartu Pelajar')
        <option value= "KartuPelajar"> Kartu Pelajar </option>
       @endif
       @if( $mahasiswa->jenis_identitas  != 'Paspor')
        <option value= "Paspor"> Paspor </option>
       @endif
      </select>
    </div>
  </div>
   

    NO. IDENTITAS:
  <input type="number" class="form-control" name="nomorIdentitas" required value= "{{ $mahasiswa->nomor_identitas }}">
   <p></p>
    NO.TELEPON:
     <p><label>{{$mahasiswa->nomor_telepon}}</label></p>
    NO. HANDPHONE:
     <p><label>{{$mahasiswa->nomor_telepon}}</label></p>
    NAMA PEMILIK REKENING:
    <input type="text" class="form-control" name="pemilikRekening" required value= "{{ $mahasiswa->nama_pemilik_rekening }}">
    <p></p>
    PENGHASILAN ORANG TUA:
     <p><label>{{$mahasiswa->penghasilan_orang_tua}}</label></p>


   <div>
      <button type="submit" id="submit-form" class="btn"> Submit</button>
      <button style ="text-decoration: none"id="cancel" class="btn btn-danger" formnovalidate><a href="{{ url('profil') }}" >Cancel </a></button>
    </div>
</form>
<br>
<div name= "alertNomorIdentitas" class="alert alert-danger alert-dismissable fade in">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Nomor identitas harus berupa angka</strong>
</div>
    @endif
   
@endsection

@section('script')
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script src="http://parsleyjs.org/dist/parsley.js"></script>
<script>
  $("[name='alertNomorIdentitas']").hide();
  $("[name='alertDanaModal']").hide();
  

    function validateForm(){

       return true;   
     }  
  
  
  $(function () {
    $('#editProfil').parsley().on('field:validated', function() {
      var ok = $('.parsley-error').length === 0;
      $('.bs-callout-info').toggleClass('hidden', !ok);
      $('.bs-callout-warning').toggleClass('hidden', ok);
    })
    .on('form:submit', function() {
      return true;
    });
  });

</script>
@endsection
