<x-guest-layout>
    <x-slot name="title">Register - Palembang Songket Store</x-slot>

    <div class="bg-white rounded-2xl shadow-xl p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 font-serif">Create Account</h2>
            <p class="text-gray-600 mt-2">Join us to explore authentic Songket collection</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus autocomplete="name" placeholder="Enter your full name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" placeholder="Enter your email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" placeholder="Create a password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password"
                    placeholder="Confirm your password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Terms Agreement -->
            <div class="flex items-start">
                <input id="terms" type="checkbox"
                    class="rounded border-gray-300 text-amber-600 shadow-sm focus:ring-amber-500 mt-1" required>
                <label for="terms" class="ms-2 text-sm text-gray-600">
                    I agree to the
                    <a href="#" class="text-amber-600 hover:text-amber-700 font-medium">Terms of Service</a>
                    and
                    <a href="#" class="text-amber-600 hover:text-amber-700 font-medium">Privacy Policy</a>
                </label>
            </div>

            <!-- Submit Button -->
            <div>
                <x-primary-button class="w-full justify-center py-3 text-base">
                    {{ __('Create Account') }}
                </x-primary-button>
            </div>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Already have an account?</span>
                </div>
            </div>

            <!-- Login Link -->
            <div class="text-center">
                <a href="{{ route('login') }}"
                    class="w-full inline-flex justify-center items-center px-4 py-3 border border-amber-300 rounded-lg font-medium text-amber-600 bg-amber-50 hover:bg-amber-100 transition-colors">
                    Sign In Instead
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
