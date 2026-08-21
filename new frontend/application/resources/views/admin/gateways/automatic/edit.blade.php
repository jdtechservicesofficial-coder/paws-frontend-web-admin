@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form action="{{ route('admin.gateway.automatic.update', 'paystack') }}" method="POST">
                @csrf

                <div class="card">
                    <div class="card-body">

                        <div class="payment-method-item block-item card border--primary border--primary">
                            <h5 class="card-header bg--primary">@lang('Gateway Settings for Paystack')</h5>
                            
                            <div class="payment-method-body mt-2 px-2">
                                <h4 class="mb-3">@lang('Configurations')</h4>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label>@lang('Paystack Public Key')</label>
                                        <input type="text" class="form-control" name="paystack_publickey" value="{{ $publicKey }}" required />
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label>@lang('Paystack Secret Key')</label>
                                        <input type="text" class="form-control" name="paystack_secretkey" value="{{ $secretKey }}" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn--primary btn-global my-4 float-end">
                            @lang('Save')
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.gateway.automatic.index') }}" class="btn btn-sm btn--primary"><i class="la la-undo"></i>@lang('Back')</a>
@endpush
