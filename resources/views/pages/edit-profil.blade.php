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
      <p>{{$pegawai->jabatan}}</p>
    
    @elseif($namarole=='pendonor')
    NAMA INSTANSI:
     <p>{{$pendonor->nama_instansi}}</p>
     NAMA:
      <p>{{$pengguna->nama}}</p>

      NAMA BEASISWA YANG DI DONORKAN:
       @foreach($beasiswas as $index => $beasiswa)
    <p>{{$index+1}} {{$beasiswa->nama_beasiswa}}</p>
    @endforeach

   @elseif($namarole=='mahasiswa')
   <form id='editProfil' action = "{{ url('edit-profil') }}" onsubmit="return validateForm()" method = "post" data-parsley-validate="">
   NAMA:
 <p><label> {{$pengguna->nama}}</label></p>
   FAKULTAS
   <p><label>{{$fakultas->nama_fakultas}}</label></p>
   PROGRAM STUDI
   <p><label>{{$prodi->nama_prodi}}</label></p>
   JENJANG:
   <p></p>
   IPK:
   <p><label>{{$mahasiswa->IPK}}</label></p>
   NOMOR REKENING:
   <p><label>{{$mahasiswa->nomor_rekening}}</label></p>
   NAMA BANK:
    <p>{{$mahasiswa->nama_bank}}</p>
   JENIS IDENTITAS:
   <input type="text" class="form-control" name="jenisIdentitas" required value= "{{ $mahasiswa->jenis_identitas }}">
    NO. IDENTITAS:
  <input type="text" class="form-control" name="nomorIdentitas" required value= "{{ $mahasiswa->nomor_identitas }}">
    NO.TELEPON:
     <p>{{$mahasiswa->nomor_telepon}}</p>
    NO. HANDPHONE:
     <p>{{$mahasiswa->nomor_telepon}}</p>
    NAMA PEMILIK REKENING:
    <input type="text" class="form-control" name="pemilikRekening" required value= "{{ $mahasiswa->nama_pemilik_rekening }}">
    PENGHASILAN ORANG TUA:
     <p>{{$mahasiswa->penghasilan_orang_tua}}</p>

    DAFTAR BEASISWA YANG DIDAFTAR:
    @foreach($beasiswas as $index => $beasiswa)
    <p>{{$index+1}} {{$beasiswa->nama_beasiswa}}</p>
    @endforeach
</form>

    @endif
   
<div name= "alertNomorIdentitas" class="alert alert-danger alert-dismissable fade in">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Nomor identitas harus berupa angka</strong>
</div>
 <div>
    <button type="submit" id="submit-form" class="btn"> <a href="{{ url('profil') }}" >Submit</a></button>
    <button style ="text-decoration: none"id="cancel" class="btn btn-danger" formnovalidate><a href="{{ url('profil') }}" >Cancel </a></button>
  </div>
@endsection

@section('script')
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script src="http://parsleyjs.org/dist/parsley.js"></script>
<script>
  $("[name='alertNomorIdentitas']").hide();
  $("[name='alertDanaModal']").hide();
  counter=1;
  /*function insertRow(){
    counter+=1;
    document.getElementsByName("counter")[0].value = counter;
    var theForm = document.getElementById('editScholarshipForm');*/
    /*
    var tmp = document.createElement("input");
    tmp.name = "syarat"+counter;
    tmp.type = "text";
    console.log(tmp.name);
    theForm.appendChild(tmp);
    var r = document.createElement('span');
    theForm.appendChild(r);
    */
   /* var x = document.getElementsByName('syarat')[0];
    var elem = document.createElement('div');
    elem.innerHTML = '<input type = "text" class="form-control" name="syarat'+counter+'">';
    x.appendChild(elem);
    theForm.appendChild(x);
  }*/
  /*if (nomorIdentitas)
    {
      return true;
    }
    else if(totalDana != jumlahDana){
      $("[name='alertDanaModal']").show();
      return false;
    }*/
    function validateForm(){
    var jenisIdentitas = document.getElementsByName('jenisIdentitas').value;
    var nomorIdentitas = document.getElementsByName('nomorIdentitas').value;
     var number = /^[0-9]+$/;  
     if((nomorIdentitas.value.match(number))   
     {  
       return true;  
     }  
     else  
     {   
       alert("alertNomorIdentitas");   
       return true;   
     }  
   /* var kuota = document.getElementsByName('kuota')[0].value;
    var nominal = document.getElementsByName('nominal')[0].value;
    var jangka = document.getElementsByName('jangka')[0].value;
    var jumlahDana = kuota*nominal*jangka;
    var tanggalBuka = new Date(document.getElementsByName('tanggalBuka')[0].value);
    var tanggalTutup = new Date(document.getElementsByName('tanggalTutup')[0].value);
    if (tanggalBuka.getTime() < tanggalTutup.getTime() && totalDana == kuota*nominal*jangka)
    {
      return true;
    }
    else if(totalDana != jumlahDana){
      $("[name='alertDanaModal']").show();
      return false;
    }
    else{
      $("[name='alertDateModal']").show();
      return false;
    }
*/
  }
   /* function numeric(nomorIdentitas)  
{  
 var number = /^[0-9]+$/;  
 if((nomorIdentitas.value.match(number))   
  {  
   return true;  
  }  
else  
  {   
   alert("alertNomorIdentitas");   
   return false;   
  }  
}  */

  
  $(function () {
    $('#editScholarshipForm').parsley().on('field:validated', function() {
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
