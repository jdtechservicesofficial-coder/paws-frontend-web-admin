@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-6">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>@lang('Service Name')</td>
                            <td>{{ $consultation->service_name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Email')</td>
                            <td>{{ $consultation->email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Consultation Time')</td>
                            <td>{{ showDateTime($consultation->time) }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Message')</td>
                            <td>{{ $consultation->message }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Status')</td>
                            <td>@php echo __($consultation->showBadge($consultation->status)); @endphp</td>
                        </tr>
                        @if($consultation->status == 1)
                        @else
                        <tr>
                            <th>@lang('Completion')</td>
                            <td>
                                <a class="btn btn-sm bg--primary"
                                    href="{{ route('admin.consultation.complete', $consultation->id) }}">@lang('Complete
                                    Now')</a>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div><!-- card end -->
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
<a href="{{ route('admin.consultations.index') }}" class="btn btn--primary">
    @lang('Back') </a>
@endpush