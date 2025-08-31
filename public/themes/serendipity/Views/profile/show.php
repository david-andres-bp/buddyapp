<div class="grid md:grid-cols-3 gap-8">
    <!-- Left Column: Identity and Actions -->
    <div class="md:col-span-1 space-y-6">
        <!-- Profile Photo -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <img src="<?= esc($user->meta->profile_photo ?? 'https://placehold.co/600x600/FBCFE8/9D174D?text=Serendipity') ?>" alt="<?= esc($user->username) ?>" class="w-full h-auto">
        </div>

        <!-- Action Buttons -->
        <div class="bg-white p-4 rounded-lg shadow-md text-center space-y-3">
            <h2 class="text-2xl font-bold font-serif text-ruby"><?= esc($user->username) ?></h2>
            <p class="text-slate-600 text-sm"><?= esc($user->meta->age ?? 'N/A') ?> years old &bull; <?= esc($user->meta->location ?? 'Unknown') ?></p>
            <hr class="my-3">
            <a href="<?= site_url('messages/new?recipient=' . $user->id) ?>" class="btn btn-primary w-full">Send Message</a>
            <a href="<?= site_url('connections/create/' . $user->id) ?>" class="btn btn-secondary w-full">Add Connection</a>
        </div>
    </div>

    <!-- Right Column: Details and Gallery -->
    <div class="md:col-span-2 space-y-8">
        <!-- About Me Section -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-2xl font-serif text-slate-800 border-b pb-2 mb-4">About Me</h3>
            <p class="text-slate-700 leading-relaxed">
                <?= nl2br(esc($user->meta->bio ?? 'No biography provided.')) ?>
            </p>
        </div>

        <!-- Details Section -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-2xl font-serif text-slate-800 border-b pb-2 mb-4">My Details</h3>
            <div class="grid grid-cols-2 gap-4 text-slate-700">
                <div>
                    <strong class="font-semibold">Relationship Goal:</strong>
                    <p><?= esc($user->meta->relationship_goal ?? 'Not specified') ?></p>
                </div>
                <div>
                    <strong class="font-semibold">Occupation:</strong>
                    <p><?= esc($user->meta->occupation ?? 'Not specified') ?></p>
                </div>
                <div>
                    <strong class="font-semibold">Height:</strong>
                    <p><?= esc($user->meta->height ?? 'Not specified') ?></p>
                </div>
                <div>
                    <strong class="font-semibold">Education:</strong>
                    <p><?= esc($user->meta->education ?? 'Not specified') ?></p>
                </div>
            </div>
        </div>

        <!-- Photo Gallery -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-2xl font-serif text-slate-800 border-b pb-2 mb-4">Photo Gallery</h3>
            <div class="grid grid-cols-3 gap-4">
                <?php
                $gallery = isset($user->meta->photo_gallery) ? json_decode($user->meta->photo_gallery, true) : [];
                if (!empty($gallery)):
                    foreach ($gallery as $photo):
                ?>
                        <a href="<?= esc($photo['url']) ?>" data-lightbox="gallery">
                            <img src="<?= esc($photo['url']) ?>" alt="Gallery photo" class="rounded-md w-full h-32 object-cover hover:opacity-80 transition">
                        </a>
                <?php
                    endforeach;
                else:
                ?>
                    <p class="text-slate-500 col-span-3">No photos in the gallery yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Lightbox2 for gallery, if you add it via CDN -->
<?= $this->section('scripts') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox-plus-jquery.min.js"></script>
<?= $this->endSection() ?>
