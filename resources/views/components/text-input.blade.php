@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 rounded-md shadow-sm transition duration-200 ease-in-out px-4 py-2 placeholder-gray-400 text-gray-800 hover:border-blue-400 hover:shadow-md']) }} />
