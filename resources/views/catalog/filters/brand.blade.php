<div>
    <h5 class="mb-4 text-sm 2xl:text-md font-bold">Бренд</h5>

    @if($brands)
        @foreach($brands as $brand)
            <div class="form-checkbox">

                <input type="checkbox"
                       name="filters[brands][{{$brand->id}}]"
                       value="{{$brand->id}}"
                       @checked(request('filters.brands.'.$brand->id))
                       id="filters-item-{{$brand->id}}">
                <label for="filters-item-{{$brand->id}}" class="form-checkbox-label">{{$brand->title}}</label>
            </div>
        @endforeach
    @endif


</div>
