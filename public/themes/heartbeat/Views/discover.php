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
                                            <a href="<?= site_url(route_to('profile', $user->username)) ?>">
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
                                <a href="<?= site_url(route_to('profile', $activity->user->username ?? 'user')) ?>" class="font-semibold text-indigo hover:underline"><?= esc($activity->user->username ?? 'Unknown User') ?></a>
                                <p class="text-sm text-gray-500"><?= date('M j, Y \a\t g:i a', strtotime($activity->created_at)) ?></p>
                                <p class="mt-2 text-gray-700"><?= esc($activity->content) ?></p>
                            </div>
                        </div>
                        <?php if (auth()->id() === $activity->user_id) : ?>
                        <div class="mt-4 flex justify-end space-x-4">
                            <button data-id="<?= $activity->id ?>" class="delete-button text-sm font-semibold text-red-600 hover:text-red-800">Delete</button>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle Activity Post form submission
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

        // Handle Delete Activity button clicks
        const deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                if (!confirm('Are you sure you want to delete this post?')) {
                    return;
                }

                const activityId = this.dataset.id;
                const url = `/api/activities/delete/${activityId}`;

                const headers = new Headers({
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                });

                fetch(url, {
                    method: 'POST', // Using POST as defined in routes
                    headers: headers,
                    body: JSON.stringify({ id: activityId })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.message) {
                        // Find the closest parent activity container and remove it
                        this.closest('.bg-white.p-6.rounded-lg.shadow-md').remove();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error: ' + (error.messages ? error.messages.error : 'Could not delete the activity.'));
                });
            });
        });
    });
</script>
<?php $this->endSection() ?>
