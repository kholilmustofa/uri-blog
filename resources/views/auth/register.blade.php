<x-guest-layout>
    <x-slot name="title">Create your account</x-slot>
    <x-slot name="subtitle">Or <a href="{{ route('login') }}"
            class="font-black text-indigo-600 hover:text-indigo-700 transition-colors">sign in to existing
            account</a></x-slot>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div class="flex flex-col gap-2.5">
            <label for="name" class="text-[#0f172a] text-xs font-black uppercase tracking-widest">
                Full Name
            </label>
            <input id="name" name="name" type="text" autocomplete="name" required autofocus
                value="{{ old('name') }}"
                class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] placeholder-slate-400 transition-all outline-none font-bold shadow-sm">
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Username -->
        <div class="flex flex-col gap-2.5">
            <label for="username" class="text-[#0f172a] text-xs font-black uppercase tracking-widest">
                Username
            </label>
            <input id="username" name="username" type="text" autocomplete="username" required
                value="{{ old('username') }}"
                class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] placeholder-slate-400 transition-all outline-none font-bold shadow-sm">
            <x-input-error :messages="$errors->get('username')" class="mt-1" />
        </div>

        <!-- Email -->
        <div class="flex flex-col gap-2.5">
            <label for="email" class="text-[#0f172a] text-xs font-black uppercase tracking-widest">
                Email Address
            </label>
            <input id="email" name="email" type="email" autocomplete="email" required
                value="{{ old('email') }}"
                class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] placeholder-slate-400 transition-all outline-none font-bold shadow-sm">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="flex flex-col gap-2.5">
            <label for="password" class="text-[#0f172a] text-xs font-black uppercase tracking-widest">
                Password
            </label>
            <input id="password" name="password" type="password" autocomplete="new-password" required
                class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] placeholder-slate-400 transition-all outline-none font-bold shadow-sm">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="flex flex-col gap-2.5">
            <label for="password_confirmation" class="text-[#0f172a] text-xs font-black uppercase tracking-widest">
                Confirm Password
            </label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                required
                class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] placeholder-slate-400 transition-all outline-none font-bold shadow-sm">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-4">
            <button type="submit"
                class="w-full h-14 flex items-center justify-center bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 transform active:scale-[0.98] transition-all hover:-translate-y-0.5 uppercase tracking-widest text-sm">
                Create Account
            </button>
        </div>
    </form>
</x-guest-layout>
