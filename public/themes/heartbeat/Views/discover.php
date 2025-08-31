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
                                <?php if (!empty($activity->attachment_url)) : ?>
                                    <div class="mt-4">
                                        <img src="<?= site_url($activity->attachment_url) ?>" alt="Activity attachment" class="rounded-lg max-w-full h-auto">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if (auth()->id() == $activity->user_id) : ?>
                        <div class="mt-4 flex justify-end space-x-4">
                            <button data-id="<?= $activity->id ?>" class="edit-button text-sm font-semibold text-gray-600 hover:text-gray-800">Edit</button>
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

        // Use event delegation for dynamically added buttons
        const activityFeed = document.querySelector('.space-y-6');
        if(activityFeed) {
            activityFeed.addEventListener('click', function(e) {
                const button = e.target;

                // Handle Edit
                if (button.classList.contains('edit-button')) {
                    e.preventDefault();
                    const postContainer = button.closest('.bg-white.p-6.rounded-lg.shadow-md');
                    const contentP = postContainer.querySelector('p.mt-2.text-gray-700');
                    if (!contentP) return;

                    const originalContent = contentP.innerHTML;
                    const textarea = document.createElement('textarea');
                    textarea.className = 'w-full p-2 border border-gray-300 rounded';
                    textarea.rows = 4;
                    textarea.value = contentP.innerText;
                    contentP.replaceWith(textarea);

                    const buttonContainer = button.parentElement;
                    const activityId = button.dataset.id;
                    buttonContainer.innerHTML = `
                        <button class="cancel-edit-button text-sm font-semibold text-gray-600 hover:text-gray-800">Cancel</button>
                        <button data-id="${activityId}" class="save-edit-button text-sm font-semibold text-green-600 hover:text-green-800">Save</button>
                    `;
                    postContainer.dataset.originalContent = originalContent;
                    postContainer.dataset.originalButtons = buttonContainer.innerHTML; // Save original buttons
                }

                // Handle Save
                if (button.classList.contains('save-edit-button')) {
                    e.preventDefault();
                    const activityId = button.dataset.id;
                    const postContainer = button.closest('.bg-white.p-6.rounded-lg.shadow-md');
                    const textarea = postContainer.querySelector('textarea');
                    const newContent = textarea.value;
                    const formData = new FormData();
                    formData.append('content', newContent);

                    fetch(`/api/activities/update/${activityId}`, {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            const newP = document.createElement('p');
                            newP.className = 'mt-2 text-gray-700';
                            newP.innerText = newContent;
                            textarea.replaceWith(newP);
                            button.parentElement.innerHTML = `
                                <button data-id="${activityId}" class="edit-button text-sm font-semibold text-gray-600 hover:text-gray-800">Edit</button>
                                <button data-id="${activityId}" class="delete-button text-sm font-semibold text-red-600 hover:text-red-800">Delete</button>
                            `;
                        } else {
                            alert('Error: ' + (data.messages ? data.messages.error : 'Could not update post.'));
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }

                // Handle Cancel
                if (button.classList.contains('cancel-edit-button')) {
                    e.preventDefault();
                    const postContainer = button.closest('.bg-white.p-6.rounded-lg.shadow-md');
                    const textarea = postContainer.querySelector('textarea');
                    const newP = document.createElement('p');
                    newP.className = 'mt-2 text-gray-700';
                    newP.innerHTML = postContainer.dataset.originalContent;
                    textarea.replaceWith(newP);

                    const activityId = postContainer.querySelector('.delete-button, .edit-button').dataset.id;
                     button.parentElement.innerHTML = `
                        <button data-id="${activityId}" class="edit-button text-sm font-semibold text-gray-600 hover:text-gray-800">Edit</button>
                        <button data-id="${activityId}" class="delete-button text-sm font-semibold text-red-600 hover:text-red-800">Delete</button>
                    `;
                }

                // Handle Delete
                if (button.classList.contains('delete-button')) {
                    e.preventDefault();
                    if (!confirm('Are you sure you want to delete this post?')) return;

                    const activityId = button.dataset.id;
                    const url = `/api/activities/delete/${activityId}`;
                    fetch(url, {
                        method: 'POST',
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: activityId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            button.closest('.bg-white.p-6.rounded-lg.shadow-md').remove();
                        } else {
                             alert('Error: ' + (data.messages ? data.messages.error : 'Could not delete the activity.'));
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            });
        }
    });
</script>
<?php $this->endSection() ?>
