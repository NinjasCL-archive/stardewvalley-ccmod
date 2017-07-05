<select name="{{$name or ''}}" class="select">
@foreach(App\Item::all() as $item)
<option value="{{$loop->index}}">{{$item->id}} - {{$item->name}}</option>
@endforeach()
</select> 