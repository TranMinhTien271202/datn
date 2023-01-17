@foreach($data as $dat)
<div class="mt-3 content-of-review rating-css" style="border-bottom: 1px solid #d9cfcf">
    <div class="rating-css">
        <div class="star-icon">
            <input @if($dat->rate == 1) checked  @endif type="radio" value="1" id="rating1" disabled>
            <label for="rating1" class="fa fa-star"></label>
            <input @if($dat->rate == 2) checked @endif type="radio" value="2" id="rating2" disabled>
            <label for="rating2" class="fa fa-star"></label>
            <input @if($dat->rate == 3) checked @endif type="radio" value="3" id="rating3" disabled>
            <label for="rating3" class="fa fa-star"></label>
            <input @if($dat->rate == 4) checked @endif type="radio" value="4" id="rating4" disabled>
            <label for="rating4" class="fa fa-star"></label>
            <input @if($dat->rate == 5) checked @endif type="radio" value="5" id="rating5" disabled>
            <label for="rating5" class="fa fa-star"></label>
        </div>
    </div>
    <aside class="mb-3">
        <strong style="font-size:16px;">{{$dat->title}}</strong>
        <br>
   <small style="font-size:12px">{{date('\T\h\á\n\g\ m \n\ă\m\ Y', strtotime($dat->created_at))}}</small>
    </aside>

    <aside class="row d-flex">
        <p class="col">
            <span style="font-size:15px;font-weight: bold;">Điều hài lòng</span>
            <br>
            <span>{{$dat->satisfied}}</span>
        </p>
        <p class="col">
            <span style="font-size:15px;font-weight: bold;">Điều không hài lòng</span>
            <br>
            <span>{{$dat->unsatisfied}}</span>
        </p>
    </aside>

    <aside class="row">
        <p class="col">
            <span style="font-size:15px;font-weight: bold;">Điều thích</span>
            <br>
            <span>{{$dat->like_text}}</span>
        </p>
        
        <p class="col">
            <span style="font-size:15px;font-weight: bold;">Điều cần cải thiện</span>
        <br>
        <span>{{$dat->improve}}</span>
        </p>
    </aside>
    
</div>
@endforeach

<div class="ls-pagination">{{ $data->links('company.layout.paginate'); }}</div>