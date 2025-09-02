<?= $this->extend('layout') ?>

<?= $this->section('title') ?><?= esc($thread->subject) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex h-screen">
    <!-- Left Pane: Thread List -->
    <div class="w-1/3 bg-white border-r">
        <div class="p-5 border-b">
            <h1 class="text-xl font-bold">Messages</h1>
        </div>
        <div>
            <?php if (!empty($threads)) : ?>
                <ul>
                    <?php foreach ($threads as $t) : ?>
                        <li class="p-5 border-b hover:bg-slate-50 cursor-pointer <?= $t->id === $thread->id ? 'bg-slate-100' : '' ?>">
                            <a href="<?= url_to('message-show', $t->id) ?>">
                                <p class="font-bold">
                                    <?php
                                    $participantNames = array_map(function ($p) {
                                        return esc($p->username);
                                    }, $t->participants);
                                    echo implode(', ', $participantNames);
                                    ?>
                                </p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="p-5 text-center text-slate-500">You have no messages.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Right Pane: Chat Window -->
    <div class="w-2/3 bg-slate-100 flex flex-col">
        <div class="p-5 border-b bg-white">
            <h2 class="text-lg font-bold"><?= esc($thread->subject) ?></h2>
        </div>
        <div class="flex-grow p-5 overflow-y-auto">
            <?php if (!empty($messages)) : ?>
                <?php foreach ($messages as $message) : ?>
                    <div class="flex <?= $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' ?> mb-4">
                        <div class="bg-white rounded-lg p-3 max-w-lg">
                            <p class="font-bold"><?= esc($message->sender->username) ?></p>
                            <p><?= esc($message->message) ?></p>
                            <p class="text-xs text-slate-500 mt-1 text-right"><?= esc(CodeIgniter\I18n\Time::parse($message->created_at)->humanize()) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-center text-slate-500">No messages in this thread yet.</p>
            <?php endif; ?>
        </div>
        <div class="p-5 bg-white border-t">
            <form action="<?= site_url('message-reply/' . $thread->id) ?>" method="post">
                <?= csrf_field() ?>
                <div class="flex">
                    <input type="text" name="message" class="w-full border-slate-300 rounded-l-lg" placeholder="Type your message...">
                    <button type="submit" class="bg-sky-500 text-white font-semibold px-6 py-2 rounded-r-lg hover:bg-sky-600">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
