@extends('layouts.app')

@section('content')
  @extends('layouts.sidenav')
  <div class="row">
    <div class="col-md-8">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">List Store Services</li>
        </ol>
      </nav>
    </div>
    <div class="col col-md-4">
      <a href="{{ route('store_services.create') }}" type="button" class="btn btn-dark">Add New Store Service</a>
    </div>
  </div>
  <hr/>
  <h4 class="text-center">List Store Services. <i class="fa fa-smile-beam"></i></h4>
  <span class="m-5"></span>
  
  <table class="table">
    <caption>List of Store Services</caption>
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Sku</th>
        <th scope="col">Name</th>
        <th scope="col">Price</th>
        <th scope="col">Duration</th>
        <th scope="col">Tag</th>
        <th scope="col">Usable</th>
        <th scope="col">Operation</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($store_services as $item)
        <tr>
          <td scope="row">
            <div class="user-pic">
              <img alt="..." src="{!! $item->getFirstMedia('picture')->getUrl('thumb') !!}" class="rounded-circle avatar">
            </div>
          </td>
          <td>{{ $item->sku }}</td>
          <td>{{ $item->name }}</td>
          <td>R {{ $item->price }}</td>
          <td>{{ $item->duration }}</td>
          <td>{{ $item->tag }}</td>
          <td>
            @if($item->is_active)
              <button type="button" class="btn btn-success"><span class="badge badge-success">Yes</span></button>
            @else
              <button type="button" class="btn btn-warning"><span class="badge badge-warning">No</span></button>
            @endif
          </td>
          <td>
            <div class="col col-md-4">
              <a href="{{ route('store_services.show', $item) }}" type="button" class="btn btn-primary">Details</a>
            </div>
          </td>
        </tr>
      @empty
        <h4>No Store Services to display. <i class="fa fa-sad-tear"></i></h4>
        <p>You may add Store Services and they will be listed here</p>
      @endforelse
    </tbody>
  </table>

  {!! $store_services->links() !!}

@endsection
