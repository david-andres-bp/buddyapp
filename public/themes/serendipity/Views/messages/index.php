<div class="flex justify-between items-center mb-6">
    <h1 class="text-4xl font-serif text-slate-900">My Messages</h1>
    <a href="<?= site_url(route_to('message-new')) ?>" class="btn btn-primary">New Message</a>
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <?php if (!empty($threads)): ?>
        <div class="space-y-2">
            <?php foreach ($threads as $thread): ?>
                <a href="<?= site_url('messages/' . $thread->id) ?>" class="block p-4 rounded-lg hover:bg-pink-light transition">
                    <div class="flex justify-between">
                        <p class="font-semibold text-ruby"><?= esc($thread->subject) ?></p>
                        <span class="text-sm text-slate-500"><?= $thread->created_at->humanize() ?></span>
                    </div>
                    <p class="text-sm text-slate-600">
                        <!-- This would ideally show the other participant's name and last message snippet -->
                        Click to view conversation.
                    </p>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-slate-500">You have no messages yet.</p>
    <?php endif; ?>
</div>
