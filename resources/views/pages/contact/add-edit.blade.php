@extends('layouts.app')

@section('content')
  @extends('layouts.sidenav')
  <div class="row">
    <div class="col-md-8">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">List Employees</a></li>
          <li class="breadcrumb-item active" aria-current="page">Show Employee Contact Details</li>
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
      <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="contact-tab">
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
        <form class="needs-validation" novalidate action="{{ route('contact.store') }}" method="post" enctype="multipart/form-data">
          @csrf
          {{ method_field('POST') }}
          <input type="hidden" name="e_id" value="{{ $employee->id }}">
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationName01">Cellphone</label>
              @if (!empty($contact->cellphone))
                <input type="text" class="form-control" id="validationName01" name="cellphone" value="{!! $contact->cellphone !!}" required>
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
              <label for="validationName02">Home</label>
              @if (!empty($contact->home))
                <input type="text" class="form-control" id="validationName02" name="home" value="{!! $contact->home !!}">
              @else
                <input type="text" class="form-control" id="validationName02" name="home" value="">
              @endif
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationName03">Telephone</label>
              @if (!empty($contact->telephone))
                <input type="text" class="form-control" id="validationName03" name="telephone" value="{!! $contact->telephone !!}">
              @else
                <input type="text" class="form-control" id="validationName03" name="telephone" value="">
              @endif
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationCustom03">Work</label>
              @if (!empty($contact->work))
                <input type="text" class="form-control" id="validationName05" name="work" value="{!! $contact->work !!}">
              @else
                <input type="text" class="form-control" id="validationName05" name="work" value="">
              @endif
              <div class="invalid-feedback">
                Make sure this field has a value
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationCustom04">Other</label>
              @if (!empty($contact->other))
                <input type="text" class="form-control" id="validationCustom04" name="other" value="{!! $contact->other !!}">
              @else
                <input type="text" class="form-control" id="validationCustom04" name="other" value="">
              @endif
              <div class="invalid-feedback">
                Please provide a input
              </div>
            </div>
          </div>
          <button class="btn btn-primary" type="submit">Update Details</button>
        </form>
      </div>
    </div>
  </div>
@endsection
