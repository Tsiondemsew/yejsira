<x-guest-layout>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white shadow-lg rounded-xl">
        <h2 class="text-2xl font-bold text-center mb-6">Login to Your Account</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            @if(request()->has('redirect'))
                <input type="hidden" name="redirect" value="{{ request()->redirect }}">
            @endif

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" required autofocus
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-indigo-300">
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-indigo-300">
            </div>

            <!-- Remember Me -->
            <div class="mb-4 flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="mr-2">
                <label for="remember_me" class="text-sm text-gray-600">Remember me</label>
            </div>

            <div class="flex justify-between items-center mb-4">
                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition duration-200">
                Login
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-sm">Don't have an account?
                <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Register</a>
            </p>
        </div>
    </div>
</x-guest-layout>
