<?php

namespace App\Http\Controllers\Gateway;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Deposit;
use App\Models\Package;
use App\Models\Product;
use App\Models\Shipping;
use App\Lib\FormProcessor;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\GatewayCurrency;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\SubscriptionController;

class PaymentController extends Controller
{

    public function paynow($id)
    {
        $package = Package::find($id);
        $oldSubscription = Subscription::orderBy('created_at', 'desc')->whereUserId(auth()->user()->id)->first();
        if($oldSubscription){
            if(Carbon::parse($oldSubscription->created_at)->diffIndays(Carbon::now()) < 31 && $oldSubscription->amount >= $package->price){
                $notify[] = ['error', 'You already have a active subscription. Please check your dashboard or you can upgrade the package'];
                return back()->withNotify($notify);
            }
        }
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $pageTitle = 'Payment Methods';
        return view($this->activeTemplate . 'user.payment.paynow', compact('gatewayCurrency', 'pageTitle', 'package'));
    }

     // product payment
     public function productPayment (Request $request)
     {
         $request->validate([
             'amount' => 'required|numeric|gt:0',
             'gateway' => 'required',
             'firstname' => 'required',
             'lastname' => 'required',
             'mobile' => 'required',
             'email' => 'required',
             'address' => 'required',
             'shipping' => 'required',
         ]);

         $user = auth()->user();
         $productSession = session('cart');

         if (!$productSession || count($productSession) == 0) {
             $notify[] = ['error', 'Your cart is empty'];
             return back()->withNotify($notify);
         }

         // Recalculate Subtotal
         $subTotal = 0;
         foreach ($productSession as $details) {
             $subTotal += @$details['price'] * @$details['quantity'];
         }
         if (session()->has('coupon')) {
             $subTotal = $subTotal - ($subTotal * (session()->get('coupon')['discount'] ?? 0)) / 100;
         }

         // Fetch Logistic Zone (Shipping)
         $shipping = \Illuminate\Support\Facades\DB::table('logistic_zones')->where('id', $request->shipping)->first();
         $shipingCharge = $shipping ? $shipping->standard_delivery_charge : 0;

         // Fetch Tax
         $taxRow = \Illuminate\Support\Facades\DB::table('taxes')->where('module_type', 'products')->where('status', 1)->whereNull('deleted_at')->first();
         $taxAmount = 0;
         if($taxRow) {
             $taxAmount = $taxRow->type == 'percentage' ? $subTotal * ($taxRow->value / 100) : $taxRow->value;
         }

         $totalAmount = $subTotal + $shipingCharge + $taxAmount;

         if($request->gateway == 'balance'){
             // check balance
             if(!$user || $user->balance < $totalAmount){
                 $notify[] = ['error', 'Insufficient Balance'];
                 return back()->withNotify($notify);
             }
         }

         $orderCode = rand(100000, 999999);
         $orderGroup = new \App\Models\OrderGroup();
         $orderGroup->order_code = $orderCode;
         $orderGroup->user_id = auth()->check() ? auth()->user()->id : null;
         $orderGroup->sub_total_amount = $subTotal;
         $orderGroup->total_shipping_cost = $shipingCharge;
         $orderGroup->total_tax_amount = $taxAmount;
         $orderGroup->grand_total_amount = $totalAmount;
         $orderGroup->phone_no = $request->mobile;
         $orderGroup->pos_order_address = $request->address;
         $orderGroup->payment_status = $request->gateway == 'balance' ? 'paid' : 'unpaid';
         $orderGroup->payment_method = $request->gateway == 'balance' ? 'wallet' : 'gateway';
         $orderGroup->save();

         $order = new Order();
         $order->order_group_id = $orderGroup->id;
         $order->user_id = auth()->check() ? auth()->user()->id : null;
         $order->delivery_status = 'pending';
         $order->payment_status = $request->gateway == 'balance' ? 'paid' : 'unpaid';
         $order->shipping_cost = $shipingCharge;
         $order->save();

         // insert order items
         $itemCount = count($productSession);
         foreach($productSession as $item){
             $order->products()->attach($item['id'],['product_quantity'=>$item['quantity']]);

             $variation = \Illuminate\Support\Facades\DB::table('product_variations')->where('product_id', $item['id'])->first();
             if (!$variation) {
                 $variationId = \Illuminate\Support\Facades\DB::table('product_variations')->insertGetId([
                     'product_id' => $item['id'],
                     'price' => $item['price'],
                     'created_at' => now(),
                     'updated_at' => now(),
                 ]);
             } else {
                 $variationId = $variation->id;
             }

             \Illuminate\Support\Facades\DB::table('order_items')->insert([
                 'order_id' => $order->id,
                 'product_variation_id' => $variationId,
                 'qty' => $item['quantity'],
                 'unit_price' => $item['price'],
                 'total_tax' => $taxAmount / $itemCount,
                 'total_shipping_cost' => $shipingCharge / $itemCount,
                 'total_price' => $item['price'] * $item['quantity'],
                 'delivery_status' => 'pending',
                 'payment_status' => $request->gateway == 'balance' ? 'paid' : 'unpaid',
                 'created_at' => now(),
                 'updated_at' => now(),
             ]);
         }

         // Insert Pawlly Notification
         \Illuminate\Support\Facades\DB::table('notifications')->insert([
             'id' => \Illuminate\Support\Str::uuid(),
             'type' => "App\\\\Notifications\\\\OrderNotification",
             'notifiable_type' => "App\\\\Models\\\\User",
             'notifiable_id' => 1,
             'data' => json_encode([
                 'message' => "New order #" . $order->id . " has been successfully placed",
                 'order_id' => $order->id,
             ]),
             'created_at' => now(),
             'updated_at' => now(),
         ]);

         if ($user) {
             // Admin Notification (ViserLab)
             $adminNotification = new AdminNotification();
             $adminNotification->user_id = $user->id;
             $adminNotification->title = 'Order request from '.$request->firstname.' '.$request->lastname;
             $adminNotification->click_url = urlPath('admin.deposit.successful');
             $adminNotification->save();

             // Notify Customer (ViserLab)
             notify($user, 'ORDER REQUEST', [
                 'order_number'=> $orderGroup->order_code,
                 'amount' => showAmount($totalAmount),
                 'trx' => 'N/A',
                 'post_balance' => showAmount($user->balance)
             ]);
         }

         if($request->gateway == 'balance'){
             if($user) {
                 $user->balance -= $totalAmount;
                 $user->save();

                 $transaction = new Transaction();
                 $transaction->user_id = $user->id;
                 $transaction->amount = $totalAmount;
                 $transaction->post_balance = $user->balance;
                 $transaction->charge = 0;
                 $transaction->trx_type = '-';
                 $transaction->details = 'Payment via Wallet for Order ' . $orderGroup->order_code;
                 $transaction->trx = getTrx();
                 $transaction->remark = 'order_payment';
                 $transaction->save();
             }

             session()->forget('cart');
             session()->forget('cupon');

             $notify[] = ['success', 'Order placed successfully'];
             return to_route('home')->withNotify($notify);
         }



         $gate = GatewayCurrency::whereHas('method', function ($gate) {
             $gate->where('status', 1);
         })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();
         if (!$gate) {
             $notify[] = ['error', 'Invalid gateway'];
             return back()->withNotify($notify);
         }

         if ($gate->min_amount > $totalAmount || $gate->max_amount < $totalAmount) {
             $notify[] = ['error', 'Please follow deposit limit'];
             return back()->withNotify($notify);
         }

         $charge = $gate->fixed_charge + ($totalAmount * $gate->percent_charge / 100);
         $payable = $totalAmount + $charge;
         $final_amo = $payable * $gate->rate;

         $data = new Deposit();
         $data->user_id = auth()->check() ? auth()->user()->id : 0 ;
         $data->method_code = $gate->method_code;
         $data->method_currency = strtoupper($gate->currency);
         $data->amount = $totalAmount;
         $data->order_id = $order->id;
         $data->charge = $charge;
         $data->rate = $gate->rate;
         $data->final_amo = $final_amo;
         $data->btc_amo = 0;
         $data->btc_wallet = "";
         $data->trx = getTrx();
         $data->try = 0;
         $data->status = 0;
         $data->detail = (object)[
             'email' => $request->email,
             'name' => $request->firstname . ' ' . $request->lastname,
             'mobile' => $request->mobile,
             'address' => $request->address
         ];
         $data->save();

         session()->put('Track', $data->trx);
         session()->put('customer_email', $request->email);

         if(auth()->user()){
             return to_route('user.deposit.confirm');
         }else{
             return to_route('deposit.confirm');
         }
     }

    public function deposit()
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $pageTitle = 'Payment Methods';
        return view($this->activeTemplate . 'user.payment.deposit', compact('gatewayCurrency', 'pageTitle'));
    }

    public function depositInsert(Request $request)
    {
        $user = auth()->user();
        $package = Package::find($request->package_id);

        /// user paying from his account balance :::: start
        if($request->gateway == 'balance'){

            if($user->balance < $request->amount){
                $notify[] = ['error', 'Insufficient Balance'];
                return back()->withNotify($notify);
            }

            $user->balance -= $package->price;
            $user->save();

            SubscriptionController::subscribe($user->id, $package->id, $package->price);

            $notify[] = ['success', 'Successfully purchased the package'];
            return to_route('home')->withNotify($notify);
        }
        /// user paying from his account balance :::: end


        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'method_code' => 'required',
            'currency' => 'required',
        ]);

        $user = auth()->user();
        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
            $notify[] = ['error', 'Please follow deposit limit'];
            return back()->withNotify($notify);
        }

        $charge = $gate->fixed_charge + ($request->amount * $gate->percent_charge / 100);
        $payable = $request->amount + $charge;
        $final_amo = $payable * $gate->rate;

        $data = new Deposit();
        $data->user_id = $user->id;
        $data->method_code = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount = $request->amount;
        $data->charge = $charge;
        $data->rate = $gate->rate;
        $data->final_amo = $final_amo;
        $data->btc_amo = 0;
        $data->btc_wallet = "";
        $data->trx = getTrx();
        $data->try = 0;
        $data->status = 0;
        $data->package_id =  $request->package_id ?  $request->package_id : 0;
        $data->save();

        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }

    public function appDepositConfirm($hash)
    {
        try {
            $id = decrypt($hash);
        } catch (\Exception $ex) {
            return "Sorry, invalid URL.";
        }
        $data = Deposit::where('id', $id)->where('status', 0)->orderBy('id', 'DESC')->firstOrFail();
        $user = User::findOrFail($data->user_id);
        auth()->login($user);
        session()->put('Track', $data->trx);
        if(auth()->user()){
            return to_route('user.deposit.confirm');
        }else{
            return to_route('deposit.confirm');
        }
    }


    public function depositConfirm()
    {
        $track = session()->get('Track');
        $deposit = Deposit::where('trx', $track)->where('status',0)->orderBy('id', 'DESC')->with('gateway')->firstOrFail();

        if ($deposit->method_code >= 1000) {
            if(auth()->user()){
                return to_route('user.deposit.manual.confirm');
            }else{
                return to_route('deposit.manual.confirm');
            }
        }


        $dirName = $deposit->gateway->alias;
        $new = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);


        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return to_route(gatewayRedirectUrl())->withNotify($notify);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if(@$data->session){
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $pageTitle = 'Payment Confirm';
        return view($this->activeTemplate . $data->view, compact('data', 'pageTitle', 'deposit'));
    }


    public static function userDataUpdate($deposit, $isManual = null)
    {
        if ($deposit->status == 0 || $deposit->status == 2) {
            $deposit->status = 1;
            $deposit->save();

            $user = User::find($deposit->user_id);


            if (!isset($deposit->order_id) && !isset($deposit->package_id)) {
                $user->balance += $deposit->amount;
                $user->save();
            }

            if(isset($deposit->order_id)){

                $order = Order::findOrFail($deposit->order_id);

                foreach ($order->products as $product) {
                    $ProductIid = $product->pivot->product_id;
                    $TotalQuantity = $product->pivot->product_quantity;

                    $product = Product::find($ProductIid);
                    $product->quantity -= $TotalQuantity;
                    $product->save();

                }

                $order->status = 1;
                $order->payment_status = 'paid';
                $order->save();

                if ($order->orderGroup) {
                    $order->orderGroup->payment_status = 'paid';
                    $order->orderGroup->save();
                }

                \Illuminate\Support\Facades\DB::table('order_items')->where('order_id', $order->id)->update(['payment_status' => 'paid']);


                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $deposit->user_id !== 0 ? $deposit->user_id : 0;
                $adminNotification->title = $deposit->user_id !== 0 ? 'Order placed by '.($user->firstname ?? '').' '.($user->lastname ?? '') : 'Order placed by guest user';
                $adminNotification->click_url = urlPath('admin.deposit.successful');
                $adminNotification->save();

                $customer = $deposit->user_id !== 0 ? $user : (object)[
                    'email' => @$deposit->detail->email ?? @$order->orderGroup->email ?? session('customer_email'),
                    'fullname' => @$deposit->detail->name ?? 'Valued Customer',
                    'username' => @$deposit->detail->name ?? 'Customer',
                    'firstname' => @$deposit->detail->name ?? 'Customer',
                    'lastname' => '',
                ];

                if (!empty($customer->email)) {
                    notify($customer, 'ORDER PLACE', [
                        'order_number' => optional($order->orderGroup)->order_code ?? 'N/A',
                        'amount' => showAmount($deposit->amount),
                        'trx' => $deposit->trx,
                        'post_balance' => $user ? showAmount($user->balance) : 0
                    ]);
                }

            }


            if(!empty($deposit->package_id)){
                $subscribe = SubscriptionController::subscribe($deposit->user_id, $deposit->package_id, $deposit->amount);

            }
 

            if (!isset($deposit->order_id) && !isset($deposit->package_id)) {
                $transaction = new Transaction();
                $transaction->user_id = $deposit->user_id ? $deposit->user_id : 0 ;
                $transaction->amount = $deposit->amount;
                $transaction->post_balance = $user ? $user->balance : 0;
                $transaction->charge = $deposit->charge;
                $transaction->trx_type = '+';
                $transaction->details = 'Deposit Via ' . $deposit->gatewayCurrency()->name;
                $transaction->trx = $deposit->trx;
                $transaction->remark = 'deposit';
                $transaction->save();

                if (!$isManual) {
                    $adminNotification = new AdminNotification();
                    $adminNotification->user_id = $user->id;
                    $adminNotification->title = 'Deposit successful via '.$deposit->gatewayCurrency()->name;
                    $adminNotification->click_url = urlPath('admin.deposit.successful');
                    $adminNotification->save();
                }

                if( $deposit->user_id != 0){
                    notify($user, $isManual ? 'DEPOSIT_APPROVE' : 'DEPOSIT_COMPLETE', [
                        'method_name' => $deposit->gatewayCurrency()->name,
                        'method_currency' => $deposit->method_currency,
                        'method_amount' => showAmount($deposit->final_amo),
                        'amount' => showAmount($deposit->amount),
                        'charge' => showAmount($deposit->charge),
                        'rate' => showAmount($deposit->rate),
                        'trx' => $deposit->trx,
                        'post_balance' => showAmount($user->balance)
                    ]);
                }
            }

        }
    }

    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }
        if ($data->method_code > 999) {

            $pageTitle = 'Deposit Confirm';
            $method = $data->gatewayCurrency();
            $gateway = $method->method;
            if(auth()->user()){
                return view($this->activeTemplate . 'user.payment.manual', compact('data', 'pageTitle', 'method','gateway'));

            }else{
                return view($this->activeTemplate . 'user.payment.manual_nonuser', compact('data', 'pageTitle', 'method','gateway'));

            }
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }
        $gatewayCurrency = $data->gatewayCurrency();
        $gateway = $gatewayCurrency->method;
        $formData = $gateway->form->form_data;

        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);


        $data->detail = $userData;
        $data->status = 2; // pending
        $data->save();


        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $data->user_id !== 0 ? $data->user->id : 0;
        $adminNotification->title = $data->user_id !== 0 ? 'Deposit request from '.$data->user->username : 'Deposit request from guest user';
        $adminNotification->click_url = urlPath('admin.deposit.details',$data->id);
        $adminNotification->save();

        if(!empty(auth()->user)){
            notify($data->user, 'DEPOSIT_REQUEST', [
                'method_name' => $data->gatewayCurrency()->name,
                'method_currency' => $data->method_currency,
                'method_amount' => showAmount($data->final_amo),
                'amount' => showAmount($data->amount),
                'charge' => showAmount($data->charge),
                'rate' => showAmount($data->rate),
                'trx' => $data->trx
            ]);
        }
        session()->forget('cart');
        session()->forget('cupon');

        // $notify[] = ['success', 'You have deposit request has been taken'];
        $notify[] = ['success', 'Your request has been taken'];
        return to_route('home')->withNotify($notify);
    }


}
