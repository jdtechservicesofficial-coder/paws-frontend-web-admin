<style>
    body {
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        font-size: 13px;
        color: #333;
        line-height: 1.5;
    }
    .invoice-container {
        width: 100%;
        max-width: 800px;
        margin: auto;
        padding: 20px;
        background: #fff;
    }
    .invoice-header {
        border-bottom: 2px solid #0056b3;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .invoice-header h1 {
        margin: 0;
        color: #0056b3;
        font-size: 24px;
        text-transform: uppercase;
    }
    .invoice-header p {
        margin: 5px 0;
        color: #777;
    }
    .info-section {
        width: 100%;
        margin-bottom: 20px;
    }
    .info-section td {
        width: 50%;
        vertical-align: top;
    }
    .info-title {
        font-size: 14px;
        font-weight: bold;
        color: #0056b3;
        margin-bottom: 8px;
        text-transform: uppercase;
        border-bottom: 1px solid #eee;
        padding-bottom: 4px;
    }
    .order-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .order-table th {
        background-color: #0056b3;
        color: #fff;
        font-weight: bold;
        padding: 10px;
        text-align: left;
    }
    .order-table td {
        border-bottom: 1px solid #ddd;
        padding: 10px;
    }
    .order-table .text-right {
        text-align: right;
    }
    .order-table .text-center {
        text-align: center;
    }
    .summary-table {
        width: 40%;
        float: right;
        border-collapse: collapse;
    }
    .summary-table td {
        padding: 8px;
        border-bottom: 1px solid #eee;
    }
    .summary-table .total-row {
        font-weight: bold;
        color: #000;
        font-size: 14px;
        border-top: 2px solid #333;
    }
    .clearfix {
        clear: both;
    }
    .footer-note {
        margin-top: 40px;
        font-size: 12px;
        color: #777;
        text-align: center;
        border-top: 1px solid #ddd;
        padding-top: 10px;
    }
    .badge {
        background: #17a2b8;
        color: #fff;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 10px;
    }
</style>

<div class="invoice-container">
    <!-- Header -->
    <table class="info-section">
        <tr>
            <td>
                <div class="invoice-header">
                    <h1>Invoice</h1>
                    <p><strong>Invoice No:</strong> {{ setting('inv_prefix') }}{{ optional(optional($orderItem->order)->orderGroup)->order_code }}</p>
                    <p><strong>Order Date:</strong> {{ date('d M, Y', strtotime($orderItem->created_at)) }}</p>
                    @php
                        $expected_delivery_date = \Carbon\Carbon::parse($orderItem->expected_delivery_date)->format('d M, Y');
                    @endphp
                    <p><strong>Expected Delivery:</strong> {{ $expected_delivery_date }}</p>
                </div>
            </td>
            <td style="text-align: right;">
                <div style="padding-top: 10px;">
                    <img src="{{ setting('light_logo') ? asset('storage/' . setting('light_logo')) : asset('backend/images/logo-default.png') }}" alt="Logo" style="max-height: 60px;">
                </div>
            </td>
        </tr>
    </table>

    <!-- Addresses -->
    <table class="info-section">
        <tr>
            <td style="padding-right: 20px;">
                <div class="info-title">Bill To</div>
                <p><strong>{{ optional(optional($orderItem->order)->user)->full_name ?? 'N/A' }}</strong></p>
                <p>{{ optional(optional($orderItem->order)->user)->email ?? 'N/A' }}</p>
                <p>{{ optional(optional($orderItem->order)->user)->mobile ?? 'N/A' }}</p>
                @if(!$orderItem->order->orderGroup->is_pos_order)
                    @php $billingAddress = optional(optional($orderItem->order)->orderGroup)->billingAddress; @endphp
                    @if($billingAddress)
                        <p>
                            {{ optional($billingAddress)->address_line_1 }},<br>
                            {{ optional($billingAddress->city_data)->name }},
                            {{ optional($billingAddress->state_data)->name }},
                            {{ optional($billingAddress->country_data)->name }}
                        </p>
                    @endif
                @endif
            </td>
            <td>
                <div class="info-title">Ship To</div>
                @php $shippingAddress = optional(optional($orderItem->order)->orderGroup)->shippingAddress; @endphp
                @if($shippingAddress)
                    <p><strong>{{ optional($shippingAddress)->first_name }} {{ optional($shippingAddress)->last_name }}</strong></p>
                    <p>
                        {{ optional($shippingAddress)->address_line_1 }},<br>
                        @if(optional($shippingAddress)->address_line_2)
                            {{ optional($shippingAddress)->address_line_2 }},<br>
                        @endif
                        {{ optional($shippingAddress->city_data)->name }},
                        {{ optional($shippingAddress->state_data)->name }},
                        {{ optional($shippingAddress->country_data)->name }}
                    </p>
                @else
                    <p>Same as Billing Address</p>
                @endif
                
                <div style="margin-top: 15px;">
                    <p><strong>Payment Method:</strong> {{ ucwords(str_replace('_', ' ', optional(optional($orderItem->order)->orderGroup)->payment_method)) }}</p>
                    <p><strong>Logistic:</strong> {{ $orderItem->order->logistic_name ?? 'N/A' }}</p>
                </div>
            </td>
        </tr>
    </table>

    <!-- Items -->
    <table class="order-table">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="45%">Item Description</th>
                <th width="15%" class="text-right">Unit Price</th>
                <th width="10%" class="text-center">Qty</th>
                <th width="25%" class="text-right">Total Price</th>
            </tr>
        </thead>
        <tbody>
            @php
                $generateVariationOptions = function($options) {
                    $result = [];
                    if (is_string($options)) {
                        $options = json_decode($options, true);
                    }
                    if (is_array($options)) {
                        foreach ($options as $option) {
                            if (isset($option['variation']['name']) && isset($option['variation_value'])) {
                                $result[] = [
                                    'name' => $option['variation']['name'],
                                    'values' => array_map(function($val) {
                                        return ['name' => $val['name']];
                                    }, (array)$option['variation_value'])
                                ];
                            }
                        }
                    }
                    return $result;
                };
                $product = optional($orderItem->product_variation)->product;
                $totalprice = $orderItem->total_price;
                $totalTaxAmount = $orderItem->total_tax;
                $totalShippingCost = $orderItem->total_shipping_cost;
                $totalOrderPrice = $totalprice + $totalTaxAmount + $totalShippingCost;
            @endphp
            <tr>
                <td>1</td>
                <td>
                    <strong>{{ optional($product)->name ?? 'Product' }}</strong>
                    @if(!empty($orderItem->product_variation))
                        <div style="font-size: 11px; color: #666; margin-top: 4px;">
                            @foreach($generateVariationOptions($orderItem->product_variation->combinations) as $variation)
                                {{ $variation['name'] }}:
                                @foreach($variation['values'] as $value) {{ $value['name'] }} @endforeach
                                @if(!$loop->last) | @endif
                            @endforeach
                        </div>
                    @endif
                </td>
                <td class="text-right">{{ \Currency::format($orderItem->unit_price) }}</td>
                <td class="text-center">{{ $orderItem->qty }}</td>
                <td class="text-right">
                    @if ($orderItem->refundRequest && $orderItem->refundRequest->refund_status == 'refunded')
                        <span class="badge">Refunded</span>
                    @endif
                    {{ \Currency::format($orderItem->total_price) }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Summary -->
    <table class="summary-table">
        <tr>
            <td>Subtotal:</td>
            <td class="text-right">{{ \Currency::format($orderItem->total_price) }}</td>
        </tr>
        <tr>
            <td>Tax:</td>
            <td class="text-right">{{ \Currency::format($orderItem->total_tax) }}</td>
        </tr>
        <tr>
            <td>Shipping Cost:</td>
            <td class="text-right">{{ \Currency::format($orderItem->total_shipping_cost) }}</td>
        </tr>
        @if(optional(optional($orderItem->order)->orderGroup)->total_coupon_discount_amount > 0)
            <tr>
                <td>Discount:</td>
                <td class="text-right">-{{ \Currency::format(optional(optional($orderItem->order)->orderGroup)->total_coupon_discount_amount) }}</td>
            </tr>
        @endif
        <tr class="total-row">
            <td>Grand Total:</td>
            <td class="text-right">{{ \Currency::format($totalOrderPrice - optional(optional($orderItem->order)->orderGroup)->total_coupon_discount_amount) }}</td>
        </tr>
    </table>
    
    <div class="clearfix"></div>

    <!-- Other Items -->
    @if($otherItems->isNotEmpty())
        <div style="margin-top: 40px;">
            <div class="info-title" style="margin-bottom: 15px;">Other Items in Order</div>
            @foreach($otherItems as $key => $item)
                @php
                    $product = optional($item->product_variation)->product;
                    $totalprice = $item->total_price;
                    $totalTaxAmount = $item->total_tax;
                    $totalShippingCost = $item->total_shipping_cost;
                    $totalOrderPrice = $totalprice + $totalTaxAmount + $totalShippingCost;
                @endphp
                <table class="order-table" style="margin-bottom: 15px;">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="45%">Item Description</th>
                            <th width="15%" class="text-right">Unit Price</th>
                            <th width="10%" class="text-center">Qty</th>
                            <th width="25%" class="text-right">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <strong>{{ optional($product)->name ?? 'Product' }}</strong>
                                @if(!empty($item->product_variation))
                                    <div style="font-size: 11px; color: #666; margin-top: 4px;">
                                        @foreach($generateVariationOptions($item->product_variation->combinations) as $variation)
                                            {{ $variation['name'] }}:
                                            @foreach($variation['values'] as $value) {{ $value['name'] }} @endforeach
                                            @if(!$loop->last) | @endif
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td class="text-right">{{ \Currency::format($item->unit_price) }}</td>
                            <td class="text-center">{{ $item->qty }}</td>
                            <td class="text-right">
                                @if ($item->refundRequest && $item->refundRequest->refund_status == 'refunded')
                                    <span class="badge">Refunded</span>
                                @endif
                                {{ \Currency::format($item->total_price) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="summary-table">
                    <tr>
                        <td>Subtotal:</td>
                        <td class="text-right">{{ \Currency::format($item->total_price) }}</td>
                    </tr>
                    <tr>
                        <td>Tax:</td>
                        <td class="text-right">{{ \Currency::format($item->total_tax) }}</td>
                    </tr>
                    <tr>
                        <td>Shipping Cost:</td>
                        <td class="text-right">{{ \Currency::format($item->total_shipping_cost) }}</td>
                    </tr>
                    <tr class="total-row">
                        <td>Item Total:</td>
                        <td class="text-right">{{ \Currency::format($totalOrderPrice) }}</td>
                    </tr>
                </table>
                <div class="clearfix"></div>
            @endforeach
            
            <table class="summary-table" style="margin-top: 20px;">
                <tr class="total-row">
                    <td>Order Grand Total:</td>
                    <td class="text-right">{{ \Currency::format(optional(optional($orderItem->order)->orderGroup)->grand_total_amount) }}</td>
                </tr>
            </table>
            <div class="clearfix"></div>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer-note">
        {{ setting('spacial_note') ?? 'Thank you for your business!' }}
    </div>
</div>
