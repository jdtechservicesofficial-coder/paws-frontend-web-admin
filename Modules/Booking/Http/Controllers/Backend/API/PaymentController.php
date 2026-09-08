<?php

namespace Modules\Booking\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\BookingTransaction;
use Modules\Booking\Trait\PaymentTrait;
use Modules\Tip\Models\TipEarning;
use Modules\Commission\Models\CommissionEarning;

use Modules\Booking\Trait\BookingTrait;

class PaymentController extends Controller
{
    use PaymentTrait, BookingTrait;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Payment';
    }

    public function savePayment(Request $request)
    {
    
        $data = $request->all();
        $data['tip_amount'] = $data['tip'] ?? 0;

        $booking = Booking::where('id', $data['booking_id'])->first();
  
        $payment = BookingTransaction::updateOrCreate(['id' => $data['id'] ],$data);

        if($booking['employee_id'] !=''){

            $earning_data = $this->commissionData($payment);

            $booking->commission()->save(new CommissionEarning($earning_data['commission_data']));
    
            if ($data['tip_amount'] > 0) {
    
                $booking->tip()->save(new TipEarning($earning_data['tip_data']));
    
            }
    
        }

        if ($booking->status == 'draft') {
            $booking->status = 'pending';
            $booking->save();
            
            try {
                $notification_data = [
                    'id' => $booking->id,
                    'user_id' => $booking->user_id,
                    'user_name' => optional($booking->user)->first_name ?? default_user_name(),
                    'employee_id' => optional($booking->employee)->id,
                    'employee_name' => optional($booking->employee)->first_name,
                    'booking_date' => \Carbon\Carbon::parse($booking->start_date_time)->format('d/m/Y'),
                    'booking_time' => \Carbon\Carbon::parse($booking->start_date_time)->format('h:i'),
                    'booking_services_names' => optional($booking->systemservice)->name ?? 'Service',
                    'booking_services_image' => optional($booking->systemservice)->feature_image ?? '',
                    'booking_date_and_time' => \Carbon\Carbon::parse($booking->start_date_time)->format('Y-m-d H:i'),
                    'latitude' => $request->has('latitude') ? $request->latitude : null,
                    'longitude' => $request->has('longitude') ? $request->longitude : null,
                ];
                $type = 'new_booking';
                $messageTemplate = 'New booking #[[booking_id]] has been booked.';
                $notify_message = str_replace('[[booking_id]]', $booking->id, $messageTemplate);
                
                $this->sendNotificationOnBookingUpdate($type, $notify_message, $notification_data);
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            }
        }
       
        $message = __('booking.payment_done');

        return response()->json(['message' => $message, 'status' => true], 200);
    }
}
