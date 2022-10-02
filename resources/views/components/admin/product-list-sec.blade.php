@props(['clubs' => $clubs])
<div class="responsive-Table">
    <table id="club_list_tbl" class="display">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Type</th>
                <th>Clubs</th>
                <th>Gender</th>
                <th>Dexterity</th>
                <th>Listed By</th>
                <th>Listed On</th>
                <th>View</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="club_list_body">
    
            @foreach ($clubs as $club)
                <tr>
                    @if (!empty($club->type) && $club->type == 'individual')
                        <td>
                            <img style="width: 40px;
                            height: 40px;" class="rounded-circle"
                                src="{{ !empty($club->clubLists[0]->clubImages[0]->image_path) ? URL('/' . $club->clubLists[0]->clubImages[0]->image_path) : 'https://style.anu.edu.au/_anu/4/images/placeholders/person.png' }}"
                                alt="">
    
                            {{ $club->clubLists[0]->name ?? '---' }}
                        </td>
                        <td>${{ !empty($club->clubLists[0]->price) ? number_format($club->clubLists[0]->price, 2) : '0.00' }}/day
                        </td>
                    @elseif (!empty($club->type) && $club->type == 'set')
                        <td>
                            <img style="width: 40px;
                            height: 40px; " class="rounded-circle"
                                src="{{ !empty($club->clubLists[0]->clubImages[0]->image_path) ? URL('/' . $club->clubLists[0]->clubImages[0]->image_path) : 'https://style.anu.edu.au/_anu/4/images/placeholders/person.png' }}"
                                alt="">
    
                            {{ $club->set_name ?? '---' }}
                        </td>
                        <td>${{ !empty($club->set_price) ? number_format($club->set_price, 2) : '0.00' }}/day</td>
                    @endif
    
    
                    <td>{{ !empty($club->type) ? Str::title($club->type) : '---' }}</td>
                    <td>
                        @foreach($club->clubLists as $clubItems)
                            <span class="badge bg-label-info">{{ Str::title($clubItems->name) }}</span>
                        @endforeach
                    </td>
                    <td>{{ !empty($club->gender) ? Str::title($club->gender) : '---' }}</td>
                    <td>{{ !empty($club->dexterity) ? Str::title($club->dexterity) : '---' }}</td>
                    <td>{{ !empty($club->user->fname) ? Str::title($club->user->fname) . ' ' . Str::title($club->user->lname) : '---' }}
                    </td>
                    <td>{{ !empty($club->created_at) ? $club->created_at->diffForHumans() : '---' }}</td>
                    <td style="text-align: center">
                        <a href="{{ route('product.view', ['club' => $club->slug]) }}" target="__blank"><i
                                class="fa fa-eye fa-sm" title="Preview" style="margin-right: 5px;cursor: pointer;"
                                aria-hidden="true"></i></a>
                    </td>
                    <td class="actionBtn">
                        @if (!empty($club->is_active))
                            <span class="badge rounded-pill bg-info">Active</span>
                        @else
                            <span class="badge rounded-pill bg-warning">Pending</span>
                        @endif
                    </td>
                    <td data-club-approve="{{ route('administrator.product.approve',['club'=>$club->slug]) }}" data-club-suspend="{{ route('administrator.product.suspend',['club'=>$club->slug]) }}">
                        @if (!empty($club->is_active))
                        <i class="fa fa-ban fa-sm suspendThis" title="Suspend" class="suspendThis" style="cursor: pointer;" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-check fa-sm approveThis" title="Approve" style="cursor: pointer;" aria-hidden="true"></i>
                    @endif
                    </td>
                </tr>
            @endforeach
    
        </tbody>
    </table>
</div>
