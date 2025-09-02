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
                        <form action="<?= $isFollowing ? site_url('unfollow/' . $user->id) : site_url('follow/' . $user->id) ?>" method="post" class="inline">
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
                                    <p class="font-bold"><?= esc($user->username) ?> <span class="font-normal text-slate-500">@<?= esc($user->username) ?> · <?= esc(CodeIgniter\I18n\Time::parse($post->created_at)->humanize()) ?></span></p>
                                    <p><?= esc($post->content) ?></p>
                                </div>
                            </div>
                            <div class="flex justify-around items-center mt-4 pt-3 border-t text-slate-500">
                                <!-- Action buttons would be dynamic here -->
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="bg-white p-5 rounded-b-lg shadow-sm text-center">
                        <p class="text-slate-500">This user hasn't posted anything yet.</p>
                    </div>
                <?php endif; ?>
            </div>
            <div x-show="activeTab === 'likes'" class="space-y-6">
                <?php if (!empty($liked_posts)) : ?>
                    <?php foreach ($liked_posts as $post) : ?>
                        <div class="bg-white p-5 rounded-b-lg shadow-sm">
                            <div class="flex items-center space-x-3">
                                <img src="https://placehold.co/48x48/1E293B/FFFFFF?text=<?= substr($user->username, 0, 2) ?>" alt="<?= esc($user->username) ?>" class="w-12 h-12 rounded-full">
                                <div>
                                    <p class="font-bold"><?= esc($user->username) ?> <span class="font-normal text-slate-500">@<?= esc($user->username) ?> · <?= esc(CodeIgniter\I18n\Time::parse($post->created_at)->humanize()) ?></span></p>
                                    <p><?= esc($post->content) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="bg-white p-5 rounded-b-lg shadow-sm text-center">
                        <p class="text-slate-500 py-10"><?= esc($user->username) ?> hasn't liked any posts yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
