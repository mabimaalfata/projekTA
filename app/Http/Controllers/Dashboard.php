<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Biodata;
use App\Models\Aspek;
use App\Models\PoinAspek;
use App\Models\Nilai;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PDF;

class Dashboard extends Controller
{
    public function index(){
        if(Auth::check() && Auth::user()->role === 'siswa') {
            $user_id = Auth::user()->id;

            $nilai = Nilai::where('user_id', '=', $user_id)
                ->join('poin_aspek', 'poin_aspek.id', '=', 'nilai_siswa.poin_id')
                ->join('aspek', 'aspek.id', '=', 'poin_aspek.aspek_id')
                ->select('nilai_siswa.*', 'poin_aspek.nama_poin', 'aspek.nama_aspek')
                ->paginate(20);
            return view('dashboard.index', ['nilai' => $nilai, 'aspeks' => '']);
        }

        $total_siswa = User::where('role', '=', 'siswa')->count();
        $total_guru = User::where('role', '=', 'guru')->count();
        $kelas_a = Biodata::where('kelas', '=', 'A')->count();
        $kelas_b = Biodata::where('kelas', '=', 'B')->count();
        $total_aspek = Aspek::count();
        $aspeks = Aspek::select('id', 'nama_aspek', 'kode')->get();

        return view('dashboard.index', [
            'total_siswa' => $total_siswa,
            'total_guru' => $total_guru,
            'total_aspek' => $total_aspek,
            'kelas_a' => $kelas_a,
            'kelas_b' => $kelas_b,
            'aspeks' => $aspeks
        ]);
    }

    public function charts(Request $request)
{
    $semester = $request->query('semester');
    $classroom = $request->query('classroom');
    $angkatan = $request->query('angkatan');

    $aspek_kode = Aspek::select('kode')->get();
    $query = Nilai::query();

    if (Auth::user()->role === 'guru') {
        $guru = Biodata::where('user_id', Auth::user()->id)
            ->select('kelas')->first();

        $query->join('poin_aspek', 'poin_aspek.id', '=', 'nilai_siswa.poin_id')
            ->join('aspek', 'aspek.id', '=', 'poin_aspek.aspek_id')
            ->join('biodata', 'biodata.user_id', '=', 'nilai_siswa.user_id')
            ->where('biodata.kelas', $guru->kelas);
    }
    if (Auth::user()->role === 'admin' || Auth::user()->role === 'kepala-sekolah') {
        $query->join('poin_aspek', 'poin_aspek.id', '=', 'nilai_siswa.poin_id')
            ->join('aspek', 'aspek.id', '=', 'poin_aspek.aspek_id')
            ->join('biodata', 'biodata.user_id', '=', 'nilai_siswa.user_id');
    }

    if ($semester != '') {
        $query->where('nilai_siswa.semester', $semester);
    }

    if ($classroom != '') {
        $query->where('biodata.kelas', $classroom);
    }

    if ($angkatan != '') {
        $query->where('biodata.angkatan', $angkatan);
    }

    $data = $query->get();
    $result =[];
    foreach ($aspek_kode as $aspek) {
        $result[$aspek->kode] = [
            'mb' => 0,
            'bsh' => 0,
            'bsb' => 0,
        ];
        foreach ($data as $item) {
            if ($item->kode === $aspek->kode && $item->nilai === 'mb') {
                $result[$aspek->kode]['mb']++;
            }
            if ($item->kode === $aspek->kode && $item->nilai === 'bsh') {
                $result[$aspek->kode]['bsh']++;
            }
            if ($item->kode === $aspek->kode && $item->nilai === 'bsb') {
                $result[$aspek->kode]['bsb']++;
            }
        }
    }
    return response()->json($result);
}

    public function users(Request $request)
    {
        $query = User::query();
        $query->join('biodata', 'biodata.user_id', '=', 'users.id');

        if (Auth::user()->role === 'kepala-sekolah') {
            $query->whereIn('users.role', ['guru', 'siswa']);
        }

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->orWhere('biodata.alamat', 'like', "%{$search}%")
                    ->orWhere('biodata.tanggal_lahir', 'like', "%{$search}%")
                    ->orWhere('biodata.tempat_lahir', 'like', "%{$search}%")
                    ->orWhere('biodata.angkatan', 'like', "%{$search}%")
                    ->orWhere('biodata.wali', 'like', "%{$search}%")
                    ->orWhere('biodata.nisn', 'like', "%{$search}%")
                    ->orWhere('biodata.nip', 'like', "%{$search}%")
                    ->orWhere('users.username', 'like', "%{$search}%")
                    ->orWhere('users.nama', 'like', "%{$search}%");
            });
        }

        if ($request->role) {
            if ($request->user()->role == 'guru') {
                $role = 'siswa';
            } else {
                $role = $request->role;
            }

            $query->where('users.role', $role);
        }

        if ($request->classroom) {
            $query->where('biodata.kelas', $request->classroom);
        }

        if ($request->agama) {
            $query->where('biodata.agama', $request->agama);
        }

        if ($request->kelamin) {
            $query->where('biodata.jenis_kelamin', $request->kelamin);
        }

        $users = $query->paginate(15);

        return view('dashboard.users', ['users' => $users]);
    }

    public function add_account(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:6',
            'nama' => 'required',
            'role' => 'required',
            'poto' => 'image|mimes:jpg,png,jpeg'
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama' => $request->nama,
            'role' => $request->role,
        ]);

        $potoUrl = $request->poto ? $this->save_photo($request) : '';

        $biodata = Biodata::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'nisn' => $request->nisn,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'angkatan' => $request->angkatan,
            'wali' => $request->wali,
            'poto' => $potoUrl,
            'agama' => $request->agama,
            'kelas' => $request->kelas,
            'alamat' => $request->alamat,
        ]);

        return redirect('dashboard/users')->with('success', 'Berhasil membuat akun baru!');
    }

    public function remove_account(Request $request, $biodata_id) {
        $biodata = Biodata::find($biodata_id);
        $user_id = $biodata->user_id;
        $photo = $biodata->poto;
        $this->remove_photo($photo);

        Biodata::find($biodata_id)->delete();
        user::find($user_id)->delete();
        return redirect('dashboard/users')->with('succces', 'Berhasil menghapus akun baru!');
    }

    public function save_photo($request) {
        $imageName = time().'.'.$request->poto->extension();
        $request->poto->move(public_path('/storage/images'), $imageName);
        return $imageName;
    }

    public function remove_photo($photo) {
        if(Storage::exists('images/'.$photo)){
            Storage::delete('images/'.$photo);
            return true;
        }else{
            return false;
        }
    }

    public static function quickRandom($length = 12) {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    public function usersEdit($biodata_id) {
        $user = Biodata::join('users', 'users.id', '=', 'biodata.user_id')
            ->select('users.*', 'biodata.*')
            ->where('biodata.id', '=', $biodata_id)
            ->get();

        return view('dashboard.users_edit', ['user' => $user[0]]);
    }

    public function userEdit_action(Request $request, $user_id, $biodata_id) {
        $user = User::find($user_id);
        $biodata = Biodata::find($biodata_id);

        if($request->password && $request->password !== '') {
            $user->password = Hash::make($request->password);
        }

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->role = $request->role;
        $user->update();

        if($request->has('poto')) {
            $request->validate([
                'poto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $this->remove_photo($biodata->poto);
            $imageName = $this->save_photo($request);
            $biodata->poto = $imageName;
        }

        $biodata->nip = $request->nip;
        $biodata->nisn = $request->nisn;
        $biodata->tempat_lahir = $request->tempat_lahir;
        $biodata->tanggal_lahir = $request->tanggal_lahir;
        $biodata->jenis_kelamin = $request->jenis_kelamin;
        $biodata->angkatan = $request->angkatan;
        $biodata->wali = $request->wali;
        $biodata->agama = $request->agama;
        $biodata->kelas = $request->kelas;
        $biodata->alamat = $request->alamat;
        $biodata->update();

        return redirect('dashboard/users')->with('success', 'Berhasil memperbaharui akun!');
    }

    public function aspek() {
        $aspeks = Aspek::paginate(20);

        return view('dashboard.aspek', ['aspeks' => $aspeks]);
    }

    public function aspek_add(Request $request) {
        $request->validate([
            'nama_aspek',
            'kode',
        ]);

        $aspek = Aspek::create([
            'nama_aspek' => $request->nama_aspek,
            'kode' => $request->kode,
        ]);

        return redirect('dashboard/aspek')->with('success', 'Berhasil menambahkan data aspek!');
    }

    public function remove_aspek($aspek_id) {
        PoinAspek::where('aspek_id', '=', $aspek_id)->delete();
        Aspek::find($aspek_id)->delete();

        return redirect('dashboard/aspek')->with('success', 'Berhasil menghapus data aspek!');
    }

    public function aspekEdit_view($aspek_id) {
        $aspek = Aspek::find($aspek_id);
        return view('dashboard.aspek_edit', ['aspek' => $aspek]);
    }

    public function aspekEdit_action(Request $request, $aspek_id) {
        $aspek = Aspek::find($aspek_id);
        $aspek->nama_aspek = $request->nama_aspek;
        $aspek->kode = $request->kode;
        $aspek->update();

        return redirect('dashboard/aspek')->with('success', 'Berhasil memperbaharui data aspek!');
    }

    public function poin_penilaian() {
        $aspeks = Aspek::all();
        $poins = PoinAspek::join('aspek', 'aspek.id', '=', 'poin_aspek.aspek_id')
            ->select('poin_aspek.*', 'aspek.nama_aspek', 'aspek.kode')
            ->paginate(20);
        return view('dashboard.poin_penilaian', [
            'aspeks' => $aspeks,
            'poins' => $poins
        ]);
    }

    public function show()
    {
        // Ambil pengguna yang sedang login
        $logged_in_user = Auth::user();
        
        // Ambil data pengguna dengan ID 2
        $guru = User::find(2); // Sesuaikan model dan ID sesuai kebutuhan

        // Oper data ke view
        return view('nama_view', compact('logged_in_user', 'guru'));
    }


    public function add_poin_penilaian(Request $request) {
        $request->validate([
            'nama_poin',
            'aspek_id',
        ]);

        PoinAspek::create([
            'nama_poin' => $request->nama_poin,
            'aspek_id' => $request->aspek_id,
        ]);
        return redirect('dashboard/poin-penilaian')->with('success', 'Berhasil menambahkan data poin penilaian!');
    }

    public function edit_view_poin_penilaian($poin_id) {
        $poin = PoinAspek::find($poin_id);
        $aspeks = Aspek::all();

        return view('dashboard.poin_penilaian_edit', [
            'poin' => $poin,
            'aspeks' => $aspeks
        ]);
    }

    public function edit_action_poin_penilaian(Request $request, $poin_id) {
        $poin = PoinAspek::find($poin_id);
        $poin->nama_poin = $request->nama_poin;
        $poin->aspek_id = $request->aspek_id;
        $poin->update();
        return redirect('dashboard/poin-penilaian')->with('success', 'Berhasil memperbaharui data poin penilaian!');
    }

    public function remove_poin_penilaian($poin_id) {
        PoinAspek::find($poin_id)->delete();
        return redirect('dashboard/poin-penilaian')->with('success', 'Berhasil menghapus data poin penilaian!');
    }

    public function nilai(Request $request) {
        $guru_id = Auth::user()->id;
        $guru = Biodata::find($guru_id);

        $query = Biodata::query();
        $query->join('users', 'users.id', '=', 'biodata.user_id')
            ->where('users.role', 'siswa')
            ->where('biodata.kelas', $guru->kelas);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->orWhere('biodata.alamat', 'like', "%{$search}%")
                    ->orWhere('biodata.tanggal_lahir', 'like', "%{$search}%")
                    ->orWhere('biodata.tempat_lahir', 'like', "%{$search}%")
                    ->orWhere('biodata.nisn', 'like', "%{$search}%")
                    ->orWhere('biodata.nip', 'like', "%{$search}%")
                    ->orWhere('users.username', 'like', "%{$search}%")
                    ->orWhere('users.nama', 'like', "%{$search}%");
            });
        }

        if ($request->agama) {
            $query->where('biodata.agama', $request->agama);
        }

        if ($request->kelamin) {
            $query->where('biodata.jenis_kelamin', $request->kelamin);
        }

        $users = $query->paginate(20);
        return view('dashboard.nilai', ['all_siswa' => $users]);
    }

    public function nilai_detail($user_id) {
        $nilai = Nilai::where('user_id', '=', $user_id)
            ->join('poin_aspek', 'poin_aspek.id', '=', 'nilai_siswa.poin_id')
            ->join('aspek', 'aspek.id', '=', 'poin_aspek.aspek_id')
            ->select('nilai_siswa.*', 'poin_aspek.nama_poin', 'aspek.nama_aspek')
            ->get();
        $poins = PoinAspek::join('aspek', 'aspek.id', '=', 'poin_aspek.aspek_id')
            ->select('poin_aspek.*', 'aspek.nama_aspek', 'aspek.kode')
            ->get();

        return view('dashboard.nilai_detail', ['nilai' => $nilai, 'poins' => $poins]);
    }

    public function nilai_add(Request $request, $user_id) {
        $request->validate([
            'semester',
            'awal_ajaran',
            'akhir_ajaran',
            'poin_id',
            'nilai'
        ]);

        Nilai::create([
            'semester' => $request->semester,
            'awal_ajaran' => $request->awal_ajaran,
            'akhir_ajaran' => $request->akhir_ajaran,
            'user_id' => $user_id,
            'poin_id' => $request->poin_id,
            'nilai' => $request->nilai,
        ]);

        return redirect('dashboard/nilai/'.$user_id)->with('success', 'Berhasil menambahkan data nilai!');
    }

    public function remove_nilai($user_id, $nilai_id) {
        Nilai::find($nilai_id)->delete();
        return redirect('dashboard/nilai/'.$user_id)->with('success', 'Berhasil menghapus data nilai!');
    }

    public function profile($user_id) {
        $biodata = Biodata::where('user_id', '=', $user_id)
            ->join('users', 'users.id', '=', 'biodata.user_id')
            ->select('biodata.*', 'users.id as user_id', 'users.nama')
            ->get();

        return view('dashboard.profile', ['biodata' => $biodata[0]]);
    }

    public function profile_update(Request $request, $user_id, $biodata_id) {
        $user = User::find($user_id);
        $biodata = Biodata::find($biodata_id);

        $user->nama = $request->nama;
        $user->update();

        if($request->has('poto')) {
            $request->validate([
                'poto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $this->remove_photo($biodata->poto);
            $imageName = $this->save_photo($request);
            $biodata->poto = $imageName;
        }

        if($request->has('nip')) {
            $biodata->nip = $request->nip;
        }

        if($request->has('nisn')) {
            $biodata->nisn = $request->nisn;
        }

        $biodata->tempat_lahir = $request->tempat_lahir;
        $biodata->tanggal_lahir = $request->tanggal_lahir;
        $biodata->jenis_kelamin = $request->jenis_kelamin;
        $biodata->agama = $request->agama;
        $biodata->alamat = $request->alamat;
        $biodata->update();

        return redirect('dashboard/profile/'.$user_id)->with('success', 'Profile berhasil diperbaharui!');
    }

    public function print($user_id, $semester) {
        $nilai = Nilai::where('user_id', '=', $user_id)
            ->where('semester', '=', $semester)
            ->join('poin_aspek', 'poin_aspek.id', '=', 'nilai_siswa.poin_id')
            ->join('aspek', 'aspek.id', '=', 'poin_aspek.aspek_id')
            ->select('nilai_siswa.*', 'poin_aspek.nama_poin', 'aspek.nama_aspek')
            ->get();

        $biodatas = Biodata::where('user_id', '=', $user_id)
            ->join('users', 'users.id', '=', 'biodata.user_id')
            ->get();
        $biodata = $biodatas[0];
        $pdf = PDF::loadView('dashboard.print', compact('nilai', 'biodata'));
        return $pdf->stream('Rapor Penilaian-'.$biodata->id.'-'.$biodata->nama.'.pdf');
    }
}
