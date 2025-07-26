<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\TimeLog;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $timeLogs = ($user->role === 'admin')
            ? TimeLog::with('user')->orderBy('created_at', 'desc')->get()
            : TimeLog::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        $query = Product::query();

        // If search query is provided
        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                ->orWhere('serial_number', 'like', '%' . $search . '%')
                ->orWhere('tracking_number', 'like', '%' . $search . '%')
                ->orWhere('tracing_number', 'like', '%' . $search . '%')
                ->orWhere('module_location', 'like', '%' . $search . '%');
            });
        }

        // Apply order by module_location priority + latest created_at
        $query->orderByRaw("
            FIELD(module_location, 'Order', 'Received', 'Unreceived', 'Labeling', 'Stockroom')
        ")->orderBy('created_at', 'desc');

        // Finally, paginate:
        $products = $query->paginate(4)->withQueryString();

        return view('dashboard', compact('timeLogs', 'products'));
    }
}





