<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold font-serif text-indigo mb-6">Send a New Message</h1>

    <div class="bg-white p-8 rounded-lg shadow-md">
        <form action="<?= url_to('message-create') ?>" method="post">
            <?= csrf_field() ?>

            <!-- Recipient -->
            <div class="mb-4">
                <label for="recipient" class="block text-gray-700 font-semibold mb-2">To:</label>
                <select id="recipient" name="recipient" class="w-full p-3 border border-gray-300 rounded-lg" required>
                    <option value="">Select a connection...</option>
                    <?php foreach ($connections as $conn): ?>
                        <option value="<?= $conn->id ?>"><?= esc($conn->username) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Subject -->
            <div class="mb-4">
                <label for="subject" class="block text-gray-700 font-semibold mb-2">Subject</label>
                <input type="text" id="subject" name="subject" class="w-full p-3 border border-gray-300 rounded-lg" value="<?= old('subject') ?>" required>
            </div>

            <!-- Message -->
            <div class="mb-6">
                <label for="message" class="block text-gray-700 font-semibold mb-2">Message</label>
                <textarea id="message" name="message" class="w-full p-3 border border-gray-300 rounded-lg" rows="8" required><?= old('message') ?></textarea>
            </div>

            <!-- Submit Button -->
            <div class="text-right">
                <button type="submit" class="bg-coral text-white font-semibold px-8 py-3 rounded-full hover:bg-coral-dark transition">Send Message</button>
            </div>
        </form>
    </div>
</div>
