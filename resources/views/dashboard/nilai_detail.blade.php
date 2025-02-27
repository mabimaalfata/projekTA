@extends('layout.dashboard_template')
@section('dashboard-content')

<div class="container-fluid px-2 px-md-4">
    <a href="{{ url('dashboard/nilai') }}" class="btn btn-outline-secondary">Kembali</a>
    <div class="page-header min-height-300 border-radius-xl mt-2"
        style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
        <span class="mask  bg-gradient-primary  opacity-6"></span>
    </div>
    <div class="card card-body mx-3 mx-md-4 mt-n6">
        <div class="row">
            <div class="row">
                <div class="col-12">
                    <div class="card card-plain h-100">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-0">Perkembangan Siswa</h6>
                                </div>
                                <div class="col-md-4 text-end">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#tambah_data">
                                        Tambah Data
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Semester</th>
                                            <th scope="col">Tahun Ajaran</th>
                                            <th scope="col">Aspek</th>
                                            <th scope="col">Poin Penilaian</th>
                                            <th scope="col">Nilai</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($nilai) > 0)
                                        @foreach($nilai as $item)
                                        <tr>
                                            <td>{{$item->semester}}</td>
                                            <td>{{$item->awal_ajaran}}/{{$item->akhir_ajaran}}</td>
                                            <td>{{$item->nama_aspek}}</td>
                                            <td>{{$item->nama_poin}}</td>
                                            <td>{{$item->nilai === "mb" ? 'Mulai Berkembang' : ($item->nilai === 'bsh' ? 'Berkembang Sesuai Harapan' : ($item->nilai === 'bsb' ? 'Berkembang Sangat Baik' : '-'))}}
                                            </td>
                                            <td>
                                                <form action="{{url('dashboard/nilai/'.$item->user_id.'/'.$item->id)}}"
                                                    method="POST">
                                                    <button type="button" class="btn btn-link text-secondary mb-0" data-bs-toggle="modal"
                                                    data-bs-target="#tambah_data">
                                                        Edit
                                                    </button>
                                                
                                                    
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"onclick="return confirm('Apakah Anda ingin menghapus?')"
                                                        >Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambah_data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambah_data">Perkembangan Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('dashboard/nilai/'.request('user_id'))}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group input-group-static mb-4">
                                <label for="semester" class="ms-0">Semester</label>
                                <select name="semester" class="form-control" id="semester">
                                    <option value="">Pilih semester</option>
                                    <option value="1">semester 1</option>
                                    <option value="2">semester 2</option>
                                </select>
                        <div class="col-6">
                            <div class="input-group input-group-static mb-4">
                                <label for="awal_ajaran" class="ms-0">Awal Ajaran (tahun)</label>
                                <select id="awal_ajaran" class="form-control" name="awal_ajaran">
                                    <option value="">Pilih Tahun</option>
                                    @for ($i = 2020; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                    @for ($i = date('Y') + 1; $i <= 2045; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group input-group-static mb-4">
                                <label for="akhir_ajaran" class="ms-0">Akhir Ajaran (tahun)</label>
                                <select id="akhir_ajaran" class="form-control" name="akhir_ajaran">
                                    <option value="">Pilih Tahun</option>
                                    @for ($i = 2020; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                    @for ($i = date('Y') + 1; $i <= 2045; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group input-group-static mb-4">
                                <label for="poin" class="ms-0">Poin Aspek Penilaian</label>
                                <select name="poin_id" class="form-control" id="poin" required>
                                    <option value="">Pilih poin aspek yang akan dinilai</option>
                                    @if(count($poins) > 0)
                                    @foreach($poins as $poin)
                                    <option value="{{$poin->id}}">
                                        ({{$poin->nama_aspek}}) {{$poin->nama_poin}}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group input-group-static mb-4">
                                <label for="nilai" class="ms-0">Nilai</label>
                                <select name="nilai" class="form-control" id="nilai" required>
                                    <option value="">Pilih nilai</option>
                                    <option value="mb">MB(Mulai Berkembang)</option>
                                    <option value="bsh">BSH(Berkembang Sesuai Harapan)</option>
                                    <option value="bsb">BSB(Berkembang Sangat Baik)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="edit_data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_data">Perkembangan Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modals" aria-label="Close"></button>
            </div>
            <form action="{{url('dashboard/nilai/'.request('user_id'))}}" method="POST">
                @csrf
                <div class="modals-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group input-group-static mb-4">
                                <label for="semester" class="ms-0">Semester</label>
                                <select name="semester" class="form-control" id="semester">
                                    <option value="">Pilih semester</option>
                                    <option value="1">semester 1</option>
                                    <option value="2">semester 2</option>
                                </select>
                        <div class="col-6">
                            <div class="input-group input-group-static mb-4">
                                <label for="awal_ajaran" class="ms-0">Awal Ajaran (tahun)</label>
                                <select id="awal_ajaran" class="form-control" name="awal_ajaran">
                                    <option value="">Pilih Tahun</option>
                                    @for ($i = 2020; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                    @for ($i = date('Y') + 1; $i <= 2045; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group input-group-static mb-4">
                                <label for="akhir_ajaran" class="ms-0">Akhir Ajaran (tahun)</label>
                                <select id="akhir_ajaran" class="form-control" name="akhir_ajaran">
                                    <option value="">Pilih Tahun</option>
                                    @for ($i = 2020; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                    @for ($i = date('Y') + 1; $i <= 2045; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group input-group-static mb-4">
                                <label for="poin" class="ms-0">Poin Aspek Penilaian</label>
                                <select name="poin_id" class="form-control" id="poin" required>
                                    <option value="">Pilih poin aspek yang akan dinilai</option>
                                    @if(count($poins) > 0)
                                    @foreach($poins as $poin)
                                    <option value="{{$poin->id}}">
                                        ({{$poin->nama_aspek}}) {{$poin->nama_poin}}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group input-group-static mb-4">
                                <label for="nilai" class="ms-0">Nilai</label>
                                <select name="nilai" class="form-control" id="nilai" required>
                                    <option value="">Pilih nilai</option>
                                    <option value="mb">MB(Mulai Berkembang)</option>
                                    <option value="bsh">BSH(Berkembang Sesuai Harapan)</option>
                                    <option value="bsb">BSB(Berkembang Sangat Baik)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection