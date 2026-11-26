@extends('layouts.app')

@section('title', 'Dashboard')

@push('scripts')
<script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/widgets/new-orders-graph.js') }}"></script>
<script src="{{ asset('assets/js/widgets/new-users-graph.js') }}"></script>
<script src="{{ asset('assets/js/widgets/visitors-graph.js') }}"></script>
<script src="{{ asset('assets/js/widgets/overview-chart.js') }}"></script>
<script src="{{ asset('assets/js/widgets/income-graph.js') }}"></script>
<script src="{{ asset('assets/js/widgets/languages-graph.js') }}"></script>
<script src="{{ asset('assets/js/widgets/overview-product-graph.js') }}"></script>
@endpush

@section('content')
<div class="page-header">
  <div class="page-block">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="javascript: void(0)">Dashboard</a></li>
      <li class="breadcrumb-item" aria-current="page">Analytics</li>
    </ul>
    <div class="page-header-title">
      <h2 class="mb-0">Dashboard Rekam Medis</h2>
    </div>
  </div>
</div>

<div class="grid grid-cols-12 gap-x-6">
  <div class="col-span-12 md:col-span-6 2xl:col-span-3">
    <div class="card">
      <div class="card-body">
        <div class="flex items-center justify-between">
          <h5 class="mb-0">Total Pasien</h5>
          <select class="form-select form-select-sm w-auto">
            <option>Today</option>
            <option>Weekly</option>
            <option selected>Monthly</option>
          </select>
        </div>
        <div class="my-3">
          <div id="new-orders-graph"></div>
          <h5 class="text-center mt-3">1,234 <small class="text-primary-500"><i class="ti ti-arrow-up-right"></i> 12.5%</small></h5>
        </div>
        <div class="grid">
          <button class="btn btn-outline-secondary">View more</button>
        </div>
      </div>
    </div>
  </div>
  <div class="col-span-12 md:col-span-6 2xl:col-span-3">
    <div class="card">
      <div class="card-body">
        <div class="flex items-center justify-between">
          <h5 class="mb-0">Kunjungan Hari Ini</h5>
          <select class="form-select form-select-sm w-auto">
            <option>Today</option>
            <option>Weekly</option>
            <option selected>Monthly</option>
          </select>
        </div>
        <div class="my-3">
          <div id="new-users-graph"></div>
          <h5 class="text-center mt-3">45 <small class="text-success-500"><i class="ti ti-arrow-up-right"></i> 8.2%</small></h5>
        </div>
        <div class="grid">
          <button class="btn btn-outline-secondary">View more</button>
        </div>
      </div>
    </div>
  </div>
  <div class="col-span-12 md:col-span-6 2xl:col-span-3">
    <div class="card">
      <div class="card-body">
        <div class="flex items-center justify-between">
          <h5 class="mb-0">Dokter Aktif</h5>
          <select class="form-select form-select-sm w-auto">
            <option>Today</option>
            <option>Weekly</option>
            <option selected>Monthly</option>
          </select>
        </div>
        <div class="my-3">
          <div id="visitors-graph"></div>
          <h5 class="text-center mt-3">12 <small class="text-success-500"><i class="ti ti-arrow-up-right"></i> 5.0%</small></h5>
        </div>
        <div class="grid">
          <button class="btn btn-outline-secondary">View more</button>
        </div>
      </div>
    </div>
  </div>
  <div class="col-span-12 md:col-span-6 2xl:col-span-3">
    <div class="card bg-gray-800 dropbox-card overflow-hidden">
      <div class="bg-[url('../images/widget/img-dropbox-bg.svg')] opacity-50 absolute inset-0 z-10 bg-right-bottom bg-no-repeat bg-[length:100%]"></div>
      <div class="card-body relative z-20">
        <div class="flex items-center justify-between mb-2">
          <h5 class="text-white">Rekam Medis</h5>
          <h4 class="text-white">2,456</h4>
        </div>
        <div class="mb-3">
          <div class="w-10 h-10 rounded-xl inline-flex items-center justify-center bg-white bg-opacity-10 text-white">
            <i class="ti ti-file-text text-lg leading-none"></i>
          </div>
        </div>
        <small class="text-white block mb-3">2,100 rekam medis bulan ini</small>
        <div class="w-full bg-transparent rounded-lg h-2 flex items-center mb-0.5">
          <div class="bg-danger-500 h-full rounded-full" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
          <div class="bg-warning-500 h-full rounded-full" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
          <div class="bg-primary-100 h-full rounded-full" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
          <div class="bg-success-500 h-full rounded-full" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
    </div>
    <div class="card bg-primary-500 available-balance-card overflow-hidden">
      <div class="card-body !p-4 bg-[linear-gradient(245deg,transparent_25.46%,rgba(0,0,0,0.2)_68.77%,rgba(0,0,0,0.3)_81.72%)]">
        <div class="flex items-center justify-between">
          <div>
            <p class="mb-0 text-white text-opacity-75">Pendapatan Bulan Ini</p>
            <h4 class="mb-0 text-white">Rp 45.500.000</h4>
          </div>
          <div class="w-10 h-10 rounded-xl inline-flex items-center justify-center bg-dark-500/10 text-white">
            <i class="ti ti-currency-dollar text-lg leading-none"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-span-12">
    <div class="card">
      <div class="card-header !pb-0 !pt-2">
        <ul class="flex flex-wrap w-full text-center nav-tabs">
          <li class="group active">
            <a href="javascript:void(0);" data-pc-toggle="tab" data-pc-target="analytics-tab-1" class="inline-block mr-6 py-4 transition-all duration-300 ease-linear border-b-2 border-transparent group-[.active]:text-primary-500 group-[.active]:border-primary-500 hover:text-primary-500 active:text-primary-500">
            Overview
            </a>
          </li>
          <li class="group">
            <a href="javascript:void(0);" data-pc-toggle="tab" data-pc-target="analytics-tab-2" class="inline-block mr-6 py-4 transition-all duration-300 ease-linear border-b-2 border-transparent group-[.active]:text-primary-500 group-[.active]:border-primary-500 hover:text-primary-500 active:text-primary-500">
            Kunjungan
            </a>
          </li>
          <li class="group">
            <a href="javascript:void(0);" data-pc-toggle="tab" data-pc-target="analytics-tab-3" class="inline-block mr-6 py-4 transition-all duration-300 ease-linear border-b-2 border-transparent group-[.active]:text-primary-500 group-[.active]:border-primary-500 hover:text-primary-500 active:text-primary-500">
            Pasien
            </a>
          </li>
          <li class="group">
            <a href="javascript:void(0);" data-pc-toggle="tab" data-pc-target="analytics-tab-4" class="inline-block mr-6 py-4 transition-all duration-300 ease-linear border-b-2 border-transparent group-[.active]:text-primary-500 group-[.active]:border-primary-500 hover:text-primary-500 active:text-primary-500">
            Pendapatan
            </a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="grid grid-cols-12 gap-6">
          <div class="col-span-12 lg:col-span-7 xl:col-span-8">
            <ul class="mb-3 flex flex-wrap items-center justify-end gap-3">
              <li class="list-inline-item">
                <select class="form-select w-auto">
                  <option>Today</option>
                  <option>Weekly</option>
                  <option selected="">Monthly</option>
                </select>
              </li>
              <li class="list-inline-item">
                <a href="#" class="w-10 h-10 rounded-xl inline-flex items-center justify-center btn-link-secondary border border-secondary">
                  <i class="ti ti-external-link text-lg leading-none"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#" class="w-10 h-10 rounded-xl inline-flex items-center justify-center btn-link-secondary border border-secondary">
                  <i class="ti ti-arrows-diagonal text-lg leading-none"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <div class="dropdown">
                  <a class="w-10 h-10 rounded-xl inline-flex items-center justify-center btn-link-secondary border border-secondary dropdown-toggle arrow-none" href="#" data-pc-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ti ti-dots text-lg leading-none"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#">Name</a>
                    <a class="dropdown-item" href="#">Date</a>
                    <a class="dropdown-item" href="#">Ratting</a>
                    <a class="dropdown-item" href="#">Unread</a>
                  </div>
                </div>
              </li>
            </ul>
            <div class="tab-content">
              <div class="block tab-pane" id="analytics-tab-1"><div id="overview-chart-1"></div></div>
              <div class="hidden tab-pane" id="analytics-tab-2"><div id="overview-chart-2"></div></div>
              <div class="hidden tab-pane" id="analytics-tab-3"><div id="overview-chart-3"></div></div>
              <div class="hidden tab-pane" id="analytics-tab-4"><div id="overview-chart-4"></div></div>
            </div>
          </div>
          <div class="col-span-12 lg:col-span-5 xl:col-span-4">
            <ul class="rounded-lg *:py-4 *:px-[25px] divide-y divide-inherit border-theme-border dark:border-themedark-border">
              <li class="list-group-item">
                <div class="flex items-center">
                  <div class="shrink-0">
                    <div class="w-10 h-10 rounded-xl inline-flex items-center justify-center bg-secondary-500/10 text-secondary-500">
                      <i class="ti ti-users text-xl leading-none"></i>
                    </div>
                  </div>
                  <div class="grow ltr:ml-3 rtl:mr-3">
                    <div class="grid grid-cols-12 gap-1">
                      <div class="col-span-6">
                        <p class="text-muted mb-1">Pasien Baru</p>
                        <h6 class="mb-0">156</h6>
                      </div>
                      <div class="col-span-6 ltr:text-right rtl:text-left">
                        <h6 class="mb-1">+24</h6>
                        <p class="text-success-500 mb-0"><i class="ti ti-arrow-up-right"></i> 18.2%</p>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="flex items-center">
                  <div class="shrink-0">
                    <div class="w-10 h-10 rounded-xl inline-flex items-center justify-center bg-secondary-500/10 text-secondary-500">
                      <i class="ti ti-calendar text-xl leading-none"></i>
                    </div>
                  </div>
                  <div class="grow ltr:ml-3 rtl:mr-3">
                    <div class="grid grid-cols-12 gap-1">
                      <div class="col-span-6">
                        <p class="text-muted mb-1">Kunjungan</p>
                        <h6 class="mb-0">892</h6>
                      </div>
                      <div class="col-span-6 ltr:text-right rtl:text-left">
                        <h6 class="mb-1">+67</h6>
                        <p class="text-success-500 mb-0"><i class="ti ti-arrow-up-right"></i> 8.1%</p>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="flex items-center">
                  <div class="shrink-0">
                    <div class="w-10 h-10 rounded-xl inline-flex items-center justify-center bg-secondary-500/10 text-secondary-500">
                      <i class="ti ti-stethoscope text-xl leading-none"></i>
                    </div>
                  </div>
                  <div class="grow ltr:ml-3 rtl:mr-3">
                    <div class="grid grid-cols-12 gap-1">
                      <div class="col-span-6">
                        <p class="text-muted mb-1">Pemeriksaan</p>
                        <h6 class="mb-0">734</h6>
                      </div>
                      <div class="col-span-6 ltr:text-right rtl:text-left">
                        <h6 class="mb-1">+52</h6>
                        <p class="text-success-500 mb-0"><i class="ti ti-arrow-up-right"></i> 7.6%</p>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="flex items-center">
                  <div class="shrink-0">
                    <div class="w-10 h-10 rounded-xl inline-flex items-center justify-center bg-secondary-500/10 text-secondary-500">
                      <i class="ti ti-currency-dollar text-xl leading-none"></i>
                    </div>
                  </div>
                  <div class="grow ltr:ml-3 rtl:mr-3">
                    <div class="grid grid-cols-12 gap-1">
                      <div class="col-span-6">
                        <p class="text-muted mb-1">Pendapatan</p>
                        <h6 class="mb-0">Rp 45.5jt</h6>
                      </div>
                      <div class="col-span-6 ltr:text-right rtl:text-left">
                        <h6 class="mb-1">+Rp 5.2jt</h6>
                        <p class="text-success-500 mb-0"><i class="ti ti-arrow-up-right"></i> 12.9%</p>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-span-12 2xl:col-span-3">
    <div class="grid grid-cols-12 gap-x-6">
      <div class="col-span-12 md:col-span-6 2xl:col-span-12">
        <div class="card">
          <div class="card-body">
            <div class="flex items-center justify-between mb-3">
              <div class="w-8 h-8 rounded-xl inline-flex items-center justify-center bg-secondary-500/10 text-secondary-500">
                <i class="ti ti-currency-dollar text-xl leading-none"></i>
              </div>
              <div class="dropdown">
                <a class="w-8 h-8 rounded-xl inline-flex items-center justify-center btn-link-secondary dropdown-toggle arrow-none" href="#" data-pc-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="ti ti-dots-vertical text-lg leading-none"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                  <a class="dropdown-item" href="#">Hari Ini</a>
                  <a class="dropdown-item" href="#">Minggu Ini</a>
                  <a class="dropdown-item" href="#">Bulan Ini</a>
                </div>
              </div>
            </div>
            <h5 class="mb-0">Rp 45.500.000</h5>
            <p class="text-muted mb-0">Pendapatan</p>
            <div class="mt-2">
              <div id="income-graph"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-span-12 md:col-span-6 2xl:col-span-12">
        <div class="card">
          <div class="card-body">
            <div class="flex items-center justify-between mb-3">
              <h5 class="mb-0">Sistem Info</h5>
              <div class="dropdown">
                <a class="w-8 h-8 rounded-xl inline-flex items-center justify-center btn-link-secondary dropdown-toggle arrow-none" href="#" data-pc-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="ti ti-dots-vertical text-lg leading-none"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                  <a class="dropdown-item" href="#">Info</a>
                  <a class="dropdown-item" href="#">Settings</a>
                </div>
              </div>
            </div>
            <div class="flex items-center">
              <div class="shrink-0">
                <div class="w-8 h-8 rounded-xl inline-flex items-center justify-center bg-secondary-500/10 text-secondary-500">
                  <i class="ti ti-arrow-big-right text-lg leading-none"></i>
                </div>
              </div>
              <div class="grow ltr:ml-3 rtl:mr-3">
                <h6 class="mb-0">Version <span class="badge bg-success-500/10 text-success-500">V1.0.0</span></h6>
              </div>
            </div>
            <div class="mt-2 mb-3">
              <div id="languages-graph"></div>
            </div>
            <div class="grid grid-cols-12 gap-2">
              <div class="col-span-6">
                <div class="grid"><button class="btn btn-outline-secondary">Pasien</button></div>
              </div>
              <div class="col-span-6">
                <div class="grid"><button class="btn btn-outline-secondary">Dokter</button></div>
              </div>
              <div class="col-span-6">
                <div class="grid"><button class="btn btn-outline-secondary">Rekam Medis</button></div>
              </div>
              <div class="col-span-6">
                <div class="grid"><button class="btn btn-outline-secondary">Laporan</button></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-span-12 2xl:col-span-6">
    <div class="card">
      <div class="card-body">
        <div class="flex items-center justify-between mb-3">
          <h5 class="mb-0">Statistik Layanan</h5>
          <div class="dropdown">
            <a class="w-8 h-8 rounded-xl inline-flex items-center justify-center btn-link-secondary dropdown-toggle arrow-none" href="#" data-pc-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="ti ti-dots-vertical text-lg leading-none"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
              <a class="dropdown-item" href="#">Hari Ini</a>
              <a class="dropdown-item" href="#">Minggu Ini</a>
              <a class="dropdown-item" href="#">Bulan Ini</a>
            </div>
          </div>
        </div>
        <div class="my-3">
          <div id="overview-product-graph"></div>
        </div>
        <div class="grid grid-cols-12 gap-3 text-center">
          <div class="col-span-6 lg:col-span-4 2xl:col-span-4">
            <div class="p-4 rounded-lg border border-theme-border dark:border-themedark-border">
              <p class="mb-1 relative inline-block"><span class="rounded-full w-1.5 h-1.5 inline-block bg-dark-500 absolute -left-4 top-2"></span><span>Umum</span></p>
              <h6 class="mb-0">450+</h6>
            </div>
          </div>
          <div class="col-span-6 lg:col-span-4 2xl:col-span-4">
            <div class="p-4 rounded-lg border border-theme-border dark:border-themedark-border">
              <p class="mb-1 relative inline-block"><span class="rounded-full w-1.5 h-1.5 inline-block bg-dark-500 absolute -left-4 top-2"></span><span>Gigi</span></p>
              <h6 class="mb-0">120+</h6>
            </div>
          </div>
          <div class="col-span-6 lg:col-span-4 2xl:col-span-4">
            <div class="p-4 rounded-lg border border-theme-border dark:border-themedark-border">
              <p class="mb-1 relative inline-block"><span class="rounded-full w-1.5 h-1.5 inline-block bg-dark-500 absolute -left-4 top-2"></span><span>Anak</span></p>
              <h6 class="mb-0">89+</h6>
            </div>
          </div>
          <div class="col-span-6 lg:col-span-4 2xl:col-span-4">
            <div class="p-4 rounded-lg border border-theme-border dark:border-themedark-border">
              <p class="mb-1 relative inline-block"><span class="rounded-full w-1.5 h-1.5 inline-block bg-dark-500 absolute -left-4 top-2"></span><span>Kandungan</span></p>
              <h6 class="mb-0">67+</h6>
            </div>
          </div>
          <div class="col-span-6 lg:col-span-4 2xl:col-span-4">
            <div class="p-4 rounded-lg border border-theme-border dark:border-themedark-border">
              <p class="mb-1 relative inline-block"><span class="rounded-full w-1.5 h-1.5 inline-block bg-primary-500 absolute -left-4 top-2"></span><span>Jantung</span></p>
              <h6 class="mb-0">45+</h6>
            </div>
          </div>
          <div class="col-span-6 lg:col-span-4 2xl:col-span-4">
            <div class="p-4 rounded-lg border border-theme-border dark:border-themedark-border">
              <p class="mb-1 relative inline-block"><span class="rounded-full w-1.5 h-1.5 inline-block bg-primary-500 absolute -left-4 top-2"></span><span>Lainnya</span></p>
              <h6 class="mb-0">121+</h6>
            </div>
          </div>
        </div>
        <div class="grid grid-cols-12 gap-2 text-center mt-4">
          <div class="col-span-12 sm:col-span-6">
            <div class="grid">
              <button class="btn btn-outline-secondary">Lihat Semua</button>
            </div>
          </div>
          <div class="col-span-12 sm:col-span-6">
            <div class="grid">
              <button class="btn btn-primary">Tambah Layanan</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-span-12 2xl:col-span-3">
    <div class="card">
      <div class="card-body !pb-0">
        <div class="flex items-center justify-between mb-3">
          <h5 class="mb-0">Aktivitas Terbaru</h5>
          <a class="w-8 h-8 rounded-xl inline-flex items-center justify-center btn-link-secondary">
            <i class="ti ti-plus text-lg leading-none"></i>
          </a>
        </div>
      </div>
      <ul class="rounded-lg *:py-4 *:px-[25px] divide-y divide-inherit border-theme-border dark:border-themedark-border">
        <li class="list-group-item">
          <div class="flex align-items-center">
            <div class="shrink-0">
              <div class="w-10 h-10 rounded-xl inline-flex items-center justify-center bg-success-500/10 text-success-500">
                <i class="ti ti-user-plus text-lg leading-none"></i>
              </div>
            </div>
            <div class="grow mx-2">
              <p class="mb-1">Pasien Baru</p>
              <h6 class="mb-0">+24 <small class="text-success-500">+ 18.2%</small></h6>
            </div>
          </div>
        </li>
        <li class="list-group-item">
          <div class="flex align-items-center">
            <div class="shrink-0">
              <div class="w-10 h-10 rounded-xl inline-flex items-center justify-center bg-primary-500/10 text-primary-500">
                <i class="ti ti-calendar-check text-lg leading-none"></i>
              </div>
            </div>
            <div class="grow mx-2">
              <p class="mb-1">Kunjungan</p>
              <h6 class="mb-0">+67 <small class="text-success-500">+ 8.1%</small></h6>
            </div>
          </div>
        </li>
        <li class="list-group-item">
          <div class="flex align-items-center">
            <div class="shrink-0">
              <div class="w-10 h-10 rounded-xl inline-flex items-center justify-center bg-warning-500/10 text-warning-500">
                <i class="ti ti-file-text text-lg leading-none"></i>
              </div>
            </div>
            <div class="grow mx-2">
              <p class="mb-1">Rekam Medis</p>
              <h6 class="mb-0">+52 <small class="text-success-500">+ 7.6%</small></h6>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
  
  <div class="col-span-12">
    <div class="card">
      <div class="card-header">
        <h5>Jadwal Dokter Hari Ini</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Dokter</th>
                <th>Spesialisasi</th>
                <th>Jadwal</th>
                <th>Pasien Hari Ini</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <div class="flex items-center">
                    <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="user" class="w-8 h-8 rounded-full mr-2" />
                    <span>Dr. John Doe</span>
                  </div>
                </td>
                <td>Spesialis Umum</td>
                <td>08:00 - 14:00</td>
                <td>12 Pasien</td>
                <td><span class="badge bg-success-500/10 text-success-500">Aktif</span></td>
                <td>
                  <a href="#" class="w-8 h-8 rounded-xl inline-flex items-center justify-center btn-link-secondary">
                    <i class="ti ti-eye text-lg leading-none"></i>
                  </a>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="flex items-center">
                    <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="user" class="w-8 h-8 rounded-full mr-2" />
                    <span>Dr. Jane Smith</span>
                  </div>
                </td>
                <td>Spesialis Anak</td>
                <td>09:00 - 15:00</td>
                <td>8 Pasien</td>
                <td><span class="badge bg-success-500/10 text-success-500">Aktif</span></td>
                <td>
                  <a href="#" class="w-8 h-8 rounded-xl inline-flex items-center justify-center btn-link-secondary">
                    <i class="ti ti-eye text-lg leading-none"></i>
                  </a>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="flex items-center">
                    <img src="{{ asset('assets/images/user/avatar-3.jpg') }}" alt="user" class="w-8 h-8 rounded-full mr-2" />
                    <span>Dr. Ahmad Yani</span>
                  </div>
                </td>
                <td>Spesialis Jantung</td>
                <td>10:00 - 16:00</td>
                <td>5 Pasien</td>
                <td><span class="badge bg-warning-500/10 text-warning-500">Istirahat</span></td>
                <td>
                  <a href="#" class="w-8 h-8 rounded-xl inline-flex items-center justify-center btn-link-secondary">
                    <i class="ti ti-eye text-lg leading-none"></i>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
