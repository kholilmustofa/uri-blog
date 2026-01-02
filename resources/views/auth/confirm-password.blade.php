<x-guest-layout>
    <x-slot name="title">Confirm access</x-slot>
    <x-slot name="subtitle">Password required to proceed</x-slot>

    <div class="mb-8 text-sm text-slate-500 font-bold leading-relaxed">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <!-- Password -->
        <div>
            <label for="password"
                class="text-[#0f172a] text-xs font-black uppercase tracking-widest block mb-2">{{ __('Password') }}</label>
            <input id="password"
                class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] placeholder-slate-400 transition-all outline-none font-bold shadow-sm"
                type="password" name="password" placeholder="••••••••" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <button type="submit"
                class="w-full h-14 flex items-center justify-center bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 transform active:scale-[0.98] transition-all hover:-translate-y-0.5 uppercase tracking-widest text-sm">
                {{ __('Confirm Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>
