<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Services\MedicalRecordService;

class MedicalRecordsController extends Controller
{
    protected $service;

    public function __construct(MedicalRecordService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $patients = $this->service->getAllPatients();
        return view('app.medical_record.medical_records', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required',
            'record_type' => 'required|string',
            'description' => 'required|string',
            'record_date' => 'required|date',
            'medical_record_file'  => 'nullable|mimes:pdf|max:4096', // 4 MB
        ]);

        $validated['medical_record_file'] = $request->file('medical_record_file');

        // dd($validated);

        try {
            $this->service->createMedicalRecord($validated);
            return response()->json(['message' => 'Medical record created successfully!']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create medical record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function list(Request $request)
    { 
        $records = $this->service->getMedicalRecordsForDataTable($request);

        return DataTables::of($records)
            ->addColumn('name', fn($record) => $record->patient->name ?? 'N/A')
            ->addColumn('record_type', fn($record) => $record->record_type)
            ->addColumn('description', fn($record) => $record->description)
            ->addColumn('record_date', fn($record) => date('M d, Y', strtotime($record->record_date)))
            ->addColumn('action', function ($record) {
                $buttons = '';
                $user = auth()->user();

                $buttons .= '<div class="ms-auto">';
                if($user->hasAnyRole(['admin', 'doctor'])) {
                    $buttons .= '<button class="btn btn-sm btn-warning editMedicalRecord" data-id="' . $record->id . '">Edit</button> ';
                    $buttons .= '<button class="btn btn-sm btn-danger deleteMedicalRecord" data-id="' . $record->id . '">Delete</button> ';
                }
                $buttons .= '<button class="btn btn-primary btn-sm" data-id="' . $record->id . '">View</button>';
                $buttons .= '</div>';

                return $buttons;
            })
            ->filter(function ($query) use ($request) {
                // Global search
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
