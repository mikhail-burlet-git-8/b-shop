<div class="product-card flex flex-col rounded-3xl bg-card">
    <a href="{{route('posts.show', $item->slug)}}" class="product-card-photo overflow-hidden h-[320px] rounded-3xl">
        <img src="{{$item->makeThumbnail('345x320', $item->id)}}" class="object-cover w-full h-full"
             alt="{{$item->title}}">
    </a>
    <div class="grow flex flex-col py-8 px-6">
        <h3 class="text-sm lg:text-md mb-2 font-black">
            <a href="{{route('posts.show', $item->slug)}}"
               class="inline-block text-white hover:text-pink">
                {{$item->title}}
            </a></h3>
        <div class="short-text">
            {{$item->short_text}}
        </div>
    </div>
</div>
