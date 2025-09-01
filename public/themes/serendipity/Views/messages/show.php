<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1 class="text-4xl font-serif text-slate-900 mb-6"><?= esc($thread->subject) ?></h1>

<div class="bg-white p-6 rounded-lg shadow-md">
    <!-- Message History -->
    <div class="space-y-6 mb-8">
        <?php foreach ($messages as $message):
            $isCurrentUser = $message->sender_id === auth()->id();
        ?>
            <div class="flex <?= $isCurrentUser ? 'justify-end' : 'justify-start' ?>">
                <div class="flex items-start gap-3 max-w-lg">
                    <?php if (!$isCurrentUser): ?>
                        <img src="<?= esc($message->sender->meta->profile_photo ?? 'https://placehold.co/80x80/FBCFE8/9D174D?text=S') ?>" alt="<?= esc($message->sender->username) ?>" class="w-10 h-10 rounded-full object-cover">
                    <?php endif; ?>

                    <div class="p-4 rounded-lg <?= $isCurrentUser ? 'bg-ruby text-white' : 'bg-slate-100' ?>">
                        <p class="text-sm"><?= nl2br(esc($message->message)) ?></p>
                        <div class="text-xs mt-2 <?= $isCurrentUser ? 'text-white/70' : 'text-slate-500' ?>">
                            <?= esc($message->sender->username) ?> &bull; <?= $message->created_at->humanize() ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Reply Form -->
    <hr class="my-6">
    <form action="<?= site_url('messages/reply/' . $thread->id) ?>" method="post">
        <?= csrf_field() ?>
        <div>
            <label for="message" class="block text-sm font-medium text-slate-700">Your Reply</label>
            <textarea name="message" id="message" rows="4" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-pink focus:ring-pink sm:text-sm" placeholder="Type your message..."></textarea>
        </div>
        <div class="mt-4 text-right">
            <button type="submit" class="btn btn-primary">Send Reply</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
