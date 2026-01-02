<section class="space-y-6" x-data="{ showConfirmModal: false }">
    <header class="mb-8">
        <h2 class="text-xl font-black text-red-600 uppercase tracking-widest">
            {{ __('Delete Account') }}
        </h2>
        <p class="mt-2 text-sm text-slate-500 font-bold leading-relaxed">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. This action is irreversible.') }}
        </p>
    </header>

    <div class="p-6 bg-red-50 rounded-[2rem] border border-red-100">
        <p class="text-sm text-red-800 font-bold mb-6">
            {{ __('Before deleting your account, please ensure you have downloaded any data or information that you wish to retain.') }}
        </p>

        <button type="button" @click="showConfirmModal = true"
            class="h-14 px-10 bg-red-600 text-white font-black rounded-2xl shadow-xl shadow-red-100 hover:bg-red-700 transition-all active:scale-95 uppercase tracking-widest text-xs">
            {{ __('Delete Account') }}
        </button>
    </div>

    <!-- Custom Alpine.js Delete Modal -->
    <template x-teleport="body">
        <div x-show="showConfirmModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            style="display: none;">

            <div @click.away="showConfirmModal = false" x-show="showConfirmModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                class="relative bg-white rounded-[2.5rem] shadow-2xl p-8 md:p-12 text-center flex flex-col items-center gap-8 border border-slate-50 w-full max-w-md">

                <div
                    class="w-24 h-24 bg-red-50 text-red-600 rounded-[2rem] flex items-center justify-center shadow-inner">
                    <span class="material-symbols-outlined text-5xl">person_off</span>
                </div>

                <div class="flex flex-col gap-3">
                    <h3 class="text-3xl font-black text-[#0f172a] tracking-tight">Are you sure?</h3>
                    <p class="text-slate-500 font-bold leading-relaxed px-4">
                        Please enter your password to confirm you want to permanently delete your account.
                    </p>
                </div>

                <form method="post" action="{{ route('profile.destroy') }}" class="w-full space-y-6">
                    @csrf
                    @method('delete')

                    <div class="space-y-2 text-left">
                        <label for="password"
                            class="text-[#0f172a] text-[10px] font-black uppercase tracking-widest block">{{ __('Password') }}</label>
                        <input id="password" name="password" type="password"
                            class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-red-600 focus:ring-4 focus:ring-red-100 px-6 text-[#0f172a] transition-all outline-none font-bold"
                            placeholder="Type your password...">
                        @error('password', 'userDeletion')
                            <p class="text-xs text-red-600 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 w-full pt-4">
                        <button @click="showConfirmModal = false" type="button"
                            class="flex-1 h-16 bg-slate-50 text-[#0f172a] font-black rounded-2xl hover:bg-slate-100 transition-all uppercase tracking-widest text-xs">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit"
                            class="flex-1 h-16 bg-red-600 text-white font-black rounded-2xl hover:bg-red-700 shadow-xl shadow-red-100 transition-all uppercase tracking-widest text-xs">
                            {{ __('Delete Account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</section>
