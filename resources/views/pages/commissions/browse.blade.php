@extends('layouts.app')

@section('content')
  @extends('layouts.sidenav')
  <div class="row">
    <div class="col-md-8">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">List Commissions</li>
        </ol>
      </nav>
    </div>
    <div class="col col-md-4">
      <a href="{{ route('commissions.create') }}" type="button" class="btn btn-dark">Add New Commission</a>
    </div>
  </div>
  <hr/>
  <h4 class="text-center">List Commissions. <i class="fa fa-smile-beam"></i></h4>
  <span class="m-5"></span>
  
  <table class="table">
    <caption>List of Commissions</caption>
    <thead>
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Percentage %</th>
        <th scope="col">Is Active</th>
        <th scope="col">Description</th>
        <th scope="col">Operation</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($commissions as $item)
        <tr>
          <td>{{ $item->name }}</td>
          <td>{{ $item->percentage }}</td>
          <td>
            @if($item->is_active)
              <button type="button" class="btn btn-success"><span class="badge badge-success">Yes</span></button>
            @else
              <button type="button" class="btn btn-warning"><span class="badge badge-warning">No</span></button>
            @endif
          </td>
          <td>{{ $item->description }}</td>
          <td>
            <div class="col col-md-4">
              <a href="{{ route('commissions.show', $item) }}" type="button" class="btn btn-primary">Details</a>
            </div>
          </td>
        </tr>
      @empty
        <h4>No Commissions to display. <i class="fa fa-sad-tear"></i></h4>
        <p>You may add commissions and they will be listed here</p>
      @endforelse
    </tbody>
  </table>

  {!! $commissions->links() !!}

@endsection
