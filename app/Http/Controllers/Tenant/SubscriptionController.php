<?php

namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
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
        $tenant = tenant();
        $invoices = $tenant->invoices();
        $subscription = $tenant->subscription('default');
        return view('tenant.dashboard.subscriptions.index', compact('tenant', 'invoices', 'subscription'));
    }


    public function checkout()
    {
        return view('tenant.dashboard.subscriptions.checkout', [
            'intent' => tenant()->createSetupIntent()
        ]);
    }


    public function store(Request $request)
    {
        tenant()
            ->newSubscription('default', $request->plan)
            ->create($request->token);

        return redirect()->route('subscriptions.index');
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
        return redirect()->route('subscriptions.index');
    }


    public function resume()
    {
        tenant()->subscription('default')->resume();
        return redirect()->route('subscriptions.index');
    }

}