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
            <?php
            $commentedOnId = session()->getFlashdata('commented_on');
            ?>
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="bg-white p-4 rounded-lg shadow-sm" x-data="{ commentsOpen: <?= ($commentedOnId == $post->id) ? 'true' : 'false' ?> }">
                        <div class="flex items-start space-x-4">
                            <img src="https://placehold.co/48x48/38BDF8/FFFFFF?text=<?= esc(substr($post->user->username, 0, 1)) ?>" alt="<?= esc($post->user->username) ?>" class="w-12 h-12 rounded-full">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <a href="<?= site_url('profile/' . $post->user->username) ?>" class="font-bold text-slate-800 hover:underline"><?= esc($post->user->username) ?></a>
                                        <span class="text-sm text-slate-500"> &middot; <?= esc(CodeIgniter\I18n\Time::parse($post->created_at)->humanize()) ?></span>
                                    </div>
                                    <!-- More actions dropdown placeholder -->
                                </div>
                                <p class="text-slate-700 mt-2"><?= esc($post->content) ?></p>
                                <div class="flex items-center space-x-6 mt-4 text-slate-500">
                                    <!-- Like Button -->
                                    <form action="<?= site_url('posts/like/' . $post->id) ?>" method="post" class="flex items-center space-x-2">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="flex items-center space-x-1 hover:text-red-500 <?= $post->is_liked_by_user ? 'text-red-500' : '' ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" /></svg>
                                            <span><?= esc($post->like_count) ?></span>
                                        </button>
                                    </form>
                                    <!-- Comment Button -->
                                    <button @click="commentsOpen = !commentsOpen" class="flex items-center space-x-1 hover:text-sky-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.08-3.239A8.962 8.962 0 012 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM4.416 14.584A6.962 6.962 0 008 15c3.314 0 6-2.686 6-6s-2.686-6-6-6-6 2.686-6 6c0 1.309.432 2.523 1.18 3.524l-.693 2.081 2.08-1.542z" clip-rule="evenodd" /></svg>
                                        <span><?= esc($post->comment_count) ?></span>
                                    </button>
                                </div>

                                <!-- Comments Section -->
                                <div x-show="commentsOpen" x-transition class="mt-4 pt-4 border-t border-slate-200">
                                    <!-- Comment Form -->
                                    <form action="<?= site_url('posts/comment/' . $post->id) ?>" method="post" class="flex items-start space-x-3 mb-4">
                                        <?= csrf_field() ?>
                                        <img src="https://placehold.co/32x32/38BDF8/FFFFFF?text=<?= esc(substr($currentUser->username, 0, 1)) ?>" alt="<?= esc($currentUser->username) ?>" class="w-8 h-8 rounded-full">
                                        <div class="flex-1">
                                            <textarea name="content" class="w-full bg-slate-100 border-slate-200 p-2 rounded-lg text-sm focus:ring-sky-500 focus:border-sky-500 transition" rows="1" placeholder="Write a comment..."></textarea>
                                            <div class="text-right mt-1">
                                                <button type="submit" class="bg-sky-500 text-white font-semibold px-4 py-1 text-sm rounded-full hover:bg-sky-600 transition">Comment</button>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Comment List -->
                                    <div class="space-y-3">
                                        <?php if (!empty($post->comments)): ?>
                                            <?php foreach ($post->comments as $comment): ?>
                                                <div class="flex items-start space-x-3">
                                                    <img src="https://placehold.co/32x32/94A3B8/FFFFFF?text=<?= esc(substr($comment->user->username, 0, 1)) ?>" alt="<?= esc($comment->user->username) ?>" class="w-8 h-8 rounded-full">
                                                    <div class="flex-1 bg-slate-100 p-3 rounded-lg">
                                                        <a href="<?= site_url('profile/' . $comment->user->username) ?>" class="font-semibold text-sm text-slate-700 hover:underline"><?= esc($comment->user->username) ?></a>
                                                        <p class="text-sm text-slate-600"><?= esc($comment->text) ?></p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p class="text-sm text-slate-500 text-center">No comments yet.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
