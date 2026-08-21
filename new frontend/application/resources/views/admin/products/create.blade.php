@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.product.store')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="category" class="font-weight-bold">@lang('Category')</label>
                                    <select class="form-control" name="category_id" required>
                                        <option selected disabled>@lang('Select Category')</option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{ __($category->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name" class="font-weight-bold">@lang('Name')</label>
                                    <input type="text" name="name" id="name" value="{{old('name')}}"
                                        class="form-control " placeholder="@lang('Name...')"
                                        required>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="price" class="font-weight-bold">@lang('Price')</label>
                                    <input type="number" name="price" id="price" value="{{old('price')}}"
                                        class="form-control " placeholder="@lang('Price...')"
                                        required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="discount" class="font-weight-bold">@lang('Discount') %</label>
                                    <input type="number" name="discount" id="discount" value="{{old('discount')}}"
                                    class="form-control " placeholder="@lang('Discount...')">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="quantity" class="font-weight-bold">@lang('Quantity')</label>
                                    <input type="text" name="quantity" id="quantity" value="{{old('quantity')}}"
                                        class="form-control " placeholder="@lang('Quantity...')"
                                        required>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="short_desc" class="font-weight-bold">@lang('Short Description')</label>
                                    <textarea class="form-control" name="short_desc" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row form-group">
                                    <div class="col-12">
                                        <label for="iamges" class="font-weight-bold">@lang('Image')</label>
                                    </div>
                                    <div class="col-9 mb-3">
                                        <div class="file-upload-wrapper" data-text="Select your file!">
                                            <input type="file" name="images[]" id="images" class="file-upload-field">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <button type="button" class="btn btn--white addProductImage ms-0"><i class="fa fa-plus"></i></button>
                                    </div>
                                    <div class="col-12">
                                        <div id="productImage"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="price" class="font-weight-bold">@lang('Status')</label>
                                    <label class="switch m-0">
                                        <input type="checkbox" class="toggle-switch" name="status">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="price" class="font-weight-bold">@lang('Is featured')</label>
                                    <label class="switch m-0">
                                        <input type="checkbox" class="toggle-switch" name="is_featured">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col text-end">
                                <button type="submit" class="btn btn--primary btn-global">@lang('create')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
<a href="{{route('admin.product.index')}}" class="btn btn-sm btn--primary ">@lang('Back')</a>
@endpush



@push('script')
<script>
    "use strict";
    (function ($) {

        var fileAdded = 0;
        $('.addProductImage').on('click', function () {
            if (fileAdded >= 2) {
                notify('error', 'You\'ve added maximum number of file');
                return false;
            }
            fileAdded++;
            $("#productImage").append(`
                    <div class="row">
                        <div class="col-9 mb-3">
                            <div class="file-upload-wrapper" data-text="@lang('Select your file!')"><input type="file" name="images[]" id="inputAttachments" class="file-upload-field"/></div>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn text--danger removeProductImage"><i class="la la-times ms-0"></i></button>
                        </div>
                    </div>
                `)
        });

        $(document).on('click', '.removeProductImage', function () {
            fileAdded--;
            $(this).closest('.row').remove();
        });
    })(jQuery);
</script>
@endpush
