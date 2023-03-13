@extends('layout.app')

@section('title', $post->title)

@section('content')
    <main class="py-16 lg:py-20">
        <div class="container">
            <!-- Breadcrumbs -->
            <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6">
                <li><a href="{{ route('home') }}" class="text-body hover:text-pink text-xs">Главная</a></li>
                <li><a href="{{ route('posts') }}" class="text-body hover:text-pink text-xs">Статьи</a></li>
                <li><span class="text-body text-xs">{{ $post->title }}</span></li>
            </ul>
            <!-- Main product -->
            <section class="flex flex-col lg:flex-row gap-10 xl:gap-14 2xl:gap-20 mt-12">

                <div class="basis-full lg:basis-2/5 xl:basis-2/5">
                    <div class="overflow-hidden h-auto max-h-[620px] lg:h-[480px] xl:h-[620px] rounded-3xl">
                        <img src="{{ $post->makeThumbnail('700x500', $post->id, 'crop') }}"
                             class="object-cover w-full h-full"
                             alt="{{ $post->title }}">
                    </div>
                </div>

                <div class="basis-full lg:basis-3/5 xl:basis-2/4">
                    <div class="grow flex flex-col lg:py-8">
                        <h1 class="text-lg md:text-xl mb-5 xl:text-[42px] font-black">
                            {{ $post->title }}
                        </h1>
                        <article class="text-xs md:text-sm">
                            {!! $post->text !!}
                        </article>
                    </div>
                </div>

            </section>


        </div>
    </main>
@endsection
