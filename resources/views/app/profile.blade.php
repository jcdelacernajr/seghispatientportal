<x-layouts.app title="Profile">

    <h2>Welcome, {{ auth()->user()->name }}!</h2>
    <p>Your email: {{ auth()->user()->email }}</p>

    <p>Here are your profile information.</p>
  

</x-layouts.app>