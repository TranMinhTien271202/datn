<form id="create_sko" action="{{route('saveSkillOther')}}" method="post">
    @if(!empty($seeker)) <input type="hidden" name="seeker_id" value="{{$seeker->id}}"> @endif
    @csrf
    <div class="form-group">
        <div class="d-flex justify-content-between border-bot">
            <div class="font-weight-bold h4" >Các kỹ năng khác</div>
            <div id="block-sko" style="cursor: pointer;"><i class="fa fa-plus" aria-hidden="true"></i></div>
        </div>
        <div id="skill_other" class="mt-3" style="display: none">
            <div class="form-group">
                <label for="">Tên kỹ năng *</label>
                <input type="text" name="title" class="form-control">
                <small class="val_title_sko text-danger pl-4"></small>
            </div>
            <div class="form-group">
                <label for="">Mô tả</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="d-flex mt-3 flex-row-reverse">
                <div class="hide-button-sko btn btn-warning">Hủy</div>
                <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Lưu</button>
            </div>
        </div>
    </div>
</form>

@if(!empty($skill_other))
        
<div class="list-skill_other mt-3">
    @foreach($skill_other as $sko)
    <div class="sko_div{{$sko->id}}">
        <form id="form-border-sko{{$sko->id}}" class="delSko d-flex mt-3 border-dotted-bot" action="{{route('deleteSkillOther', ['id' => $sko->id])}}" method="get">
            <div style="width: 90%;" class="mb-3" id="EditHideSko{{$sko->id}}">
                <div class="h6">
                    <span>{{$sko->title}}</span>
                </div>
                <div>
                    <span>{{$sko->description}}</span>
                </div>
            </div>
            <div id="btnFormSko{{$sko->id}}" style="width: 10%;">
                <button data-id-sko="{{$sko->id}}" class="removeSko" type="submit" style="float: right;"><i class="fa fa-trash" aria-hidden="true"></i></button>
                <div onclick="EditFormSkoId({{$sko->id}})" style="float: right;margin-right: 5px; cursor: pointer;"><i class="fas fa-edit"></i></div>
                <div style="clear: both;"></div>
            </div>
        </form>
    
        <form class="update_sko" action="{{route('updateSkillOther', ['id' => $sko->id])}}" method="post">
            @csrf
            <div id="EditFormSko{{$sko->id}}" class="mt-3 mb-3 border-dotted-bot form" style="display: none;">
                @if(!empty($seeker)) <input type="hidden" name="seeker_id" value="{{$seeker->id}}"> @endif
                <div class="form-group">
                    <label for="">Tên kỹ năng *</label>
                    <input type="text" name="title" value="{{$sko->title}}" class="form-control">
                    <small class="val_title_sko text-danger pl-4"></small>
                </div>
                <div class="form-group">
                    <label for="">Mô tả</label>
                    <textarea name="description" class="form-control" rows="3">{{$sko->description}}</textarea>
                </div>
                <div class="d-flex mt-3 flex-row-reverse">
                    <div class="hide-button-sko{{$sko->id}} btn btn-warning">Hủy</div>
                    <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Lưu</button>
                </div>
            </div>
        </form>
    </div>

    @endforeach
</div>
@endif