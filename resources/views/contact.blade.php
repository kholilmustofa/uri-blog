<x-layout :title="$title">
    @push('style')
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
            rel="stylesheet" />
    @endpush

    <main class="bg-gray-50/50 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-24 items-start">

                <!-- Left Column: Heading & Contact Info -->
                <div class="lg:col-span-5 flex flex-col gap-12">

                    <!-- Page Heading -->
                    <div class="flex flex-col gap-6">
                        <span class="text-indigo-600 font-bold text-sm tracking-widest uppercase block">Contact Us</span>
                        <h2 class="text-5xl md:text-6xl font-black text-gray-900 leading-[1.1] tracking-tight">
                            Let's start a <br><span class="text-indigo-600">conversation.</span>
                        </h2>
                        <p class="text-xl text-gray-600 leading-relaxed max-w-md">
                            Have a question about a post, a suggestion for a topic, or just want to say hi? We're here
                            to help you.
                        </p>
                    </div>

                    <!-- Contact Details Cards -->
                    <div class="flex flex-col gap-5">
                        <!-- Email Card -->
                        <div
                            class="flex items-start gap-5 p-6 rounded-2xl bg-white border border-gray-100 shadow-sm hover:border-indigo-200 transition-all group">
                            <div
                                class="p-4 rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                <span class="material-symbols-outlined text-3xl">mail</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Email Us</h3>
                                <p class="text-gray-500 text-sm mt-1">For general inquiries and support</p>
                                <a class="block mt-2 font-semibold text-indigo-600 hover:text-indigo-700 transition-colors"
                                    href="mailto:hello@uriblog.com">hello@uriblog.com</a>
                            </div>
                        </div>

                        <!-- Location Card -->
                        <div
                            class="flex items-start gap-5 p-6 rounded-2xl bg-white border border-gray-100 shadow-sm hover:border-indigo-200 transition-all group">
                            <div
                                class="p-4 rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                <span class="material-symbols-outlined text-3xl">location_on</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Office</h3>
                                <p class="text-gray-500 text-sm mt-1">Come visit our friendly team</p>
                                <p class="mt-2 font-semibold text-gray-700 leading-relaxed">123 Blog Street, Web City,
                                    Digital State 90210</p>
                            </div>
                        </div>
                    </div>

                    <!-- Socials -->
                    <div class="pt-8 border-t border-gray-200">
                        <p class="font-bold text-gray-900 mb-6">Follow our journey</p>
                        <div class="flex gap-4">
                            <a class="w-12 h-12 flex items-center justify-center rounded-xl bg-white border border-gray-200 text-gray-400 hover:text-indigo-600 hover:border-indigo-600 hover:bg-indigo-50 transition-all"
                                href="#">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-6 w-6 fill-current" viewbox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z">
                                    </path>
                                </svg>
                            </a>
                            <a class="w-12 h-12 flex items-center justify-center rounded-xl bg-white border border-gray-200 text-gray-400 hover:text-indigo-600 hover:border-indigo-600 hover:bg-indigo-50 transition-all"
                                href="#">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-6 w-6 fill-current" viewbox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z">
                                    </path>
                                </svg>
                            </a>
                            <a class="w-12 h-12 flex items-center justify-center rounded-xl bg-white border border-gray-200 text-gray-400 hover:text-indigo-600 hover:border-indigo-600 hover:bg-indigo-50 transition-all"
                                href="#">
                                <span class="sr-only">LinkedIn</span>
                                <svg class="h-6 w-6 fill-current" viewbox="0 0 24 24">
                                    <path
                                        d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Form -->
                <div
                    class="lg:col-span-7 bg-white rounded-3xl border border-gray-100 p-8 md:p-12 shadow-2xl shadow-gray-200/50">
                    <form action="#" method="POST" class="flex flex-col gap-8">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Name Field -->
                            <div class="flex flex-col gap-3">
                                <label class="text-gray-900 text-sm font-bold uppercase tracking-wider"
                                    for="name">Full Name</label>
                                <input
                                    class="w-full rounded-xl bg-gray-50 border-transparent focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 h-14 px-5 text-gray-900 placeholder:text-gray-400 transition-all outline-none"
                                    id="name" placeholder="Ex. John Doe" type="text" required>
                            </div>
                            <!-- Email Field -->
                            <div class="flex flex-col gap-3">
                                <label class="text-gray-900 text-sm font-bold uppercase tracking-wider"
                                    for="email">Email Address</label>
                                <input
                                    class="w-full rounded-xl bg-gray-50 border-transparent focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 h-14 px-5 text-gray-900 placeholder:text-gray-400 transition-all outline-none"
                                    id="email" placeholder="you@company.com" type="email" required>
                            </div>
                        </div>
                        <!-- Subject Field -->
                        <div class="flex flex-col gap-3">
                            <label class="text-gray-900 text-sm font-bold uppercase tracking-wider"
                                for="subject">Subject</label>
                            <input
                                class="w-full rounded-xl bg-gray-50 border-transparent focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 h-14 px-5 text-gray-900 placeholder:text-gray-400 transition-all outline-none"
                                id="subject" placeholder="What is this regarding?" type="text" required>
                        </div>
                        <!-- Message Field -->
                        <div class="flex flex-col gap-3">
                            <label class="text-gray-900 text-sm font-bold uppercase tracking-wider"
                                for="message">Message</label>
                            <textarea
                                class="w-full rounded-xl bg-gray-50 border-transparent focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 p-5 text-gray-900 placeholder:text-gray-400 transition-all outline-none resize-none min-h-[180px]"
                                id="message" placeholder="Type your message here..." rows="6" required></textarea>
                        </div>
                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button
                                class="w-full md:w-auto px-10 h-14 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-100 transform active:scale-95 transition-all duration-200 flex items-center justify-center gap-3"
                                type="submit">
                                <span>Send Message</span>
                                <span class="material-symbols-outlined text-2xl">send</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</x-layout>
