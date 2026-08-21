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
                                <th>@lang('Name')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($packages as $item)
                            <tr>
                                <td>{{ __($item->name) }} @if($item->is_featured)<span
                                        class="badge badge--primary">@lang('Featured')</span>@endif</td>
                                <td>{{ __($general->cur_sym) }}{{ showAmount($item->price) }}</td>
                                <td>@php echo $item->statusBadge($item->status); @endphp</td>
                                <td>
                                    <a data-obj="{{ $item }}" title="@lang('Edit')"
                                        href="{{ route('admin.packages.edit', ['package' => $item->id]) }}"
                                        class="btn btn-sm btn--warning">
                                        <i class="las la-pencil-alt"></i>
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
            @if ($packages->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($packages) }}
            </div>
            @endif
        </div><!-- card end -->
    </div>
</div>

<x-confirmation-modal></x-confirmation-modal>
@endsection

@push('breadcrumb-plugins')
<a class="btn btn-sm btn--primary" href="{{ route('admin.packages.create') }}"><i class="las la-plus"></i>@lang('Add
    New')</a>
@endpush