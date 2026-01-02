<x-guest-layout>
    <x-slot name="title">Sign in to your account</x-slot>
    <x-slot name="subtitle">Or <a href="{{ route('register') }}"
            class="font-black text-indigo-600 hover:text-indigo-700 transition-colors">create a new account</a></x-slot>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email or Username -->
        <div class="flex flex-col gap-2.5">
            <label for="user_cred" class="text-[#0f172a] text-xs font-black uppercase tracking-widest">
                Email or Username
            </label>
            <input id="user_cred" name="user_cred" type="text" autocomplete="username" required autofocus
                value="{{ old('user_cred') }}"
                class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] placeholder-slate-400 transition-all outline-none font-bold shadow-sm">
            <x-input-error :messages="$errors->get('user_cred')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="flex flex-col gap-2.5">
            <label for="password" class="text-[#0f172a] text-xs font-black uppercase tracking-widest">
                Password
            </label>
            <input id="password" name="password" type="password" autocomplete="current-password" required
                class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] placeholder-slate-400 transition-all outline-none font-bold shadow-sm">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="flex items-center justify-between">
            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" name="remember" type="checkbox"
                    class="h-5 w-5 text-indigo-600 focus:ring-indigo-100 border-slate-200 rounded-lg">
                <label for="remember_me" class="ml-3 block text-sm text-[#0f172a] font-bold">
                    Remember me
                </label>
            </div>

            <!-- Forgot Password -->
            @if (Route::has('password.request'))
                <div class="text-sm">
                    <a href="{{ route('password.request') }}"
                        class="font-bold text-indigo-600 hover:text-indigo-700 transition-colors">
                        Forgot password?
                    </a>
                </div>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full h-14 flex items-center justify-center bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 transform active:scale-[0.98] transition-all hover:-translate-y-0.5 uppercase tracking-widest text-sm">
                Sign in
            </button>
        </div>
    </form>
</x-guest-layout>
