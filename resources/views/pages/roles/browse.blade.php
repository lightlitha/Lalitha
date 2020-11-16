@extends('layouts.app')

@section('content')
  @extends('layouts.sidenav')
  <div class="row">
    <div class="col-md-7">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Roles & Permissions</li>
        </ol>
      </nav>
    </div>
    <div class="col col-md-2">
      <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#AddRole">New Role</button>
    </div>
    <div class="col col-md-3">
      <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#AddPermission">New Permission</a>
    </div>
  </div>
  <hr/>
  <h4 class="text-center">Roles & Permissions. <i class="fa fa-smile-beam"></i></h4>
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
  <table class="table">
    <caption>List of Roles</caption>
    <thead>
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Permissions</th>
        <th scope="col">Update</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($roles as $item)
        <tr>
          <td>{{ $item->name }}</td>
          <td>
            <a href="#" type="button" data-toggle="modal" data-target="#RolePermission{!! str_replace(' ', '', $item->name) !!}{{ $item->id }}" class="btn btn-outline-primary">Permissions</a>
          </td>
          <td>
            <a href="#" type="button" class="btn btn-outline-info">Update</a>
          </td>
        </tr>

        <!-- Modal -->
        <div class="modal fade" id="RolePermission{!! str_replace(' ', '', $item->name) !!}{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="AddRoleLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="AddRoleLabel">Role Permissions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form class="needs-validation" novalidate action="{{ route('roles.store') }}" method="post">
                  @csrf
                  <input type="hidden" value="{{ $item->id }}" name="role_id">
                  <div class="modal-body">
                    <div class="form-row">
                      @foreach ($permissions as $perms)
                        @php $ischecked = false; @endphp
                        @foreach ($item->getAllPermissions() as $perm)
                          @if ($perm->name === $perms['name'])
                            @php $ischecked = true; @endphp
                          @endif
                        @endforeach
                        <div class="col-md-6 mb-3">
                          <div class="form-check">
                            @if ($ischecked)
                              <input class="form-check-input" type="checkbox" value="{{ $perms['name'] }}" name="role_permissions[]" id="role_permissions{{ ucfirst(strtolower($perms['name'])) }}" checked="true" aria-checked="true">
                            @else
                              <input class="form-check-input" type="checkbox" value="{{ $perms['name'] }}" name="role_permissions[]" id="role_permissions{{ ucfirst(strtolower($perms['name'])) }}">
                            @endif
                            <label class="form-check-label" for="role_permissions{{ ucfirst(strtolower($perms['name'])) }}">
                              {{ ucfirst(strtolower($perms['name'])) }}
                            </label>
                            <div class="valid-feedback">
                              Looks good!
                            </div>
                          </div>
                        </div>
                      @endforeach
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                  </div>
              </form>
            </div>
          </div>
        </div>

      @empty
        <tr>
          <td>
            <h4>No Roles to display. <i class="fa fa-sad-tear"></i></h4>
            <p>You may add Roles and they will be listed here</p>
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>

  {!! $roles->links() !!}

  <!-- Modal -->
  <div class="modal fade" id="AddRole" tabindex="-1" role="dialog" aria-labelledby="AddRoleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="AddRoleLabel">Add Role</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="needs-validation" novalidate action="{{ route('roles.store') }}" method="post">
            @csrf
            <div class="modal-body">
              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="validationName01">Role Name</label>
                  <input type="text" class="form-control" id="validationName01" name="role_name" value="" maxlength="30" required>
                  <div class="valid-feedback">
                    Looks good!
                  </div>
                  <div class="invalid-feedback">
                    Please make sure the are only alphabets and character are less than 30.
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="AddPermission" tabindex="-1" role="dialog" aria-labelledby="AddPermissionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="AddPermissionLabel">Add Permission</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="needs-validation" novalidate action="{{ route('roles.store') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="validationName01">Permission Name</label>
                <input type="text" class="form-control" id="validationName01" name="permission_name" value="" maxlength="30" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Please make sure the are only alphabets and character are less than 30.
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection
