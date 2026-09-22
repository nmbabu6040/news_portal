<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ড্যাশবোর্ড') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-xl shadow-lg p-6 sm:p-8 text-white">
                <h3 class="text-xl font-bold">স্বাগতম, {{ auth()->user()->name }}!</h3>
                <p class="text-white/80 text-sm mt-1">আপনার অ্যাকাউন্টে লগইন করা আছে।</p>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-6 sm:p-8">
                <h4 class="font-semibold text-gray-800 mb-4">দ্রুত অ্যাকশন</h4>
                <div class="grid sm:grid-cols-2 gap-4">
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 p-4 rounded-lg border border-gray-100 hover:border-red-200 hover:bg-red-50 transition">
                        <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-100 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        <div>
                            <div class="font-medium text-gray-800">প্রোফাইল সেটিংস</div>
                            <div class="text-xs text-gray-500">নাম, ইমেইল, পাসওয়ার্ড পরিবর্তন করুন</div>
                        </div>
                    </a>
                    <a href="{{ route('home') }}"
                        class="flex items-center gap-3 p-4 rounded-lg border border-gray-100 hover:border-red-200 hover:bg-red-50 transition">
                        <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-green-100 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </span>
                        <div>
                            <div class="font-medium text-gray-800">সাইটে যান</div>
                            <div class="text-xs text-gray-500">সর্বশেষ খবর পড়ুন</div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
