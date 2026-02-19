@extends('layouts.app')



@section('content')
<div id="login-page" class="min-h-screen bg-gray-100 flex flex-col justify-center sm:py-12">
    <div class="relative py-3 sm:max-w-xl sm:mx-auto">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-700 to-indigo-500 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl"></div>
        <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
            <div class="max-w-md mx-auto">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Admin Login</h1>
                </div>
                <div class="divide-y divide-gray-200">
                    <form method="POST" action="{{ route('login') }}" class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                        @csrf
                        <div class="relative">
                            <input autocomplete="off" id="email" name="email" type="email" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-rose-600 @error('email') border-red-500 @enderror" placeholder="Alamat Email" required value="{{ old('email') }}" />
                            <label for="email" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Alamat Email</label>
                            @error('email')
                                <span class="text-red-500 text-sm" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="relative">
                            <input autocomplete="off" id="password" name="password" type="password" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-rose-600 @error('password') border-red-500 @enderror" placeholder="Password" required />
                            <label for="password" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Password</label>
                            @error('password')
                                <span class="text-red-500 text-sm" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember" class="ml-2 block text-sm text-gray-900">
                                    Ingat Saya
                                </label>
                            </div>
                        </div>
                        <div class="relative">
                            <button type="submit" class="w-full bg-indigo-600 text-white rounded-md px-2 py-1 text-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Login
                            </button>
                        </div>
                        <div class="text-center mt-4">
                            @if (Route::has('password.request'))
                                <a class="text-sm font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('password.request') }}">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
