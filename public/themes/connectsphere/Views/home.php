<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Home<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="main-grid">
    <!-- Left Column -->
    <aside>
        <!-- User Card -->
        <div class="bg-white p-5 rounded-lg shadow-sm mb-6">
            <div class="flex items-center space-x-4">
                <img src="https://placehold.co/56x56/38BDF8/FFFFFF?text=A" alt="User Avatar" class="w-14 h-14 rounded-full">
                <div>
                    <h2 class="font-bold text-lg">Alex Johnson</h2>
                    <p class="text-sm text-slate-500">@alexj</p>
                </div>
            </div>
            <div class="mt-4 flex justify-around text-center text-sm">
                <div>
                    <p class="font-bold">1,256</p>
                    <p class="text-slate-500">Following</p>
                </div>
                <div>
                    <p class="font-bold">2,840</p>
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
                 <li class="flex items-center space-x-3 cursor-pointer group">
                    <img src="https://placehold.co/40x40/F87171/FFFFFF?text=EP" alt="Emily" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="font-semibold group-hover:text-sky-500">Emily Parker</p>
                        <p class="text-sm text-slate-500">@emilyp</p>
                    </div>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Center Column (Feed) -->
    <div class="space-y-6">
       <!-- Post Composer -->
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <textarea class="w-full border-0 p-2 text-lg focus:ring-0" placeholder="What's on your mind?"></textarea>
            <div class="flex justify-between items-center mt-2 pt-2 border-t">
                <div class="flex space-x-2 text-slate-500">
                    <button class="hover:bg-slate-200 p-2 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></button>
                    <button class="hover:bg-slate-200 p-2 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg></button>
                    <button class="hover:bg-slate-200 p-2 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg></button>
                </div>
                <button class="bg-sky-500 text-white font-semibold px-6 py-2 rounded-full hover:bg-sky-600">Post</button>
            </div>
        </div>

        <!-- Feed Item -->
        <div class="bg-white p-5 rounded-lg shadow-sm">
            <div class="flex items-center space-x-3">
                <img src="https://placehold.co/48x48/FBBF24/FFFFFF?text=LS" alt="Laura" class="w-12 h-12 rounded-full">
                <div>
                    <p class="font-bold">Laura Smith <span class="font-normal text-slate-500">@lauras · 2h</span></p>
                    <p>Just released my new photography portfolio website! Built with so much love (and lots of coffee). Check it out and let me know what you think! #webdev #photography</p>
                </div>
            </div>
            <img src="https://placehold.co/600x400/CCCCCC/FFFFFF?text=Portfolio+Screenshot" alt="Portfolio" class="mt-3 rounded-lg w-full">
            <div class="flex justify-around items-center mt-4 pt-3 border-t text-slate-500">
                 <!-- Action Buttons -->
            </div>
        </div>
        <!-- ... more feed items ... -->
    </div>

    <!-- Right Column -->
    <aside>
        <!-- Who to Follow -->
        <div class="bg-white p-5 rounded-lg shadow-sm mb-6">
            <h3 class="font-bold mb-4">Who to Follow</h3>
            <ul class="space-y-4">
               <!-- ... user suggestions ... -->
            </ul>
        </div>
        <!-- Trending -->
        <div class="bg-white p-5 rounded-lg shadow-sm">
             <h3 class="font-bold mb-4">Trending Topics</h3>
             <ul class="space-y-2">
               <!-- ... trending topics ... -->
            </ul>
        </div>
    </aside>
</div>
<?= $this->endSection() ?>
