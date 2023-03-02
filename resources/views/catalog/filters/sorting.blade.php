<select name="sort"
        x-on:change="$refs.sortForm.submit()"
        class="form-select w-full h-12 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xxs sm:text-xs shadow-transparent outline-0 transition">


    @if ($filter->values())
        @foreach($filter->values() as $id => $label)
            <option @selected(request('sort') === $id)
                    value="{{$id}}"
                    class="text-dark">{{$label}}
            </option>
        @endforeach
    @endif

</select>
