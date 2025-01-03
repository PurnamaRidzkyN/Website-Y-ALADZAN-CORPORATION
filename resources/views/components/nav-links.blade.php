@props(['active'=>false])
<a {{ $attributes->merge([
    'class' => 'block rounded-md ' . (request()->is(trim($attributes->get('href'), '/')) 
        ? 'bg-gray-900 px-3 py-2 text-sm font-medium text-white' 
        : 'px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white')
]) }} 
aria-current="{{ request()->is(trim($attributes->get('href'), '/')) ? 'page' : false }}">
    {{ $slot }}
</a>
