<h1 class="text-4xl font-serif text-slate-900 mb-6">Compose New Message</h1>

<div class="bg-white p-6 rounded-lg shadow-md">
    <form action="<?= site_url(route_to('message-create')) ?>" method="post">
        <?= csrf_field() ?>

        <!-- Recipient -->
        <div class="mb-4">
            <label for="recipient" class="block text-sm font-medium text-slate-700">Recipient</label>
            <select name="recipient" id="recipient" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-pink focus:ring-pink sm:text-sm">
                <option value="">Select a connection...</option>
                <?php foreach ($connections as $connection): ?>
                    <option value="<?= $connection->id ?>" <?= set_select('recipient', $connection->id) ?>>
                        <?= esc($connection->username) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (session('errors.recipient')): ?>
                <p class="text-sm text-red-600 mt-1"><?= session('errors.recipient') ?></p>
            <?php endif; ?>
        </div>

        <!-- Subject -->
        <div class="mb-4">
            <label for="subject" class="block text-sm font-medium text-slate-700">Subject</label>
            <input type="text" name="subject" id="subject" value="<?= set_value('subject') ?>" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-pink focus:ring-pink sm:text-sm" placeholder="Subject of your message">
            <?php if (session('errors.subject')): ?>
                <p class="text-sm text-red-600 mt-1"><?= session('errors.subject') ?></p>
            <?php endif; ?>
        </div>

        <!-- Message -->
        <div class="mb-4">
            <label for="message" class="block text-sm font-medium text-slate-700">Message</label>
            <textarea name="message" id="message" rows="6" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-pink focus:ring-pink sm:text-sm" placeholder="Write your message here..."><?= set_value('message') ?></textarea>
            <?php if (session('errors.message')): ?>
                <p class="text-sm text-red-600 mt-1"><?= session('errors.message') ?></p>
            <?php endif; ?>
        </div>

        <!-- Submit Button -->
        <div class="text-right">
            <button type="submit" class="btn btn-primary">Send Message</button>
        </div>
    </form>
</div>
