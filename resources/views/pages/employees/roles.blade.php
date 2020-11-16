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
        <form class="needs-validation" novalidate action="{{ route('employee.update.acl', $employee) }}" method="post" enctype="multipart/form-data">
          @csrf
          {{ method_field('PUT') }}
          <h5>Roles</h5>
          <div class="form-row">
            @foreach ($roles as $role)
            {{-- @php echo print_r($role); @endphp --}}
              @php $ischecked = false; @endphp
              @foreach ($user->roles as $roler)
                @if ($roler->name === $role['name'])
                  @php $ischecked = true; @endphp
                @endif
              @endforeach
              <div class="col-md-6 mb-3">
                <div class="form-check">
                  @if ($ischecked)
                    <input class="form-check-input" type="checkbox" value="{{ $role['name'] }}" name="roles[]" id="roles{{ ucfirst(strtolower($role['name'])) }}" checked="true" aria-checked="true">
                  @else
                    <input class="form-check-input" type="checkbox" value="{{ $role['name'] }}" name="roles[]" id="roles{{ ucfirst(strtolower($role['name'])) }}">
                  @endif
                  <label class="form-check-label" for="roles{{ ucfirst(strtolower($role['name'])) }}">
                    {{ ucfirst(strtolower($role['name'])) }}
                  </label>
                  <div class="valid-feedback">
                    Looks good!
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          <h5>Permissions</h5>
          <div class="form-row">
            @foreach ($permissions as $perms)
              @php $ischecked = false; @endphp
              @foreach ($user->permissions as $perm)
                @if ($perm->name === $perms['name'])
                  @php $ischecked = true; @endphp
                @endif
              @endforeach
              <div class="col-md-6 mb-3">
                <div class="form-check">
                  @if ($ischecked)
                    <input class="form-check-input" type="checkbox" value="{{ $perms['name'] }}" name="permissions[]" id="permissions{{ ucfirst(strtolower($perms['name'])) }}" checked="true" aria-checked="true">
                  @else
                    <input class="form-check-input" type="checkbox" value="{{ $perms['name'] }}" name="permissions[]" id="permissions{{ ucfirst(strtolower($perms['name'])) }}">
                  @endif
                  <label class="form-check-label" for="permissions{{ ucfirst(strtolower($perms['name'])) }}">
                    {{ ucfirst(strtolower($perms['name'])) }}
                  </label>
                  <div class="valid-feedback">
                    Looks good!
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          <button class="btn btn-primary" type="submit">Update Details</button>
        </form>
      </div>
    </div>
  </div>
@endsection
