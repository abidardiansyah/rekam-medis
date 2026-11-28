<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRekamMedisRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'dokter_id' => 'required|exists:dokters,id',
            'tanggal_kunjungan' => 'required|date',
            'keluhan_utama' => 'required|string',
            'tekanan_darah' => 'nullable|string',
            'suhu_badan' => 'nullable|numeric',
            'nadi' => 'nullable|integer',
            'pernapasan' => 'nullable|integer',
            'berat_badan' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
            'saturasi_oksigen' => 'nullable|integer',
            'diagnosa' => 'required|string',
            'diagnosa_code' => 'nullable|string',
            'rencana_tindakan' => 'nullable|string',
            'hasil_lab' => 'nullable|string',
            'catatan_dokter' => 'nullable|string',
            'status' => 'required|in:draft,completed,reviewed'
        ];
    }
}
