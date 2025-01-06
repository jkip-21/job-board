<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel Job board</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles / Scripts -->

</head>

<body
    class="mx-auto mt-10 max-w-2xl bg-gradient-to-r from-indigo-100 from-10% via-sky-100 via-30% to-emerald-100 to-90%  text-slate-700">
    {{-- getting the current signed in user if not signed in it will output guest --}}
    {{-- {{ auth()->user()->name ?? 'Guest' }} --}}
    <nav class="mb-8 flex justify-between text-lg font-medium">
        <ul>
            <li>
                <a href="{{ route('jobs.index') }}">Home</a>
            </li>
        </ul>
        <ul class="flex space-x-2">
            @auth
                <li>
                    <a href="{{ route('my_job_applications.index') }}">{{ auth()->user()->name ?? 'Guest' }}:
                        Applications</a>

                </li>
                <li>
                    <a href="{{ route('my_jobs.index') }}">My Jobs</a>
                </li>
                <li>
                    <form action="{{ route('auth.logout') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button>Logout</button>
                    </form>
                </li>
            @else
                <a href="{{ route('login') }}">Sign in</a>
            @endauth
        </ul>
    </nav>
    @if (session('success'))
        <div role="alert" class=" rounded-md border-l-4 bg-green-100 text-green-700 p-4  my-8">

            <p class="font-bold">Success!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div role="alert" class=" rounded-md border-l-4 bg-red-100 text-red-500 p-4  my-8">
            <p class="font-bold">Error!</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif
    {{ $slot }}


</body>

</html>
