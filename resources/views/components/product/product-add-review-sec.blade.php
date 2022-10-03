@props(['club'=>$club])
<div class="reviewbox">
    @foreach ($errors->all() as $error)
                <span style="color: red">{{ $error }}</span>
    @endforeach
    <form action="{{ route('user.club.review.create',['club'=>$club->slug]) }}" method="POST" id="clubreviewForm">
        @csrf
        <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
            <input type="hidden" name="inputRating" id="inputRating" value="5" style="display: none">
            <div id="inputStarRating" rating="true" style="color: rgb(252, 215, 3);margin-left: 55px;margin-bottom: 2px"><i class="fas fa-star"
                    style="cursor: pointer;"></i><i class="fas fa-star" style="cursor: pointer;"></i><i class="far fa-star"
                    style="cursor: pointer;"></i><i class="far fa-star" style="cursor: pointer;"></i><i class="far fa-star"
                    style="cursor: pointer;"></i>
            </div>
            <div class="d-flex flex-start w-100">
    
                <img class="rounded-circle shadow-1-strong me-3"
                    src="{{ URL('/'.(auth()->user()->avatar ?? '')) }}" alt="avatar" width="40"
                    height="40" />
                <div class="form-outline w-100">
                    <textarea class="form-control" id="reviewComment" rows="4" style="background: #fff;" name="reviewComment"
                        placeholder="Share your experince"></textarea>
                    <label class="form-label" for="reviewComment"></label>
                </div>
            </div>
            <div class="float-end mt-2 pt-2">
                <button type="button" class="btn btn-primary btn-sm" id="clubReviewbtn">Submit review</button>
                {{-- <button type="button" class="btn btn-outline-primary btn-sm">Cancel</button> --}}
            </div>
        </div>
    </form>
</div>
