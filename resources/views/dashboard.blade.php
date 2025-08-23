@if(session('toast_warning'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition:enter="transform ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transform ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="fixed top-6 left-1/2 z-500 max-w-xs -translate-x-1/2 rounded-xl bg-red-500 px-6 py-4 text-white shadow-2xl flex items-center gap-3"
        role="alert"
    >
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2">
            <flux:icon.shield-exclamation class="w-6 h-6" />
            <strong class="font-bold">Atención:</strong>
            </div>
            <div class="text-sm">{{ session('toast_warning') }}</div>
        </div>
    </div>
    @php session()->forget('toast_warning'); @endphp
@endif

@if(session('toast_success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition:enter="transform ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transform ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="fixed top-6 left-1/2 z-50 max-w-xs -translate-x-1/2 rounded-xl bg-green-600 px-6 py-4 text-white shadow-2xl flex items-center gap-3"
        role="alert"
    >
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2">
                <flux:icon.check-circle class="w-6 h-6" />
                <strong class="font-bold">Éxito</strong>
            </div>
            <div class="text-sm">{{ session('toast_success') }}</div>
        </div>
    </div>
    @php session()->forget('toast_success'); @endphp
@endif

<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <livewire:components.data-table
                model-class="App\Models\User"
                :columns="[
                    ['label' => 'ID', 'field' => 'id'],
                    ['label' => 'Nombre', 'field' => 'name'],
                    ['label' => 'Correo', 'field' => 'email'],
                    ['label' => 'Creacion', 'field' => 'created_at'],
                    ['label' => 'Verificacion', 'field' => 'email_verified_at'],
                    ['label' => 'Estado', 'field' => 'deleted_at'],
                ]"
            />
        </div>
    </div>
</x-layouts.app>
