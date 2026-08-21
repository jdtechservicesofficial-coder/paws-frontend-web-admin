@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-8 col-sm-12">
        <form action="{{ route('admin.packages.store') }}" method="post">
            <div class="card">
                <div class="card-body">
                    @csrf
                    <div class="form-group">
                        <label class="required">@lang('Name')</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="required">@lang('Price')</label>
                        <input type="number" step="any" name="price" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="required">@lang('Attributes')</label>
                        <table class="table table-bordered mb-2" id="dynamicTable">
                            <tr>
                                <th>@lang('Name')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </table>
                        <div class="text-end">
                            <button type="button" name="add" id="add-more"
                                class="btn btn-sm bg--success me-4">@lang('Add
                                Field')</button>
                        </div>
                    </div>
                    <div class=" form-group">
                        <label>@lang('Status')</label>
                        <select class="form-control" name="status" required>
                            <option value="1"> @lang('Active') </option>
                            <option value="0">@lang('In-Active')
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>@lang('Featured') </label>
                        <label class="switch m-0">
                            <input type="checkbox" class="toggle-switch" name="is_featured">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn bg--primary btn-global">@lang('Save')</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script>
    "use strict";
    var i = Math.floor((Math.random() * 100000));
    $("#add-more").on('click', function () {
        $("#dynamicTable").append('<tr id="row' + i + '"><td><input type="text" name="attr[]" class="form-control" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-sm bg--danger btn_remove">@lang('Remove')</button></td></tr>');
        i++;
    });
    $(document).on('click', '.btn_remove', function () {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });
</script>

@endpush