@extends('layout.dashboard_template')
@section('dashboard-content')
<div class="card my-5">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Daftar Siswa PAUD Teratai</h6>
        </div>
    </div>
    <div class="card-body px-2 pb-2">
    <div class="mx-3">
            <form method="GET" action="{{route('nilai')}}">
                <div class="row">
                    <div class="col-12 col-md-3 col-lg-2">
                        <div class="input-group input-group-outline">
                            <label class="form-label">Cari</label>
                            <input name="search" type="text" class="form-control">
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
                        <th class="text-uppercase text-dark text-xxs font-weight-bolder ps-2">NISN</th>
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
                    @if(count($all_siswa) > 0)
                    @foreach($all_siswa as $user)
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
                            <span class="text-xs font-weight-bold">{{ $user->nisn ? $user->nisn : '-' }}</span>
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
                            @if(Auth::user()->role === 'guru')
                            <a href="{{ url('dashboard/nilai/'.$user->id) }}" class="btn btn-link text-primary mb-0">
                                Lihat Nilai
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @else
                    @endif
                </tbody>
            </table>
            {{ $all_siswa->links() }}
        </div>
    </div>
</div>

<script>
    document.querySelector('#reset-filter').addEventListener('click', function() {
        window.location.href = '{{ route('nilai') }}';
    });
</script>
@endsection
