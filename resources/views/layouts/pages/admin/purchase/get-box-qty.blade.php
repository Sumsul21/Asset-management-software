

@foreach($datas as $item)
    <option value="{{ $item->id}}">{{ $item->box_qty}}</option>
@endforeach