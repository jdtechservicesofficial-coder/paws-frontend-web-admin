<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gateway;
use App\Models\GatewayCurrency;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AutomaticGatewayController extends Controller
{
    public function index()
    {
        $pageTitle = 'Automatic Gateways';
        
        $paystackStatus = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'paystack_payment_method')->value('val') == '1';
        $gateways = [
            (object)[
                'name' => 'Paystack',
                'alias' => 'paystack',
                'status' => $paystackStatus,
                'code' => 'paystack'
            ]
        ];
        return view('admin.gateways.automatic.list', compact('pageTitle', 'gateways'));
    }

    public function edit($alias)
    {
        if ($alias !== 'paystack') {
            abort(404);
        }
        $pageTitle = 'Update Paystack Configuration';
        
        $publicKey = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'paystack_publickey')->value('val');
        $secretKey = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'paystack_secretkey')->value('val');
        
        return view('admin.gateways.automatic.edit', compact('pageTitle', 'publicKey', 'secretKey'));
    }

    public function update(Request $request, $code)
    {
        if ($code !== 'paystack') abort(404);

        $request->validate([
            'paystack_publickey' => 'required',
            'paystack_secretkey' => 'required',
        ]);

        \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(
            ['name' => 'paystack_publickey'],
            ['val' => $request->paystack_publickey, 'type' => 'paystack_payment_method']
        );
        \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(
            ['name' => 'paystack_secretkey'],
            ['val' => $request->paystack_secretkey, 'type' => 'paystack_payment_method']
        );

        $notify[] = ['success', 'Paystack configuration updated successfully'];
        return to_route('admin.gateway.automatic.edit', 'paystack')->withNotify($notify);
    }

    public function activate($code)
    {
        if ($code === 'paystack') {
            \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(
                ['name' => 'paystack_payment_method'],
                ['val' => '1', 'type' => 'paystackPayment']
            );
            $notify[] = ['success', 'Paystack enabled successfully'];
            return back()->withNotify($notify);
        }
        abort(404);
    }

    public function deactivate($code)
    {
        if ($code === 'paystack') {
            \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(
                ['name' => 'paystack_payment_method'],
                ['val' => '0', 'type' => 'paystackPayment']
            );
            $notify[] = ['success', 'Paystack disabled successfully'];
            return back()->withNotify($notify);
        }
        abort(404);
    }

}
