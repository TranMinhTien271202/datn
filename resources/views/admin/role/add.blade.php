<div class="modal fade" id="formAdd" tabindex="-1" role="dialog" aria-labelledby="formAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formAddLabel">{{__('Thêm vai trò')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body ">
          <div class="row justify-content-md-center">
            <div class="form-group col-5">
              <label for="Name">{{ __('Tên vai trò') }}</label>
              <input type="text" class="form-control" name="name" id="nameInput"
              placeholder="{{ __('Enter Name') }}" aria-describedby="name-error" aria-invalid="true">
              <small id="name-error" class="error invalid-feedback"></small>
            </div>
          </div>
          <div class="row">
            <label for="" class="col-4">{{ __('Danh sách quyền') }}</label>
            <div class="custom-control custom-checkbox ">
              <input type="checkbox" id="check-all-permission" name="permission" class="custom-control-input-secondary custom-control-input-outline mr-2 ">
              <label for="checkall" >Chọn tất cả</label>
            </div>
          </div>
          <p><span id="permission-error" class="error text-danger"></span></p>
          @foreach ($group as $key => $item)
          <div class="row pl-2">
          <div class="col-lg-3 col-md-3 mb-3">
            <strong>{{$key}}</strong>
          </div>
                @foreach ($item as  $permission)
                  <div class="col-lg-2 col-md-2">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input custom-control-input-secondary custom-control-input-outline permission" type="checkbox" id="permissionCheck{{$permission->id}}" name="permissions[]" value="{{$permission->name}}">
                      <label for="permissionCheck{{$permission->id}}" class="custom-control-label">{{explode('-',$permission->name)[1]}}</label>
                    </div>
                  </div>
                @endforeach
              </div>
          @endforeach
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-create">{{__('Lưu')}}</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Đóng')}}</button>
        </div>
      </div>
    </div>
  </div>