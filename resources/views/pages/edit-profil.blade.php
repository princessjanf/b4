@extends('master')

@section('title', 'Edit Profil')

@section('content')

   <h2>EDIT PROFIL</h2>
   <form id='editProfil' action = "{{ url('update-profil') }}" onsubmit="return validateForm()" method = "post" data-parsley-validate="">
   <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
   <input type = "hidden" name = "idUser" value= {{$mahasiswa->id_user}}>
   <div class="row">
    <div class = "col-sm-6">
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
    <p></p>
    NOMOR REKENING:
   <input type="number" class="form-control" name="nomorRekening" required value= "{{ $mahasiswa->nomor_rekening }}">
   <p></p>
   <!-- <p><label>{{$mahasiswa->nomor_rekening}}</label></p> -->
  </div>
  </div>
   <div class = "col-sm-6">
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
  <input data-parsley-maxlength-message="Panjang harus 10 karakter" data-parsley-minlength-message="Panjang harus 10 karakter" data-parsley-maxlength= '10' data-parsley-minlength= '10' data-parsley-trigger="keyup" data-parsley-validation-threshold="8" type="number" class="form-control" name="nomorIdentitas" required value= "{{ $mahasiswa->nomor_identitas }}">
   <p></p>
    NO.TELEPON:
    <input data-parsley-maxlength-message="Panjang harus maksimal 12 karakter" data-parsley-minlength-message="Panjang harus minimal 8 karakter" data-parsley-maxlength= '12' data-parsley-minlength= '8' data-parsley-trigger="keyup" data-parsley-validation-threshold="8" type="number" class="form-control" name="nomorTelepon" required value= "{{ $mahasiswa->nomor_telepon }}">
   <p></p>
    <!--  <p><label>{{$mahasiswa->nomor_telepon}}</label></p> -->
    NO. HANDPHONE:
     <input data-parsley-maxlength-message="Panjang harus maksimal 12 karakter" data-parsley-minlength-message="Panjang harus minimal 8 karakter" data-parsley-maxlength= '12' data-parsley-minlength= '8' data-parsley-trigger="keyup" data-parsley-validation-threshold="8" type="number" class="form-control" name="nomorHandphone" value= "{{ $mahasiswa->nomor_hp }}">
   <p></p>
    <!--  <p><label>{{$mahasiswa->nomor_telepon}}</label></p> -->
    NAMA PEMILIK REKENING:
    <input maxlength="20" data-parsley-trigger="keyup" data-parsley-validation-threshold="8" type="text" class="form-control" name="pemilikRekening" required value= "{{ $mahasiswa->nama_pemilik_rekening }}">
    <p></p>
    PENGHASILAN ORANG TUA:
     <p> <input class="form-control" disabled id="penghasilan"></input></p>
     </div>
     </div>

   <div>
      <button type="submit" id="submit-form" class="btn"> Submit</button>
     <a href="{{ url('profil') }}" ><button id="cancel" class="btn btn-danger" type="button" formnovalidate>Cancel </button></a>
    </div>
</form>
<br>
<div name= "alertNomorIdentitas" class="alert alert-danger alert-dismissable fade in">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Nomor identitas harus berupa angka</strong>
</div>


@endsection

@section('script')
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script src="http://parsleyjs.org/dist/parsley.js"></script>
<script>
  $("[name='alertNomorIdentitas']").hide();
  $("[name='alertDanaModal']").hide();

  $(document).ready(function(){
    addComas('penghasilan',{{$mahasiswa->penghasilan_orang_tua}});
  });

  function addComas(place, nStr)
  {

    nStr = nStr.toString();
    var x1 = nStr.replace (/,/g, "");

    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    console.log(x1);
    document.getElementById('penghasilan').value = 'Rp' + x1;
  }
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
