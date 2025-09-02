<?= $this->extend('layout') ?>

<?= $this->section('title') ?>Messages<?= $this->endSection() ?>

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
                    <?php foreach ($threads as $thread) : ?>
                        <li class="p-5 border-b hover:bg-slate-50 cursor-pointer">
                            <a href="<?= site_url('messages/' . $thread['id']) ?>">
                                <p class="font-bold">
                                    <?php
                                    $participantNames = array_map(function ($p) {
                                        return esc($p->username);
                                    }, $thread['participants']);
                                    echo implode(', ', $participantNames);
                                    ?>
                                </p>
                                <p class="text-sm text-slate-500 truncate"><?= esc($thread['last_message']['content'] ?? '') ?></p>
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
    <div class="w-2/3 bg-slate-100">
        <div class="p-5 text-center">
            <p class="text-slate-500">Select a conversation to start messaging.</p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
