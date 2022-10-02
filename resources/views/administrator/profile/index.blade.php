<x-administrator-app-layout>
    <x-slot name='addOnCss'></x-slot>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>

            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>
                                Account</a>
                        </li>
                        {{-- <li class="nav-item">
              <a class="nav-link" href="pages-account-settings-notifications.html"
                ><i class="bx bx-bell me-1"></i> Notifications</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages-account-settings-connections.html"
                ><i class="bx bx-link-alt me-1"></i> Connections</a
              >
            </li> --}}
                    </ul>
                    <div class="card mb-4">
                        <h5 class="card-header">Profile Details</h5>
                        <!-- Account -->
                        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ !empty(auth()->guard('administrator')->user()->avatar)? URL('/' .auth()->guard('administrator')->user()->avatar): '' }}"
                                    alt="user-avatar" class="d-block rounded" height="100" width="100"
                                    id="uploadedAvatar" />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" class="account-file-input profileImage"
                                            hidden accept="image/png, image/jpeg" />
                                    </label>


                                    <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                </div>
                            </div>
                        </div>
                        <hr class="my-0" />
                        <div class="card-body">
                            <form id="formAccountSettings" action="{{ route('administrator.profile.update',['administrator'=>auth()->guard('administrator')->user()->id]) }}" method="POST" enctype="multipart/form-data">
                              @csrf
                              @method('PUT');
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Name</label>
                                        <input class="form-control" type="text" id="name" name="firstName"
                                            value="{{ auth()->guard('administrator')->user()->name }}" autofocus />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input class="form-control" type="text" name="email" id="email"
                                            value="{{ auth()->guard('administrator')->user()->email }}" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input class="form-control" type="text" name="phone" id="phone"
                                            value="{{ auth()->guard('administrator')->user()->phone }}" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="address" class="form-label">Address</label>
                                        <input class="form-control" type="text" name="address" id="address"
                                            value="{{ auth()->guard('administrator')->user()->address }}" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="country" class="form-label">Country</label>
                                        <input class="form-control" type="text" name="country" id="country"
                                            value="{{ auth()->guard('administrator')->user()->country }}" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="zip" class="form-label">Zip</label>
                                        <input class="form-control" type="text" name="zip" id="zip"
                                            value="{{ auth()->guard('administrator')->user()->zip }}" />
                                    </div>

                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                    <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                </div>
                            </form>
                        </div>
                        <!-- /Account -->
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->


        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
    <x-slot name="addOnJs">
        <script>
            $(document).on('change', '#upload', function(e) {
                var src = e.target.files;
                if (src.length > 0) {
                    $('#uploadedAvatar').attr('src', URL.createObjectURL(src[0]));
                }
            })
        </script>
    </x-slot>
</x-administrator-app-layout>
