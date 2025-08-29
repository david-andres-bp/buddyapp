<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold font-serif text-indigo mb-4">Share an Activity</h2>
    <form id="activity-form" action="/api/activities" method="post">
        <textarea name="content" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" rows="4" placeholder="What's on your mind?"></textarea>
        <div class="mt-4 flex justify-end">
            <button type="submit" class="bg-coral text-white font-semibold px-6 py-2 rounded-full hover:bg-coral-dark transition">Post</button>
        </div>
    </form>
</div>
