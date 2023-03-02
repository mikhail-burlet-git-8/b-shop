<div>
    <h5 class="mb-4 text-sm 2xl:text-md font-bold">Бренд</h5>

    @if($filter->values())
        @foreach($filter->values() as $id => $label)
            <div class="form-checkbox">

                <input type="checkbox"
                       name="{{$filter->name($id)}}"
                       value="{{$id}}"
                       @checked($filter->requestValue($id))
                       id="filters-item-{{$id}}">
                <label for="filters-item-{{$id}}" class="form-checkbox-label">
                    {{$label}}
                </label>
            </div>
        @endforeach
    @endif


</div>
