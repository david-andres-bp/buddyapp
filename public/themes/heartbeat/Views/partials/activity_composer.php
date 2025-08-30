<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold font-serif text-indigo mb-4">Share an Activity</h2>
    <form id="activity-form" action="<?= url_to('api-activities') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <textarea name="content" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" rows="4" placeholder="What's on your mind?"></textarea>
        <div class="mt-4">
            <label for="attachment" class="block text-sm font-medium text-gray-700">Attach a photo or video</label>
            <input type="file" name="attachment" id="attachment" class="mt-1 block w-full text-sm text-gray-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-full file:border-0
                file:text-sm file:font-semibold
                file:bg-indigo-50 file:text-indigo-700
                hover:file:bg-indigo-100
            "/>
        </div>
        <div class="mt-4 flex justify-end">
            <button type="submit" class="bg-coral text-white font-semibold px-6 py-2 rounded-full hover:bg-coral-dark transition">Post</button>
        </div>
    </form>
</div>
