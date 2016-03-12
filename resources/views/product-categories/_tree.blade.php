<ol class="dd-list">
@foreach($items as $item)
    <li class="dd-item" data-id="{{$item->id}}">
    <a style ="margin-right: -35px;" class="pull-right btn btn-sm btn-danger destroy-confirm" href="{{ admin_route('ecommerce.product-categories.destroy', [$item->id]) }}">&times;</a>
        <a class="pull-right btn btn-sm btn-primary" href="{{ admin_route('ecommerce.product-categories.edit', [$item->id]) }}"><i class="icon-pencil"></i></a>
      <div class="dd-handle" style="margin-right:50px">{{ $item->node->title }}
			
      </div>
      
        @if(isset($item->children))
            @include('ecommerce::product-categories._tree', ['items' => $item->children])
        @endif
    </li>
@endforeach
</ol>

