<div x-data="{ show: true }" 
    x-trap="show" 
    x-show="show"
    @password-set-success.window="show = false"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60">
    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl p-6 w-full max-w-md mx-auto">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Establecé una contraseña</h2>

        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
            Tu cuenta fue creada usando Google o Facebook. Por seguridad, agregá una contraseña.
        </p>

        <form wire:submit.prevent="save" class="space-y-4">
            <div>
                <input type="password" wire:model.defer="password" placeholder="Contraseña"
                    class="w-full rounded border p-2 dark:bg-zinc-900 dark:text-white" />
                @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <input type="password" wire:model.defer="password_confirmation" placeholder="Confirmar contraseña"
                    class="w-full rounded border p-2 dark:bg-zinc-900 dark:text-white" />
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
                Guardar contraseña
            </button>
        </form>
    </div>
</div>