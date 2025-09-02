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
                <!-- Pinned profiles would be dynamic here -->
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
               <!-- Who to follow would be dynamic here -->
            </ul>
        </div>
        <!-- Trending -->
        <div class="bg-white p-5 rounded-lg shadow-sm">
             <h3 class="font-bold mb-4">Trending Topics</h3>
             <ul class="space-y-2">
                <!-- Trending topics would be dynamic here -->
             </ul>
        </div>
    </aside>
</div>
<?= $this->endSection() ?>
