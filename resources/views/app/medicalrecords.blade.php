<x-layouts.app title="Medical records">

    <h2>Welcome, {{ auth()->user()->name }}!</h2>
    <p>Your email: {{ auth()->user()->email }}</p>

    <p>Here are your medical records.</p>
  

</x-layouts.app>