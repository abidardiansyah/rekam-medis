@extends('layouts.app')

@section('title', 'Registrasi Baru')

@section('content')
<div class="page-header">
  <div class="page-block">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('registrasi.index') }}">Registrasi</a></li>
      <li class="breadcrumb-item" aria-current="page">Registrasi Baru</li>
    </ul>
    <div class="page-header-title">
      <h2 class="mb-0">Registrasi Baru</h2>
    </div>
  </div>
</div>

<div class="grid grid-cols-12 gap-x-6">
  <div class="col-span-12">
    <div class="card">
      <div class="card-body">
        <form action="{{ route('registrasi.store') }}" method="POST">
          @csrf
          <div class="container">
            <div class="grid grid-cols-12 gap-x-6">
              <div class="col-span-12 sm:col-span-6">
                <div class="mb-3">
                  <label class="form-label">Pasien</label>
                  <select name="pasien_id" class="form-select" required>
                    <option value="">Pilih Pasien</option>
                    @foreach($pasiens as $pasien)
                      <option value="{{ $pasien->id }}">{{ $pasien->nama }} - {{ $pasien->no_rm }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-span-12 sm:col-span-6">
                <div class="mb-3">
                  <label class="form-label">Dokter</label>
                  <select name="dokter_id" class="form-select" required id="dokterSelect">
                    <option value="">Pilih Dokter</option>
                    @foreach($dokters as $dokter)
                      <option value="{{ $dokter->id }}">{{ $dokter->nama }} - {{ $dokter->spesialisasi }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="grid grid-cols-12 gap-x-6">
              <div class="col-span-12 sm:col-span-6">
                <div class="mb-3">
                  <label class="form-label">Jadwal Dokter</label>
                  <select name="jadwal_dokter_id" class="form-select" id="jadwalSelect">
                    <option value="">Pilih Jadwal</option>
                  </select>
                </div>
              </div>
              <div class="col-span-12 sm:col-span-6">
                <div class="mb-3">
                  <label class="form-label">Jenis Kunjungan</label>
                  <select name="jenis_kunjungan" class="form-select" required>
                    <option value="baru">Baru</option>
                    <option value="kontrol">Kontrol</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="grid grid-cols-12 gap-x-6">
              <div class="col-span-12 sm:col-span-6">
                <div class="mb-3">
                  <label class="form-label">Tanggal Kunjungan</label>
                  <input type="date" name="tanggal_kunjungan" class="form-control" required value="{{ date('Y-m-d') }}" />
                </div>
              </div>
              <div class="col-span-12 sm:col-span-6">
                <div class="mb-3">
                  <label class="form-label">Jam Kunjungan</label>
                  <input type="time" name="jam_kunjungan" class="form-control" required />
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Keluhan</label>
              <textarea name="keluhan" class="form-control" rows="4" placeholder="Masukkan keluhan pasien..."></textarea>
            </div>
            <div class="text-right mt-4">
              <a href="{{ route('registrasi.index') }}" class="btn btn-outline-secondary mr-2">Batal</a>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('dokterSelect').addEventListener('change', function() {
    const dokterId = this.value;
    const jadwalSelect = document.getElementById('jadwalSelect');
    
    jadwalSelect.innerHTML = '<option value="">Loading...</option>';
    
    if (!dokterId) {
        jadwalSelect.innerHTML = '<option value="">Pilih Jadwal</option>';
        return;
    }
    
    fetch(`/api/jadwal-dokter/${dokterId}`)
        .then(response => response.json())
        .then(data => {
            jadwalSelect.innerHTML = '<option value="">Pilih Jadwal</option>';
            data.forEach(jadwal => {
                const option = document.createElement('option');
                option.value = jadwal.id;
                option.textContent = `${jadwal.hari} - ${jadwal.jam_mulai.substring(0,5)} s/d ${jadwal.jam_selesai.substring(0,5)} (${jadwal.ruangan || '-'})`;
                jadwalSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            jadwalSelect.innerHTML = '<option value="">Error loading jadwal</option>';
        });
});
</script>
@endsection
