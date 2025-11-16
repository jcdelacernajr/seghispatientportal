<x-layouts.app title="Page Not Found">
    <div class="text-center mt-5">
        <h1 class="display-1">404</h1>
        <h3>Oops! Page not found.</h3>
        <p>The page you are looking for does not exist.</p>
        <a href="{{ route('dashboard') ?? route('login') }}" class="btn btn-primary mt-3">Go Back Home</a>
    </div>
</x-layouts.app>
