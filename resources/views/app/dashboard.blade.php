<x-layouts.app title="Dashboard">

    <h2>Welcome</h2>
    <p>Your email: {{ auth()->user()->email }}</p>

    <section id="core-functionalities">
        <h2>Upcoming Appointments</h2>
        @if($appointments->isEmpty())
        <p>No upcoming appointments.</p>
        @else
        <ul>
            @foreach($appointments as $appt)
            <li>
                {{ date('M d, Y', strtotime($appt->appointment_date)) }} {{ date('H:i', strtotime($appt->appointment_time)) }} 
                - {{ $appt->title ?? 'No title' }}
            </li>

            @endforeach
        </ul>
        @endif
    </section>

    <section id="core-functionalities">
        <h2>Notifications</h2>
        @if($appointments->isEmpty())
        <p>No Notifications.</p>
        @else
        <ul>
            @foreach($appointments as $appt)
            <li>
                {{ date('M d, Y', strtotime($appt->appointment_date)) }} {{ date('H:i', strtotime($appt->appointment_time)) }} 
                - {{ $appt->title ?? 'No title' }}
            </li>

            @endforeach
        </ul>
        @endif
    </section>

</x-layouts.app>