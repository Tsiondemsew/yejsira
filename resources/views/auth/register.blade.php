<x-guest-layout>
     <div class="max-w-md mx-auto mt-10 p-6 bg-white shadow-lg rounded-xl">
        <h2 class="text-2xl font-bold text-center mb-6">Create an Account</h2>

        @if ($errors->any())
            <div class="mb-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input id="name" type="text" name="name" required autofocus
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-indigo-300">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" required
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-indigo-300">
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-indigo-300">
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-indigo-300">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition duration-200">
                Register
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-sm">Already have an account?
                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Login</a>
            </p>
        </div>
    </div>
</x-guest-layout>
