@extends('main')

@section('title', '| Create Scholarship')

@section('nav.home')
class="active"
@endsection

@section('body')
<div class="container">
  <form action = "/insertScholarship" method = "post">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">


      <input type="text" class="form-control" name="namaBeasiswa">

    <div class="form-group">
      <label for="deskripsiBeasiswa">Deskripsi Beasiswa</label>
      <input type="textarea" class="form-control" name="deskripsiBeasiswa">
    </div>
    <div class="form-group">
      <label for="nominal">Nominal</label>
      <input type="number" class="form-control" name="nominal">
    </div>
    <div class="form-group">
      <label for="totalDana">Total Dana</label>
      <input type="number" class="form-control" name="totalDana">
    </div>
    <div class="form-group">
      <label for="kategoriBeasiswa">Kategori</label>
      <input type="text" class="form-control" name="kategoriBeasiswa">
    </div>
    <div class="form-group">
      <label for="tanggalBuka">Tanggal Buka</label>
      <input type="text" class="form-control" name="tanggalBuka">
    </div>
    <div class="form-group">
      <label for="tanggalTutup">Tanggal Tutup</label>
      <input type="text" class="form-control" name="tanggalTutup">
    </div>
    <div class="form-group">
      <label for="syaratBeasiswa">Syarat Beasiswa</label>
      <input type="text" class="form-control" name="syaratBeasiswa">
    </div>
    <div class="form-group">
      <label for="pendonor">Pendonor</label>
      <input type="text" class="form-control" name="pendonor">
    </div>
    <div class="form-group">
      <label for="kuota">Kuota</label>
      <input type="number" class="form-control" name="kuota">
    </div>

    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>
@endsection
