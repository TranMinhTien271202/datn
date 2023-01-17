<form id="create_tool" action="{{route('saveTools')}}" method="post">
    @if(!empty($seeker)) <input type="hidden" name="seeker_id" value="{{$seeker->id}}"> @endif
    @csrf
    <div class="form-group">
        <div class="d-flex justify-content-between border-bot">
            <div class="font-weight-bold h4" >Công cụ sử dụng</div>
            <div id="block-tool" style="cursor: pointer;"><i class="fa fa-plus" aria-hidden="true"></i></div>
        </div>
        <div id="tools_used" class="mt-3" style="display: none">
            <div class="form-group">
                <label for="">Tên công cụ *</label>
                <input type="text" name="title" class="form-control">
                <small class="val_title_tool text-danger pl-4"></small>
            </div>
            <div class="form-group">
                <label for="">Mô tả</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="d-flex mt-3 flex-row-reverse">
                <div class="hide-button-tool btn btn-warning">Hủy</div>
                <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Lưu</button>
            </div>
        </div>
    </div>
</form>

@if(!empty($tool_used))
        
<div class="list-tool_used mt-3">
    @foreach($tool_used as $tool)
    <div class="tool_div{{$tool->id}}">
        <form id="form-border-tool{{$tool->id}}" class="delTool d-flex mt-3 border-dotted-bot" action="{{route('deleteTools', ['id' => $tool->id])}}" method="get">
            <div style="width: 90%;" class="mb-3" id="EditHideTool{{$tool->id}}">
                <div class="h6">
                    <span>{{$tool->title}}</span>
                </div>
                <div>
                    <span>{{$tool->description}}</span>
                </div>
            </div>
            <div id="btnFormTool{{$tool->id}}" style="width: 10%;">
                <button data-id-tool="{{$tool->id}}" class="removeTool" type="submit" style="float: right;"><i class="fa fa-trash" aria-hidden="true"></i></button>
                <div onclick="EditFormToolId({{$tool->id}})" style="float: right;margin-right: 5px; cursor: pointer;"><i class="fas fa-edit"></i></div>
                <div style="clear: both;"></div>
            </div>
        </form>
    
        <form class="update_tool" action="{{route('updateTools', ['id' => $tool->id])}}" method="post">
            @csrf
            <div id="EditFormTool{{$tool->id}}" class="mt-3 mb-3 border-dotted-bot form" style="display: none;">
                @if(!empty($seeker)) <input type="hidden" name="seeker_id" value="{{$seeker->id}}"> @endif
                <div class="form-group">
                    <label for="">Tên công cụ *</label>
                    <input type="text" name="title" value="{{$tool->title}}" class="form-control">
                    <small class="val_title_tool text-danger pl-4"></small>
                </div>
                <div class="form-group">
                    <label for="">Mô tả</label>
                    <textarea name="description" class="form-control" rows="3">{{$tool->description}}</textarea>
                </div>
                <div class="d-flex mt-3 flex-row-reverse">
                    <div class="hide-button-tool{{$tool->id}} btn btn-warning">Hủy</div>
                    <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Lưu</button>
                </div>
            </div>
        </form>
    </div>

    @endforeach
</div>
@endif