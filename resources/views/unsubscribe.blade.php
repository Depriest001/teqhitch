<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unsubscribed | {{ config('app.name') }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-xl rounded-lg p-10 max-w-md text-center">
        
        <!-- Unsubscribe Icon -->
        <div class="flex justify-center mb-6">
            <svg class="w-16 h-16 text-red-500 animate-pulse" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </div>

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-800 mb-4">You Have Unsubscribed</h1>

        <!-- Description -->
        <p class="text-gray-600 mb-6">
            We're sorry to see you go! You have successfully unsubscribed from <strong>{{ config('app.name') }}</strong> newsletters. 
            You will no longer receive email updates from us.
        </p>

        <!-- Call to Action -->
        <a href="{{ url('/') }}" 
           class="inline-block bg-red-500 hover:bg-red-600 text-white font-medium py-3 px-8 rounded-lg transition">
            Return to Homepage
        </a>

        <!-- Optional Flash Message -->
        @if(session('message'))
            <p class="mt-4 text-gray-500 text-sm">{{ session('message') }}</p>
        @endif

    </div>

</body>
</html>