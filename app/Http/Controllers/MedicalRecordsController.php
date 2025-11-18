<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use Yajra\DataTables\Facades\DataTables;

class MedicalRecordsController extends Controller
{
    public function index()
    {
        return view('app.medical_records');
    }

    public function list(Request $request)
    {
        $records = MedicalRecord::with('patient');

        // Restrict to logged-in patient's own records
        if (auth()->user()->hasRole('patient')) {
            $records->where('patient_id', auth()->user()->patient->id ?? 0);
        }

       // dd(auth()->user()->role);

        return DataTables::of($records)
            ->addColumn('name', function ($record) {
                return $record->patient->name ?? 'N/A';
            })
            ->addColumn('record_type', function ($record) {
                return $record->record_type;
            })
            ->addColumn('description', function ($record) {
                return $record->description;
            })
            ->addColumn('record_date', function ($record) {
                return date('M d, Y', strtotime($record->record_date));
            })
            ->addColumn('action', function ($record) {
                return '<button class="btn btn-primary btn-sm" data-id="' . $record->id . '">View</button>';
            })
             ->filter(function ($query) use ($request) {
                // Global search filter
                if ($search = $request->input('search.value')) {
                    $query->where(function ($q) use ($search) {
                        $q->where('record_type', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('patient', function ($q2) use ($search) {
                            $q2->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                    });
                }

                // Date range filter
                if ($start = $request->input('start_date')) {
                    $query->whereDate('record_date', '>=', $start);
                }
                if ($end = $request->input('end_date')) {
                    $query->whereDate('record_date', '<=', $end);
                }
                if ($recordType = $request->input('record_type')) {
                    $query->where('record_type', $recordType);
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
