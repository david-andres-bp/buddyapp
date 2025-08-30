<div class="space-y-8">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold font-serif text-indigo">Inbox</h1>
        <a href="<?= site_url(route_to('message-new')) ?>" class="bg-coral text-white font-semibold px-6 py-2 rounded-full hover:bg-coral-dark transition">New Message</a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <?php if (empty($threads)) : ?>
            <p class="text-gray-500">You have no messages.</p>
        <?php else : ?>
            <div class="divide-y divide-gray-200">
                <?php foreach ($threads as $thread) : ?>
                    <a href="<?= site_url(route_to('message-show', $thread->id)) ?>" class="block p-4 hover:bg-gray-50 <?= (int)$thread->is_read === 0 ? 'bg-indigo-50' : '' ?>">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-indigo truncate <?= (int)$thread->is_read === 0 ? 'font-bold' : '' ?>"><?= esc($thread->subject ?: 'No Subject') ?></p>
                                <p class="text-sm text-gray-500">
                                    With: <span class="font-medium"><?= esc($thread->other_user->username ?? 'Unknown User') ?></span>
                                </p>
                            </div>
                            <p class="text-sm text-gray-500 flex-shrink-0 ml-4"><?= date('M j, Y', strtotime($thread->last_message->created_at)) ?></p>
                        </div>
                        <p class="text-gray-600 mt-2 text-sm truncate">
                            <span class="font-semibold"><?= $thread->last_message->sender_id === auth()->id() ? 'You' : esc($thread->last_message->sender->username ?? 'User') ?>:</span>
                            <?= esc(strip_tags($thread->last_message->message)) ?>
                        </p>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
