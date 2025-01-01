<select
    {{ $attributes->merge([
        'class' => 'border-gray-300
                focus:border-blue-500 rounded-md',
    ]) }}>
    {{ $slot }}
</select>
