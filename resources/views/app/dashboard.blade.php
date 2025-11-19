<x-layouts.app title="Dashboard">

    <h2>Welcome</h2>
    <p>Your email: {{ auth()->user()->email }}</p>

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
                <div>{{ $notification->message }}</div>
            </li>

            @endforeach
        </ul>
        @endif
    </section>

</x-layouts.app>