<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serendipity - Meaningful Connections Await</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; background-color: #FFFBFB; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .text-ruby { color: #EF4444; }
        .bg-ruby { background-color: #EF4444; }
        .hover\:bg-ruby-dark:hover { background-color: #DC2626; }
        .text-pink { color: #EC4899; }
        .bg-pink-light { background-color: #FCE7F3; }
        .border-pink { border-color: #EC4899; }
        .hero-gradient {
            background: linear-gradient(to top, rgba(255, 251, 251, 1) 0%, rgba(255, 251, 251, 0) 50%), url('<?= service('theme')->asset('images/hero-background.png') ?>');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="text-slate-800">

    <!-- Header -->
    <header class="absolute top-0 left-0 right-0 z-10 py-6">
        <div class="max-w-6xl mx-auto px-4 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-ruby font-serif">Serendipity</h1>
            <div>
                <a href="#features" class="text-slate-700 hover:text-ruby mx-4 font-medium">Features</a>
                <a href="#" class="bg-ruby text-white font-semibold px-5 py-2 rounded-full hover:bg-ruby-dark transition">Join Now</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative h-[65vh] flex items-end pb-20 md:pb-24 text-center hero-gradient">
        <div class="relative z-10 px-4 w-full">
            <h2 class="text-5xl md:text-6xl font-bold leading-tight font-serif text-slate-900">Where Real Stories Begin.</h2>
            <p class="mt-4 text-lg md:text-xl max-w-2xl mx-auto text-slate-700">It's time for a dating experience that values depth over games. Find a lasting connection with someone who truly understands you.</p>
            <a href="#" class="mt-8 inline-block bg-ruby text-white font-bold text-lg px-10 py-4 rounded-full hover:bg-ruby-dark transition transform hover:scale-105">Begin Your Journey</a>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h3 class="text-4xl font-bold text-slate-900 font-serif">Find Your Match, Intelligently</h3>
            <p class="mt-2 text-gray-600">Our process is designed to help you find what you're looking for.</p>
            <div class="mt-12 grid md:grid-cols-3 gap-12">
                <!-- Step 1 -->
                <div class="flex flex-col items-center">
                    <div class="bg-pink-light text-pink h-20 w-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-edit text-3xl"></i>
                    </div>
                    <h4 class="mt-6 text-xl font-semibold">1. Create a Rich Profile</h4>
                    <p class="mt-2 text-gray-600">Go beyond the surface. Share your passions, goals, and what makes you unique with our detailed profile builder.</p>
                </div>
                <!-- Step 2 -->
                <div class="flex flex-col items-center">
                    <div class="bg-pink-light text-pink h-20 w-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-search-location text-3xl"></i>
                    </div>
                    <h4 class="mt-6 text-xl font-semibold">2. Discover with Precision</h4>
                    <p class="mt-2 text-gray-600">Use our powerful filters to search for exactly what you want in a partner, from age and location to relationship intent.</p>
                </div>
                <!-- Step 3 -->
                <div class="flex flex-col items-center">
                    <div class="bg-pink-light text-pink h-20 w-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-comments text-3xl"></i>
                    </div>
                    <h4 class="mt-6 text-xl font-semibold">3. Connect with Confidence</h4>
                    <p class="mt-2 text-gray-600">Our mutual connection system ensures you only talk to people who are also interested in you. No unwanted messages.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20">
        <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-2 gap-12 items-center">
            <div>
                <img src="<?= service('theme')->asset('images/detailed-profiles.png') ?>" class="rounded-lg shadow-xl" alt="A detailed user profile">
            </div>
            <div>
                <span class="font-semibold text-ruby">DATING FOR ADULTS</span>
                <h3 class="text-4xl font-bold text-slate-900 font-serif mt-2">Go Beyond the Photo</h3>
                <p class="mt-4 text-lg text-gray-600">Serendipity is built for those who know what they want. Our features are designed to help you make informed decisions on your journey to love.</p>
                <ul class="mt-6 space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-pink text-xl mt-1 mr-3"></i>
                        <span><strong class="font-semibold">Detailed Profiles:</strong> Learn about someone's lifestyle, goals, and personality before you even say hello.</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-pink text-xl mt-1 mr-3"></i>
                        <span><strong class="font-semibold">Advanced Filtering:</strong> Don't waste time. Narrow your search to find the most compatible matches for you.</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-pink text-xl mt-1 mr-3"></i>
                        <span><strong class="font-semibold">Secure Messaging:</strong> Communicate safely and privately with your mutual connections.</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-20 bg-ruby text-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h3 class="text-4xl font-bold font-serif">Your Next Chapter is Waiting</h3>
            <p class="mt-4 text-lg text-white/90 max-w-xl mx-auto">Join a community of singles who are ready for a real relationship. Your search for something meaningful starts here.</p>
            <a href="#" class="mt-8 inline-block bg-white text-ruby font-bold text-lg px-10 py-4 rounded-full hover:bg-slate-100 transition transform hover:scale-105">Create Your Profile</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-8">
        <div class="max-w-6xl mx-auto px-4 text-center text-gray-500">
            <p>&copy; 2025 Serendipity. All Rights Reserved.</p>
            <div class="mt-4 flex justify-center space-x-6">
                <a href="#" class="hover:text-ruby"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-ruby"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-ruby"><i class="fab fa-facebook"></i></a>
            </div>
        </div>
    </footer>

</body>
</html>
