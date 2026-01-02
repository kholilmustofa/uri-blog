<x-guest-layout>
    <x-slot name="title">Reset access</x-slot>
    <x-slot name="subtitle">We'll send you a recovery link</x-slot>

    <div class="mb-8 text-sm text-slate-500 font-bold leading-relaxed">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email"
                class="text-[#0f172a] text-xs font-black uppercase tracking-widest block mb-2">{{ __('Email Address') }}</label>
            <input id="email"
                class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] placeholder-slate-400 transition-all outline-none font-bold shadow-sm"
                type="email" name="email" :value="old('email')" placeholder="Enter your email" required
                autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <button type="submit"
                class="w-full h-14 flex items-center justify-center bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 transform active:scale-[0.98] transition-all hover:-translate-y-0.5 uppercase tracking-widest text-sm">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>

        <div class="text-center pt-4">
            <a href="{{ route('login') }}"
                class="text-sm font-black text-indigo-600 hover:text-indigo-700 transition-colors">
                Back to sign in
            </a>
        </div>
    </form>
</x-guest-layout>
