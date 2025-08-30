<div class="text-center">
    <h1 class="text-4xl font-bold font-serif text-indigo">Welcome to HeartBeat!</h1>
    <p class="mt-4 text-lg text-gray-600">The Core Engine and Theming System are now active.</p>
    <p class="mt-2">This page is being rendered from the <strong class="text-coral">HeartBeat</strong> theme.</p>

    <div class="mt-8 p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <h2 class="text-2xl font-semibold font-serif">Next Steps</h2>
        <p class="mt-2 text-gray-600">
            From here, you can start building out the unique features of the HeartBeat theme,
            such as the AI-powered Discover page and the activity feed.
        </p>
        <div class="mt-6 flex justify-center gap-4">
            <a href="<?= site_url(route_to('account-info')) ?>" class="text-indigo hover:underline">View Your Account</a>
            <a href="<?= site_url(route_to('logout')) ?>" class="text-indigo hover:underline">Logout</a>
        </div>
    </div>
</div>
