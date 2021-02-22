@extends('larasnap::layouts.app', ['class' => 'manager-index'])
@section('title','User Management')
@section('content')
<!-- Page Heading  Start-->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Manager List</h1>
</div>
<!-- Page Heading End-->				  
<!-- Page Content Start-->				  
<div class="row">
   <div class="col-xl-12">
      <div class="card shadow mb-4">
         <div class="card-body">
            <div class="card-body">
               <form  method="POST" action="{{ route('managers.index') }}" id="list-form" class="form-inline my-2 my-lg-0" autocomplete="off">
                  @method('POST')
                  @csrf
                  <div class="col-md-2 pad-0">
                     @canAccess('managers.create')
                     <a href="{{ route('managers.create') }}"  title="Add New Manager" class="btn btn-primary btn-sm"><i aria-hidden="true" class="fa fa-plus"></i> Add New Manager
                     </a>
                     @endcanAccess
                  </div>
                  <!-- list filters -->
                  <div class="col-md-10 filters">
                     @include('larasnap::list-filters.manager')
                  </div>
                  <!-- list filters -->
                  <br> <br> 
                  <div class="table-responsive">
                     <table class="table">
                        <thead>
                           <tr>
                              <th>ID</th>
                              <th>FirstName</th>
                              <th>LastName</th>
                              <th>Email</th>
                              <th>Mobile No</th>
                              <th>profile picture</th>
                              <th>Action</th>
                             
                              
                           </tr>
                        </thead>
                        @forelse($users as $manager)
                        <tr>
                              <td>{{$manager->id}}</td>
                              <td>{{$manager->first_name}}</td>
                              <td>{{$manager->last_name}}</td>
                              <td>{{$manager->email}}</td>
                              <td>{{$manager->mobile_phone}}</td>
                              <td>
                              @if (strpos($manager->user_photo, '.jpg') !== false || strpos($manager->user_photo, '.png') !== false || strpos($manager->user_photo, '.gif') !== false || strpos($manager->user_photo, '.svg') !== false || strpos($manager->user_photo, '.jpeg') !== false)
                              <img  src="{{asset('storage/images/'.$manager->user_photo)}}"  style="width: 80px;height: 80px"/>
                              @endif </td>
                              <td>
                              @canAccess('managers.edit')
                                     <a href="{{ route('managers.edit', $manager->id) }}" title="Edit User"><button class="btn btn-primary btn-sm" type="button"><i aria-hidden="true" class="fa fa-pencil-square-o"></i></button></a>
                                 @endcanAccess
                                 @canAccess('managers.destroy')
                                     <a href="{{ route('managers.destroy', $manager->id)}}" onclick="return individualDelete({{ $manager->id }})" title="Delete User"><button class="btn btn-danger btn-sm" type="button"><i aria-hidden="true" class="fa fa-trash"></i></button></a>
                                 @endcanAccess
                                 </td>
                              @empty
                              @endforelse
                        </tr>
                     </table>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Page Content End-->				  
@endsection