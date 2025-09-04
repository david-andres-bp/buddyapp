<?= $this->extend('layout') ?>

<?= $this->section('title') ?><?= esc($user->username) ?>'s Profile<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto" x-data="{ activeTab: 'posts' }">
    <!-- Profile Header -->
    <div>
        <div class="h-48 bg-sky-400 rounded-t-lg bg-cover bg-center" style="background-image: url('<?= esc($user->meta->cover_photo ?? '') ?>')"></div>
        <div class="bg-white p-5 rounded-b-lg shadow-sm">
            <div class="flex justify-between items-start">
                <div class="relative">
                    <img src="<?= esc($user->meta->profile_photo ?? 'https://placehold.co/128x128/1E293B/FFFFFF?text=' . substr($user->username, 0, 2)) ?>" alt="<?= esc($user->username) ?>" class="w-32 h-32 rounded-full border-4 border-white -mt-20">
                </div>
                <div class="flex space-x-2">
                    <?php if (auth()->loggedIn()): ?>
                        <?php if (auth()->id() == $user->id): ?>
                            <a href="<?= site_url('account/info') ?>" class="bg-slate-200 text-slate-800 font-semibold px-4 py-2 rounded-full hover:bg-slate-300">Edit Profile</a>
                        <?php else: ?>
                            <button class="bg-white border-2 border-sky-500 text-sky-500 font-semibold px-4 py-2 rounded-full hover:bg-sky-50 flex items-center space-x-2" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-3.13L5 18V4z" /></svg>
                                <span>Pin</span>
                            </button>
                            <?php if ($isFollowing): ?>
                                <form action="<?= site_url('unfollow/' . $user->id) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="bg-slate-600 text-white font-semibold px-4 py-2 rounded-full hover:bg-slate-700">Unfollow</button>
                                </form>
                            <?php else: ?>
                                <form action="<?= site_url('follow/' . $user->id) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="bg-sky-500 text-white font-semibold px-4 py-2 rounded-full hover:bg-sky-600">Follow</button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mt-2">
                <h1 class="text-2xl font-bold"><?= esc($user->username) ?></h1>
                <p class="text-slate-500">@<?= esc($user->username) ?></p>
                <p class="mt-2 text-slate-700"><?= esc($user->meta->bio ?? 'No biography provided.') ?></p>
                <div class="flex space-x-4 mt-2 text-slate-500 text-sm">
                    <span><span class="font-bold text-slate-800"><?= esc($followingCount) ?></span> Following</span>
                    <span><span class="font-bold text-slate-800"><?= esc($followersCount) ?></span> Followers</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="mt-6">
        <!-- Tabs -->
        <div class="border-b border-slate-300 bg-white rounded-t-lg shadow-sm">
            <nav class="-mb-px flex space-x-6 px-5">
                <a href="#" @click.prevent="activeTab = 'posts'" :class="{ 'border-sky-500 text-sky-600': activeTab === 'posts', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'posts' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Posts</a>
                <a href="#" @click.prevent="activeTab = 'likes'" :class="{ 'border-sky-500 text-sky-600': activeTab === 'likes', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'likes' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Likes</a>
                <a href="#" @click.prevent="activeTab = 'media'" :class="{ 'border-sky-500 text-sky-600': activeTab === 'media', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'media' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Media</a>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="bg-white p-5 rounded-b-lg shadow-sm">
            <!-- Posts Tab -->
            <div x-show="activeTab === 'posts'" class="space-y-4">
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <?= $this->setData(['post' => $post, 'currentUser' => $currentUser])->include('post_item') ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-slate-500 py-10"><?= esc($user->username) ?> hasn't posted anything yet.</p>
                <?php endif; ?>
            </div>
            <!-- Likes Tab -->
            <div x-show="activeTab === 'likes'" class="space-y-4" style="display: none;">
                <?php if (!empty($likedPosts)): ?>
                    <?php foreach ($likedPosts as $post): ?>
                        <?= $this->setData(['post' => $post, 'currentUser' => $currentUser])->include('post_item') ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-slate-500 py-10"><?= esc($user->username) ?> hasn't liked any posts yet.</p>
                <?php endif; ?>
            </div>
            <!-- Media Tab -->
            <div x-show="activeTab === 'media'" style="display: none;">
                <?php if (!empty($mediaPosts)): ?>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        <?php foreach ($mediaPosts as $post): ?>
                            <!-- Simple media display, assuming content has an image -->
                            <div class="rounded-lg aspect-square object-cover overflow-hidden">
                                <?= $post->content ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-center text-slate-500 py-10"><?= esc($user->username) ?> hasn't posted any media yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- This is a placeholder for a reusable post item view -->
<!-- I will create this as a new file: `app/Views/post_item.php` -->
<!-- This will avoid code duplication between the main feed and the profile page -->

<?= $this->endSection() ?>
