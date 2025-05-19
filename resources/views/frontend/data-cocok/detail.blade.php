<x-app-layout>
    <div class="container">
        <h1 class="my-4">Detail Perbandingan</h1>

        <div class="mb-3">
            <a href="{{ route('data-cocok.rekomendasi', $lakiLaki->user_id) }}" class="btn btn-secondary">
                Kembali ke Rekomendasi
            </a>
        </div>

        <!-- Informasi Persentase Kecocokan -->
        <div class="mb-4 card">
            <div class="text-white card-header bg-success">
                <h4 class="mb-0">Persentase Kecocokan: {{ $persentase }}%</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="text-center col-md-5">
                        <img src="{{ asset('storage/foto/' . ($lakiLaki->foto ?? 'default.jpg')) }}"
                            alt="Foto {{ $lakiLaki->nama_peserta }}" class="mb-2 img-thumbnail rounded-circle"
                            style="width: 150px; height: 150px; object-fit: cover;">
                        <h5>{{ $lakiLaki->nama_peserta }}</h5>
                        <p>Laki-laki</p>
                    </div>

                    <div class="col-md-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-heart fa-3x text-danger"></i>
                    </div>

                    <div class="text-center col-md-5">
                        <img src="{{ asset('storage/foto/' . ($wanita->foto ?? 'default.jpg')) }}"
                            alt="Foto {{ $wanita->nama_peserta }}" class="mb-2 img-thumbnail rounded-circle"
                            style="width: 150px; height: 150px; object-fit: cover;">
                        <h5>{{ $wanita->nama_peserta }}</h5>
                        <p>Perempuan</p>
                    </div>
                </div>

                <div class="mt-3 row">
                    <div class="text-center col-md-12">
                        <div class="alert alert-info">
                            <p>Kecocokan Laki-laki ke Wanita: <strong>{{ $lakiKeWanita }}</strong> kriteria cocok dari
                                {{ count($kriteriaPasanganLaki) }} kriteria yang diinginkan</p>
                            <p>Kecocokan Wanita ke Laki-laki: <strong>{{ $wanitaKeLaki }}</strong> kriteria cocok dari
                                {{ count($kriteriaPasanganWanita) }} kriteria yang diinginkan</p>
                        </div>
                    </div>
                </div>

                <div class="mt-3 row">
                    <div class="text-center col-md-12">
                        <form action="{{ route('data-cocok.konfirmasi') }}" method="POST">
                            @csrf
                            <input type="hidden" name="laki_id" value="{{ $lakiLaki->user_id }}">
                            <input type="hidden" name="wanita_id" value="{{ $wanita->user_id }}">
                            <input type="hidden" name="persentase" value="{{ $persentase }}">

                            <button type="submit" class="btn btn-success">Konfirmasi Pasangan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Perbandingan Detail -->
        <div class="row">
            <!-- Data Diri -->
            <div class="mb-4 col-md-12">
                <div class="card">
                    <div class="text-white card-header bg-primary">
                        <h5 class="mb-0">Data Diri</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Informasi</th>
                                        <th>{{ $lakiLaki->nama_peserta }}</th>
                                        <th>{{ $wanita->nama_peserta }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Usia</td>
                                        <td>
                                            @php
                                                $birthDate = new DateTime($lakiLaki->tanggal_lahir);
                                                $today = new DateTime();
                                                $age = $birthDate->diff($today)->y;
                                            @endphp
                                            {{ $age }} tahun
                                        </td>
                                        <td>
                                            @php
                                                $birthDate = new DateTime($wanita->tanggal_lahir);
                                                $today = new DateTime();
                                                $age = $birthDate->diff($today)->y;
                                            @endphp
                                            {{ $age }} tahun
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pendidikan</td>
                                        <td>{{ $lakiLaki->pendidikan }}</td>
                                        <td>{{ $wanita->pendidikan }}</td>
                                    </tr>
                                    <tr>
                                        <td>Pekerjaan</td>
                                        <td>{{ $lakiLaki->pekerjaan }}</td>
                                        <td>{{ $wanita->pekerjaan }}</td>
                                    </tr>
                                    <tr>
                                        <td>Penghasilan</td>
                                        <td>{{ $lakiLaki->penghasilan }}</td>
                                        <td>{{ $wanita->penghasilan }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status Pernikahan</td>
                                        <td>{{ $lakiLaki->status_pernikahan }}</td>
                                        <td>{{ $wanita->status_pernikahan }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Karakteristik Diri -->
            <div class="mb-4 col-md-6">
                <div class="card h-100">
                    <div class="text-white card-header bg-info">
                        <h5 class="mb-0">Karakteristik Diri</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col">
                                <h6>{{ $lakiLaki->nama_peserta }}</h6>
                                <ul>
                                    @forelse($kriteriaDiriLaki as $karakteristik)
                                        <li>{{ $karakteristik }}</li>
                                    @empty
                                        <li>Tidak ada data</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h6>{{ $wanita->nama_peserta }}</h6>
                                <ul>
                                    @forelse($kriteriaDiriWanita as $karakteristik)
                                        <li>{{ $karakteristik }}</li>
                                    @empty
                                        <li>Tidak ada data</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Karakteristik Pasangan yang Diinginkan -->
            <div class="mb-4 col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0">Karakteristik Pasangan yang Diinginkan</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col">
                                <h6>{{ $lakiLaki->nama_peserta }} menginginkan:</h6>
                                <ul>
                                    @forelse($kriteriaPasanganLaki as $karakteristik)
                                        <li>
                                            {{ $karakteristik }}
                                            @if (in_array($karakteristik, $kriteriaDiriWanita))
                                                <span class="text-success"> ✓</span>
                                            @else
                                                <span class="text-danger"> ✗</span>
                                            @endif
                                        </li>
                                    @empty
                                        <li>Tidak ada data</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h6>{{ $wanita->nama_peserta }} menginginkan:</h6>
                                <ul>
                                    @forelse($kriteriaPasanganWanita as $karakteristik)
                                        <li>
                                            {{ $karakteristik }}
                                            @if (in_array($karakteristik, $kriteriaDiriLaki))
                                                <span class="text-success"> ✓</span>
                                            @else
                                                <span class="text-danger"> ✗</span>
                                            @endif
                                        </li>
                                    @empty
                                        <li>Tidak ada data</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
