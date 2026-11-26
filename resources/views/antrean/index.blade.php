@extends('layouts.app')

@section('title', 'Antrean Pasien')

@section('content')
<div class="page-header">
  <div class="page-block">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="javascript: void(0)">Registrasi</a></li>
      <li class="breadcrumb-item" aria-current="page">Antrean</li>
    </ul>
    <div class="page-header-title">
      <h2 class="mb-0">Antrean Pasien</h2>
    </div>
  </div>
</div>

<div id="antrean-scheduler"></div>

<script>
  window.antreans = @json($antreans);
  window.dokters = @json($dokters);
</script>
@vite('resources/js/app.js')
@endsection
