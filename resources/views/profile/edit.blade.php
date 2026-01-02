<x-app-layout>
    <x-slot name="header">
        Profile Settings
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 mb-20">
        <!-- Header Desc -->
        <div class="flex flex-col gap-2">
            <h3 class="text-3xl font-black text-[#0f172a] tracking-tight">Account Preferences</h3>
            <p class="text-slate-500 font-bold leading-relaxed">Manage your public profile, security settings, and
                personal data.</p>
        </div>

        <div class="p-8 sm:p-12 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-8 sm:p-12 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-8 sm:p-12 bg-white rounded-[2.5rem] border border-red-50 shadow-sm overflow-hidden">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
