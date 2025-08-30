<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <!-- Profile Sidebar -->
    <div class="md:col-span-1">
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <img src="https://i.pravatar.cc/150?u=<?= esc($user->username) ?>" alt="<?= esc($user->username) ?>" class="w-32 h-32 rounded-full mx-auto mb-4">
            <h1 class="text-3xl font-bold font-serif text-indigo"><?= esc($user->username) ?></h1>
            <p class="text-gray-600 mt-2">
                <!-- Placeholder for bio, to be implemented with user_meta -->
                A passionate adventurer and foodie.
            </p>
            <div class="mt-4 flex justify-center space-x-2 flex-wrap">
                <?php if (!empty($tags)) : ?>
                    <?php foreach (array_slice($tags, 0, 3) as $tag) : // Show max 3 tags ?>
                        <span class="bg-coral/20 text-coral text-sm font-semibold px-3 py-1 rounded-full mb-2"><?= esc(ucfirst($tag)) ?></span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500 text-sm">No personality tags yet.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="mt-6 space-y-4">
            <?php if (auth()->loggedIn() && auth()->id() !== $user->id) : ?>
                <form action="<?= url_to('connection-create', $user->id) ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="w-full bg-indigo text-white font-semibold px-6 py-3 rounded-full hover:bg-indigo-700 transition">
                        <i class="fas fa-link mr-2"></i> Connect
                    </button>
                </form>

                <button onclick="alert('This feature is coming soon!')" class="w-full bg-yellow text-near-black font-semibold px-6 py-3 rounded-full hover:bg-yellow-400 transition">
                    <i class="fas fa-gift mr-2"></i> Send a Gift
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Activity Feed -->
    <div class="md:col-span-2">
        <h2 class="text-2xl font-bold font-serif text-indigo mb-4">Recent Activity</h2>
        <div class="space-y-6">
            <?php if (empty($activities)) : ?>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p class="text-gray-500">This user hasn't posted any activities yet.</p>
                </div>
            <?php else : ?>
                <?php foreach ($activities as $activity) : ?>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-start">
                            <img src="https://i.pravatar.cc/150?u=<?= esc($user->username) ?>" alt="<?= esc($user->username) ?>" class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <p class="font-semibold"><?= esc($user->username) ?></p>
                                <p class="text-sm text-gray-500"><?= date('M j, Y \a\t g:i a', strtotime($activity->created_at)) ?></p>
                                <p class="mt-2 text-gray-700"><?= esc($activity->content) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
