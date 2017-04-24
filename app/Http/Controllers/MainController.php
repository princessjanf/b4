<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use SSO\SSO;
	use Illuminate\Support\Facades\URL;
	use Illuminate\Support\Facades\DB;

	class MainController extends Controller
	{
		function index()
		{
			if(!SSO::check()) {
				$user = null;
				$beasiswas = DB::table('beasiswa')->where('flag', '1')->where('public', '1')->take(4)->get();
				return view('pages.homepage')->withBeasiswas($beasiswas)->withUser($user);
			}
			else{
				$user = SSO::getUser();
				$pengguna = DB::table('user')->where('username', $user->username)->first();
				$role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
				$namarole = $role->nama_role;

				if($namarole=='pegawai'){
					$pengguna = DB::table('pegawai')->where('username', $user->username)->first();
					$role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
					$namarole = $role->nama_role_pegawai;
				}

				$beasiswas = DB::table('beasiswa')->where('flag', '1')->where('public', '1')->take(4)->get();
				return view('pages.homepage')->withBeasiswas($beasiswas)->withUser($user)->withNamarole($namarole);
			}

		}

		function login()
		{
			if(!SSO::check())
			SSO::authenticate();
			$user = SSO::getUser();
			$exist = DB::table('user')->where('username', $user->username)->first();
			if ($exist == null)
			{
				DB::insert('INSERT INTO `user`(`username`, `nama`, `email`, `id_role`)
				VALUES (?,?,?,1)',
				[
				$user->username,
				$user->name,
				$user->username."@ui.ac.id"
				]
				);
				DB::insert('INSERT INTO `mahasiswa`(`username`, `npm`, `id_fakultas`, `id_prodi`)
				VALUES (?,?,1,1)',
				[
				$user->username,
				$user->npm
				]
				);
			}
			return redirect('');
		}

		function logout()
		{
			SSO::logout(URL::to('/'));
		}

		function listbeasiswa()
		{
			$user = SSO::getUser();
			$pengguna = DB::table('user')->where('username', $user->username)->first();
			$role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
			$namarole = $role->nama_role;

			if($namarole=='Pegawai'){
				$pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();
				$role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
				$namarole = $role->nama_role_pegawai;
			}

			if ($namarole == 'Mahasiswa' || $namarole == 'Pegawai Fakultas') {
				$beasiswas = DB::table('beasiswa')->where('flag', '1')->where('public', '1')->get();
				} else if ($namarole == 'pendonor'){
				$pendonor = DB::table('pendonor')->where('username', $user->username)->first();
				$beasiswas = collect(DB::table('beasiswa')->where('flag', '1')->where('public', '1')->get());
				$beasiswas2= collect(DB::table('beasiswa')->where('flag', '1')->where('public', '0')->where('id_pendonor', $pendonor->id_pendonor)->get());
				$beasiswas = $beasiswas->merge($beasiswas2)->sort()->values()->all();
				} else {
				$beasiswas = DB::table('beasiswa')->where('flag', '1')->get();
			}

			$daftarBeasiswa = DB::table('beasiswa_penyeleksi')->where('id_penyeleksi', $pengguna->id_user)
												->join('beasiswa','beasiswa_penyeleksi.id_beasiswa', 'beasiswa.id_beasiswa')
												->select('beasiswa.id_beasiswa', 'beasiswa.nama_beasiswa')->get();
			$seleksichecker = 0;
			if ($daftarBeasiswa->count() == 0)
			{
				return view('pages.list-beasiswa')->withBeasiswas($beasiswas)->withUser($user)->withNamarole($namarole)->withSeleksichecker($seleksichecker);
			}
			else{
				$seleksichecker = 1;
				return view('pages.list-beasiswa')->withBeasiswas($beasiswas)->withUser($user)->withNamarole($namarole)->withSeleksichecker($seleksichecker);
			}


		}

		function addbeasiswa()
		{
			$user = SSO::getUser();

			$pengguna = DB::table('pegawai')->where('username', $user->username)->first();

			if($pengguna==null){
				return redirect('/');
			}

			$role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
			$namarole = $role->nama_role_pegawai;

			$kategoribeasiswa = DB::table('kategori_beasiswa')->get();
			$pendonor = DB::table('pendonor')->get();

			if($namarole=='Pegawai Universitas'){
				return view('pages.createScholarship')->withUser($user)->withNamarole($namarole)->withKategoribeasiswa($kategoribeasiswa)->withPendonor($pendonor);
			}
		}
		function noaccess()
		{
			if(!SSO::check()) {
				$user = null;
				$beasiswas = DB::table('beasiswa')->where('flag', '1')->where('public', '1')->take(4)->get();
				return view('pages.homepage')->withBeasiswas($beasiswas)->withUser($user);
			}
			else{
				$user = SSO::getUser();
				$pengguna = DB::table('user')->where('username', $user->username)->first();
				$role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
				$namarole = $role->nama_role;

				if($namarole=='pegawai'){
					$pengguna = DB::table('pegawai')->where('username', $user->username)->first();
					$role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
					$namarole = $role->nama_role_pegawai;
				}

				$beasiswas = DB::table('beasiswa')->where('flag', '1')->where('public', '1')->get();
				return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
			}

		}
		function detailbeasiswa($id)
		{
			$user = SSO::getUser();
			$pengguna = DB::table('user')->where('username', $user->username)->first();
			$role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
			$namarole = $role->nama_role;

			if($namarole=='pegawai'){
				$pengguna = DB::table('pegawai')->where('username', $user->username)->first();
				$role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
				$namarole = $role->nama_role_pegawai;
			}

			$beasiswa = DB::table('beasiswa')->where('id_beasiswa', $id)->first();
			$persyaratans = DB::table('persyaratan')->where('id_beasiswa', $beasiswa->id_beasiswa)->get();

			if ($namarole=='pendonor')
			{
				$isPendonor = false;
				$pendonor = DB::table('beasiswa')
				->where('id_beasiswa', $beasiswa->id_beasiswa)
				->join('pendonor', 'beasiswa.id_pendonor', '=', 'pendonor.id_pendonor')
				->select('pendonor.*')
				->first();
				if ($pendonor->username == $user->username)
				{
					$isPendonor = true;
				}

				$pendaftars = DB::table('melamar')
				->where('id_beasiswa', $beasiswa->id_beasiswa)
				->join('user', 'melamar.username', '=', 'user.username')
				->select('melamar.*', 'user.nama')
				->get();
				return view('pages.detail-beasiswa')->withBeasiswa($beasiswa)->withPersyaratans($persyaratans)->withUser($user)->withNamarole($namarole)->withPendaftars($pendaftars)->withIspendonor($isPendonor);
			}
			else
			{
				return view('pages.detail-beasiswa')->withBeasiswa($beasiswa)->withPersyaratans($persyaratans)->withUser($user)->withNamarole($namarole);
			}
		}

		function pageSeleksi(){
			// get seleksi
			$user = SSO::getUser();
			$pengguna = DB::table('user')->where('username', $user->username)->first();
			$role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
			$namarole = $role->nama_role;

			if($namarole=='pegawai'){
				$pengguna = DB::table('pegawai')->where('username', $user->username)->first();
				$role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
				$namarole = $role->nama_role_pegawai;
			}


			$daftarBeasiswa = DB::table('beasiswa_penyeleksi')->where('id_penyeleksi', $pengguna->id_user)
												->join('beasiswa','beasiswa_penyeleksi.id_beasiswa', 'beasiswa.id_beasiswa')
												->select('beasiswa.id_beasiswa', 'beasiswa.nama_beasiswa')->get();
			if ($daftarBeasiswa->count() == 0)
			{
				return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
			}
			else{
			return view('pages.daftar-seleksi')->withDaftarbeasiswa($daftarBeasiswa)->withUser($user)->withNamarole($namarole);
			}
		}

		function seleksi($id)
		{
			/*
				Cek if user adalah penyeleksi beasiswa
				Jika iya, tunjukkan page seleksi beasiswa beserta tahapannya tapi di disabled kalau dia bukan penyeleksi tahapan tsb
				Jika dia penyeleksi tahapan tsb. tunjukkan tombol lakukan seleksiBeasiswa
				Jika tidak, tunjukkan no acces

				------------------------------------------SELEKSI
			*/
			$user = SSO::getUser();
			$pengguna = DB::table('user')->where('username', $user->username)->first();
			$role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
			$namarole = $role->nama_role;

			if ($namarole=='Mahasiswa')
			{
				return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
			}

			//Retrieve role pegawai
			else if($namarole=='Pegawai'){
				$pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();
				$role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
				$namarole = $role->nama_role_pegawai;
			}

			//Cek if user adalah penyeleksi untuk beasiswa tersebut
			$retrievePenyeleksi = DB::table('beasiswa_penyeleksi')->where('id_beasiswa',$id)->where('id_penyeleksi', $pengguna->id_user)->first();


			if (empty($retrievePenyeleksi))
			{
				return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
			}
			else{

				//Retrieve Akses Beasiswa: didapat dari get semua bp dgn beasiswa dan penyeleksi tertentu

				$retrAksesTahapan = DB::table('beasiswa_penyeleksi')->where('id_beasiswa',$id)->where('id_penyeleksi', $pengguna->id_user)
				->join('beasiswa_penyeleksi_tahapan','beasiswa_penyeleksi.id_bp','=','beasiswa_penyeleksi_tahapan.id_bp')
				->select('beasiswa_penyeleksi_tahapan.id_tahapan')->get();

				//Retrieve Tahapan Beasiswa: tahapan yang ada dari sebuah beasiswa
				$retrTahapan = DB::table('beasiswa_penyeleksi')->where('id_beasiswa', $id)
				->join('beasiswa_penyeleksi_tahapan','beasiswa_penyeleksi.id_bp','=','beasiswa_penyeleksi_tahapan.id_bp')
				->join('tahapan','beasiswa_penyeleksi_tahapan.id_tahapan','=','tahapan.id_tahapan')
				->join('user','beasiswa_penyeleksi.id_penyeleksi','=','user.id_user')
				->select('beasiswa_penyeleksi_tahapan.id_tahapan', 'tahapan.nama_tahapan','user.nama')
				->orderBy('beasiswa_penyeleksi_tahapan.id_bpt', 'asc')->get();

				/*$retrTahapan = DB::table('beasiswa_penyeleksi_tahapan')->where('id_bp', $retrievePenyeleksi->id_bp)
					->join('tahapan','beasiswa_penyeleksi_tahapan.id_tahapan','=','tahapan.id_tahapan')
					->select('beasiswa_penyeleksi_tahapan.id_tahapan', 'tahapan.nama_tahapan')
					->orderBy('beasiswa_penyeleksi_tahapan.id_tahapan', 'asc')->get();
				*/


				return view('pages.seleksi-beasiswa')->withUser($user)->withNamarole($namarole)->withAksestahapan($retrAksesTahapan)->withTahapan($retrTahapan)->withIdbeasiswa($id);


			}
		}

		function seleksiBeasiswa($idBeasiswa, $idTahapan){
			$user = SSO::getUser();
			$pengguna = DB::table('user')->where('username', $user->username)->first();
			$role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
			$namarole = $role->nama_role;

			if ($namarole=='Mahasiswa')
			{
				return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
			}

			//Retrieve role pegawai
			else if($namarole=='Pegawai'){
				$pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();
				$role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
				$namarole = $role->nama_role_pegawai;
			}

			//Check apakah penyeleksi ini memiliki akses ke tahapan tertentu dari beasiswa tertentu
			$cekPenyeleksi = DB::table('beasiswa_penyeleksi')->where('id_beasiswa', $idBeasiswa)->where('id_penyeleksi', $pengguna->id_user)
			->join('beasiswa_penyeleksi_tahapan','beasiswa_penyeleksi.id_bp','=','beasiswa_penyeleksi_tahapan.id_bp')
			->where('id_tahapan',$idTahapan)->get();

			if ($cekPenyeleksi->count() == 0)
			{
				return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
			}
			else{
				// BELUM: cek if tahapan ini udah final atau belum, kalau udah final cuma bisa lihat hasil seleksi

				//get nama dan nilai pendaftar beasiswa untuk tahap ini
				$beasiswa = DB::table('beasiswa')->where('id_beasiswa',$idBeasiswa)->first();

				$final = 0;
				/*	final = 1 -> belum ada pendaftar
				*		final = 2 -> lihat hasi
				*/
				$cekFinal = DB::table('seleksi_beasiswa')->where('id_beasiswa', $idBeasiswa)->where('id_tahapan', $idTahapan)->first();
				if (empty($cekFinal)) // Jika belum/ tidak ada pendaftar
				{
					$final = 1;
					return view('pages.seleksi-tahapan')->withUser($user)->withPengguna($pengguna)->withNamarole($namarole)->withIdtahapan($idTahapan)->withIdbeasiswa($idBeasiswa)->withBeasiswa($beasiswa)->withFinal($final);

				}
				else{
					// $pendaftar = DB::table('pendaftaran_beasiswa')->where('pendaftaran_beasiswa.id_beasiswa', $idBeasiswa)
					// ->join('seleksi_beasiswa','pendaftaran_beasiswa.id_beasiswa','=','seleksi_beasiswa.id_beasiswa')
					// ->where('id_tahapan','=',$idTahapan)
					// ->join('user','seleksi_beasiswa.id_mahasiswa','=','user.id_user')
					// ->select('seleksi_beasiswa.id_mahasiswa', 'seleksi_beasiswa.nilai_seleksi', 'seleksi_beasiswa.final', 'user.nama')->get();

					$pendaftar = DB::table('seleksi_beasiswa')->where('id_beasiswa', $idBeasiswa)
					->where('id_tahapan','=',$idTahapan)
					->join('user','seleksi_beasiswa.id_mahasiswa','=','user.id_user')
					->select('seleksi_beasiswa.id_mahasiswa', 'seleksi_beasiswa.nilai_seleksi', 'seleksi_beasiswa.final', 'user.nama')->get();

					if($cekFinal -> final == '1')
					{
						$final = 2;
						return view('pages.seleksi-tahapan')->withUser($user)->withPengguna($pengguna)->withNamarole($namarole)->withPendaftar($pendaftar)->withIdtahapan($idTahapan)->withIdbeasiswa($idBeasiswa)->withBeasiswa($beasiswa)->withFinal($final);
					}
					else{
						return view('pages.seleksi-tahapan')->withUser($user)->withPengguna($pengguna)->withNamarole($namarole)->withPendaftar($pendaftar)->withIdtahapan($idTahapan)->withIdbeasiswa($idBeasiswa)->withBeasiswa($beasiswa)->withFinal($final);
					}

				}
			}

		}
		function savedraftest()
		{
			$partisipan = DB::table('seleksi_beasiswa')->where('id_beasiswa', '5')->where('id_tahapan', '1')->select('id_mahasiswa')->get();
			//get nama tahapan
			$namatahapan = DB::table('tahapan')->where('id_tahapan', '1')->select('nama_tahapan')->first();

			if ($namatahapan->nama_tahapan == 'Administratif')
			{
				$idstatus = 2;
			}
			else if ($namatahapan->nama_tahapan == 'Berkas')
			{
				$idstatus = 3;
			}
			else if ($namatahapan->nama_tahapan == 'Tes Tertulis')
			{
				$idstatus = 4;
			}
			else if ($namatahapan->nama_tahapan == 'Wawancara')
			{
				$idstatus = 5;
			}

			DB::table('pendaftaran_beasiswa')->where('id_mahasiswa', '2')->where('id_beasiswa', '5')->update(['status_lamaran' => $idstatus]);
			$table = [4];
			foreach($partisipan as $key => $partisipan)
			{
				DB::table('pendaftaran_beasiswa')->where('id_mahasiswa', $partisipan->id_mahasiswa)->where('id_beasiswa', '5')->update(['status_lamaran' => '7']);
			}
			foreach ($table as $key => $idMahasiswa) {
					DB::table('pendaftaran_beasiswa')->where('id_mahasiswa', $idMahasiswa)->where('id_beasiswa', '5')->update(['status_lamaran' => $idstatus]);
					// if ($partisipan->id_mahasiswa == $idMahasiswa)
					// {
					// 	DB::table('pendaftaran_beasiswa')->where('id_mahasiswa', $idMahasiswa)->where('id_beasiswa', $request->idbeasiswa)->update(['status_lamaran' => $idstatus]);
					// }
			}
		}





		function sort($a,$b)
		{
			return ($a[1] >= $b[1]) ? -1 : 1;
		}



		function saveDraft(Request $request)
		{

			$table = explode("&",$request->get('table'));

			for($i = 0;$i < sizeof($table);$i++)
			{
				$row = explode("=",$table[0]);
				DB::table('seleksi_beasiswa')
				->where('id_beasiswa', $request->idbeasiswa)->where('id_penyeleksi', $request->pengguna)
				->where('id_tahapan', $request->idtahapan)->where('id_mahasiswa', $row[0])
				->update(['nilai_seleksi' => $row[1]]);
			}
			$return_2d_array = array_map (
			function ($_) {return explode ('=', $_);},
			explode ('&', $request->get('table'))
			);
			usort($return_2d_array, array($this,'sort'));
			//$msg = "This is a simple message.";
			return response()->json(array('msg'=> $return_2d_array), 200);
		}

    function retrieveNama(Request $request)
    {
      $nama=DB::table('user')->where('id_user', $request->id_user)->select('nama')->first();
      return response()->json(array('msg'=> $nama), 200);
    }

		function finalizeResult(Request $request)
		{

			// get partisipan seleksi beasiswa untuk tahapan ini
			$partisipan = DB::table('seleksi_beasiswa')->where('id_beasiswa', $request->idbeasiswa)->where('id_tahapan', $request->idtahapan)->select('id_mahasiswa')->get();
			//get nama tahapan
			$namatahapan = DB::table('tahapan')->where('id_tahapan', $request->idtahapan)->select('nama_tahapan')->first();

			if ($namatahapan->nama_tahapan == 'Administratif')
			{
				$idstatus = 2;
			}
			else if ($namatahapan->nama_tahapan == 'Berkas')
			{
				$idstatus = 3;
			}
			else if ($namatahapan->nama_tahapan == 'Tes Tertulis')
			{
				$idstatus = 4;
			}
			else if ($namatahapan->nama_tahapan == 'Wawancara')
			{
				$idstatus = 5;
			}


			foreach($partisipan as $key => $partisipan)
			{
				DB::table('pendaftaran_beasiswa')->where('id_mahasiswa', $partisipan->id_mahasiswa)->where('id_beasiswa', $request->idbeasiswa)->update(['status_lamaran' => '7']);
			}
			foreach ($request->table as $key => $idMahasiswa) {
					DB::table('pendaftaran_beasiswa')->where('id_mahasiswa', $idMahasiswa)->where('id_beasiswa', $request->idbeasiswa)->update(['status_lamaran' => $idstatus]);
					// if ($partisipan->id_mahasiswa == $idMahasiswa)
					// {
					// 	DB::table('pendaftaran_beasiswa')->where('id_mahasiswa', $idMahasiswa)->where('id_beasiswa', $request->idbeasiswa)->update(['status_lamaran' => $idstatus]);
					// }
			}

			/*
				Jika ada tahapan berikutnya, maka masukkan nama finalis ke db untuk tahap berikutnya
			*/
			$retrTahapan = DB::table('beasiswa_penyeleksi')->where('id_beasiswa', $request->idbeasiswa)
			->join('beasiswa_penyeleksi_tahapan','beasiswa_penyeleksi.id_bp','=','beasiswa_penyeleksi_tahapan.id_bp')
			->join('tahapan','beasiswa_penyeleksi_tahapan.id_tahapan','=','tahapan.id_tahapan')
			->join('user','beasiswa_penyeleksi.id_penyeleksi','=','user.id_user')
			->select('beasiswa_penyeleksi_tahapan.id_tahapan', 'tahapan.nama_tahapan','beasiswa_penyeleksi.id_penyeleksi')
			->orderBy('beasiswa_penyeleksi_tahapan.id_bpt', 'asc')->get();
			$set=0;

			foreach ($retrTahapan as $key => $tahapan) {
				if (count($retrTahapan)-1 == $key)
				{
					DB::table('seleksi_beasiswa')
					->where('id_beasiswa', $request->idbeasiswa)->where('id_penyeleksi', $request->pengguna)
					->where('id_tahapan', $request->idtahapan)
					->update(['final' => '1']);
					foreach ($request->table as $key => $idMahasiswa) {
							DB::table('penerima_beasiswa')->insert(
								['id_beasiswa' => $request->idbeasiswa,
								'id_mahasiswa'=>$idMahasiswa
							]
						);
					}
				}
				if ($set==1)
				{
					$set=$tahapan->id_tahapan;
					DB::table('seleksi_beasiswa')
					->where('id_beasiswa', $request->idbeasiswa)->where('id_penyeleksi', $request->pengguna)
					->where('id_tahapan', $request->idtahapan)
					->update(['final' => '1']);
					foreach ($request->table as $key => $idMahasiswa) {
							DB::table('seleksi_beasiswa')->insert(
								['id_beasiswa' => $request->idbeasiswa,
								'id_penyeleksi'=>$request->pengguna,
								'id_tahapan'=>$set,
								'id_mahasiswa'=>$idMahasiswa
							]
						);
					}
					break;
				}
				else if ($tahapan->id_tahapan == $request->idtahapan)
				{
					$set=1;
				}
			}



			return response()->json(array('msg'=> $set), 200);
		}


	}
