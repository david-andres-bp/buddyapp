<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <div>
        <a href="<?= route_to('messages') ?>" class="text-indigo hover:underline">&larr; Back to Inbox</a>
        <h1 class="text-3xl font-bold font-serif text-indigo mt-2"><?= esc($thread->subject ?: 'Conversation') ?></h1>
    </div>

    <!-- Message List -->
    <div class="space-y-4">
        <?php foreach ($messages as $message) : ?>
            <?php $isMe = $message->sender_id === auth()->id(); ?>
            <div class="flex <?= $isMe ? 'justify-end' : 'justify-start' ?>">
                <div class="flex items-start gap-4 max-w-lg">
                    <?php if (!$isMe): ?>
                        <img src="https://i.pravatar.cc/150?u=<?= esc($message->sender->username ?? 'user') ?>" alt="" class="w-10 h-10 rounded-full">
                    <?php endif; ?>

                    <div class="p-4 rounded-lg <?= $isMe ? 'bg-indigo text-white' : 'bg-white shadow-md' ?>">
                        <p><?= esc($message->message) ?></p>
                        <p class="text-xs mt-2 <?= $isMe ? 'text-indigo-200' : 'text-gray-500' ?>">
                            <?= date('M j, g:i a', strtotime($message->created_at)) ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Reply Form -->
    <div class="mt-6 pt-6 border-t">
        <form action="<?= site_url('messages/reply/' . $thread->id) ?>" method="post">
            <?= csrf_field() ?>
            <h2 class="text-2xl font-semibold mb-2">Send a Reply</h2>
            <textarea name="message" class="w-full p-3 border border-gray-300 rounded-lg" rows="4" placeholder="Type your message..."></textarea>
            <div class="mt-4 text-right">
                <button type="submit" class="bg-coral text-white font-semibold px-8 py-3 rounded-full hover:bg-coral-dark transition">Send</button>
            </div>
        </form>
    </div>

</div>

<?= $this->endSection() ?>
