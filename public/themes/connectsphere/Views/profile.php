<?= $this->extend('layout') ?>

<?= $this->section('title') ?><?= esc($user->username) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div x-data="{ activeTab: 'posts' }">
    <!-- Profile Header -->
    <div>
        <div class="h-48 bg-slate-300 rounded-t-lg bg-cover bg-center" style="background-image: url('https://placehold.co/1200x400/38BDF8/FFFFFF?text=Cover+Photo')"></div>
        <div class="bg-white p-5 rounded-b-lg shadow-sm">
            <div class="flex justify-between items-start">
                <div class="relative">
                    <img src="https://placehold.co/128x128/1E293B/FFFFFF?text=<?= substr($user->username, 0, 2) ?>" alt="<?= esc($user->username) ?>" class="w-32 h-32 rounded-full border-4 border-white -mt-20">
                </div>
                <div class="flex space-x-2">
                    <?php if (auth()->loggedIn() && auth()->id() !== $user->id) : ?>
                        <form action="<?= $isPinned ? url_to('unpin-profile', $user->id) : url_to('pin-profile', $user->id) ?>" method="post" class="inline">
                            <?= csrf_field() ?>
                            <button type="submit" class="bg-white border-2 border-sky-500 text-sky-500 font-semibold px-4 py-2 rounded-full hover:bg-sky-50 flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-3.13L5 18V4z" /></svg>
                                <span><?= $isPinned ? 'Unpin' : 'Pin' ?></span>
                            </button>
                        </form>
                        <form action="<?= $isFollowing ? url_to('unfollow', $user->id) : url_to('follow', $user->id) ?>" method="post" class="inline">
                            <?= csrf_field() ?>
                            <button type="submit" class="bg-sky-500 text-white font-semibold px-4 py-2 rounded-full hover:bg-sky-600">
                                <?= $isFollowing ? 'Unfollow' : 'Follow' ?>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mt-2">
                <h1 class="text-2xl font-bold"><?= esc($user->username) ?></h1>
                <p class="text-slate-500">@<?= esc($user->username) ?></p>
                <p class="mt-2 text-slate-700"><?= esc($user->bio) ?></p>
                 <div class="flex space-x-4 mt-2 text-slate-500 text-sm">
                    <span><span class="font-bold text-slate-800"><?= $followingCount ?></span> Following</span>
                    <span><span class="font-bold text-slate-800"><?= $followersCount ?></span> Followers</span>
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
        <div class="mt-0">
            <div x-show="activeTab === 'posts'" class="space-y-6">
                <!-- Posts -->
                <?php if (!empty($posts)) : ?>
                    <?php foreach ($posts as $post) : ?>
                        <div class="bg-white p-5 rounded-b-lg shadow-sm">
                            <div class="flex items-center space-x-3">
                                <img src="https://placehold.co/48x48/1E293B/FFFFFF?text=<?= substr($user->username, 0, 2) ?>" alt="<?= esc($user->username) ?>" class="w-12 h-12 rounded-full">
                                <div>
                                    <p class="font-bold"><?= esc($user->username) ?> <span class="font-normal text-slate-500">@<?= esc($user->username) ?> · <?= esc(CodeIgniter\I18n\Time::parse($post['created_at'])->humanize()) ?></span></p>
                                    <p><?= esc($post['content']) ?></p>
                                </div>
                            </div>
                            <div class="flex justify-around items-center mt-4 pt-3 border-t text-slate-500">
                                <button class="flex items-center space-x-2 hover:text-sky-500"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg> <span>15</span></button>
                                <button class="flex items-center space-x-2 hover:text-green-500"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M5.5 9.5l1.5-1.5a4.243 4.243 0 016 0L16 11M20 20v-5h-5M18.5 14.5l-1.5 1.5a4.243 4.243 0 01-6 0L8 13" /></svg> <span>5</span></button>
                                <button class="flex items-center space-x-2 hover:text-pink-500"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg> <span>128</span></button>
                                <button class="flex items-center space-x-2 hover:text-sky-500"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg></button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="bg-white p-5 rounded-b-lg shadow-sm text-center">
                        <p class="text-slate-500">This user hasn't posted anything yet.</p>
                    </div>
                <?php endif; ?>
            </div>
            <div x-show="activeTab === 'likes'">
                <div class="bg-white p-5 rounded-b-lg shadow-sm">
                    <p class="text-center text-slate-500 py-10"><?= esc($user->username) ?> hasn't liked any posts yet.</p>
                </div>
            </div>
             <div x-show="activeTab === 'media'">
                <div class="bg-white p-5 rounded-b-lg shadow-sm">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        <img src="https://placehold.co/400x400/94A3B8/FFFFFF?text=Media" class="rounded-lg aspect-square object-cover">
                        <img src="https://placehold.co/400x400/94A3B8/FFFFFF?text=Media" class="rounded-lg aspect-square object-cover">
                        <img src="https://placehold.co/400x400/94A3B8/FFFFFF?text=Media" class="rounded-lg aspect-square object-cover">
                        <img src="https://placehold.co/400x400/94A3B8/FFFFFF?text=Media" class="rounded-lg aspect-square object-cover">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
