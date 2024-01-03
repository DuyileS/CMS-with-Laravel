<x-admin-master>
 @section('content')

        <h1>All Users</h1>

          @if (Session::has('message'))
          <div class="alert alert-danger">{{Session::get('message')}}</div> 
          @elseif (Session::has('post-created-message'))
          <div class="alert alert-success">{{Session::get('post-created-message')}}</div>
          @elseif (Session::has('update-message'))
          <div class="alert alert-success">{{Session::get('update-message')}}</div>
          @elseif (Session::has('user-deleted'))
          <div class="alert alert-danger">{{Session::get('user-deleted')}}</div>
          @endif

              <!-- DataTales Example -->
            <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Users</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="users-table" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Username</th>
                      <th>Avatar</th>
                      <th>Name</th>
                      <th>Registered Date</th>
                      <th>Updated profile date</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                    <th>Id</th>
                      <th>Username</th>
                      <th>Avatar</th>
                      <th>Name</th>
                      <th>Registered Date</th>
                      <th>Updated profile date</th>
                      <th>Delete</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($users as $user)   
                    <tr>
                            <td>{{$user->id}} </td>
                            <td>{{$user->username}} </td>
                            <td>
                                <img height="40px" src="/images/images (5).png" alt="">
                            </td>
                            <td><a href="{{route('user.profile.show', $user->id)}}">{{$user->name}}</a>  </td>
                            <td>{{$user->created_at->diffForHumans()}} </td>
                            <td>{{$user->updated_at->diffForHumans()}} </td>
                            <td>
                            
                              <form method="post" action="{{ route('user.destroy', $user->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                              </form>
                              
                            </td>
                    </tr>
                    @endforeach 
                  </tbody> 
                </table>
              </div>
            </div>
            </div>
<!-- $posts->links() -->
@section('scripts')
 <!-- Page level plugins -->
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{asset('js/demo/datatables-demo.js')}}"></script>

@endsection

@endsection
</x-admin-master>