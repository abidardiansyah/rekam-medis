@extends('layouts.app')

@section('title', 'Antrean Pasien V2')

@section('content')
<div class="page-header">
  <div class="page-block">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="javascript: void(0)">Registrasi</a></li>
      <li class="breadcrumb-item" aria-current="page">Antrean V2</li>
    </ul>
    <div class="page-header-title">
      <h2 class="mb-0">Antrean Pasien V2</h2>
    </div>
  </div>
</div>

<div id="antrean-scheduler-v2"></div>

<script>
  window.antreansV2 = @json($antreans);
  window.shiftsV2 = @json($shifts);
  window.doktersByShiftV2 = @json($doktersByShift);
</script>
@vite('resources/js/app.js')
@endsection
