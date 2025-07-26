<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeLog;
use Illuminate\Support\Facades\Auth;

class TimeLogController extends Controller
{
    public function clockIn()
    {
        TimeLog::create([
            'user_id' => Auth::id(),
            'clock_in_time' => now(),
        ]);

        return back()->with('success', 'Clock In recorded.');
    }

    public function clockOut()
    {
        $timeLog = TimeLog::where('user_id', Auth::id())
            ->whereNull('clock_out_time')
            ->latest()
            ->first();

        if ($timeLog) {
            $timeLog->update([
                'clock_out_time' => now(),
            ]);

            return back()->with('success', 'Clock Out recorded.');
        }

        return back()->with('error', 'No active clock-in found.');
    }
    public function adminLogs()
        {
            $timeLogs = \App\Models\TimeLog::with('user')->orderBy('created_at', 'desc')->get();

            return view('admin.time-logs', compact('timeLogs'));
        }

}
