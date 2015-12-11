@extends('admin::base')
@section('content')
  <div class="wrapper-md">
    <div class="row">
      <div class="col-md-4">
        <div class="panel panel-default">
          <a href class="text-muted m-t-sm m-l inline"><i class="icon-pie-chart"></i></a>
          <div class="text-center wrapper m-b-sm">
            <div ui-refresh="data" ui-jq="sparkline" ui-options="
              {{ json_encode($posts->lists('chart_param')) }},
              {
                type:'pie',
                height:126,
                sliceColors:['#7266ba','#23b7e5','#fad733']
              }
              " class="sparkline inline"></div>
          </div>
          <ul class="list-group no-radius">
            @foreach ($posts as $post)
            <li class="list-group-item">
              <span class="pull-right">{{ $post->chart_param }}</span>
              <span class="label bg-primary">{{ $loop->index1 }}</span>
              {{ ($post->node) ? $post->node->title : $post->id }}
            </li>
            @endforeach
          </ul>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <ul class="list-group no-radius">
              <li class="list-group-item">
                <a href="{{ admin_route('content.roots.index') }}">Roots</a>
              </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
@endsection