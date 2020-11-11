@extends('layouts.app')

@section('content')
  @extends('layouts.sidenav')
  <div class="row">
    <div class="col-md-8 col-sm-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">List Employees</a></li>
          <li class="breadcrumb-item active" aria-current="page">Show Employee</li>
        </ol>
      </nav>
    </div>
    <div class="col-md-4 col-sm-12">
      <img loading="auto" srcset="{{ $avatar }}" alt="..." />
    </div>
  </div>
  <hr/>

  <div class="row">
    <div class="nav flex-column nav-pills col-md-3 col-sm-12 border-right" id="myTab" role="tablist" aria-orientation="vertical">
      @foreach ($tabs as $item)
        <a class="nav-link @php if($item['name'] == $active) echo 'active'; @endphp"
            id="{!! $item['name'] !!}-tab" 
            {{-- data-toggle="tab"  --}}
            href="{!! route($item['route'], $item['param']) !!}" 
            {{-- role="tab"  --}}
            aria-controls="{!! $item['name'] !!}" 
            aria-selected="@php if($item['name'] == $active) { echo 'true'; } else { echo 'false';} @endphp"
        >
        {!! ucfirst($item['name']) !!}
        </a>
      @endforeach
    </div>
    <div class="tab-content col-md-9 col-sm-12" id="myTabContent">
      <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="basicinfo-tab">
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
        <form class="needs-validation" novalidate action="{{ route('employees.update', $employee) }}" method="post" enctype="multipart/form-data">
          @csrf
          {{ method_field('PUT') }}
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationCustom06">Avatar</label>
              <input type="file" class="form-control" id="validationCustom09" name="avatar">
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationName01">Nickname</label>
              <input type="text" class="form-control" id="validationName01" name="nickname" value="{!! $employee->nickname !!}" maxlength="30" required>
              <div class="valid-feedback">
                Looks good!
              </div>
              <div class="invalid-feedback">
                Please make sure the are only alphabets and character are less than 30.
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationName02">First name</label>
              <input type="text" class="form-control" id="validationName02" name="first_name" value="{!! $employee->first_name !!}" maxlength="30" required>
              <div class="valid-feedback">
                Looks good!
              </div>
              <div class="invalid-feedback">
                Please make sure the are only alphabets and character are less than 30.
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationName03">Last name</label>
              <input type="text" class="form-control" id="validationName03" name="last_name" value="{!! $employee->last_name !!}" maxlength="30" required>
              <div class="valid-feedback">
                Looks good!
              </div>
              <div class="invalid-feedback">
                Please make sure the are only alphabets and character are less than 30.
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationCustom03">Date Of Birth</label>
              <input type="date" class="form-control" id="validationCustom03" name="date_of_birth" value="{!! $employee->date_of_birth !!}" required>
              <div class="invalid-feedback">
                Employee must be older than 18 years of age.
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationCustom04">ID Number</label>
              <input type="text" class="form-control" id="validationCustom04" name="id_number" value="{!! $employee->id_number !!}" maxlength="13">
              <div class="invalid-feedback">
                Please provide a valid South African ID Number.
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationCustom05">Passport Number</label>
              <input type="text" class="form-control" id="validationCustom05" name="passport_number" value="{!! $employee->passport_number !!}">
              <div class="invalid-feedback">
                Please provide a valid Passport Number.
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationCustom06">Nationality</label>
              <input type="text" class="form-control" id="validationCustom06" name="nationality" value="{!! $employee->nationality !!}">
              <div class="invalid-feedback">
                Please provide a proper response.
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="is_active" id="invalidCheck" aria-checked="{{ $employee->is_active }}" checked="{{ $employee->is_active }}">
              <label class="form-check-label" for="invalidCheck">
                Is an Employee of ours ?
              </label>
              <div class="invalid-feedback">
                Does the employee work here ?.
              </div>
            </div>
          </div>
          <button class="btn btn-primary" type="submit">Update Details</button>
        </form>
      </div>
    </div>
  </div>
@endsection
