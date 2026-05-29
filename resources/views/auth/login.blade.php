<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skinist — Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white min-h-screen flex flex-col items-center justify-center px-8">

    <h1 class="text-8xl font-thin tracking-widest text-sky-200 mb-16" style="font-family: 'Georgia', serif; letter-spacing: 0.15em; padding-top: 120px;">Skinist</h1>

    <div class="w-full max-w-md">
        <h2 class="text-2xl text-gray-600 mb-6">LogIn</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <input type="email" name="email" placeholder="email@gmail.com"
                    class="w-full bg-gray-100 rounded-lg px-5 py-4 text-gray-500 text-lg focus:outline-none focus:ring-2 focus:ring-sky-300"
                    value="{{ old('email') }}" required>
                @error('email')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <div class="relative bg-gray-100 rounded-lg flex items-center">
                    <input type="password" name="password" id="password" placeholder="password"
                        class="w-full bg-transparent px-5 py-4 text-gray-500 text-lg focus:outline-none"
                        required>
                    <button type="button" onclick="togglePassword('password', 'eye1')"
                        class="px-4 text-gray-400 hover:text-sky-400 flex-shrink-0">
                        <svg id="eye1" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-sky-300 hover:bg-sky-400 text-white font-semibold py-4 rounded-xl text-lg transition-all duration-200 mb-4">
                Login
            </button>

            <div class="flex justify-between text-sm text-gray-400">
                <a href="{{ route('password.request') }}" class="hover:text-sky-400">Forget your password?</a>
                <a href="{{ route('register') }}" class="hover:text-sky-400">create an account</a>
            </div>
        </form>
    </div>

<script>
function togglePassword(inputId, eyeId) {
    const input = document.getElementById(inputId);
    const eye = document.getElementById(eyeId);
    if (input.type === 'password') {
        input.type = 'text';
        eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
        `;
    } else {
        input.type = 'password';
        eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
    }
}
</script>

</body>
</html>