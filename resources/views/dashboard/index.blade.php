@extends('layout.dashboard_template')
@section('dashboard-content')

@if(Auth::user()->role !== 'siswa')
<!-- <div class="card my-4">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Dashboard</h6>
        </div>
    </div>
    <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0">

        </div>
    </div>
</div> -->
<div class="row">
    <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div
                    class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">person</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Total Siswa</p>
                    <h4 class="mb-0">{{$total_siswa}}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div
                    class="icon icon-lg icon-shape bg-gradient-secondary shadow-secondary text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">person</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Total Guru</p>
                    <h4 class="mb-0">{{$total_guru}}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div
                    class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">person</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Kelas A</p>
                    <h4 class="mb-0">{{$kelas_a}}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div
                    class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">person</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Kelas B</p>
                    <h4 class="mb-0">{{$kelas_b}}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div
                    class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">person</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Total Aspek</p>
                    <h4 class="mb-0">{{$total_aspek}}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mt-4">
    <div class="w-100 d-flex flex-col flex-md-row align-items-center mb-4">
        <h5>Perkembangan Murid</h5>
        <div class="input-group input-group-outline ms-3" style="max-width: 150px">
            <select class="form-control" name="year">
                @for ($i = 1980; $i <= date('Y'); $i++)
                    <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
                @for ($i = date('Y') + 1; $i <= 2045; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
    </div>
    <div id="my-charts" class="row">
    </div>
</div>
@endif

@if(Auth::user()->role === 'siswa')
<div class="card my-5">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Perkembangan Siswa</h6>
        </div>
    </div>
    <div class="card-body px-4 pb-2">
        <a target="_blank" href="dashboard/print/{{Auth::user()->id}}" class="btn btn-outline-info">
            <i class="fa-solid fa-print"></i>
            Print
        </a>
        <div class="table-responsive p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Semester</th>
                            <th scope="col">Tahun Ajaran</th>
                            <th scope="col">Aspek</th>
                            <th scope="col">Poin Penilaian</th>
                            <th scope="col">Nilai</th>
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
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                {{$nilai->links()}}
            </div>
        </div>
    </div>
</div>
@endif

<script>
function getCardTemplate(label, kode) {
    return `
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 text-center">${label}</h6>
                    <canvas id="chart-${kode}"></canvas>
                </div>
            </div>
        </div>
    `
}

function createChart(elementId, items, label) {
    const ctx = document.getElementById(elementId);
    const data = {
    labels: [
        'MB',
        'MSH',
        'BSB'
    ],
    datasets: [{
        label,
        data: items,
        backgroundColor: [
        'rgb(255, 99, 132)',
        'rgb(54, 162, 235)',
        'rgb(255, 205, 86)'
        ],
        hoverOffset: 4
    }]
    };

    new Chart(ctx, {
    type: 'doughnut',
    data,
    options: {
        scales: {
        y: {
            beginAtZero: true
        }
        }
    }
    });
}

const aspeks = {!! json_encode($aspeks) !!};
const parentElement = document.getElementById('my-charts')
let childElement = ''
aspeks.forEach(item => {
    childElement += getCardTemplate(item.nama_aspek, item.kode)
})
parentElement.innerHTML = childElement
const data = [0, 0, 0]
aspeks.forEach(item => {
    createChart(`chart-${item.kode}`, data, item.nama_aspek)
})
</script>
@endsection
