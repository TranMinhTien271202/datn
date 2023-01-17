  <div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formEdit">{{__('Cập nhật quyền')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                      <label for="Name">{{ __('Tên quyền') }}</label>
                      <input type="text" class="form-control" name="name" id="nameEdit"
                          placeholder="{{ __('Enter Name') }}" aria-describedby="name-edit-error" aria-invalid="true">
                          <small id="name-edit-error" class="error invalid-feedback"></small>
                  </div>
                  <input type="hidden" id="idPermission" >
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-primary btn-edit">{{__('Lưu')}}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Đóng')}}</button>
              </div>
        </div>
    </div>
</div>