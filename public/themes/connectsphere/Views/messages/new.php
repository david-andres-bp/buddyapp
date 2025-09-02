<?= $this->extend('layout') ?>

<?= $this->section('title') ?>New Message<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">New Message</h1>
    <form action="<?= url_to('message-create') ?>" method="post">
        <?= csrf_field() ?>
        <div class="space-y-4">
            <div>
                <label for="recipient" class="block font-medium">Recipient</label>
                <select name="recipient" id="recipient" class="w-full border-slate-300 rounded-lg">
                    <?php foreach ($users as $user) : ?>
                        <option value="<?= $user->id ?>"><?= esc($user->username) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="content" class="block font-medium">Message</label>
                <textarea name="content" id="content" rows="5" class="w-full border-slate-300 rounded-lg"></textarea>
            </div>
            <div>
                <button type="submit" class="bg-sky-500 text-white font-semibold px-6 py-2 rounded-lg hover:bg-sky-600">Send</button>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
