<x-layouts.app title="Dashboard">

    <h2>Welcome</h2>
    <p>Your email: {{ auth()->user()->email }}</p>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <section id="core-functionalities" class="mb-5">
        <h2>Upcoming Appointments</h2>
        @if($appointments->isEmpty())
        <p>No upcoming appointments.</p>
        @else
        <ul class="list-group">
            @foreach($appointments as $appt)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        {{ $appt->patient->name ?? 'No patient' }} - {{ $appt->title ?? 'No title' }}
                            <span class="badge bg-primary">
                                {{ date('M d, Y', strtotime($appt->appointment_date)) }}
                                {{ date('H:i A', strtotime($appt->appointment_time)) }}
                        </span>                    
                    </div>
                </li>
            @endforeach
        </ul>

        @endif
    </section>

    <section id="core-functionalities">
        <h2>Notifications</h2>
        @if($notifications->isEmpty())
        <p>No Notifications.</p>
        @else
        <ul class="list-group">
            @foreach($notifications as $notification)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <span>{{ $notification->message }}
                            @php
                                $fileUrl = null;
                                if ($notification->medicalRecordsFiles && $notification->medicalRecordsFiles->count() > 0) {
                                    // Get latest medical record
                                    $latestRecord = $notification->medicalRecordsFiles->sortByDesc('created_at')->first();

                                    // Get latest file from that record
                                    if ($latestRecord->files && $latestRecord->files->count() > 0) {
                                        $latestFile = $latestRecord->files->sortByDesc('created_at')->first();
                                        $fileUrl = asset('storage/' . $latestFile->file_path);
                                    }
                                }
                            @endphp
                            @if($fileUrl)
                                <span style="cursor: pointer"
                                        class="badge bg-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#pdfModal" 
                                        data-pdf="{{ $fileUrl }}" 
                                        data-id="{{ $notification->id }}">
                                      <i class="bi bi-eye"></i> View
                                </span>
                            @else
                                <span class="badge bg-secondary">No file</span>
                            @endif
                        </span>
                    </div>
                </li>
                @endforeach
  
        </ul>
        @endif
    </section>

    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Medical Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfFrame" src="" width="100%" height="600px" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('js/dashboard.js') }}"></script>
    @endpush

</x-layouts.app>