<?php

namespace App\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Booking\Models\Booking;
use Modules\Product\Models\Order;
use Modules\Booking\Transformers\BookingListResource;
use DB;
use Auth;

class AdminDashboardApiController extends Controller
{
    public function dashboardDetail(Request $request)
    {
        $query = Booking::query();

        $completeBookingsCount = (clone $query)->where('status', 'completed')->count(); 
        $pendingBookingsCount = (clone $query)->where('status', 'pending')->count();
        $totalBookings = $query->count();
        
        $revenue_data = getRevenueData();
        
        $totalEmployees = User::where('user_type', '!=', 'user')
            ->where('status', 1)
            ->whereNotNull('email_verified_at')
            ->count();
        
        $totalOrders = Order::count();

        $recent_bookings_raw = Booking::with([
                'user', 'employee', 'payment', 
                'boarding', 'walking', 'daycare', 'training', 'veterinary', 'grooming', 'systemservice'
            ])
            ->orderBy('id','desc')
            ->take(10)
            ->get();
            
        $recent_bookings = BookingListResource::collection($recent_bookings_raw);

        $data = [
            'total_bookings' => $totalBookings,
            'completed_bookings' => $completeBookingsCount,
            'pending_bookings' => $pendingBookingsCount,
            'total_revenue' => $revenue_data['total_amount'] ?? 0,
            'total_profit' => $revenue_data['admin_earnings'] ?? 0,
            'total_employees' => $totalEmployees,
            'total_orders' => $totalOrders,
            'recent_bookings' => $recent_bookings,
        ];

        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => 'Admin dashboard loaded successfully',
        ], 200);
    }

    public function adminBookingsList(Request $request)
    {
        $query = Booking::with([
            'user', 'employee', 'payment', 
            'boarding', 'walking', 'daycare', 'training', 'veterinary', 'grooming', 'systemservice'
        ]);

        if ($request->has('booking_type') && isset($request->booking_type)) {
            $query->where('booking_type', $request->booking_type);
        }

        if ($request->has('status') && isset($request->status)) {
            $status = explode(',', $request->status);
            $query->whereIn('status', $status);
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%$search%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"])
                                ->orWhere('email', 'LIKE', "%$search%");
                  })
                  ->orWhereHas('employee', function ($employeeQuery) use ($search) {
                      $employeeQuery->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"])
                                    ->orWhere('email', 'LIKE', "%$search%");
                  });
            });
        }

        $per_page = $request->input('per_page', 10);
        $bookings = $query->orderBy('id', 'desc')->paginate($per_page);

        $items = BookingListResource::collection($bookings);

        return response()->json([
            'status' => true,
            'data' => $items,
            'message' => 'Admin booking list loaded successfully',
        ], 200);
    }

    public function adminOrdersList(Request $request)
    {
        $query = \Modules\Product\Models\OrderItem::with(['order.orderGroup', 'product_variation.product']);

        if ($request->filled('delivery_status') && $request->delivery_status !== 'all') {
            $query->where('delivery_status', $request->delivery_status);
        }

        if ($request->filled('payment_status') && $request->payment_status !== 'all') {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('order', function ($oq) use ($search) {
                    $oq->whereHas('orderGroup', function ($gq) use ($search) {
                        $gq->where('order_code', 'LIKE', "%$search%");
                    })->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('first_name', 'LIKE', "%$search%")
                           ->orWhere('last_name', 'LIKE', "%$search%");
                    });
                })->orWhere('total_price', 'LIKE', "%$search%");
            });
        }
        if ($request->has('date') && !empty($request->date)) {
            $query->whereDate('created_at', $request->date);
        }

        $per_page = $request->input('per_page', 10);
        $orders = $query->orderBy('id', 'desc')->paginate($per_page);

        $items = \Modules\Product\Transformers\OrderItemResource::collection($orders);

        return response()->json([
            'status' => true,
            'data' => $items,
            'message' => 'Admin orders list loaded successfully',
        ], 200);
    }
    public function bookingDetail($id)
    {
        $booking = Booking::with([
            'user', 'employee', 'payment', 
            'boarding', 'walking', 'daycare', 'training', 'veterinary', 'grooming', 'systemservice'
        ])->find($id);

        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Booking not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => new BookingListResource($booking),
            'message' => 'Booking detail loaded successfully',
        ], 200);
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required_without:is_reschedule|string',
        ]);

        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Booking not found',
            ], 404);
        }

        if ($request->has('is_reschedule') && $request->is_reschedule == 1) {
            $request->validate([
                'date' => 'required|date',
                'time' => 'required',
            ]);
            $booking->start_date_time = $request->date . ' ' . $request->time;

            $booking_type = $booking->booking_type;
            if ($booking_type && $booking->$booking_type) {
                $service = $booking->$booking_type;
                if (in_array($booking_type, ['walking', 'veterinary', 'training', 'grooming'])) {
                    $service->date_time = $booking->start_date_time;
                } elseif ($booking_type == 'boarding') {
                    $service->dropoff_date_time = $booking->start_date_time;
                } elseif ($booking_type == 'daycare') {
                    $service->date = $request->date;
                    $service->dropoff_time = $request->time;
                }
                $service->save();
            }
        }

        if ($request->has('status')) {
            $booking->status = $request->status;
        }

        $booking->save();

        return response()->json([
            'status' => true,
            'data' => new BookingListResource($booking),
            'message' => $request->has('is_reschedule') ? 'Booking rescheduled successfully' : 'Booking status updated successfully',
        ], 200);
    }

    public function orderDetail($id)
    {
        $orderItem = \Modules\Product\Models\OrderItem::with(['order.orderGroup', 'order.user', 'product_variation.product'])->find($id);

        if (!$orderItem) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found',
            ], 404);
        }

        $order_prefix_data = \App\Models\Setting::where('name', 'inv_prefix')->first();
        $order_prefix = $order_prefix_data ? $order_prefix_data->val : '';
        $order_code = $order_prefix . optional(optional($orderItem->order)->orderGroup)->order_code;

        $product = optional($orderItem->product_variation)->product;
        $productName = $product->name ?? 'Unknown Product';
        $productImage = $product?->media->pluck('original_url')->first() ?? '';
        $user = optional($orderItem->order)->user;

        $data = [
            'id' => $orderItem->id,
            'order_code' => $order_code,
            'payment_status' => $orderItem->payment_status,
            'delivery_status' => $orderItem->delivery_status,
            'total_amount' => $orderItem->total_price + $orderItem->total_tax + $orderItem->total_shipping_cost,
            'order_date' => $orderItem->created_at ? $orderItem->created_at->format('Y-m-d H:i') : '',
            'user' => [
                'first_name' => $user ? $user->first_name : 'Unknown',
                'last_name' => $user ? $user->last_name : 'Customer',
                'email' => $user ? $user->email : '',
                'mobile' => $user ? $user->mobile : '',
                'profile_image' => $user ? $user->getFirstMediaUrl('profile_image') : '',
            ],
            'order_items' => [
                [
                    'product' => [
                        'name' => $productName,
                        'product_image' => $productImage,
                    ],
                    'qty' => $orderItem->qty,
                    'price' => $orderItem->unit_price,
                    'total_price' => $orderItem->total_price,
                ]
            ]
        ];

        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => 'Order detail loaded successfully',
        ], 200);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $orderItem = \Modules\Product\Models\OrderItem::with(['order.orderGroup', 'order.user', 'product_variation.product'])->find($id);
        
        if (!$orderItem) {
            return response()->json([
                'status' => false,
                'message' => 'Order item not found',
            ], 404);
        }

        if ($request->has('delivery_status')) {
            $orderItem->delivery_status = $request->delivery_status;
        }
        
        $orderItem->save();

        $order_prefix_data = \App\Models\Setting::where('name', 'inv_prefix')->first();
        $order_prefix = $order_prefix_data ? $order_prefix_data->val : '';
        $order_code = $order_prefix . optional(optional($orderItem->order)->orderGroup)->order_code;

        $productName = optional(optional($orderItem->product_variation)->product)->name ?? 'Unknown Product';
        $productImg = optional(optional($orderItem->product_variation)->product)->product_image ?? '';
        $user = optional($orderItem->order)->user;

        $data = [
            'id' => $orderItem->id,
            'order_code' => $order_code,
            'payment_status' => $orderItem->payment_status,
            'delivery_status' => $orderItem->delivery_status,
            'total_amount' => $orderItem->total_price,
            'user' => [
                'first_name' => $user ? $user->first_name : 'Unknown',
                'last_name' => $user ? $user->last_name : 'Customer',
                'mobile' => $user ? $user->mobile : '',
            ],
            'order_items' => [
                [
                    'product' => ['name' => $productName, 'product_image' => $productImg],
                    'qty' => $orderItem->qty,
                    'price' => $orderItem->unit_price,
                ]
            ]
        ];

        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => 'Order status updated successfully',
        ], 200);
    }
    
    public function financeDetails(Request $request)
    {
        $revenue_data = getRevenueData();
        
        $query = User::select('users.id', 'users.first_name', 'users.last_name', 'users.avatar')
            ->whereHas('commission_earning')
            ->with([
                'commission_earning' => function ($q) {
                    $q->whereHas('getbooking', function ($query) {
                        $query->where('status', 'completed');
                    });
                }
            ])
            ->with('tip_earning');

        $staff_earnings = [];
        foreach ($query->get() as $user) {
            $commissionAmount = $user->commission_earning->sum('commission_amount');
            $tipAmount = $user->tip_earning->sum('tip_amount');
            
            if ($commissionAmount > 0 || $tipAmount > 0) {
                $staff_earnings[] = [
                    'id' => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'profile_image' => $user->avatar,
                    'total_commission' => $commissionAmount,
                    'total_tip' => $tipAmount,
                    'total_earnings' => $commissionAmount + $tipAmount,
                ];
            }
        }

        $data = [
            'total_revenue' => $revenue_data['total_amount'] ?? 0,
            'total_commission' => $revenue_data['total_commission'] ?? 0,
            'admin_earnings' => $revenue_data['admin_earnings'] ?? 0,
            'staff_earnings' => $staff_earnings,
        ];

        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => 'Finance details loaded successfully',
        ], 200);
    }

    public function adminReports(Request $request)
    {
        $query = Booking::select(
            DB::raw('DATE(bookings.start_date_time) AS date'),
            DB::raw('COUNT(DISTINCT bookings.id) AS total_booking'),
            DB::raw('COALESCE(SUM( bookings.service_amount), 0) as total_service_amount'),
            DB::raw('COALESCE(SUM( bookings.total_amount), 0) as total_amount')
        )
        ->where('bookings.status', 'completed')
        ->groupBy(DB::raw('DATE(bookings.start_date_time)'))
        ->orderBy('date', 'desc')
        ->take(30)
        ->get();

        return response()->json([
            'status' => true,
            'data' => $query,
            'message' => 'Reports loaded successfully',
        ], 200);
    }
}
