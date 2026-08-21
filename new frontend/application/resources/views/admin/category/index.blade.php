@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table">
                        <thead>
                            <tr>
                                <th>@lang('Name')</th>
                                <th>@lang('status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody id="categoryTable">
                           @forelse ($categories as $item)
                           <tr data-id="{{ $item->id }}">
                              <td>{{__($item->name)}}</td>
                              <td>
                                @php
                                    echo $item->statusBadge($item->status);
                                @endphp
                            </td>
                              <td>
                                 <div class="button--group">
                                    <button type="button" class="btn btn-sm btn--primary updateCategory"data-id="{{$item->id}}"data-name="{{$item->name}}" data-status="{{$item->status}}"><i class="las la-edit"></i></button>
                                 </div>
                              </td>
                           </tr>
                           @empty
                           <tr class="empty-message">
                             <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                          </tr>
                           @endforelse
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            @if ($categories->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($categories) }}
            </div>
            @endif
        </div><!-- card end -->
    </div>
</div>


{{-- Add METHOD MODAL --}}
<div id="addCategory" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Add Category')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form id="categoryForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">@lang('Name'):</label>
                        <input type="text" class="form-control" name="name" placeholder="@lang('Name')..." required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-global">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- Update METHOD MODAL --}}
<div id="updateCategory" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Update Manage Category')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form id="updateCategoryForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label  for="name"> @lang('Name'):</label>
                        <input type="text" class="form-control" name="name" placeholder="@lang('Name')...">
                    </div>
                    <div class="form-group">
                        <label  for="name"> @lang('Status'):</label>
                        <select name="status" class="form-control">
                            <option value="0" {{ @$item->status == 0 ? 'selected' : '' }}>@lang('Inactive')</option>
                            <option value="1" {{ @$item->status == 1 ? 'selected' : '' }}>@lang('Active')</option>

                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-global">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('breadcrumb-plugins')
<button type="button" class="btn btn-sm btn--primary addCategory"><i class="las la-plus"></i>@lang('Add
    New')</button>
@endpush
@push('script')
<script>
     "use strict";
    //  add category  modal show
    (function($){
        $('.addCategory').on('click', function() {
        $('#addCategory').modal('show');
        });

        // update modal anad existing data show
        $('.updateCategory').on('click', function() {
            var modal = $('#updateCategory');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('input[name=name]').val($(this).data('name'));

            var statusValue = $(this).data('status');
            modal.find('select[name=status]').val(statusValue);

            modal.modal('show');
        });
    })(jQuery);


         // add category
        $(document).ready(function() {
        $('#categoryForm').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: '{{ route("admin.category.store") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                if (response.hasOwnProperty('message')) {
                        Toast.fire({
                                    icon: 'success',
                                    title: response.message
                                });
                    }
                    $('#categoryForm')[0].reset();
                    appendCategory(response.category);
                    $('#addCategory').modal('hide');

                    if ($('#categoryTable tr').length > 1) {
                    $('#categoryTable tr.empty-message').hide();
            }
                },
                error: function(xhr, status, error) {

                    // If the response contains validation errors
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;

                        // Show specific error messages for each field
                        for (var field in errors) {
                            if (errors.hasOwnProperty(field)) {
                                var errorMessage = errors[field][0];
                                Toast.fire({
                                    icon: 'error',
                                    title: errorMessage
                                });
                            }
                        }
                    } else {
                        var errorMessage = 'Category could not be created. Please try again later.';
                        Toast.fire({
                            icon: 'error',
                            title: errorMessage
                        });
                    }
                }
            });
        });

        // update category
        $('#updateCategoryForm').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: '{{ route("admin.category.update") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                if (response.hasOwnProperty('message')) {
                        Toast.fire({
                                    icon: 'success',
                                    title: response.message
                                });
                    }

                var categoryId = response.category.id;
                var categoryName = response.category.name;
                var categoryStatus = response.category.status;

                // Update category data in the table row
                var $tableRow = $('#categoryTable').find('tr[data-id="' + categoryId + '"]');
                if ($tableRow.length) {
                    $tableRow.find('td:nth-child(1)').text(categoryName);
                    $tableRow.find('td:nth-child(2)').html(categoryStatus === 1 ? '<span class="badge badge--success">Active</span>' : '<span class="badge badge--danger">Inactive</span>');
                }

                $(document).on('click', '.updateCategory', function() {
                 var modal = $('#updateCategory').modal('show');
                 modal.find('input[name=id]').val(categoryId);
                 modal.find('input[name=name]').val(categoryName);
                 var statusValue = categoryStatus === 1 ? '1' : '0';
                 modal.find('select[name=status]').val(statusValue);

                 });

                  $('#updateCategoryForm').get(0).reset();
                  $('#updateCategory').modal('hide');
                },
                error: function(xhr, status, error) {

                    // If the response contains validation errors
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;

                        // Show specific error messages for each field
                        for (var field in errors) {
                            if (errors.hasOwnProperty(field)) {
                                var errorMessage = errors[field][0];
                                Toast.fire({
                                    icon: 'error',
                                    title: errorMessage
                                });
                            }
                        }
                    } else {
                        var errorMessage = 'Category could not be updated. Please try again later.';
                        Toast.fire({
                            icon: 'error',
                            title: errorMessage
                        });
                    }
                }
            });
        });

        //    apend new category
        function appendCategory(category) {
            var statusLabel = category.status === 1 ? 'Active' : 'Inactive';
            var statusBadge = category.status === 1 ? '<span class="badge badge--success">Active</span>' : '<span class="badge badge--danger">Inactive</span>';

            var tableRow = '<tr>' +
                        '<td>' + category.name + '</td>' +
                        '<td>' + statusBadge + '</td>' +
                        '<td>' +
                        '<div class="button--group">' +
                        '<button type="button" class="btn btn-sm btn--primary updateCategory" data-id="' + category.id + '" data-name="' + category.name + '" data-status="' + category.status + '"><i class="las la-edit"></i></button>' +
                        '</div>' +
                        '</td>' +
                        '</tr>';
                    $('#categoryTable').prepend(tableRow);
                }

                $(document).on('click', '.updateCategory', function() {

                var modal = $('#updateCategory').modal('show');
                    modal.find('input[name=id]').val($(this).data('id'));
                    modal.find('input[name=name]').val($(this).data('name'));
                    var statusValue = $(this).data('status');
                    modal.find('select[name=status]').val(statusValue);
            });

    });

</script>

@endpush
