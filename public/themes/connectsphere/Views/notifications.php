<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Notifications<?= $this->endSection() ?>

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
                <li class="flex items-center space-x-3 cursor-pointer group">
                    <img src="https://placehold.co/40x40/FBBF24/FFFFFF?text=LS" alt="Laura" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="font-semibold group-hover:text-sky-500">Laura Smith</p>
                        <p class="text-sm text-slate-500">@lauras</p>
                    </div>
                </li>
                <li class="flex items-center space-x-3 cursor-pointer group">
                    <img src="https://placehold.co/40x40/34D399/FFFFFF?text=CW" alt="Chris" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="font-semibold group-hover:text-sky-500">Chris Williams</p>
                        <p class="text-sm text-slate-500">@chrisw</p>
                    </div>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Center Column (Notifications) -->
    <div>
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-5 border-b">
                <h1 class="text-xl font-bold">Notifications</h1>
            </div>

            <!-- Notification List -->
            <div>
                <?php if (!empty($notifications)) : ?>
                    <?php foreach ($notifications as $notification) : ?>
                        <?php if ($notification['type'] === 'new_follower') : ?>
                            <!-- Notification Item: Follow -->
                            <div class="flex items-start space-x-4 p-5 border-b hover:bg-slate-50 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-sky-500 mt-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                                <div>
                                    <img src="https://placehold.co/40x40/34D399/FFFFFF?text=<?= substr($notification['follower']->username, 0, 2) ?>" alt="User Avatar" class="w-10 h-10 rounded-full mb-2">
                                    <p><a href="<?= site_url('profile/' . $notification['follower']->username) ?>" class="font-bold"><?= esc($notification['follower']->username) ?></a> followed you. <span class="text-slate-500 text-sm"><?= esc(CodeIgniter\I18n\Time::parse($notification['created_at'])->humanize()) ?></span></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="p-5 text-center">
                        <p class="text-slate-500">You have no notifications.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <aside>
        <!-- Who to Follow -->
        <div class="bg-white p-5 rounded-lg shadow-sm mb-6">
            <h3 class="font-bold mb-4">Who to Follow</h3>
            <ul class="space-y-4">
               <li class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img src="https://placehold.co/40x40/F472B6/FFFFFF?text=BR" alt="Ben" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-semibold">Ben Rivera</p>
                            <p class="text-sm text-slate-500">@benr</p>
                        </div>
                    </div>
                    <button class="bg-slate-800 text-white text-sm font-semibold px-4 py-1.5 rounded-full hover:bg-slate-900">Follow</button>
               </li>
               <li class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img src="https://placehold.co/40x40/A78BFA/FFFFFF?text=OM" alt="Olivia" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-semibold">Olivia Martinez</p>
                            <p class="text-sm text-slate-500">@oliviam</p>
                        </div>
                    </div>
                    <button class="bg-slate-800 text-white text-sm font-semibold px-4 py-1.5 rounded-full hover:bg-slate-900">Follow</button>
               </li>
            </ul>
        </div>
        <!-- Trending -->
        <div class="bg-white p-5 rounded-lg shadow-sm">
             <h3 class="font-bold mb-4">Trending Topics</h3>
             <ul class="space-y-2">
                <li class="text-slate-600 hover:text-sky-500"><a href="#"><span class="font-bold">#PHP</span> <span class="text-sm text-slate-400">15.2k Posts</span></a></li>
                <li class="text-slate-600 hover:text-sky-500"><a href="#"><span class="font-bold">#CodeIgniter4</span> <span class="text-sm text-slate-400">8.9k Posts</span></a></li>
                <li class="text-slate-600 hover:text-sky-500"><a href="#"><span class="font-bold">#WebDevelopment</span> <span class="text-sm text-slate-400">45.7k Posts</span></a></li>
             </ul>
        </div>
    </aside>
</div>
<?= $this->endSection() ?>
