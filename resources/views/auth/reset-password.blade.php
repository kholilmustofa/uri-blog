<x-guest-layout>
    <x-slot name="title">Update Password</x-slot>
    <x-slot name="subtitle">Secure your account now</x-slot>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email"
                class="text-[#0f172a] text-xs font-black uppercase tracking-widest block mb-2">{{ __('Email Address') }}</label>
            <input id="email"
                class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] placeholder-slate-400 transition-all outline-none font-bold shadow-sm"
                type="email" name="email" :value="old('email', $request->email)" placeholder="Enter your email"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password"
                class="text-[#0f172a] text-xs font-black uppercase tracking-widest block mb-2">{{ __('New Password') }}</label>
            <input id="password"
                class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] placeholder-slate-400 transition-all outline-none font-bold shadow-sm"
                type="password" name="password" placeholder="••••••••" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation"
                class="text-[#0f172a] text-xs font-black uppercase tracking-widest block mb-2">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation"
                class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] placeholder-slate-400 transition-all outline-none font-bold shadow-sm"
                type="password" name="password_confirmation" placeholder="••••••••" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <button type="submit"
                class="w-full h-14 flex items-center justify-center bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 transform active:scale-[0.98] transition-all hover:-translate-y-0.5 uppercase tracking-widest text-sm">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>
