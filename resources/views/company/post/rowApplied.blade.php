<div class="col-lg-12">
<!-- Ls widget -->
<div class="ls-widget">
    <div class="tabs-box">
        <div class="widget-title">
            <h4>{{ $title }}</h4>
            <div class="chosen-outer ">
                <form action="">
                    <div class="input-group " >
                        <input class="form-control border-end-5 border  ml-2" type="text" name="search"
                        style="border-radius:20px 0px 0px 20px" 
                            id="search" placeholder="Tìm kiếm">
                        <span class="input-group-append">
                            <button
                                class="btn btn-outline-warning bg-white border-start-0 border  "
                                style="border-radius:0px 20px 20px 0px" 
                                type="button"
                                href="{{url("company/post/profileApply/$postId")}}"
                                id="button_search">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="widget-content">
            <div class="table-outer">
                @include('company.post.tableApplied')
            </div>
        </div>
    </div>
</div>
</div>