<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <h1 class="text-2xl font-bold font-serif text-indigo mb-4">Edit Activity</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form id="edit-activity-form" action="<?= site_url(route_to('api-activity-update', $activity->id)) ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-4">
                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Your Activity:</label>
                <textarea id="content" name="content" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="4" required><?= esc($activity->content, 'html') ?></textarea>
            </div>
            <div class="flex items-center justify-end">
                <a href="<?= site_url('/') ?>" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800 mr-4">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition-colors">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('edit-activity-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                const action = form.getAttribute('action');

                const headers = new Headers({
                    'X-Requested-With': 'XMLHttpRequest'
                });

                fetch(action, {
                    method: 'POST',
                    body: formData,
                    headers: headers
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.message) {
                        // Redirect to the discover page on success
                        window.location.href = '<?= site_url('/') ?>';
                    } else if (data.messages && data.messages.error) {
                        alert('Error: ' + data.messages.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An unexpected error occurred while updating the activity.');
                });
            });
        }
    });
</script>
<?= $this->endSection() ?>
