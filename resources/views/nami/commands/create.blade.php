<form class="row g-3 from-submit-global" method="post" action="{{ $storeRoute }}" enctype="multipart/form-data">

    <div class="col-12">
        <label for="TextInput"
                class="form-label">{{ trans('auth.Command') }}</label>
        <input type="text" name="command" data-validation="required" class="form-control">
    </div>

    <div class="col-12 modal-footer">
        <button class="btn btn-primary" type="submit">{{__("buttons.save")}}</button>
        <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">{{__("buttons.close")}}</button>
    </div>

</form>
