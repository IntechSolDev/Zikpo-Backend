@extends('admin.layouts.layouts')
@section('content')
 <style>

  .dataTable th, .dataTable td {
max-width: 100px;
min-width: 70px;
overflow: hidden;
text-overflow: ellipsis;
white-space: nowrap;
}
  .dataTable th,.dataTable td:first-child {
  max-width: 40px;
  min-width: 40px;
}
.icon-custom-card .card-body {

    padding: 2.75rem 1.25rem;
}
.icon-custom-card  .fas {

    line-height: 2;
}
.icon-custom-card .mr-5 {
    font-size: 18px;
}

</style>
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{url('/admin/')}}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Overview</li>
            </ol>
            <!-- Icon Cards-->
            <div class="row icon-custom-card">
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-primary o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-fw fa-users"></i>
                            </div>
                            <div class="mr-5">{{$user_count}} Customers</div>
                        </div>

                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-warning o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-fw fa-question"></i>
                            </div>
                            <div class="mr-5">Questions</div>
                        </div>

                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-success o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-fw fa-question-circle"></i>
                            </div>
                            <div class="mr-5">Answers</div>
                        </div>

                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-danger o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-fw fa-video"></i>
                            </div>
                            <div class="mr-5">Most Liked Questions</div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- DataTables Example -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                   Customer List</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Created At</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($users as $user)
                            <tr>

                            <td>{{$user->name}}</td>
                            <td>
                                  @if (strpos($user->email, '@linkedin.com'))
                                    {{ $user->linkedin_email }}
                                  @else
                                    {{ $user->email }}
                                  @endif
                            </td>

                            <td>@if($user->isOnline())
                            <span class="badge badge-success">Online</span>
                            @else
                          <span class="badge badge-danger">Offline</span>
                            @endif
                            </td>
                            <td>{{date('d-m-Y h:i:sa', strtotime($user->created_at))}}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Sticky Footer -->


@endsection
