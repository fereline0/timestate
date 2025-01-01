<label for="{{ $id }}" class="inline-flex items-center cursor-pointer">
    <input id="{{ $id }}" type="checkbox" name="{{ $name }}" value="{{ $value }}"
        class="form-checkbox h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out {{ $checked ? 'checked' : '' }}">
    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ $label }}</span>
</label>
