
    <form id="create_proj" action="{{route('saveProject')}}" method="post">
        @csrf
        <div class="form-group">
            <div class="d-flex justify-content-between border-bot">
                <div class="font-weight-bold h4" >Dự án</div>
                <div id="block-proj" style="cursor: pointer;"><i class="fa fa-plus" aria-hidden="true"></i></div>
            </div>
            <div id="projects" class="mt-3 border-bot form" style="display: none">
                @if(!empty($seeker)) <input type="hidden" name="seeker_id" value="{{$seeker->id}}"> @endif
                <div class="form-group">
                    <label for="">Tên dự án *</label>
                    <input type="text" name="name" class="form-control">
                        <small class="val_name_proj text-danger pl-4"></small>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <label for="">Bắt đầu *</label>
                        <input type="date" name="start_date" class="form-control" >
                        <small class="val_start_date_proj text-danger pl-4"></small>
                    </div>
                    <div class="col">
                        <label for="">Kết thúc *</label>
                        <input type="date" name="end_date" class="form-control">
                        <small class="val_end_date_proj text-danger pl-4"></small>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="">Mô tả ngắn *</label>
                    <textarea name="summary" class="form-control" rows="3"></textarea>
                    <small class="val_summary_proj text-danger pl-4"></small>
               </div>
               <div class="form-group mt-3">
                    <label for="">Nội dung *</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                    <small class="val_description_proj text-danger pl-4"></small>
                    <small class="text-red"><i>Gợi ý: Mô tả dự án cụ thể, những kết quả và thành tựu đạt được có số liệu dẫn chứng</i></small>
               </div>
                <div class="d-flex mt-3 flex-row-reverse">
                    <div class="hide-button-proj btn btn-warning">Hủy</div>
                    <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Lưu</button>
                </div>
            </div>
        </div>
    </form>

    @if(!empty($projects))
    <div class="load">
        <div id="proj-full">
            <div id="list-projects" class="list-projects mt-3">
                @foreach($projects as $proj)
                <div class="item_proj proj_div{{$proj->id}}">
                    <form id="form-border-proj{{$proj->id}}" class="delProj d-flex mt-3 border-dotted-bot" action="{{route('deleteProject',['id' => $proj->id])}}" method="get">
                        @csrf
                        <div style="width: 90%;" class="proj_pro mb-3" id="EditHideProj{{$proj->id}}">
                            <div class="h5">
                                Tên dự án: <span>{{$proj->name}}</span>
                            </div>
                            <div class="d-flex">
                                Từ: {{date("m-Y", strtotime($proj->start_date))}} - {{date("m-Y", strtotime($proj->end_date))}}
                            </div>
                            <div>
                                Mô tả ngắn: {{$proj->summary}}
                            </div>
                            <div>
                                Nội dung: {{$proj->description}}
                            </div>
                        </div>
                        <div id="btnFormProj{{$proj->id}}" style="width: 10%;">
                            <button data-id-proj="{{$proj->id}}" class="removeProj" type="submit" style="float: right;"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            <div onclick="EditFormProjId({{$proj->id}})" style="float: right;margin-right: 5px; cursor: pointer;"><i class="fas fa-edit"></i></div>
                            <div style="clear: both;"></div>
                        </div>
                    </form>
        
                    <form class="update_proj" action="{{route('updateProject', ['id' => $proj->id] )}}" method="post">
                        @csrf
                        <div id="EditFormProj{{$proj->id}}" class="mt-3 mb-3 border-dotted-bot form" style="display: none;">
                            @if(!empty($seeker)) <input type="hidden" name="seeker_id" value="{{$seeker->id}}"> @endif
                            <div class="form-group">
                                <label for="">Tên dự án *</label>
                                <input type="text" value="{{$proj->name}}" name="name" class="form-control">
                                <small class="val_name_proj text-danger pl-4"></small>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="">Bắt đầu *</label>
                                    <input type="date" name="start_date" value="{{date("Y-m-d", strtotime($proj->start_date))}}" class="form-control" >
                                    <small class="val_start_date_proj text-danger pl-4"></small>
                                </div>
                                <div class="col">
                                    <label for="">Kết thúc *</label>
                                    <input type="date" @if(!empty($proj->end_date)) value="{{date("Y-m-d", strtotime($proj->end_date))}}" @endif name="end_date" class="form-control">
                                    <small class="val_end_date_proj text-danger pl-4"></small>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="">Mô tả ngắn *</label>
                                <textarea name="summary" class="form-control" rows="3">{{$proj->summary}}</textarea>
                                <small class="val_summary_proj text-danger pl-4"></small>
                           </div>
                           <div class="form-group mt-3">
                                <label for="">Nội dung *</label>
                                <textarea name="description" class="form-control" rows="3">{{$proj->description}}</textarea>
                                <small class="val_description_proj text-danger pl-4"></small>
                                <small class="text-red"><i>Gợi ý: Mô tả dự án cụ thể, những kết quả và thành tựu đạt được có số liệu dẫn chứng</i></small>
                           </div>
                            <div class="d-flex mt-3 flex-row-reverse">
                                <div class="hide-button-proj{{$proj->id}} btn btn-warning">Hủy</div>
                                <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Lưu</button>
                            </div>
                        </div>
                    </form>
                </div>
    
                @endforeach
            </div>
        </div>
    </div>
    @endif
