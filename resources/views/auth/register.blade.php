<x-guest-layout>
    <x-slot name="title">Create your account</x-slot>
    <x-slot name="subtitle">Or <a href="{{ route('login') }}"
            class="font-medium text-indigo-600 hover:text-indigo-500">sign in to existing account</a></x-slot>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">
                Full Name
            </label>
            <div class="mt-1">
                <input id="name" name="name" type="text" autocomplete="name" required autofocus
                    value="{{ old('name') }}"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Username -->
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700">
                Username
            </label>
            <div class="mt-1">
                <input id="username" name="username" type="text" autocomplete="username" required
                    value="{{ old('username') }}"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">
                Email Address
            </label>
            <div class="mt-1">
                <input id="email" name="email" type="email" autocomplete="email" required
                    value="{{ old('email') }}"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">
                Password
            </label>
            <div class="mt-1">
                <input id="password" name="password" type="password" autocomplete="new-password" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                Confirm Password
            </label>
            <div class="mt-1">
                <input id="password_confirmation" name="password_confirmation" type="password"
                    autocomplete="new-password" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Create Account
            </button>
        </div>
    </form>
</x-guest-layout>
