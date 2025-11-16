<x-layouts.app title="Dashboard">

    <h2>Welcome, {{ auth()->user()->name }}!</h2>
    <p>Your email: {{ auth()->user()->email }}</p>

    <section id="core-functionalities">
        <h2>Core Functionalities</h2>
        <ul>
            <li>User Authentication</li>
            <li>Dashboard Overview</li>
            <li>Profile Management</li>
            <li>Appointments (CRUD + AJAX)</li>
            <li>Medical Records</li>
            <li>Notifications / Events</li>
        </ul>
    </section>

    <section id="prototype-features" class="mt-5">
        <h2>Prototype Features</h2>
        <ul>
            <li>Complete CRUD operations using AJAX</li>
            <li>Smooth navigation flow between sections</li>
            <li>Real-time data update simulation</li>
            <li>Backend data may be static or mock data</li>
        </ul>
    </section>

</x-layouts.app>