<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body>
    <main :title="$title ?? null">
        {{$slot}}
    </main>
</body>

</html>
