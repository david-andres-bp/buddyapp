<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HeartBeat - Find Your Story</title>
    <link href="<?= service('theme')->asset('css/tailwind.min.css') ?>" rel="stylesheet">
    <link href="<?= service('theme')->asset('css/fontawesome.all.min.css') ?>" rel="stylesheet">
    <link href="<?= service('theme')->asset('css/google-fonts.css') ?>" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8F9FA; /* Off-white */
        }
        .font-serif {
            font-family: 'Lora', serif;
        }
        .text-coral { color: #FF6B6B; }
        .bg-coral { background-color: #FF6B6B; }
        .hover\:bg-coral-dark:hover { background-color: #E95757; }
        .text-indigo { color: #4F46E5; }
        .bg-indigo { background-color: #4F46E5; }
        .text-yellow { color: #FFD166; }
        .bg-yellow { background-color: #FFD166; }
        .text-near-black { color: #212529; }
        .bg-near-black { background-color: #212529; }
        .hero-gradient {
            background: linear-gradient(to right, rgba(255, 107, 107, 0.9), rgba(79, 70, 229, 0.9));
        }
    </style>
</head>
<body class="text-near-black">

    <!-- Header -->
    <header class="absolute top-0 left-0 right-0 z-20 py-5">
        <div class="max-w-6xl mx-auto px-4 flex justify-between items-center">
            <a href="<?= url_to('register') ?>" class="flex items-center space-x-2">
                <i class="fas fa-heart text-white text-2xl"></i>
                <span class="text-3xl font-bold text-white font-serif">HeartBeat</span>
            </a>
            <div class="hidden md:flex items-center space-x-6">
                <a href="#how-it-works" class="text-white/80 hover:text-white transition">How It Works</a>
                <a href="#features" class="text-white/80 hover:text-white transition">Why HeartBeat?</a>
                <a href="<?= url_to('register') ?>" class="bg-white text-coral font-semibold px-5 py-2 rounded-full hover:bg-slate-100 transition">Start Your Story</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative h-[80vh] flex items-center justify-center text-white text-center overflow-hidden">
        <div class="absolute inset-0 hero-gradient z-10"></div>
        <!-- Video background removed as asset is unavailable -->
        <!--
        <video autoplay loop muted playsinline class="absolute z-0 w-auto min-w-full min-h-full max-w-none opacity-20">
            <source src="<?= service('theme')->asset('videos/hero-video.mp4') ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        -->
        <div class="relative z-10 px-4">
            <h2 class="text-5xl md:text-7xl font-bold leading-tight font-serif">Your Story Starts Here.</h2>
            <p class="mt-4 text-lg md:text-xl max-w-2xl mx-auto text-white/90">A dating app that matches you on life's moments, not just a profile picture. Connect with people who love what you do.</p>
            <a href="<?= url_to('register') ?>" class="mt-8 inline-block bg-yellow text-near-black font-bold text-lg px-10 py-4 rounded-full hover:bg-yellow-400 transition transform hover:scale-105">Find Your Adventure</a>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h3 class="text-4xl font-bold text-near-black font-serif">Connect Through Shared Experiences</h3>
            <p class="mt-2 text-gray-600 max-w-2xl mx-auto">HeartBeat helps you find a genuine connection in three simple steps.</p>
            <div class="mt-16 grid md:grid-cols-3 gap-10">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="bg-coral/10 text-coral h-20 w-20 rounded-full flex items-center justify-center mx-auto">
                        <i class="fas fa-feather-alt text-3xl"></i>
                    </div>
                    <h4 class="mt-6 text-2xl font-semibold font-serif">1. Share Your Activities</h4>
                    <p class="mt-2 text-gray-600">Post photos, check-ins, and thoughts about your passions. Let your activities tell your story.</p>
                </div>
                <!-- Step 2 -->
                <div class="text-center">
                    <div class="bg-indigo/10 text-indigo h-20 w-20 rounded-full flex items-center justify-center mx-auto">
                        <i class="fas fa-robot text-3xl"></i>
                    </div>
                    <h4 class="mt-6 text-2xl font-semibold font-serif">2. Discover Personalities</h4>
                    <p class="mt-2 text-gray-600">Our AI intelligently analyzes activities to reveal the personality behind the profile, tagging users as "Adventurous," "Creative," and more.</p>
                </div>
                <!-- Step 3 -->
                <div class="text-center">
                     <div class="bg-yellow/20 text-yellow-600 h-20 w-20 rounded-full flex items-center justify-center mx-auto">
                        <i class="fas fa-comments text-3xl"></i>
                    </div>
                    <h4 class="mt-6 text-2xl font-semibold font-serif">3. Start Real Conversations</h4>
                    <p class="mt-2 text-gray-600">Break the ice by talking about a recent hike or a shared love for cooking. Connect over what truly matters.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24">
        <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-2 gap-16 items-center">
            <div class="relative">
                <img src="<?= service('theme')->asset('images/activities.png') ?>" class="rounded-lg shadow-xl relative z-10" alt="A collage of user activities">
                <div class="absolute -top-8 -left-8 w-full h-full bg-coral/20 rounded-lg transform -rotate-3"></div>
            </div>
            <div>
                <span class="font-semibold text-coral">BEYOND THE BIO</span>
                <h3 class="text-4xl font-bold text-near-black font-serif mt-2">Discover the Person Behind the Profile</h3>
                <p class="mt-4 text-lg text-gray-600">HeartBeat's unique **AI Personality Engine** creates a rich, dynamic profile that reflects who you really are.</p>
                <ul class="mt-6 space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-indigo text-xl mt-1 mr-3"></i>
                        <span><strong class="font-semibold">Authentic Matching:</strong> Find compatible lifestyles, not just faces.</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-indigo text-xl mt-1 mr-3"></i>
                        <span><strong class="font-semibold">Personality Categories:</strong> Instantly browse profiles of "Foodies," "Creatives," or "Adventurers."</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-indigo text-xl mt-1 mr-3"></i>
                        <span><strong class="font-semibold">A Story, Not a Snapshot:</strong> See a person's journey through their activity feed.</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-24 bg-near-black text-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h3 class="text-4xl font-bold font-serif">Ready to Write Your Next Chapter?</h3>
            <p class="mt-4 text-lg text-white/80 max-w-xl mx-auto">Leave the endless swiping behind. Join a community where connections are built on shared passions.</p>
            <a href="<?= url_to('register') ?>" class="mt-8 inline-block bg-coral text-white font-bold text-lg px-10 py-4 rounded-full hover:bg-coral-dark transition transform hover:scale-105">Create Your Free Profile Today</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-8">
        <div class="max-w-6xl mx-auto px-4 text-center text-gray-500">
            <p>&copy; 2025 HeartBeat. A new chapter in dating.</p>
            <div class="mt-4 flex justify-center space-x-6">
                <a href="#" class="hover:text-coral"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-coral"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-coral"><i class="fab fa-facebook"></i></a>
            </div>
        </div>
    </footer>

</body>
</html>
