<?php

namespace App\Http\Controllers;

use App\Models\DailyLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyLogController extends Controller
{
    public function showDashboard()
    {
        return view('dashboard');
    }

    public function showDailyLog(Request $request)
    {
        if (Auth::user()->id == 1) {
            $query = DailyLog::query();
            if ($request->filled('status')) {
                $query->where('status', 'like', '%' . $request->status . '%');
            }

            $logs = $query->paginate(5);
            return view('dailyLogs.listDailyLogs', compact('logs'));
        } else {
            $logs = DailyLog::where('employee_id', Auth::id())->get();
            $logs = DailyLog::query();
            if ($request->filled('status')) {
                $logs->where('status', 'like', '%' . $request->status . '%');
            }

            $logs = $logs->paginate(5);
            return view('dailyLogs.listDailyLogs', compact('logs'));
        }
    }

    public function create()
    {
        return view('dailyLogs.createForm');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'file' => 'nullable|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('daily_logs', 'public');
        }

        DailyLog::create([
            'employee_id' => Auth::id(),
            'description' => $request->description,
            'file' => $filePath,
        ]);

        return redirect()->route('dailyLogs')->with('success', 'Log harian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $updateData = DailyLog::find($id);
        return view('dailyLogs.editForm')->with([
            'dailyLog' => $updateData
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'description' => 'required',
            'file' => 'nullable|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        // Find the log
        $log = DailyLog::find($id);

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file if it exists
            // if ($log->file) {
            //     Storage::disk('public')->delete($log->file);
            // }

            // Store the new file and get the path
            $filePath = $request->file('file')->store('daily_logs', 'public');
        } else {
            // If no new file is uploaded, keep the old file path
            $filePath = $log->file;
        }

        // Update the log with the new data        
        $log->update([
            'description' => $request->description,
            'file' => $filePath,
        ]);

        return redirect()->route('dailyLogs')->with('success', 'Log harian berhasil diupdate.');
    }

    public function destroy($id)
    {
        $data = DailyLog::find($id);
        $data->delete($id);
        return redirect()->route('dailyLogs')->with('success', 'Log harian berhasil dihapus.');
    }

    public function verifyLog(DailyLog $dailyLog, $status)
    {
        if (in_array($status, ['Approved', 'Rejected'])) {
            $dailyLog->update(['status' => $status]);
        }
    }

    public function approve(DailyLog $log) {}

    public function reject(DailyLog $log) {}
}
