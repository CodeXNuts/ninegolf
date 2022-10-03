@props(['clubReviews' => $clubReviews, 'club' => $club])
<div class="rating">
    <h2>{{ !empty($club->clubRatings) ? count($club->clubRatings) : '' }}
        {{ !empty($club->clubRatings) ? Str::plural('Rating', count($club->clubRatings)) . ' & ' . Str::plural('Review', count($club->clubRatings)) : '' }}
    </h2>
    <ul>
        <li>Sort by: <select name="reviewFilter" id="reviewFilter"
                data-target="{{ route('product.view', ['club' => $club->slug]) }}">
                <option value="MOST_RECENT">Most Recent</option>
                <option value="POSITIVE_FIRST">Positive First</option>
                <option value="NEGATIVE_FIRST">Negative First</option>
            </select>
            </select>
        </li>
    </ul>

</div>

@auth
    @can('create', ['App\ClubRating', $club])
        <x-product.product-add-review-sec :club="$club" />
    @endcan
@endauth

@if (!empty($clubReviews) && count($clubReviews) > 0)
    @foreach ($clubReviews as $eachRating)
        <div class="reviewbox" style="{{ $loop->iteration == 1 ? 'margin-top: 10px;' : '' }}">
            <div id="review" rating="true" style="color: rgb(252, 215, 3);">
                @for ($i = 0; $i < $eachRating->rating; $i++)
                    <i class="fas fa-star" style="cursor: pointer;"></i>
                @endfor
                @for ($i = 0; $i < 5 - intval($eachRating->rating); $i++)
                    <i class="far fa-star" style="cursor: pointer;"></i>
                @endfor

            </div>
            <p>{{ $eachRating->comment ?? '' }}</p>


            <div class="reviewfooter">
                <img src="{{ URL('/' . ($eachRating->user->avatar ?? '')) }}" class="rounded-circle"
                    style="    height: 42px;
            width: 42px;" alt="">
                <h3> {{ $eachRating->user->fname . ' ' . $eachRating->user->lname }} </h3>
                <p>{{ $eachRating->created_at->toFormattedDateString() ?? '' }}</p>
                <a href="javascript:void(0)" class="replyThis"
                    style="margin-left: 5px">Reply({{ !empty($eachRating->clubRatingReplies) ? count($eachRating->clubRatingReplies) . ' ' . Str::plural('reply', count($eachRating->clubRatingReplies)) : '0 reply' }})</a>


            </div>

            @auth
                @can('create', ['App\ClubRatingReply', $club])
                    <div class="card-footer py-3 border-0 replyBox" style="display: none" style="background-color: #f8f9fa;">
                        <form
                            action="{{ route('user.club.review.reply.create', ['club' => $club->slug, 'clubRating' => $eachRating->id]) }}"
                            method="POST" id="clubReviewReplyForm">
                            @csrf

                            <div class="d-flex flex-start w-100">

                                <img class="rounded-circle shadow-1-strong me-3"
                                    src="{{ URL('/' . (auth()->user()->avatar ?? '')) }}" alt="avatar" width="40"
                                    height="40" />
                                <div class="form-outline w-100">
                                    <textarea class="form-control replyComment" rows="4" style="background: #fff;" name="replyComment"
                                        placeholder="Write a reply"></textarea>
                                    <label class="form-label" for="replyComment"></label>
                                </div>
                            </div>
                            <div class="float-end mt-2 pt-2">
                                <button type="button" class="btn btn-primary btn-sm replyBtn">Reply</button>
                                {{-- <button type="button" class="btn btn-outline-primary btn-sm">Cancel</button> --}}
                            </div>

                        </form>

                    </div>
                @endcan

            @endauth
            @foreach ($eachRating->clubRatingReplies as $eachReply)
                <div class="card-footer py-4 border-0 replyShowBox" style="display: none"
                    style="background-color: #f8f9fa;">
                    <p>{{ $eachReply->comment ?? '' }}</p>
                    <div class="reviewfooter">
                        <img src="{{ URL('/' . ($eachReply->user->avatar ?? '')) }}" class="rounded-circle"
                            style="    height: 42px;
            width: 42px;" alt="">

                        <h3> {{ $eachReply->user->fname . ' ' . $eachReply->user->lname }} </h3>
                        <p>{{ $eachReply->created_at->toFormattedDateString() ?? '' }}</p>
                    </div>

                </div>
            @endforeach
        </div>
    @endforeach

    {{ $clubReviews->links() }}
@else
    <p>This product doesn't have any reviews yet</p>
@endif


{{-- <div class="reviewbox">
    <div id="review" rating="true" style="color: rgb(252, 215, 3);"><i
            class="fas fa-star" style="cursor: pointer;"></i><i class="fas fa-star"
            style="cursor: pointer;"></i><i class="far fa-star"
            style="cursor: pointer;"></i><i class="far fa-star"
            style="cursor: pointer;"></i><i class="far fa-star" style="cursor: pointer;"></i>
    </div>
    <p><span>Rented item:</span> Dolor sit amet, consectetur adipiscing elit. Sit quis fames
        donec
        nec mi molestie enim. Consectetur tellus eros.</p>


    <div class="reviewfooter">
        <img src="{{ asset('user/images/reviewman.png') }}" alt="">
        <h3> Kathryn Murphy </h3>
        <p>06 May, 2022</p>
    </div>
</div>
<div class="reviewbox">
    <div id="review" rating="true" style="color: rgb(252, 215, 3);"><i
            class="fas fa-star" style="cursor: pointer;"></i><i class="fas fa-star"
            style="cursor: pointer;"></i><i class="far fa-star"
            style="cursor: pointer;"></i><i class="far fa-star"
            style="cursor: pointer;"></i><i class="far fa-star" style="cursor: pointer;"></i>
    </div>
    <p><span>Rented item:</span> Dolor sit amet, consectetur adipiscing elit. Sit quis fames
        donec
        nec mi molestie enim. Consectetur tellus eros.</p>


    <div class="reviewfooter">
        <img src="{{ asset('user/images/thesa.png') }}" alt="">
        <h3>Theresa Webb </h3>
        <p>06 May, 2022</p>
    </div>
</div> --}}
