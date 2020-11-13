@extends('layouts.app')

@section('content')
  @extends('layouts.sidenav')
  <div class="row">
    <div class="col-md-8">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('commissions.index') }}">List Commissions</a></li>
          <li class="breadcrumb-item active" aria-current="page">Commission Details</li>
        </ol>
      </nav>
    </div>
  </div>
  <hr/>
  <h4 class="text-center">Commission Details. <i class="fa fa-smile-beam"></i></h4>
  <span class="m-5"></span>
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
  <form class="needs-validation" novalidate action="{{ route('commissions.update', $commission) }}" method="post" enctype="multipart/form-data">
    @csrf
    {{ method_field('PUT') }}
    <div class="form-row">
      <div class="col-md-6 mb-3">
        <label for="validationName01">Name</label>
        <input type="text" class="form-control" id="validationName01" name="name" value="{{ $commission->name }}" maxlength="30" required>
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
        <label for="validationName02">Percentage</label>
        <input type="number" step='0.01' class="form-control" id="validationName02" name="percentage" value="{{ $commission->percentage }}" required>
        <div class="valid-feedback">
          Looks good!
        </div>
        <div class="invalid-feedback">
          Please make sure there are only numbers/decimals use . as decimal point NOT(,).
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col-md-6 mb-3">
        <label for="validationName03">Description</label>
        <textarea class="form-control" id="validationName03" name="description">
          {{ $commission->description }}
        </textarea>
        <div class="valid-feedback">
          Looks good!
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" aria-checked="{{ $commission->is_active }}" checked="{{ $commission->is_active }}">
        <label class="form-check-label" for="is_active">
          Is Commission Usable ?
        </label>
      </div>
    </div>
    <div class="form-row">.</div>
    <button class="btn btn-primary" type="submit">Submit form</button>
  </form>
  
@endsection
