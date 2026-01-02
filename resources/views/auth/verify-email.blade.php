<x-guest-layout>
    <x-slot name="title">Verify Email</x-slot>
    <x-slot name="subtitle">Almost there...</x-slot>

    <div class="mb-8 text-sm text-slate-500 font-bold leading-relaxed">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 bg-indigo-50 rounded-2xl text-sm font-bold text-indigo-600 border border-indigo-100 italic">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="space-y-6">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                class="w-full h-14 flex items-center justify-center bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 transform active:scale-[0.98] transition-all hover:-translate-y-0.5 uppercase tracking-widest text-sm">
                {{ __('Resend Email') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit"
                class="text-xs font-black text-slate-400 hover:text-red-600 uppercase tracking-widest transition-colors">
                {{ __('Sign Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
