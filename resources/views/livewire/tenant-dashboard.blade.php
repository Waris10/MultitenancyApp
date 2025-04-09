<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <div
            class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
            <h2 class="text-lg font-semibold">Welcome, {{ $user->name }}</h2>
            <p class="text-sm text-gray-600 dark:text-gray-300">Your Store: <strong>{{ $tenant->name }}</strong></p>
        </div>

        <div
            class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
            <h3 class="text-base font-medium">Slug</h3>
            <p>{{ $tenant->slug }}</p>
        </div>

        <div
            class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
            <h3 class="text-base font-medium">Subdomain</h3>
            <p><a href="http://{{ $tenant->slug }}.{{ config('app.main_domain') }}" target="_blank"
                    class="text-blue-500 underline">
                    {{ $tenant->slug }}.{{ config('app.main_domain') }}
                </a></p>
        </div>
    </div>

    <div
        class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
        <h2 class="text-xl font-semibold mb-2">Next Step</h2>
        <p>Manage your products, customize your store, and more.</p>
        <a href="" class="inline-block mt-4 text-white bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">
            Manage Products
        </a>
    </div>
</div>
