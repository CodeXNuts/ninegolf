<form class="form-inline" name="clubSearch" id="clubSearch" method="GET" action="{{ route('search') }}">
    <div class="col-lg-4 col-md-4">
        <label for="">Where</label>
        <input type="text" name="search" class="book" placeholder="City, club &amp; address etc.">
        @error('search')
            <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-lg-4 col-md-4">
        <label for="">From</label>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <input type="text" required name="fromDate" class="rentFromDate" placeholder="Select Date">
                @error('fromDate')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-lg-6 col-md-6">

                <div class="show-input">
                    <input type="text" required name="fromTime" class="timepicker" placeholder="Select Time">
                    @error('fromTime')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <label for="">Untill</label>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <input type="text" class="rentToDate" name="toDate" required placeholder="Select Date">
                @error('toDate')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-lg-6 col-md-6">

                <div class="show-input">
                    <input type="text" name="toTime" required class="timepicker" placeholder="Select Time">
                    @error('toTime')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="search">
            <img src="{{ asset('user/images/Search.svg') }}" id="searchBtn" style="cursor: pointer">
        </div>
    </div>
</form>
