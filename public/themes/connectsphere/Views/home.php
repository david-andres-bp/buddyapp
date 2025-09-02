<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Home<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="main-grid">
    <!-- Left Column -->
    <aside>
        <!-- User Card -->
        <div class="bg-white p-5 rounded-lg shadow-sm mb-6">
            <div class="flex items-center space-x-4">
                <img src="https://placehold.co/56x56/38BDF8/FFFFFF?text=<?= substr($currentUser->username, 0, 2) ?>" alt="User Avatar" class="w-14 h-14 rounded-full">
                <div>
                    <h2 class="font-bold text-lg"><?= esc($currentUser->username) ?></h2>
                    <p class="text-sm text-slate-500">@<?= esc($currentUser->username) ?></p>
                </div>
            </div>
            <div class="mt-4 flex justify-around text-center text-sm">
                <div>
                    <p class="font-bold"><?= $followingCount ?></p>
                    <p class="text-slate-500">Following</p>
                </div>
                <div>
                    <p class="font-bold"><?= $followersCount ?></p>
                    <p class="text-slate-500">Followers</p>
                </div>
            </div>
        </div>
        <!-- Pinned Profiles -->
        <div class="bg-white p-5 rounded-lg shadow-sm">
            <h3 class="font-bold mb-4">Pinned Profiles</h3>
            <ul class="space-y-4">
                <?php if (!empty($pinnedProfiles)) : ?>
                    <?php foreach ($pinnedProfiles as $profile) : ?>
                        <li class="flex items-center space-x-3 cursor-pointer group">
                            <a href="<?= site_url('profile/' . $profile->username) ?>" class="flex items-center space-x-3">
                                <img src="https://placehold.co/40x40/FBBF24/FFFFFF?text=<?= substr($profile->username, 0, 2) ?>" alt="<?= esc($profile->username) ?>" class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="font-semibold group-hover:text-sky-500"><?= esc($profile->username) ?></p>
                                    <p class="text-sm text-slate-500">@<?= esc($profile->username) ?></p>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="text-sm text-slate-500">You have no pinned profiles.</p>
                <?php endif; ?>
            </ul>
        </div>
    </aside>

    <!-- Center Column (Feed) -->
    <div class="space-y-6">
       <!-- Post Composer -->
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <form action="<?= route_to('post-create') ?>" method="post">
                <?= csrf_field() ?>
                <textarea name="content" class="w-full border-0 p-2 text-lg focus:ring-0" placeholder="What's on your mind?"></textarea>
                <div class="flex justify-between items-center mt-2 pt-2 border-t">
                    <div class="flex space-x-2 text-slate-500">
                        <button type="button" class="hover:bg-slate-200 p-2 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></button>
                        <button type="button" class="hover:bg-slate-200 p-2 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg></button>
                        <button type="button" class="hover:bg-slate-200 p-2 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg></button>
                    </div>
                    <button type="submit" class="bg-sky-500 text-white font-semibold px-6 py-2 rounded-full hover:bg-sky-600">Post</button>
                </div>
            </form>
        </div>

        <!-- Feed Items -->
        <?php if (!empty($posts)) : ?>
            <?php foreach ($posts as $post) : ?>
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <div class="flex items-center space-x-3">
                        <img src="https://placehold.co/48x48/FBBF24/FFFFFF?text=<?= substr($post['user']->username, 0, 2) ?>" alt="<?= $post['user']->username ?>" class="w-12 h-12 rounded-full">
                        <div>
                            <p class="font-bold"><?= esc($post['user']->username) ?> <span class="font-normal text-slate-500">@<?= esc($post['user']->username) ?> · <?= esc(CodeIgniter\I18n\Time::parse($post['created_at'])->humanize()) ?></span></p>
                            <p><?= esc($post['content']) ?></p>
                        </div>
                    </div>
                    <div class="flex justify-around items-center mt-4 pt-3 border-t text-slate-500">
                         <!-- Action Buttons -->
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="bg-white p-5 rounded-lg shadow-sm text-center">
                <p class="text-slate-500">No posts to display. Follow some people to see their posts here.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Right Column -->
    <aside>
        <!-- Who to Follow -->
        <div class="bg-white p-5 rounded-lg shadow-sm mb-6">
            <h3 class="font-bold mb-4">Who to Follow</h3>
            <ul class="space-y-4">
                            <?php if (!empty($suggestions)) : ?>
                                <?php foreach ($suggestions as $suggestion) : ?>
                                    <li class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <a href="<?= site_url('profile/' . $suggestion->username) ?>" class="flex items-center space-x-3">
                                                <img src="https://placehold.co/40x40/F472B6/FFFFFF?text=<?= substr($suggestion->username, 0, 2) ?>" alt="<?= esc($suggestion->username) ?>" class="w-10 h-10 rounded-full">
                                                <div>
                                                    <p class="font-semibold"><?= esc($suggestion->username) ?></p>
                                                    <p class="text-sm text-slate-500">@<?= esc($suggestion->username) ?></p>
                                                </div>
                                            </a>
                                        </div>
                                        <form action="<?= url_to('follow', $suggestion->id) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="bg-slate-800 text-white text-sm font-semibold px-4 py-1.5 rounded-full hover:bg-slate-900">Follow</button>
                                        </form>
                                    </li>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <p class="text-sm text-slate-500">No suggestions at this time.</p>
                            <?php endif; ?>
            </ul>
        </div>
        <!-- Trending -->
        <div class="bg-white p-5 rounded-lg shadow-sm">
             <h3 class="font-bold mb-4">Trending Topics</h3>
             <ul class="space-y-2">
                            <?php if (!empty($trending)) : ?>
                                <?php foreach ($trending as $topic => $count) : ?>
                                    <li class="text-slate-600 hover:text-sky-500"><a href="#"><span class="font-bold">#<?= esc($topic) ?></span> <span class="text-sm text-slate-400"><?= esc($count) ?> Posts</span></a></li>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <p class="text-sm text-slate-500">No trending topics right now.</p>
                            <?php endif; ?>
            </ul>
        </div>
    </aside>
</div>
<?= $this->endSection() ?>
