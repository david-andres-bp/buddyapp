<div class="space-y-8">
    <!-- Pending Requests -->
    <div>
        <h2 class="text-2xl font-bold font-serif text-indigo mb-4">Connection Requests</h2>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <?php if (empty($pendingReceived)) : ?>
                <p class="text-gray-500">You have no pending connection requests.</p>
            <?php else : ?>
                <div class="space-y-4">
                    <?php foreach ($pendingReceived as $request) : ?>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img src="https://i.pravatar.cc/150?u=<?= esc($request->user->username) ?>" alt="<?= esc($request->user->username) ?>" class="w-12 h-12 rounded-full mr-4">
                                <div>
                                    <a href="<?= site_url(route_to('profile', $request->user->username)) ?>" class="font-semibold text-indigo hover:underline"><?= esc($request->user->username) ?></a>
                                    <p class="text-sm text-gray-500">Wants to connect with you.</p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <form action="<?= url_to('connection-accept', $request->id) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="bg-green-500 text-white font-semibold px-4 py-2 rounded-full hover:bg-green-600 transition">Accept</button>
                                </form>
                                <form action="<?= url_to('connection-decline', $request->id) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="bg-red-500 text-white font-semibold px-4 py-2 rounded-full hover:bg-red-600 transition">Decline</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Sent Requests -->
    <div>
        <h2 class="text-2xl font-bold font-serif text-indigo mb-4">Sent Requests</h2>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <?php if (empty($pendingSent)) : ?>
                <p class="text-gray-500">You have no pending sent requests.</p>
            <?php else : ?>
                <div class="space-y-4">
                    <?php foreach ($pendingSent as $request) : ?>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img src="https://i.pravatar.cc/150?u=<?= esc($request->friend->username) ?>" alt="<?= esc($request->friend->username) ?>" class="w-12 h-12 rounded-full mr-4">
                                <div>
                                    <a href="<?= site_url(route_to('profile', $request->friend->username)) ?>" class="font-semibold text-indigo hover:underline"><?= esc($request->friend->username) ?></a>
                                    <p class="text-sm text-gray-500">Request sent.</p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <form action="<?= url_to('connection-cancel', $request->id) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="bg-gray-500 text-white font-semibold px-4 py-2 rounded-full hover:bg-gray-600 transition">Cancel</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Current Connections -->
    <div>
        <h2 class="text-2xl font-bold font-serif text-indigo mb-4">Your Connections</h2>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <?php if (empty($currentConnections)) : ?>
                <p class="text-gray-500">You have no connections yet.</p>
            <?php else : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach ($currentConnections as $conn) : ?>
                        <div class="flex items-center justify-between p-3 border rounded-lg">
                            <div class="flex items-center">
                                <img src="https://i.pravatar.cc/150?u=<?= esc($conn->friend->username) ?>" alt="<?= esc($conn->friend->username) ?>" class="w-12 h-12 rounded-full mr-4">
                                <div>
                                    <a href="<?= site_url(route_to('profile', $conn->friend->username)) ?>" class="font-semibold text-indigo hover:underline"><?= esc($conn->friend->username) ?></a>
                                    <p class="text-sm text-gray-500">Connected</p>
                                </div>
                            </div>
                            <form action="<?= url_to('connection-remove', $conn->id) ?>" method="post" onsubmit="return confirm('Are you sure you want to remove this connection?');">
                                <?= csrf_field() ?>
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold">Remove</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
