@extends('layout.app')

@section('title', 'B-Shop - Главная страница')

@section('content')
    <main class="py-16 lg:py-20">
        <div class="container">
            <!-- Breadcrumbs -->
            <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6">
                <li><a href="{{ route('home') }}" class="text-body hover:text-pink text-xs">Главная</a></li>
                <li><span class="text-body text-xs">Статьи</span></li>
            </ul>
            <section class="mt-20">
                <h2 class="text-lg lg:text-[42px] font-black">Статьи</h2>
                <div class="grid grid-cols-3 md:grid-cols-3 2xl:grid-cols-3 gap-4 md:gap-8 mt-12">
                    @each('posts.shared.post', $posts, 'item')
                </div>

                <div class="mt-12 text-center">
                    {{$posts->links()}}
                </div>
            </section>

        </div>
    </main>
@endsection
