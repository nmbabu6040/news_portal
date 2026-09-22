<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('প্রোফাইল সেটিংস') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- প্রোফাইল সামারি কার্ড --}}
            <div
                class="bg-gradient-to-r from-red-600 to-red-800 rounded-xl shadow-lg p-6 sm:p-8 text-white flex items-center gap-5">
                <div
                    class="w-16 h-16 sm:w-20 sm:h-20 bg-white/20 rounded-full flex items-center justify-center text-2xl sm:text-3xl font-bold border-2 border-white/40 flex-shrink-0">
                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-lg sm:text-xl font-bold">{{ auth()->user()->name }}</h3>
                    <p class="text-white/80 text-sm">{{ auth()->user()->email }}</p>
                    <p class="text-white/60 text-xs mt-1">সদস্য হয়েছেন {{ auth()->user()->created_at->format('d M Y') }}
                        থেকে</p>
                </div>
            </div>

            {{-- প্রোফাইল তথ্য --}}
            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-4 sm:p-8">
                    <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-blue-100 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        <div>
                            <h4 class="font-semibold text-gray-800">ব্যক্তিগত তথ্য</h4>
                            <p class="text-xs text-gray-500">আপনার নাম ও ইমেইল আপডেট করুন</p>
                        </div>
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            {{-- পাসওয়ার্ড আপডেট --}}
            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-4 sm:p-8">
                    <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-amber-100 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v4h8z" />
                            </svg>
                        </span>
                        <div>
                            <h4 class="font-semibold text-gray-800">পাসওয়ার্ড পরিবর্তন</h4>
                            <p class="text-xs text-gray-500">নিরাপত্তার জন্য নিয়মিত পাসওয়ার্ড আপডেট করুন</p>
                        </div>
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- অ্যাকাউন্ট ডিলিট --}}
            <div class="bg-white shadow-sm sm:rounded-xl border border-red-100">
                <div class="p-4 sm:p-8">
                    <div class="flex items-center gap-3 mb-5 pb-4 border-b border-red-100">
                        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-red-100 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </span>
                        <div>
                            <h4 class="font-semibold text-red-700">অ্যাকাউন্ট ডিলিট করুন</h4>
                            <p class="text-xs text-gray-500">এই কাজটি স্থায়ী, ফিরিয়ে আনা যাবে না</p>
                        </div>
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
