@extends('layouts.app')

@section('content')
  @extends('layouts.sidenav')
  <div class="row">
    <div class="col-md-8">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">List Employees</a></li>
          <li class="breadcrumb-item active" aria-current="page">Show Employee Next Of Kin Details</li>
        </ol>
      </nav>
    </div>
  </div>
  <hr/>

  <div class="row">
    <div class="nav flex-column nav-pills col-md-3 col-sm-12 border-right" id="myTab" role="tablist" aria-orientation="vertical">
      @foreach ($tabs as $item)
        <a class="nav-link @php if($item['name'] == $active) echo 'active'; @endphp"
            id="{!! $item['name'] !!}-tab" 
            href="{!! route($item['route'], $item['param']) !!}"
            aria-controls="{!! $item['name'] !!}" 
            aria-selected="@php if($item['name'] == $active) { echo 'true'; } else { echo 'false'; } @endphp"
        >
        {!! ucfirst($item['name']) !!}
        </a>
      @endforeach
    </div>
    <div class="tab-content col-md-9 col-sm-12" id="myTabContent">
      <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="family-tab">
        @if (session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
        @endif
        @if (session('failure'))
          <div class="alert alert-danger">
              {{ session('failure') }}
          </div>
        @endif
        <form class="needs-validation" novalidate action="{{ route('next_of_kin.store') }}" method="post" enctype="multipart/form-data">
          @csrf
          {{ method_field('POST') }}
          <input type="hidden" name="e_id" value="{{ $employee->id }}">
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationName02">First Name</label>
              @if (!empty($family->first_name))
                <input type="text" class="form-control" id="validationName02" name="first_name" value="{!! $family->first_name !!}" required>
              @else
                <input type="text" class="form-control" id="validationName02" name="first_name" value="" required>
              @endif
              <div class="invalid-feedback">
                Please make sure this field has input.
              </div>
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationName03">Last Name</label>
              @if (!empty($family->last_name))
                <input type="text" class="form-control" id="validationName03" name="last_name" value="{!! $family->last_name !!}" required>
              @else
                <input type="text" class="form-control" id="validationName03" name="last_name" value="" required>
              @endif
              <div class="invalid-feedback">
                Please make sure this field has input.
              </div>
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationName01">Cellphone</label>
              @if (!empty($family->cellphone))
                <input type="text" class="form-control" id="validationName01" name="cellphone" value="{!! $family->cellphone !!}" required>
              @else
                <input type="text" class="form-control" id="validationName01" name="cellphone" value="" required>
              @endif
              <div class="valid-feedback">
                Looks good!
              </div>
              <div class="invalid-feedback">
                Please make sure this field has input.
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationCustom03">Other Contact</label>
              @if (!empty($family->other_phone))
                <input type="text" class="form-control" id="validationName05" name="other_phone" value="{!! $family->other_phone !!}">
              @else
                <input type="text" class="form-control" id="validationName05" name="other_phone" value="">
              @endif
              <div class="invalid-feedback">
                Make sure this field has a value
              </div>
            </div>
          </div>
          <button class="btn btn-primary" type="submit">Update Details</button>
        </form>
      </div>
    </div>
  </div>
@endsection
