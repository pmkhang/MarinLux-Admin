<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    public function paypal(Request $request, $id)
    {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('success', ['id' => $id]),
                    "cancel_url" => route('cancel', ['id' => $id]),
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $request->deposit
                        ]
                    ]
                ]
            ]);
            $linkPaypal = '';
            if (isset($response['id']) && $response['id'] != null) {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] == 'approve') {
                        $linkPaypal = $link['href'];
                    }
                }
            }
            return response()->json([
                'status' => true,
                'linkPaypal' => $linkPaypal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function success(Request $request, $id)
    {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            $response = $provider->capturePaymentOrder($request->token);
            $booking = Booking::findOrFail($id);
            if (optional($response)['status'] == "COMPLETED") {
                $booking->update([
                    'payment_status' => 2
                ]);
            }
            return view('admin.modules.paypal.success');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    public function cancel($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->update([
                'admin_approval_status' => 3,
                'payment_status' => 3
            ]);
            return view('admin.modules.paypal.cancel');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
