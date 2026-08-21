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
                                <th>@lang('User Name')</th>
                                <th>@lang('Service Name')</th>
                                <th>@lang('email')</th>
                                <th>@lang('Time')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($consultations as $consultation)
                            <tr>
                                <td>
                                    @if($consultation->user_id == 0)
                                    <span>@lang('Guest User')</span>
                                    @else
                                    <span>{{@$consultation->user->username}}</span>
                                    @endif
                                </td>
                                <td>{{ $consultation->service_name }}</td>
                                <td>{{ $consultation->email }}</td>
                                <td>{{ showDateTime($consultation->created_at) }}</td>
                                <td>@php echo __($consultation->showBadge($consultation->status)); @endphp</td>
                                <td>
                                    <a title="@lang('Details')"
                                        href="{{ route('admin.consultation.show', $consultation->id) }}"
                                        class="btn btn-sm btn--primary ms-1">
                                        <i class="las la-eye text--shadow"></i>
                                    </a>
                                </td>
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
            @if ($consultations->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($consultations) }}
            </div>
            @endif
        </div><!-- card end -->
    </div>
</div>
@endsection
@push('breadcrumb-plugins')
<div class="d-flex flex-wrap justify-content-end">
    <form action="{{ route('admin.consultations.search') }}" method="post" class="form-inline">
        @csrf
        <div class="input-group justify-content-end">
            <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Email or Service name')"
                value="{{ request()->search }}">
            <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
</div>
@endpush
