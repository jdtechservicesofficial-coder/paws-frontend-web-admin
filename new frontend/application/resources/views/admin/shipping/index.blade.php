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
                                <th>@lang('Charge')</th>
                                <th>@lang('Day')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse ($shippings as $item)
                           <tr>
                              <td>{{__($item->name)}}</td>
                              <td>{{__($general->cur_sym)}} {{showAmount($item->charge)}}</td>
                              <td>{{__($item->day)}} @lang('day')</td>
                              <td>
                                @if($item->status ==1)
                                <span class="badge badge--success">@lang('Active')</span>
                                @else
                                <span class="badge badge--danger">@lang('Deactive')</span>
                                @endif
                              </td>
                              <td>
                                 <div class="button--group">
                                    <button type="button" class="btn btn-sm btn--primary updateCategory" data-id="{{$item->id}}" data-charge="{{$item->charge}}" data-name="{{$item->name}}" data-status="{{$item->status}}" data-day="{{$item->day}}"><i class="las la-edit"></i></button>
                                    <a href="{{route('admin.shipping.delete',$item->id)}}" class="btn btn-sm btn--danger"><i class="las la-trash"></i></a>
                                 </div>
                              </td>
                           </tr>
                           @empty
                           <tr>
                             <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                          </tr>
                           @endforelse
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
        </div><!-- card end -->
    </div>
</div>


{{-- Add METHOD MODAL --}}
<div id="addCupon" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Add Cupon')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.shipping.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label  for="name"> @lang('Name'):</label>
                        <input type="text" class="form-control" name="name" placeholder="@lang('Name')" required>
                    </div>
                    <div class="form-group">
                        <label  for="charge"> @lang('Charge') - {{__($general->cur_sym)}}</label>
                        <input step="any" type="number" class="form-control" name="charge" placeholder="@lang('Charge')" required>
                    </div>
                    <div class="form-group">
                        <label  for="day"> @lang('Day')</label>
                        <input type="text" class="form-control" name="day" placeholder="@lang('Day')" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-global">@lang('Save')</button>
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
                <h5 class="modal-title"> @lang('Update')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.shipping.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label  for="name"> @lang('Name'):</label>
                        <input type="text" class="form-control" name="name" placeholder="@lang('Name')" required>
                    </div>
                    <div class="form-group">
                        <label  for="charge"> @lang('Charge') - {{__($general->cur_sym)}}</label>
                        <input step="any" type="number" class="form-control" name="charge" placeholder="@lang('Charge')" required>
                    </div>
                    <div class="form-group">
                        <label  for="day"> @lang('Day')</label>
                        <input type="text" class="form-control" name="day" placeholder="@lang('Day')" required>
                    </div>

                    <div class="form-group">
                        <label> @lang('Status')</label>
                        <label class="switch m-0" for="statuss">
                            <input type="checkbox" class="toggle-switch" name="status" id="statuss">
                            <span class="slider round"></span>
                        </label>
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
<button type="button" class="btn btn-sm btn--primary addCupon"><i class="las la-plus"></i>@lang('Add
    New')</button>
@endpush
@push('script')
<script>
    (function($){
        "use strict";

        $('.addCupon').on('click', function() {
        $('#addCupon').modal('show');
    });

    $('.updateCategory').on('click', function() {
        var modal = $('#updateCategory');
        modal.find('input[name=id]').val($(this).data('id'));
        modal.find('input[name=name]').val($(this).data('name'));
        modal.find('input[name=charge]').val($(this).data('charge'));
        modal.find('input[name=day]').val($(this).data('day'));
        modal.find('input[name=status]').prop('checked', $(this).data('status') == 1 ? true : false );
        modal.find('input[name=status]').val($(this).data('status') == 1 ? 1 : 0);
        modal.modal('show');
    });
    })(jQuery);
</script>
@endpush
