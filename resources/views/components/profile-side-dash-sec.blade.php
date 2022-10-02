@props(['title' => $title])
<div class="col-lg-3 dashleft ">
    <h2>{{ $title }}</h2>


    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active tabToggleBtn" id="profile" data-bs-toggle="tab" data-bs-target="#tab1"
                type="button" role="tab" aria-controls="home" aria-selected="true">Profile</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link tabToggleBtn" id="rented-list" data-bs-toggle="tab" data-bs-target="#tab2" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Rented</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link tabToggleBtn" id="club-list" data-bs-toggle="tab" data-bs-target="#tab3" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Listings</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link tabToggleBtn" id="analytics" data-bs-toggle="tab" data-bs-target="#tab4" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Analytics</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link tabToggleBtn" id="payment-info" data-bs-toggle="tab" data-bs-target="#tab5" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Payment Info</button>
        </li>


    </ul>

</div>