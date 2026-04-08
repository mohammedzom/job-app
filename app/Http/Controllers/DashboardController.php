<?php

namespace App\Http\Controllers;

use App\Models\JobVacancies;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = JobVacancies::query();

        if ($request->has('filter') && $request->has('search')) {
            $query->where('type', $request->filter)
                ->where('title', 'like', '%'.$request->search.'%')
                ->orWhere('location', 'like', '%'.$request->search.'%')
                ->orWhereHas('company', function ($query) use ($request) {
                    $query->where('name', 'like', '%'.$request->search.'%');
                });
        }

        if ($request->has('search') && ! $request->has('filter')) {
            $query->where('title', 'like', '%'.$request->search.'%')
                ->orWhere('location', 'like', '%'.$request->search.'%')
                ->orWhereHas('company', function ($query) use ($request) {
                    $query->where('name', 'like', '%'.$request->search.'%');
                });
        }

        if ($request->has('filter') && ! $request->has('search')) {
            $query->where('type', $request->filter);
        }

        $jobVacancies = $query->with('company')->latest()->paginate(10)->withQueryString();

        return view('dashboard', compact('jobVacancies'));
    }
}
