@extends('layout.dashboard_template')
@section('dashboard-content')

<div class="card my-5">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Users</h6>
        </div>
    </div>
    <div class="card-body px-2 pb-2">
        <div class="mx-3">
            <form method="GET" action="{{route('users')}}">
                <div class="row">
                    <div class="col-12 col-md-3 col-lg-2">
                        <div class="input-group input-group-outline">
                            <label class="form-label">Cari</label>
                            <input name="search" type="text" class="form-control">
                        </div>
                    </div>
                    @if (Auth::user()->role === 'admin')
                    <div class="col-12 col-md-3 col-lg-2">
                        <div class="input-group input-group-outline">
                            <select name="role" class="form-control" id="role">
                                <option value="">Pilih role akun</option>
                                <option value="siswa">Siswa</option>
                                <option value="guru">Guru</option>
                                <option value="kepala-sekolah">Kepala Sekolah</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    @endif
                    <div class="col-12 col-md-3 col-lg-2">
                        <div class="input-group input-group-outline">
                            <select name="classroom" class="form-control" id="kelas">
                                <option value="">Pilih kelas</option>
                                <option value="A">Kelas A</option>
                                <option value="B">Kelas B</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-2">
                        <div class="input-group input-group-outline">
                            <select name="agama" class="form-control" id="agama">
                                <option value="">Pilih agama</option>
                                <option value="islam">Islam</option>
                                <option value="kristen">Kristen</option>
                                <option value="budha">Budha</option>
                                <option value="Hindu">Hindu</option>
                                <option value="konghucu">Konghucu</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-2">
                        <div class="input-group input-group-outline">
                            <select name="kelamin" class="form-control" id="kelamin">
                                <option value="">Pilih jenis kelamin</option>
                                <option value="l">Laki-laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-auto">
                        <button type="submit" class="btn btn-info">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        <button id="reset-filter" type="reset" class="btn btn-secondary">
                            <i class="fa-solid fa-rotate-right"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-responsive p-0">
            <table class="table align-items-center justify-content-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-dark text-xxs font-weight-bolder">Nama Lengkap
                        </th>
                        <th class="text-uppercase text-dark text-xxs font-weight-bolder ps-2">Username
                        </th>
                        <th class="text-uppercase text-dark text-xxs font-weight-bolder ps-2">Role</th>
                        <th class="text-uppercase text-dark text-xxs font-weight-bolder ps-2">NISN</th>
                        <th class="text-uppercase text-dark text-xxs font-weight-bolder ps-2">NIP</th>
                        <th class="text-uppercase text-dark text-xxs font-weight-bolder ps-2">Tempat Lahir
                        </th>
                        <th class="text-uppercase text-dark text-xxs font-weight-bolder ps-2">Tanggal
                            Lahir</th>
                        <th class="text-uppercase text-dark text-xxs font-weight-bolder ps-2">Jenis
                            Kelamin</th>
                        <th class="text-uppercase text-dark text-xxs font-weight-bolder ps-2">Angkatan</th>
                        <th class="text-uppercase text-dark text-xxs font-weight-bolder ps-2">Wali</th>
                        <th class="text-uppercase text-dark text-xxs font-weight-bolder ps-2">Agama</th>
                        <th class="text-uppercase text-dark text-xxs font-weight-bolder ps-2">Kelas</th>
                        <th class="text-uppercase text-dark text-xxs font-weight-bolder ps-2">Alamat</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($users) > 0)
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex px-2">
                                <div>
                                    <img src="{{ asset('storage/images/'.$user->poto) }}"
                                        class="avatar avatar-sm rounded-circle me-2" alt="profile-user">
                                </div>
                                <div class="my-auto">
                                    <h6 class="mb-0 text-sm">{{ $user->nama }}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-xs font-weight-bold">{{ $user->username }}</span>
                        </td>
                        <td>
                            <span class="text-xs font-weight-bold">{{ $user->role }}</span>
                        </td>
                        <td>
                            <span class="text-xs font-weight-bold">{{ $user->nisn ? $user->nisn : '-' }}</span>
                        </td>
                        <td>
                            <span class="text-xs font-weight-bold">{{ $user->nip ? $user->nip : '-' }}</span>
                        </td>
                        <td>
                            <span
                                class="text-xs font-weight-bold">{{ $user->tempat_lahir ? $user->tempat_lahir : '-' }}</span>
                        </td>
                        <td>
                            <span
                                class="text-xs font-weight-bold">{{ $user->tanggal_lahir ? $user->tanggal_lahir : '-' }}</span>
                        </td>
                        <td>
                            <span
                                class="text-xs font-weight-bold">{{ $user->jenis_kelamin ? strtoupper($user->jenis_kelamin) : '-' }}</span>
                        </td>
                        <td>
                            <span class="text-xs font-weight-bold">{{ $user->angkatan ? $user->angkatan : '-' }}</span>
                        </td>
                        <td>
                            <span class="text-xs font-weight-bold">{{ $user->wali ? $user->wali : '-' }}</span>
                        </td>
                        <td>
                            <span class="text-xs font-weight-bold">{{ $user->agama ? $user->agama : '-' }}</span>
                        </td>
                        <td>
                            <span class="text-xs font-weight-bold">{{ $user->kelas ? $user->kelas : '-' }}</span>
                        </td>
                        <td>
                            <span class="text-xs font-weight-bold">{{ $user->alamat ? $user->alamat : '-' }}</span>
                        </td>
                        <td class="align-middle d-flex">
                            @if(Auth::user()->role === 'admin')
                            <a href="{{ url('dashboard/users/'.$user->id) }}" class="btn btn-link text-secondary mb-0">
                                Edit
                            </a>
                            <form action="{{ url('dashboard/users/'.$user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-primary mb-0" onclick="return confirm('Apakah Anda ingin menghapus?')">
                                  Hapus
                                </button>
                              </form>
                              
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @else
                    @endif
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
</div>

@if(Auth::user()->role === 'admin')
<div class="card my-5">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Form Tambah Akun</h6>
        </div>
    </div>
    <div class="card-body px-4 pb-2">
        <form action="{{ route('users.add') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <h6>Akun</h6>
                <div class="col-md-6">
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Username</label>
                        <input name="username" type="text" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Password</label>
                        <input name="password" type="password" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input name="nama" type="text" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                        <label for="role" class="ms-0">Role</label>
                        <select name="role" class="form-control" id="role" required>
                            <option value="">Pilih role akun</option>
                            <option value="siswa">Siswa</option>
                            <option value="guru">Guru</option>
                            <option value="kepala-sekolah">Kepala Sekolah</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <h6>Poto</h6>
                <div class="col-md-4">
                    <div class="input-group input-group-outline my-3">
                        <input name="poto" type="file" accept=".png, .jpeg, .jpg" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <h6>Biodata</h6>
                <div class="col-md-4">
                    <label class="form-label">NISN</label>
                    <div class="input-group input-group-outline my-3">
                        <input name="nisn" type="number" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">NIP</label>
                    <div class="input-group input-group-outline my-3">
                        <input name="nip" type="number" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Tahun Angkatan</label>
                    <div class="input-group input-group-outline my-3">
                        <input name="angkatan" type="number" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nama Wali</label>
                    <div class="input-group input-group-outline my-3">
                        <input name="wali" type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Tempat Lahir</label>
                    <div class="input-group input-group-outline my-3">
                        <input name="tempat_lahir" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Lahir</label>
                    <div class="input-group input-group-outline my-3">
                        <input name="tanggal_lahir" type="date" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jenis Kelamin</label>
                    <div class="form-check mb-3">
                        <input class="form-check-input" value="l" type="radio" name="jenis_kelamin" id="laki_laki">
                        <label class="custom-control-label" for="laki_laki">Laki-laki</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" value="p" type="radio" name="jenis_kelamin" id="perempuan">
                        <label class="custom-control-label" for="perempuan">Perempuan</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group input-group-static mb-4">
                        <label for="agama" class="ms-0">Agama</label>
                        <select name="agama" class="form-control" id="agama">
                            <option value="">Pilih agama</option>
                            <option value="islam">Islam</option>
                            <option value="kristen">Kristen</option>
                            <option value="budha">Budha</option>
                            <option value="Hindu">Hindu</option>
                            <option value="konghucu">Konghucu</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-static mb-4">
                        <label for="kelas" class="ms-0">Kelas</label>
                        <select name="kelas" class="form-control" id="kelas">
                            <option value="">Pilih kelas</option>
                            <option value="A">Kelas A</option>
                            <option value="B">Kelas B</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group input-group-dynamic">
                        <textarea name="alamat" class="form-control" rows="5" placeholder="Alamat"
                            spellcheck="false"></textarea>
                    </div>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-info">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

<script>
    document.querySelector('#reset-filter').addEventListener('click', function() {
        window.location.href = '{{ route('users') }}';
    });
</script>
<script>
    function handleDeleteUser() {
      // Display a confirmation dialog with a polite message
      if (confirm('Are you sure you want to delete this user?')) {
        // If confirmed, submit the form
        return true;
      } else {
        // If canceled, prevent form submission
        return false;
      }
    }
    </script>
    
@endsection
