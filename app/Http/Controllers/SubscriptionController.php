<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }


    public function index()
    {
        return view('dashboard.subscriptions.index', [
            'intent' => tenant()->createSetupIntent()
        ]);
    }


    public function store(Request $request)
    {
        tenant()
            ->newSubscription('default', 'price_1K4Cb5LRsHtC2l7Qw2BAvWgt')
            ->create($request->token);

        return redirect()->route('subscriptions.premium');
    }

    public function premium()
    {
        return view('dashboard.subscriptions.premium');
    }

    public function account()
    {
        $invoices = tenant()->invoices();
        return view('dashboard.subscriptions.account', compact('invoices'));
    }

    public function downloadInvoice($invoiceId)
    {
        return tenant()->downloadInvoice($invoiceId, [
            'vendor' => config('app.name'),
            'product' => 'Your Product',
            'street' => 'Rua Alfredo Ometecídio, 210',
            'location' => 'São Paulo - SP',
            'phone' => '(11) 9 8108-7234',
            'email' => 'jorgemiguelto@gmail.com',
            'url' => 'https://example.com',
            'vendorVat' => 'BE123456789',
        ]);
    }

    public function cancel()
    {
        tenant()->subscription('default')->cancel();
        return redirect()->route('subscriptions.account');
    }


    public function resume()
    {
        tenant()->subscription('default')->resume();
        return redirect()->route('subscriptions.account');
    }

}
