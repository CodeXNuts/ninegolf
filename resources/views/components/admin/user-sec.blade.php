@props(['users'=>$users])
<table id="registered_user_tbl" class="display" >
    <thead>
        <tr>
            <th >Name</th>
             <th>Email</th>
            <th>Phone</th>
            <th>Location</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="registered_user_body" >

       @foreach ($users as $user)
       <tr>
        <td>
            <img style="width: 10%;
            " class="rounded-circle" src="{{ !empty($user->avatar) ? URL('/'.$user->avatar) : 'https://style.anu.edu.au/_anu/4/images/placeholders/person.png' }}" alt="">
            {{ $user->fname.$user->lname ?? '--' }}
        </td>
        <td>{{ $user->email ?? '---' }}</td>
        <td>{{ $user->phone ?? '---' }}</td>
        <td>{{ $user->location ?? '---' }}</td>
        <td >
            <i class="fa fa-trash fa-sm deleteCategory" title="Delete"   style="margin-right: 5px;cursor: pointer;" aria-hidden="true"></i>
            <i class="fa fa-edit fa-sm editCategory" title="Edit" style="cursor: pointer;margin-right: 5px" aria-hidden="true"></i>
            <i class="fa fa-ban fa-sm" title="Suspend" style="cursor: pointer" aria-hidden="true"></i>
        </td>
       </tr>
       @endforeach
           
    </tbody>
</table>