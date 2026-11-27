<?php

namespace App\Http\Controllers;

use App\Models\WorkSchedule;
use App\Models\ScheduleAssignment;
use App\Models\Dokter;
use App\Models\Perawat;
use Illuminate\Http\Request;

class WorkScheduleController extends Controller
{
    public function index()
    {
        $schedules = WorkSchedule::with('assignments.assignable')->get();
        return view('work-schedules.index', compact('schedules'));
    }

    public function create()
    {
        return view('work-schedules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:work_schedules,code',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'color' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        WorkSchedule::create($validated);

        return redirect()->route('work-schedules.index')->with('success', 'Work schedule created successfully');
    }

    public function edit(WorkSchedule $workSchedule)
    {
        return view('work-schedules.edit', compact('workSchedule'));
    }

    public function update(Request $request, WorkSchedule $workSchedule)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:work_schedules,code,' . $workSchedule->id,
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'color' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        $workSchedule->update($validated);

        return redirect()->route('work-schedules.index')->with('success', 'Work schedule updated successfully');
    }

    public function destroy(WorkSchedule $workSchedule)
    {
        $workSchedule->delete();
        return redirect()->route('work-schedules.index')->with('success', 'Work schedule deleted successfully');
    }

    public function assign(Request $request, WorkSchedule $workSchedule)
    {
        $dokters = Dokter::where('status', 'aktif')->get();
        $perawats = Perawat::where('status', 'aktif')->get();
        $assignments = $workSchedule->assignments()->with('assignable')->get();
        
        return view('work-schedules.assign', compact('workSchedule', 'dokters', 'perawats', 'assignments'));
    }

    public function storeAssignment(Request $request, WorkSchedule $workSchedule)
    {
        $validated = $request->validate([
            'staff_type' => 'required|in:dokter,perawat',
            'staff_id' => 'required|integer',
            'days' => 'required|array|min:1',
            'days.*' => 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'room' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        $assignableType = $validated['staff_type'] === 'dokter' ? Dokter::class : Perawat::class;

        foreach ($validated['days'] as $day) {
            ScheduleAssignment::updateOrCreate(
                [
                    'work_schedule_id' => $workSchedule->id,
                    'assignable_type' => $assignableType,
                    'assignable_id' => $validated['staff_id'],
                    'day_of_week' => $day
                ],
                [
                    'room' => $validated['room'],
                    'status' => $validated['status']
                ]
            );
        }

        return redirect()->route('work-schedules.assign', $workSchedule)->with('success', 'Assignment created successfully');
    }

    public function destroyAssignment(ScheduleAssignment $assignment)
    {
        $scheduleId = $assignment->work_schedule_id;
        $assignment->delete();
        
        return redirect()->route('work-schedules.assign', $scheduleId)->with('success', 'Assignment deleted successfully');
    }
}
