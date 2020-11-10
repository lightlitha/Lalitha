@extends('layouts.app')

@section('content')
  @extends('layouts.sidenav')
  <div class="row">
    <div class="col-md-8">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">List Employees</a></li>
          <li class="breadcrumb-item active" aria-current="page">Show Employee Address</li>
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
      <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="address-tab">
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
        <form class="needs-validation" novalidate action="{{ route('address.store') }}" method="post" enctype="multipart/form-data">
          @csrf
          {{ method_field('POST') }}
          <input type="hidden" name="e_id" value="{{ $employee->id }}">
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationName01">Line 1</label>
              @if (!empty($address->line1))
                <input type="text" class="form-control" id="validationName01" name="line1" value="{!! $address->line1 !!}" required>
              @else
                <input type="text" class="form-control" id="validationName01" name="line1" value="" required>
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
              <label for="validationName02">Line 2</label>
              @if (!empty($address->line2))
                <input type="text" class="form-control" id="validationName02" name="line2" value="{!! $address->line2 !!}">
              @else
                <input type="text" class="form-control" id="validationName02" name="line2" value="">
              @endif
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationName03">Suburb</label>
              @if (!empty($address->suburb))
                <input type="text" class="form-control" id="validationName03" name="suburb" value="{!! $address->suburb !!}">
              @else
                <input type="text" class="form-control" id="validationName03" name="suburb" value="">
              @endif
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationCustom03">City</label>
              @if (!empty($address->city))
                <input type="text" class="form-control" id="validationName02" name="city" value="{!! $address->city !!}" required>
              @else
                <input type="text" class="form-control" id="validationName01" name="city" value="" required>
              @endif
              <div class="invalid-feedback">
                Make sure this field has a value
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationCustom04">Zip Code</label>
              @if (!empty($address->zipcode))
                <input type="text" class="form-control" id="validationCustom04" name="zip_code" value="{!! $address->zipcode !!}" required>
              @else
                <input type="text" class="form-control" id="validationCustom04" name="zip_code" value="" required>
              @endif
              <div class="invalid-feedback">
                Please provide a zip code
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationCustom05">Country</label>
              @if (!empty($address->country))
                <input type="text" class="form-control" id="validationCustom05" name="country" value="{!! $address->country !!}" required>
              @else
                <input type="text" class="form-control" id="validationCustom05" name="country" value="" required>
              @endif
              <div class="invalid-feedback">
                Please provide a country of this address.
              </div>
            </div>
          </div>
          <button class="btn btn-primary" type="submit">Update Details</button>
        </form>
      </div>
    </div>
  </div>
@endsection
