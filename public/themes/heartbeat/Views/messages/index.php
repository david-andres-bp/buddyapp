<div class="space-y-8">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold font-serif text-indigo">Inbox</h1>
        <a href="<?= site_url(route_to('message-new')) ?>" class="bg-coral text-white font-semibold px-6 py-2 rounded-full hover:bg-coral-dark transition">New Message</a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <?php if (empty($threads)) : ?>
            <p class="text-gray-500">You have no messages.</p>
        <?php else : ?>
            <div class="space-y-4">
                <?php foreach ($threads as $thread) : ?>
                    <a href="<?= site_url(route_to('message-show', $thread->id)) ?>" class="block p-4 border rounded-lg hover:bg-gray-50">
                        <div class="flex justify-between">
                            <p class="font-semibold text-indigo"><?= esc($thread->subject ?: 'No Subject') ?></p>
                            <!-- Placeholder for last message time -->
                            <p class="text-sm text-gray-500">2 hours ago</p>
                        </div>
                        <!-- Placeholder for last message snippet -->
                        <p class="text-gray-600 mt-1 truncate">
                            Hey, just checking in to see how you're doing...
                        </p>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
