<div class="text-end d-flex gap-2 align-items-center">

    <a href="{{ route('backend.bookings.show', $data->id) }}" class="text-info" data-bs-toggle="tooltip" title="{{ __('View') }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
    </a>
    {{--

    @hasPermission('delete_booking')
        <a href="{{ route("backend.$module_name.destroy", $data->id) }}" id="delete-{{ $module_name }}-{{ $data->id }}"
            class="fs-4 text-danger" data-type="ajax" data-method="DELETE" data-token="{{ csrf_token() }}"
            data-bs-toggle="tooltip" title="{{ __('Delete') }}"
            data-confirm="{{ __('messages.are_you_sure?', ['module' => __('booking.singular_title'), 'name' => $data->user->full_name ?? default_user_name()]) }}">
            <i class="icon-delete"></i> </a>
    @endhasPermission
</div>
