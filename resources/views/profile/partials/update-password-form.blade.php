<section>
    <header class="mb-8">
        <h2 class="text-xl font-black text-[#0f172a] uppercase tracking-widest">
            {{ __('Update Password') }}
        </h2>
        <p class="mt-2 text-sm text-slate-500 font-bold leading-relaxed">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-8">
        @csrf
        @method('put')

        <div class="space-y-2">
            <label for="update_password_current_password"
                class="text-[#0f172a] text-[10px] font-black uppercase tracking-widest block">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password"
                class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] transition-all outline-none font-bold"
                autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <p class="text-xs text-red-600 font-bold mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="update_password_password"
                class="text-[#0f172a] text-[10px] font-black uppercase tracking-widest block">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password"
                class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] transition-all outline-none font-bold"
                autocomplete="new-password">
            @error('password', 'updatePassword')
                <p class="text-xs text-red-600 font-bold mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="update_password_password_confirmation"
                class="text-[#0f172a] text-[10px] font-black uppercase tracking-widest block">{{ __('Confirm New Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] transition-all outline-none font-bold"
                autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <p class="text-xs text-red-600 font-bold mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                class="h-14 px-10 bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all active:scale-95 uppercase tracking-widest text-xs flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">lock_reset</span>
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="flex items-center gap-2 text-green-600 font-bold text-sm">
                    <span class="material-symbols-outlined text-lg">check_circle</span>
                    {{ __('Password updated.') }}
                </div>
            @endif
        </div>
    </form>
</section>
