@extends('admin.layouts.app')
@section('panel')
<div class="row">

    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('Package')</th>
                                <th>@lang('User')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Date')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subscriptions as $subscription)
                            <tr>
                                <td>{{ $subscription->package->name }}</td>
                                <td><a href="{{ route('admin.users.detail', $subscription->user->id) }}">{{$subscription->user->fullname}}
                                        ({{$subscription->user->email}})</a></td>
                                <td>{{ $general->cur_sym }}{{ showAmount($subscription->amount) }}</td>
                                <td>{{ showDateTime($subscription->created_at) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            @if ($subscriptions->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($subscriptions) }}
            </div>
            @endif
        </div><!-- card end -->
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
<div class="d-flex flex-wrap justify-content-end">
    <form action="{{ route('admin.subscriptions.search') }}" method="post" class="form-inline">
        @csrf
        <div class="input-group justify-content-end">
            <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Email')"
                value="{{ request()->search }}">
            <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
</div>
@endpush