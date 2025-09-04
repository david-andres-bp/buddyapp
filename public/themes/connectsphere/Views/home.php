<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Home Feed<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="main-grid">
    <!-- Left Column: User Info & Pinned Profiles -->
    <aside class="space-y-6">
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <div class="flex items-center space-x-4">
                <img src="https://placehold.co/80x80/38BDF8/FFFFFF?text=<?= esc(substr($currentUser->username, 0, 1)) ?>" alt="<?= esc($currentUser->username) ?>" class="w-20 h-20 rounded-full">
                <div>
                    <h2 class="text-xl font-bold text-slate-800"><?= esc($currentUser->username) ?></h2>
                    <a href="<?= site_url('profile/' . $currentUser->username) ?>" class="text-sm text-sky-500 hover:underline">View Profile</a>
                </div>
            </div>
            <div class="flex justify-around mt-4 text-center">
                <div>
                    <p class="font-bold text-slate-700"><?= esc($followersCount) ?></p>
                    <p class="text-sm text-slate-500">Followers</p>
                </div>
                <div>
                    <p class="font-bold text-slate-700"><?= esc($followingCount) ?></p>
                    <p class="text-sm text-slate-500">Following</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <h3 class="font-bold text-slate-800 mb-3">Pinned Profiles</h3>
            <!-- Pinned Profiles Feature Placeholder -->
            <p class="text-sm text-slate-400">This feature is coming soon.</p>
        </div>
    </aside>

    <!-- Center Column: Main Feed -->
    <main>
        <!-- Post Composer -->
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <h3 class="font-bold text-lg mb-3">What's on your mind?</h3>
            <form action="<?= site_url('posts/create') ?>" method="post">
                <?= csrf_field() ?>
                <textarea name="content" class="w-full border-slate-300 rounded-md focus:ring-sky-500 focus:border-sky-500" rows="3" placeholder="Share your thoughts..."></textarea>
                <div class="text-right mt-2">
                    <button type="submit" class="bg-sky-500 text-white font-semibold px-6 py-2 rounded-full hover:bg-sky-600 transition">Post</button>
                </div>
            </form>
        </div>

        <!-- Feed Posts -->
        <div class="space-y-4">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <?= $this->setData(['post' => $post, 'currentUser' => $currentUser])->include('post_item') ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center text-slate-500 py-10">
                    <p>Your feed is empty.</p>
                    <p class="mt-2">Follow some people or explore the <a href="<?= site_url('discover') ?>" class="text-sky-500 hover:underline">Discover</a> page to find interesting accounts.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Right Column: Who to Follow & Trends -->
    <aside class="space-y-6">
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <h3 class="font-bold text-slate-800 mb-3">Who to Follow</h3>
            <!-- "Who to Follow" Suggestions Placeholder -->
            <p class="text-sm text-slate-400">This feature is coming soon.</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <h3 class="font-bold text-slate-800 mb-3">Trending Topics</h3>
            <?php if (!empty($trending)): ?>
                <ul class="space-y-2">
                    <?php foreach ($trending as $hashtag => $count): ?>
                        <li>
                            <a href="#" class="font-semibold text-sky-500 hover:underline">#<?= esc($hashtag) ?></a>
                            <p class="text-sm text-slate-400"><?= esc($count) ?> Posts</p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-sm text-slate-400">No trending topics right now.</p>
            <?php endif; ?>
        </div>
    </aside>
</div>
<?= $this->endSection() ?>
