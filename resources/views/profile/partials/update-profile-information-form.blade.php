@push('style')
@endpush

<section>
    <header class="mb-8">
        <h2 class="text-xl font-black text-[#0f172a] uppercase tracking-widest">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-2 text-sm text-slate-500 font-bold leading-relaxed">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="flex flex-col sm:flex-row items-center gap-8 pb-8 border-b border-slate-50">
            <div class="relative group">
                <div
                    class="w-32 h-32 rounded-full overflow-hidden border-4 border-slate-50 shadow-sm transition-all group-hover:border-indigo-100">
                    <img id="avatar-preview" class="w-full h-full object-cover"
                        src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=EEF2FF&color=4F46E5' }}"
                        alt="{{ $user->name }}">
                </div>
                <label for="avatar"
                    class="absolute bottom-0 right-0 w-10 h-10 bg-white border border-slate-100 rounded-xl flex items-center justify-center text-indigo-600 shadow-lg cursor-pointer hover:bg-indigo-50 transition-all">
                    <span class="material-symbols-outlined text-xl">photo_camera</span>
                    <input id="avatar" name="avatar" type="file" class="hidden"
                        accept="image/png, image/jpeg, image/jpg">
                </label>
            </div>
            <div class="flex-1 text-center sm:text-left">
                <h4 class="text-lg font-black text-[#0f172a]">Public Profile Photo</h4>
                <p class="text-sm text-slate-400 font-medium">PNG or JPG. Max 2MB.</p>
                @error('avatar')
                    <p class="mt-2 text-xs text-red-600 font-bold">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-2">
                <label for="name"
                    class="text-[#0f172a] text-[10px] font-black uppercase tracking-widest block">{{ __('Full Name') }}</label>
                <input id="name" name="name" type="text"
                    class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] transition-all outline-none font-bold"
                    value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name')
                    <p class="text-xs text-red-600 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="username"
                    class="text-[#0f172a] text-[10px] font-black uppercase tracking-widest block">{{ __('Username') }}</label>
                <input id="username" name="username" type="text"
                    class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] transition-all outline-none font-bold"
                    value="{{ old('username', $user->username) }}" required autocomplete="username">
                @error('username')
                    <p class="text-xs text-red-600 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="space-y-2">
            <label for="email"
                class="text-[#0f172a] text-[10px] font-black uppercase tracking-widest block">{{ __('Email Address') }}</label>
            <input id="email" name="email" type="email"
                class="w-full h-14 rounded-2xl bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 px-6 text-[#0f172a] transition-all outline-none font-bold"
                value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <p class="text-xs text-red-600 font-bold mt-1">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-amber-50 rounded-2xl border border-amber-100">
                    <p class="text-sm text-amber-800 font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">warning</span>
                        {{ __('Your email address is unverified.') }}
                    </p>
                    <button form="send-verification"
                        class="mt-2 text-xs text-amber-900 font-black uppercase tracking-widest hover:underline">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-black text-xs text-green-600 uppercase tracking-widest">
                            {{ __('A new verification link has been sent.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                class="h-14 px-10 bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all active:scale-95 uppercase tracking-widest text-xs flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">save</span>
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="flex items-center gap-2 text-green-600 font-bold text-sm">
                    <span class="material-symbols-outlined text-lg">check_circle</span>
                    {{ __('Saved successfully.') }}
                </div>
            @endif
        </div>
    </form>
</section>

@push('script')
    <script>
        const input = document.getElementById('avatar');
        const previewPhoto = () => {
            const file = input.files;
            if (file) {
                const fileReader = new FileReader();
                const preview = document.getElementById('avatar-preview');
                fileReader.onload = function(event) {
                    preview.setAttribute('src', event.target.result);
                }
                fileReader.readAsDataURL(file[0]);
            }
        }
        input.addEventListener("change", previewPhoto);
    </script>
@endpush
