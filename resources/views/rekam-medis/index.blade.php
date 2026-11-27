@extends('layouts.app')

@section('content')
<style>
    .medical-records-container {
        padding: 0 32px;
    }
    .patient-search-wrapper {
        position: relative;
        width: 100%;
        max-width: 560px;
        margin: 20px auto 24px;
    }
    .patient-search-input {
        width: 100%;
        height: 46px;
        box-sizing: border-box;
        padding-left: 44px;
        padding-right: 44px;
        border: 2px solid #E5E7EB;
        border-radius: 24px;
        background: white;
        font-size: 14px;
    }
    .patient-search-input:focus {
        outline: none;
        border-color: #3B82F6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .patient-search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
        z-index: 2;
    }
    .patient-search-clear {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 6px;
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.2s;
    }
    .patient-search-clear:hover {
        background: #F3F4F6;
    }
    .patient-search-dropdown {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        right: 0;
        width: 100%;
        min-width: 0;
        box-sizing: border-box;
        z-index: 1000;
        background: #fff;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        max-height: 320px;
        overflow-y: auto;
    }
    .patient-search-item {
        padding: 14px 16px;
        cursor: pointer;
        border-bottom: 1px solid #F3F4F6;
        transition: background 0.15s;
    }
    .patient-search-item:last-child {
        border-bottom: none;
    }
    .patient-search-item:hover {
        background: #F9FAFB;
    }
    #contentArea.show-grid {
        display: grid !important;
        grid-template-columns: 1fr;
        gap: 24px;
        align-items: start;
    }
    @media (min-width: 1024px) {
        #contentArea.show-grid {
            grid-template-columns: minmax(320px, 0.85fr) minmax(0, 1.75fr);
        }
    }
    .patient-card {
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        padding: 24px;
    }
    .patient-card .section-divider {
        margin: 20px 0;
        border-top: 1px solid #E5E7EB;
        padding-top: 20px;
    }
    .patient-card .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }
    .records-card {
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        padding: 24px;
    }
    .records-table td, .records-table th {
        padding: 12px 14px;
    }
    .stats-box {
        background: #EFF6FF;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
    }
</style>

<div class="medical-records-container">
    <!-- Header -->
    <div style="margin-bottom: 6px;">
        <h1 class="text-2xl font-bold">Medical Records</h1>
        <p class="text-gray-600" style="margin-top: 4px;">View patient medical history</p>
    </div>

    <!-- Patient Selector (Floating Search Bar) -->
    <div class="patient-search-wrapper">
        <div class="patient-search-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.3-4.3"></path>
            </svg>
        </div>
        <input
            id="searchInput"
            type="text"
            placeholder="Search patient by name or MR number..."
            class="patient-search-input"
            autocomplete="off"
        />
        <button id="clearBtn" class="patient-search-clear" style="display: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-500">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
            </svg>
        </button>
        
        <!-- Dropdown -->
        <div id="dropdown" class="patient-search-dropdown" style="display: none;"></div>
    </div>

    <!-- 2-Column Layout -->
    <div id="contentArea" style="display: none;">
        <!-- Left: Patient Card -->
        <div>
            <div class="patient-card sticky top-4">
                <!-- Avatar -->
                <div class="flex flex-col items-center">
                    <div id="avatar" class="w-24 h-24 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-3xl"></div>
                    <h2 id="patientName" class="mt-3 text-xl font-bold text-center"></h2>
                </div>
                
                <!-- Basic Info -->
                <div class="section-divider">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Basic Info</h3>
                    <div class="space-y-2 text-sm">
                        <div class="info-row">
                            <span class="text-gray-600">MR Number:</span>
                            <span id="patientRM" class="font-medium"></span>
                        </div>
                        <div class="info-row">
                            <span class="text-gray-600">Age:</span>
                            <span id="patientAge" class="font-medium"></span>
                        </div>
                        <div class="info-row">
                            <span class="text-gray-600">Gender:</span>
                            <span id="patientGender" class="font-medium"></span>
                        </div>
                    </div>
                </div>
                
                <!-- Contact -->
                <div class="section-divider">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Contact</h3>
                    <div class="text-sm">
                        <span class="text-gray-600 block mb-1">Phone:</span>
                        <span id="patientPhone" class="font-medium"></span>
                    </div>
                </div>
                
                <!-- Address -->
                <div class="section-divider">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Address</h3>
                    <p id="patientAddress" class="text-sm"></p>
                </div>
                
                <!-- Guarantor -->
                <div class="section-divider">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Guarantor</h3>
                    <div class="text-sm">
                        <span class="text-gray-600 block mb-1">Type:</span>
                        <span id="patientGuarantor" class="font-medium">Umum</span>
                    </div>
                </div>
                
                <!-- Statistics -->
                <div class="section-divider">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Statistics</h3>
                    <div class="stats-box">
                        <p id="totalRecords" class="text-4xl font-bold text-blue-600">0</p>
                        <p class="text-sm text-gray-600 mt-2">Total Records</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Records Table -->
        <div>
            <div class="records-card">
                <!-- Filters -->
                <div class="flex flex-wrap gap-2" style="margin-bottom: 16px;">
                    <select id="filterDoctor" class="px-3 py-2 border rounded-md text-sm bg-white">
                        <option value="">All Doctors</option>
                    </select>
                    <select id="filterStatus" class="px-3 py-2 border rounded-md text-sm bg-white">
                        <option value="">All Status</option>
                        <option value="draft">Draft</option>
                        <option value="completed">Completed</option>
                        <option value="reviewed">Reviewed</option>
                    </select>
                </div>

                <!-- Table -->
                <div class="border rounded-lg overflow-hidden">
                    <table class="w-full records-table">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="text-left text-xs font-medium text-gray-500 uppercase">Doctor</th>
                                <th class="text-left text-xs font-medium text-gray-500 uppercase">Clinic</th>
                                <th class="text-left text-xs font-medium text-gray-500 uppercase">Diagnosis</th>
                                <th class="text-left text-xs font-medium text-gray-500 uppercase">BP</th>
                                <th class="text-left text-xs font-medium text-gray-500 uppercase">Temp</th>
                                <th class="text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody id="recordsTable" class="divide-y"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <div id="emptyState" class="bg-white border rounded-lg shadow-sm" style="border-radius: 12px; border: 1px solid #E5E7EB;">
        <div class="p-6">
            <div class="text-center py-8">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-16 h-16 mx-auto text-gray-400 mb-4">
                    <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
                <p class="text-lg font-medium text-gray-600 mb-2">Select a patient to view medical records</p>
                <p class="text-sm text-gray-600">Search and select a patient from the dropdown above</p>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div id="modal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 9999; background: rgba(0, 0, 0, 0.5);">
    <div style="display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 24px;">
        <div style="width: min(1000px, 90vw); max-height: 85vh; display: flex; flex-direction: column; background: #ffffff; border-radius: 14px; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15); overflow: hidden;">
            <!-- Header -->
            <div style="padding: 24px 28px; border-bottom: 1px solid #E5E7EB; background: linear-gradient(to right, #EFF6FF, #ffffff);">
                <div style="display: flex; align-items: flex-start; justify-content: space-between;">
                    <div>
                        <h2 style="font-size: 22px; font-weight: 700; color: #111827; margin: 0;">Medical Record Details</h2>
                        <p id="modalSubtitle" style="font-size: 14px; color: #6B7280; margin: 6px 0 0 0;"></p>
                    </div>
                    <button id="closeModalBtn" style="padding: 8px; border: none; background: transparent; cursor: pointer; border-radius: 8px; transition: background 0.2s;" onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='transparent'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #6B7280;">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Body (Scrollable) -->
            <div style="flex: 1; overflow-y: auto; padding: 28px;">
                <!-- Patient & Doctor Info (2 Columns) -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                    <!-- Patient Card -->
                    <div style="background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 10px; padding: 20px;">
                        <p style="font-size: 12px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 12px 0;">Patient Information</p>
                        <p id="modalPatient" style="font-size: 18px; font-weight: 600; color: #111827; margin: 0 0 8px 0;"></p>
                        <p id="modalPatientInfo" style="font-size: 14px; color: #6B7280; margin: 0;"></p>
                    </div>
                    
                    <!-- Doctor Card -->
                    <div style="background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 10px; padding: 20px;">
                        <p style="font-size: 12px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 12px 0;">Doctor Information</p>
                        <p id="modalDoctor" style="font-size: 18px; font-weight: 600; color: #111827; margin: 0 0 8px 0;"></p>
                        <p id="modalDoctorSpec" style="font-size: 14px; color: #6B7280; margin: 0;"></p>
                    </div>
                </div>

                <!-- Chief Complaint -->
                <div style="background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 10px; padding: 20px; margin-bottom: 20px;">
                    <h3 style="font-size: 15px; font-weight: 600; color: #1E40AF; margin: 0 0 10px 0;">Chief Complaint</h3>
                    <p id="modalComplaint" style="font-size: 14px; color: #374151; margin: 0; line-height: 1.6;"></p>
                </div>

                <!-- Vital Signs -->
                <div style="border: 1px solid #E5E7EB; border-radius: 10px; overflow: hidden; margin-bottom: 16px;">
                    <button type="button" onclick="toggleSection('vitals')" style="width: 100%; display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; background: #F9FAFB; border: none; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='#F9FAFB'">
                        <h3 style="font-size: 16px; font-weight: 600; color: #111827; margin: 0;">Vital Signs</h3>
                        <svg id="vitalsIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #6B7280;">
                            <path d="m18 15-6-6-6 6"></path>
                        </svg>
                    </button>
                    <div id="vitalsContent" style="padding: 20px; background: #ffffff;">
                        <div id="modalVitals" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;"></div>
                    </div>
                </div>

                <!-- Diagnosis & Treatment -->
                <div style="border: 1px solid #E5E7EB; border-radius: 10px; overflow: hidden; margin-bottom: 16px;">
                    <button type="button" onclick="toggleSection('diagnosis')" style="width: 100%; display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; background: #F9FAFB; border: none; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='#F9FAFB'">
                        <h3 style="font-size: 16px; font-weight: 600; color: #111827; margin: 0;">Diagnosis & Treatment</h3>
                        <svg id="diagnosisIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #6B7280;">
                            <path d="m18 15-6-6-6 6"></path>
                        </svg>
                    </button>
                    <div id="diagnosisContent" style="padding: 20px; background: #ffffff;">
                        <div style="margin-bottom: 20px;">
                            <p style="font-size: 13px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 10px 0;">Primary Diagnosis</p>
                            <div id="modalDiagnosis"></div>
                        </div>
                        <div>
                            <p style="font-size: 13px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 10px 0;">Treatment Plan</p>
                            <p id="modalTreatment" style="font-size: 14px; color: #374151; margin: 0; line-height: 1.6;"></p>
                        </div>
                    </div>
                </div>

                <!-- Prescriptions -->
                <div style="border: 1px solid #E5E7EB; border-radius: 10px; overflow: hidden; margin-bottom: 16px;">
                    <button type="button" onclick="toggleSection('prescription')" style="width: 100%; display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; background: #F9FAFB; border: none; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='#F9FAFB'">
                        <h3 style="font-size: 16px; font-weight: 600; color: #111827; margin: 0;">Prescriptions <span id="rxCount" style="color: #6B7280;"></span></h3>
                        <svg id="prescriptionIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #6B7280;">
                            <path d="m18 15-6-6-6 6"></path>
                        </svg>
                    </button>
                    <div id="prescriptionContent" style="padding: 20px; background: #ffffff;">
                        <div id="modalPrescriptions" style="display: flex; flex-direction: column; gap: 12px;"></div>
                    </div>
                </div>

                <!-- Lab Results & Notes -->
                <div style="border: 1px solid #E5E7EB; border-radius: 10px; overflow: hidden;">
                    <button type="button" onclick="toggleSection('notes')" style="width: 100%; display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; background: #F9FAFB; border: none; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='#F9FAFB'">
                        <h3 style="font-size: 16px; font-weight: 600; color: #111827; margin: 0;">Lab Results & Notes</h3>
                        <svg id="notesIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #6B7280;">
                            <path d="m18 15-6-6-6 6"></path>
                        </svg>
                    </button>
                    <div id="notesContent" style="padding: 20px; background: #ffffff;">
                        <div style="margin-bottom: 20px;">
                            <p style="font-size: 13px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 10px 0;">Lab Results</p>
                            <p id="modalLabResults" style="font-size: 14px; color: #374151; margin: 0; line-height: 1.6;"></p>
                        </div>
                        <div>
                            <p style="font-size: 13px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 10px 0;">Doctor's Notes</p>
                            <p id="modalDoctorNotes" style="font-size: 14px; color: #374151; margin: 0; line-height: 1.6;"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 20px 28px; border-top: 1px solid #E5E7EB; background: #F9FAFB;">
                <div id="modalStatus"></div>
                <button onclick="closeModal()" style="padding: 10px 24px; background: #3B82F6; color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#2563EB'" onmouseout="this.style.background='#3B82F6'">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
let selectedPatientId = null;
let allRecords = [];
let currentRecord = null;

const searchInput = document.getElementById('searchInput');
const dropdown = document.getElementById('dropdown');
const clearBtn = document.getElementById('clearBtn');
const contentArea = document.getElementById('contentArea');
const emptyState = document.getElementById('emptyState');
const modal = document.getElementById('modal');

// Search patients
searchInput.addEventListener('input', async (e) => {
    const query = e.target.value.trim();
    
    if (query.length === 0) {
        clearBtn.style.display = 'none';
    } else {
        clearBtn.style.display = 'flex';
    }
    
    if (query.length < 2) {
        dropdown.style.display = 'none';
        return;
    }
    
    const res = await fetch(`/api/rekam-medis/search-pasien?q=${encodeURIComponent(query)}`);
    const patients = await res.json();
    
    if (patients.length === 0) {
        dropdown.innerHTML = '<div class="patient-search-item" style="text-align: center; color: #6B7280;">No patients found</div>';
        dropdown.style.display = 'block';
        return;
    }
    
    dropdown.innerHTML = patients.map(p => `
        <div class="patient-search-item" onclick="selectPatient(${p.id}, '${p.nama.replace(/'/g, "\\'")}', '${p.no_rm}')">
            <p style="font-weight: 600; margin-bottom: 4px;">${p.nama}</p>
            <p style="font-size: 13px; color: #6B7280;">${p.no_rm} • ${p.umur} years • ${p.jenis_kelamin === 'L' ? 'Male' : 'Female'}</p>
        </div>
    `).join('');
    dropdown.style.display = 'block';
});

searchInput.addEventListener('focus', () => {
    if (!selectedPatientId && searchInput.value.length >= 2) {
        dropdown.style.display = 'block';
    }
});

clearBtn.addEventListener('click', () => {
    selectedPatientId = null;
    searchInput.value = '';
    clearBtn.style.display = 'none';
    contentArea.classList.add('hidden');
    contentArea.classList.remove('show-grid');
    emptyState.classList.remove('hidden');
    dropdown.style.display = 'none';
});

async function selectPatient(id, name, rm) {
    selectedPatientId = id;
    searchInput.value = `${name} (${rm})`;
    clearBtn.style.display = 'flex';
    dropdown.style.display = 'none';
    
    const res = await fetch(`/api/rekam-medis/pasien/${id}`);
    const data = await res.json();
    
    // Update patient card
    document.getElementById('avatar').textContent = name.charAt(0);
    document.getElementById('patientName').textContent = name;
    document.getElementById('patientRM').textContent = rm;
    document.getElementById('patientAge').textContent = data.pasien.umur + ' years';
    document.getElementById('patientGender').textContent = data.pasien.jenis_kelamin === 'L' ? 'Male' : 'Female';
    document.getElementById('patientPhone').textContent = data.pasien.no_hp || '-';
    document.getElementById('patientAddress').textContent = data.pasien.alamat || '-';
    document.getElementById('totalRecords').textContent = data.records.length;
    
    allRecords = data.records;
    
    // Populate doctors filter
    const uniqueDoctors = [...new Set(data.records.map(r => r.dokter?.nama).filter(Boolean))];
    const doctorSelect = document.getElementById('filterDoctor');
    doctorSelect.innerHTML = '<option value="">All Doctors</option>' + uniqueDoctors.map(d => `<option value="${d}">${d}</option>`).join('');
    
    renderRecords();
    
    emptyState.classList.add('hidden');
    contentArea.classList.remove('hidden');
    contentArea.classList.add('show-grid');
}

function renderRecords() {
    const statusFilter = document.getElementById('filterStatus').value;
    const doctorFilter = document.getElementById('filterDoctor').value;
    
    let filtered = allRecords;
    if (statusFilter) filtered = filtered.filter(r => r.status === statusFilter);
    if (doctorFilter) filtered = filtered.filter(r => r.dokter?.nama === doctorFilter);
    
    const tbody = document.getElementById('recordsTable');
    tbody.innerHTML = filtered.map(r => {
        const statusColors = {
            draft: 'bg-gray-100 text-gray-700',
            completed: 'bg-blue-100 text-blue-700',
            reviewed: 'bg-green-100 text-green-700'
        };
        const statusLabels = {draft: 'Draft', completed: 'Completed', reviewed: 'Reviewed'};
        
        return `
            <tr class="hover:bg-gray-50 cursor-pointer" onclick="openRecord(${r.id})">
                <td class="font-medium">${new Date(r.tanggal_kunjungan).toLocaleDateString('en-US', {year: 'numeric', month: 'short', day: 'numeric'})}</td>
                <td>${r.dokter?.nama || '-'}</td>
                <td>${r.dokter?.spesialisasi || '-'}</td>
                <td>
                    <p class="font-medium">${r.diagnosis_utama}</p>
                    <p class="text-xs text-gray-600 font-mono" style="margin-top: 2px;">${r.kode_diagnosis || ''}</p>
                </td>
                <td>${r.tekanan_darah || '-'}</td>
                <td>${r.suhu ? r.suhu.toFixed(1) + '°C' : '-'}</td>
                <td>
                    <span class="text-xs px-2 py-1 rounded-full font-medium ${statusColors[r.status]}">${statusLabels[r.status]}</span>
                </td>
            </tr>
        `;
    }).join('');
}

document.getElementById('filterStatus').addEventListener('change', renderRecords);
document.getElementById('filterDoctor').addEventListener('change', renderRecords);

async function openRecord(id) {
    try {
        const res = await fetch(`/api/rekam-medis/${id}`);
        if (!res.ok) throw new Error('Failed to fetch record');
        
        currentRecord = await res.json();
        
        // Header
        document.getElementById('modalSubtitle').textContent = `${currentRecord.nomor_rekam} • ${new Date(currentRecord.tanggal_kunjungan).toLocaleDateString('en-US', {year: 'numeric', month: 'long', day: 'numeric'})}`;
        
        // Patient & Doctor Info
        document.getElementById('modalPatient').textContent = currentRecord.pasien.nama;
        document.getElementById('modalPatientInfo').textContent = `${currentRecord.pasien.no_rm} • ${currentRecord.pasien.umur} yrs • ${currentRecord.pasien.jenis_kelamin === 'L' ? 'Male' : 'Female'}`;
        document.getElementById('modalDoctor').textContent = currentRecord.dokter?.nama || '-';
        document.getElementById('modalDoctorSpec').textContent = currentRecord.dokter?.spesialisasi || '';
        
        // Chief Complaint
        document.getElementById('modalComplaint').textContent = currentRecord.keluhan_utama || 'No complaint recorded';
        
        // Vital Signs
        const vitalsHTML = `
            <div>
                <p style="font-size: 12px; color: #6B7280; margin: 0 0 6px 0;">Blood Pressure</p>
                <p style="font-size: 16px; font-weight: 600; color: #111827; margin: 0;">${currentRecord.tekanan_darah || '-'}</p>
            </div>
            <div>
                <p style="font-size: 12px; color: #6B7280; margin: 0 0 6px 0;">Temperature</p>
                <p style="font-size: 16px; font-weight: 600; color: #111827; margin: 0;">${currentRecord.suhu ? currentRecord.suhu.toFixed(1) + '°C' : '-'}</p>
            </div>
            <div>
                <p style="font-size: 12px; color: #6B7280; margin: 0 0 6px 0;">Pulse</p>
                <p style="font-size: 16px; font-weight: 600; color: #111827; margin: 0;">${currentRecord.nadi || '-'} bpm</p>
            </div>
            <div>
                <p style="font-size: 12px; color: #6B7280; margin: 0 0 6px 0;">Respiratory</p>
                <p style="font-size: 16px; font-weight: 600; color: #111827; margin: 0;">${currentRecord.pernapasan || '-'}/min</p>
            </div>
            <div>
                <p style="font-size: 12px; color: #6B7280; margin: 0 0 6px 0;">Weight</p>
                <p style="font-size: 16px; font-weight: 600; color: #111827; margin: 0;">${currentRecord.berat_badan || '-'} kg</p>
            </div>
            <div>
                <p style="font-size: 12px; color: #6B7280; margin: 0 0 6px 0;">Height</p>
                <p style="font-size: 16px; font-weight: 600; color: #111827; margin: 0;">${currentRecord.tinggi_badan || '-'} cm</p>
            </div>
            <div>
                <p style="font-size: 12px; color: #6B7280; margin: 0 0 6px 0;">BMI</p>
                <p style="font-size: 16px; font-weight: 600; color: #111827; margin: 0;">${currentRecord.bmi || '-'}</p>
            </div>
            ${currentRecord.saturasi_oksigen ? `
            <div>
                <p style="font-size: 12px; color: #6B7280; margin: 0 0 6px 0;">SpO2</p>
                <p style="font-size: 16px; font-weight: 600; color: #111827; margin: 0;">${currentRecord.saturasi_oksigen}%</p>
            </div>` : ''}
        `;
        document.getElementById('modalVitals').innerHTML = vitalsHTML;
        
        // Diagnosis
        const diagnosisHTML = `
            <div style="display: inline-flex; align-items: center; gap: 10px; padding: 12px 16px; background: #DBEAFE; border: 1px solid #93C5FD; border-radius: 8px;">
                <span style="font-size: 16px; font-weight: 600; color: #1E40AF;">${currentRecord.diagnosis_utama || 'No diagnosis'}</span>
                ${currentRecord.kode_diagnosis ? `<span style="font-size: 13px; font-family: monospace; color: #3B82F6; opacity: 0.8;">${currentRecord.kode_diagnosis}</span>` : ''}
            </div>
        `;
        document.getElementById('modalDiagnosis').innerHTML = diagnosisHTML;
        document.getElementById('modalTreatment').textContent = currentRecord.rencana_tindakan || 'No treatment plan recorded';
        
        // Prescriptions
        const prescriptions = currentRecord.resep_obat || [];
        document.getElementById('rxCount').textContent = `(${prescriptions.length})`;
        
        if (prescriptions.length > 0) {
            const rxHTML = prescriptions.map(rx => `
                <div style="background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 8px; padding: 16px;">
                    <p style="font-size: 15px; font-weight: 600; color: #111827; margin: 0 0 8px 0;">${rx.medication}</p>
                    <p style="font-size: 13px; color: #6B7280; margin: 0;">${rx.dosage} • ${rx.frequency} • ${rx.duration}</p>
                    ${rx.notes ? `<p style="font-size: 13px; color: #3B82F6; margin: 8px 0 0 0;">${rx.notes}</p>` : ''}
                </div>
            `).join('');
            document.getElementById('modalPrescriptions').innerHTML = rxHTML;
        } else {
            document.getElementById('modalPrescriptions').innerHTML = '<p style="font-size: 14px; color: #9CA3AF;">No prescriptions</p>';
        }
        
        // Lab Results & Notes
        document.getElementById('modalLabResults').textContent = currentRecord.hasil_lab || 'No lab results available';
        document.getElementById('modalDoctorNotes').textContent = currentRecord.catatan_dokter || 'No additional notes';
        
        // Status
        const statusColors = {
            draft: 'background: #F3F4F6; color: #374151;',
            completed: 'background: #DBEAFE; color: #1E40AF;',
            reviewed: 'background: #D1FAE5; color: #065F46;'
        };
        const statusLabels = {
            draft: 'Draft',
            completed: 'Completed',
            reviewed: 'Reviewed'
        };
        document.getElementById('modalStatus').innerHTML = `<span style="padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 500; ${statusColors[currentRecord.status] || statusColors.draft}">${statusLabels[currentRecord.status] || currentRecord.status}</span>`;
        
        // Show modal
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    } catch (error) {
        console.error('Error loading medical record:', error);
        alert('Failed to load medical record details. Please try again.');
    }
}

function closeModal() {
    modal.style.display = 'none';
    document.body.style.overflow = '';
}

function toggleSection(section) {
    const content = document.getElementById(section + 'Content');
    const icon = document.getElementById(section + 'Icon');
    
    if (content.style.display === 'none') {
        content.style.display = 'block';
        icon.innerHTML = '<path d="m18 15-6-6-6 6"></path>';
    } else {
        content.style.display = 'none';
        icon.innerHTML = '<path d="m6 9 6 6 6-6"></path>';
    }
}

document.getElementById('closeModalBtn').addEventListener('click', closeModal);
modal.addEventListener('click', (e) => {
    if (e.target === modal) closeModal();
});

document.addEventListener('click', (e) => {
    if (!e.target.closest('.patient-search-wrapper')) {
        dropdown.style.display = 'none';
    }
});
</script>
@endsection
