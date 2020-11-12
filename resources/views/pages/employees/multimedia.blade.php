@extends('layouts.app')

@section('content')
  @extends('layouts.sidenav')
  <div class="row">
    <div class="col-md-8 col-sm-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">List Employees</a></li>
          <li class="breadcrumb-item active" aria-current="page">Show Employee Multimedia</li>
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
        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#uploadImage">
          Upload Images
        </button>
        <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#uploadVideo">
          Upload Videos
        </button>

        <div class="row">
          <div class="col-md-12">
            @foreach ($employeeImages as $item)
              <div class="mdb-lightbox">
                <figure class="col-md-4">
                  <a href="{!! $item->getUrl() !!}" data-size="1600x1067">
                    <img loading="auto" srcset="{!! $item->getUrl() !!}" alt="..." class="img-fluid" />
                  </a>
                </figure>
              </div>
            @endforeach
          </div>
        </div>

      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="uploadImage" tabindex="-1" role="dialog" aria-labelledby="uploadImageLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="uploadImageLabel">Upload Image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="needs-validation" novalidate action="{{ route('employees.update', $employee) }}" method="post" enctype="multipart/form-data">
            @csrf
            {{ method_field('PUT') }}
            <div class="modal-body">
              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="validationCustom06">Images</label>
                  <input type="file" class="form-control" id="validationCustom09" name="image[]" multiple>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button class="btn btn-primary" type="submit">Upload</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="uploadVideo" tabindex="-1" role="dialog" aria-labelledby="uploadvideoLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="uploadvideoLabel">Upload Video</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="needs-validation" novalidate action="{{ route('employees.update', $employee) }}" method="post" enctype="multipart/form-data">
            @csrf
            {{ method_field('PUT') }}
            <div class="modal-body">
              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="validationCustom06">Videos</label>
                  <input type="file" class="form-control" id="validationCustom09" name="video[]" multiple>
                </div>
              </div>
            </div>              
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button class="btn btn-primary" type="submit">Upload</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
@endsection
