<div class="modal fade" id="formAdd" tabindex="-1" role="dialog" aria-labelledby="formAddLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formAddLabel">{{__('Thêm quyền')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="Name">{{ __('Tên quyền') }}</label>
                <input type="text" class="form-control" name="name" id="nameInput"
                    placeholder="{{ __('Enter Name') }}" aria-describedby="name-error" aria-invalid="true">
                    <small id="name-error" class="error invalid-feedback"></small>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-create">{{__('Lưu')}}</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Đóng')}}</button>
        </div>
      </div>
    </div>
  </div>