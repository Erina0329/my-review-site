<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        <!-- ヘッダー -->
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 d-flex justify-content-between align-items-center">

                {{-- 左：ユーザー名とログアウト --}}
                @auth
                    <div class="text-dark">
                        ようこそ、{{ Auth::user()->name }} さん
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-dark">ログアウト</button>
                    </form>
                @endauth

                {{-- 右：ページタイトルなど --}}
                @isset($header)
                    <div class="text-dark">
                        {{ $header }}
                    </div>
                @endisset
            </div>
        </header>

        <!-- メインコンテンツ -->
        <main>
            {{ $slot ?? '' }}
        </main>
    </div>
</body>
</html>
