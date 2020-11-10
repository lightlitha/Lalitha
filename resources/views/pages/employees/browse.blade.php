@extends('layouts.app')

@section('content')
  @extends('layouts.sidenav')
  <div class="row">
    <div class="col-md-8">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">List Employees</li>
        </ol>
      </nav>
    </div>
    <div class="col col-md-4">
      <a href="{{ route('employees.create') }}" type="button" class="btn btn-dark">Add New Employee</a>
    </div>
  </div>
  <hr/>

  <form action="{{ route('employees.index') }}" method="get">
    @csrf
    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="inputSearch">Search Keyword</label>
        <input type="text" class="form-control" id="inputSearch" name="keyword" placeholder="Search Text">
      </div>
      <div class="form-group col-md-2">
        <label for="inputState">Is Active</label>
        <select id="inputState" class="form-control" name="is_active">
          <option selected>Choose...</option>
          <option value="1">Yes</option>
          <option value="0">No</option>
        </select>
      </div>
      <div class="form-group col-md-2">
        <label for="inputAvail">Is Available</label>
        <select id="inputAvail" class="form-control" name="is_available">
          <option selected>Choose...</option>
          <option value="1">Yes</option>
          <option value="0">No</option>
        </select>
      </div>
      <div class="form-group col-md-1">
        <label for="inputSubmit">.</label>
        <button class="form-control btn btn-info" type="submit"> <i class="fa fa-filter"></i> Filter</button>
      </div>
    </div>
  </form>

  <table class="table">
    <caption>List of employees</caption>
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nickname</th>
        <th scope="col">Full Name</th>
        <th scope="col">Is Active</th>
        <th scope="col">Is Available</th>
        <th scope="col">Operation</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($employees as $employee)
        <tr>
          <th scope="row">#</th>
          <td>{{ $employee->nickname }}</td>
          <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
          <td>
            @if($employee->is_active)
              <button type="button" class="btn btn-success"><span class="badge badge-success">Yes</span></button>
            @else
              <button type="button" class="btn btn-warning"><span class="badge badge-warning">No</span></button>
            @endif
          </td>
          <td>
            @if($employee->is_available)
              <button type="button" class="btn btn-success"><span class="badge badge-success">Yes</span></button>
            @else
              <button type="button" class="btn btn-warning"><span class="badge badge-warning">No</span></button>
            @endif
          </td>
          <td>
            <div class="col col-md-4">
              <a href="{{ route('employees.show', $employee) }}" type="button" class="btn btn-primary">Details</a>
            </div>
          </td>
        </tr>
      @empty
        <h4>No Employees to display. <i class="fa fa-sad-tear"></i></h4>
        <p>You may add employees and they will be listed here</p>
      @endforelse
    </tbody>
  </table>

  {!! $employees->links() !!}

@endsection
