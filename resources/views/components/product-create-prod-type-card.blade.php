@props(['title'=>$title,'image'=>$image,'dataVal'=>$dataVal])
<div class="col-lg-3 col-6 col-md-3">
    <div class="clb" dataVal="{{ $dataVal }}" style="cursor: pointer">
        <p>{{ $title }}</p>

        <img src="{{ asset($image) }}" alt="">

    </div>
</div>

