<?php

namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Exceptions\IncompletePayment;

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
        $plans = $this->retrievePlans();
        $tenant = tenant();
        if($tenant->paymentMethods('boleto')){
            $method = collect($tenant->paymentMethods('boleto'))->first();//->billing_details->address;
        }
        return view('tenant.dashboard.subscriptions.checkout', [
            'intent'    => tenant()->createSetupIntent(), 
            'plans'     => $plans,
            'tenant'    => $tenant,
            'method'    => $method
        ]);
    }


    public function boleto($pi)
    {
        $boleto = Cashier::stripe()->paymentIntents->retrieve($pi,[]);
        return view('tenant.dashboard.subscriptions.boleto', compact('boleto'));
    }


    public function store(Request $request)
    {
        if($request->method_payment == "?payment=boleto"){
            try {
                $tenant = tenant();
                $paymentMethod = $tenant->paymentMethods('boleto')->first();
                $subscription = $tenant->newSubscription('default', $request->plan)
                                        ->create($paymentMethod->id);
            } catch (IncompletePayment $exception) {
                return redirect()->route('subscriptions.boleto', $exception->payment->id);
            }
        }
        elseif ($request->method_payment == "?payment=cartao") {
            tenant()->newSubscription('default', $request->plan)->create($request->token);
        } else {

        }
        return redirect()->route('subscriptions.index')->with('toast_success', 'Pagamento realizado com sucesso!');
    }


    public function cancel()
    {
        tenant()->subscription('default')->cancel();
        return redirect()->route('subscriptions.index')->with('toast_success', 'Assinatura cancelada com sucesso!');
    }


    public function resume()
    {
        tenant()->subscription('default')->resume();
        return redirect()->route('subscriptions.index')->with('toast_success', 'Assinatura reativada com sucesso!');
    }



    public function retrievePlans() {
        $plansraw = Cashier::stripe()->prices->all();
        $plans = $plansraw->data;
        
        foreach($plans as $plan) {
            $prod = Cashier::stripe()->products->retrieve(
                $plan->product,[]
            );
            $plan->product = $prod;
        }
        return $plans;
    }
}