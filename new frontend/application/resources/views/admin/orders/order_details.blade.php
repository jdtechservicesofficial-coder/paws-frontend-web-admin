@extends('admin.layouts.app')
@section('panel')
<div class="row mb-none-30 justify-content-center">
    <div class="col-xl-8 col-md-6 mb-30">
        <div class="card b-radius--10 overflow-hidden box--shadow1">
            <div class="card-body">
                <h5 class="mb-20 p-2 text-muted">@lang('Shipping Address')</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Order Number')
                        <span class="fw-bold  badge badge--success">#{{__(@$orderDetails->order_number)}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Full Name')
                        <span class="fw-bold">{{__(@$orderDetails->firstname.@$orderDetails->lastname)}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Address')
                        <span class="fw-bold">{{__(@$orderDetails->address)}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Email')
                        <span class="fw-bold">
                            <a>{{__(@$orderDetails->email)}}</a>
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Phone Number')
                        <span class="fw-bold">{{__(@$orderDetails->phone)}}</span>
                    </li>
                </ul>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table">
                        <thead>
                            <tr>
                                <th>@lang('Product Image')</th>
                                <th>@lang('Product Name')</th>
                                <th>@lang('Quantity')</th>
                                <th>@lang('Total Price')</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse ($orderDetails->products as $item)

                           <tr>
                              @php
                                $media = \Illuminate\Support\Facades\DB::table('media')->where('model_type', 'Modules\Product\Models\Product')->where('model_id', $item->product->id)->first();
                                $imageUrl = $media ? getCloudinaryOrLocalUrl($media) : getImage(getFilePath('product').'/');
                              @endphp
                              <td><img src="{{ $imageUrl }}" alt="Image" class="rounded" style="width:50px;"></td>

                              <td>
                                {{__($item->name)}}
                            </td>
                            <td>
                                {{__($item->pivot->product_quantity)}} x {{showAmount(__($item->price))}}
                            </td>
                            <td>
                                {{__($general->cur_sym)}}{{__($item->price * $item->pivot->product_quantity)}}
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
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-30">
        <div class="card b-radius--10 overflow-hidden box--shadow1">
            <div class="card-body">
                <h5 class="card-title mb-50 border-bottom pb-2">@lang('Order Approve')</h5>
                    <div class="row mt-4 gy-2">
                        <div class="col-md-12">
                            <form action="{{route('admin.orders.approve',$orderDetails->id)}}" method="post">
                                @csrf
                                <select name="status" class="form-control">
                                    <option value="2">@lang('Shipped')</option>
                                    <option value="3">@lang('Delivered')</option>
                                </select>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn--success"><i class="fas fa-check"></i>
                                @lang('Save')
                            </button>
                        </div>
                    </form>
                    </div>
            </div>
        </div>
    </div>

</div>

@endsection


