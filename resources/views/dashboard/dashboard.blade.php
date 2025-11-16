<x-layouts.app title="Dashboard">
    <h2>Welcome, {{ auth()->user()->name }}!</h2>
    <p>Your email: {{ auth()->user()->email }}</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-danger">Logout</button>
    </form>
</x-layouts.app>
