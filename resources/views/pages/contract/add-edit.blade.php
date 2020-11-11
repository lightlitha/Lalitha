@extends('layouts.app')

@section('content')
  @extends('layouts.sidenav')
  <div class="row">
    <div class="col-md-8">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">List Employees</a></li>
          <li class="breadcrumb-item active" aria-current="page">Show Employee Contract</li>
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
      <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="contract-tab">
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
        <form class="needs-validation" novalidate action="{{ route('contract.store') }}" method="post" enctype="multipart/form-data">
          @csrf
          {{ method_field('POST') }}
          <input type="hidden" name="e_id" value="{{ $employee->id }}">
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationCustom09">Add Contract File</label>
              <input type="file" class="form-control" id="validationCustom09" name="contract">
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              @if (!empty($contractfile))
                <a type="button" class="btn btn-outline-info" href="{{ $contractfile }}">View Contract File</a>
              @endif
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationName01">Begin</label>
              @if (!empty($contract->begin))
                <input type="date" class="form-control" id="validationName01" name="begin" value="{!! $contract->begin !!}">
              @else
                <input type="date" class="form-control" id="validationName01" name="begin" value="">
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
              <label for="validationName02">End</label>
              @if (!empty($contract->end))
                <input type="date" class="form-control" id="validationName02" name="end" value="{!! $contract->end !!}">
              @else
                <input type="date" class="form-control" id="validationName02" name="end" value="">
              @endif
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-check">
              @if (!empty($contract->is_permanent))
                <input class="form-check-input" type="checkbox" name="is_permanent" id="is_permanent" aria-checked="{{ $contract->is_permanent }}" checked="{{ $contract->is_permanent }}">
              @else
                <input class="form-check-input" type="checkbox" name="is_permanent" id="is_permanent">
              @endif
              <label class="form-check-label" for="is_permanent">
                Is Employee Permanent
              </label>
              <div class="invalid-feedback">
                Something wrong here.
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-check">
              @if (!empty($contract->is_active))
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" aria-checked="{{ $contract->is_active }}" checked="{{ $contract->is_permanent }}">
              @else
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active">
              @endif
              <label class="form-check-label" for="is_active">
                Is The Contract Active ?
              </label>
              <div class="invalid-feedback">
                Something wrong here.
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-check">
              @if (!empty($contract->is_signed))
                <input class="form-check-input" type="checkbox" name="is_signed" id="is_signed" aria-checked="{{ $contract->is_signed }}" checked="{{ $contract->is_signed }}">
              @else
                <input class="form-check-input" type="checkbox" name="is_signed" id="is_signed">
              @endif
              <label class="form-check-label" for="is_signed">
                Is The Contract Signed ?
              </label>
              <div class="invalid-feedback">
                Something wrong here.
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationCustom04">Note</label>
              @if (!empty($contract->note))
                <input type="text" class="form-control" id="validationCustom04" name="note" value="{!! $contract->note !!}">
              @else
                <input type="text" class="form-control" id="validationCustom04" name="note" value="">
              @endif
              <div class="invalid-feedback">
                Please provide a input
              </div>
            </div>
          </div>
          <button class="btn btn-primary" type="submit">Update Contract</button>
        </form>
      </div>
    </div>
  </div>
@endsection
