<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-8">
    <?= $this->include('partials/activity_composer') ?>

    <div>
        <h2 class="text-2xl font-bold font-serif text-indigo mb-4">Discover People</h2>

        <?php if (empty($usersByTag)) : ?>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <p class="text-gray-500">No users to discover right now. Try posting some activities to build the community!</p>
            </div>
        <?php else : ?>
            <div class="space-y-8">
                <?php foreach ($usersByTag as $tag => $users) : ?>
                    <?php if (!empty($users)) : ?>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-3"><?= esc(ucfirst($tag)) ?></h3>
                            <div class="relative">
                                <div class="flex space-x-4 overflow-x-auto pb-4">
                                    <?php foreach ($users as $user) : ?>
                                        <div class="flex-shrink-0 w-48 bg-white rounded-lg shadow-md text-center p-4">
                                            <a href="<?= route_to('profile', $user->username) ?>">
                                                <img src="https://i.pravatar.cc/150?u=<?= esc($user->username) ?>" alt="<?= esc($user->username) ?>" class="w-24 h-24 rounded-full mx-auto mb-3">
                                                <h4 class="font-semibold text-indigo"><?= esc($user->username) ?></h4>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Recent Activities Feed -->
    <div class="mt-8">
        <h2 class="text-2xl font-bold font-serif text-indigo mb-4">Recent Activity</h2>
        <div class="space-y-6">
            <?php if (empty($recentActivities)) : ?>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p class="text-gray-500">No activities yet. Be the first to post!</p>
                </div>
            <?php else : ?>
                <?php foreach ($recentActivities as $activity) : ?>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-start">
                            <img src="https://i.pravatar.cc/150?u=<?= esc($activity->user->username ?? 'user') ?>" alt="<?= esc($activity->user->username ?? 'user') ?>" class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <a href="<?= route_to('profile', $activity->user->username ?? 'user') ?>" class="font-semibold text-indigo hover:underline"><?= esc($activity->user->username ?? 'Unknown User') ?></a>
                                <p class="text-sm text-gray-500"><?= date('M j, Y \a\t g:i a', strtotime($activity->created_at)) ?></p>
                                <p class="mt-2 text-gray-700"><?= esc($activity->content) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('activity-form');
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
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        window.location.reload();
                    } else {
                        alert('Error: ' + (data.messages.error || 'Could not post activity.'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An unexpected error occurred.');
                });
            });
        }
    });
</script>
<?= $this->endSection() ?>
