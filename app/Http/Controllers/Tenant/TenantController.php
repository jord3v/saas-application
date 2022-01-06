<?php

namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

class TenantController extends Controller
{
    private $user;
    private $cashier;
    /**
     * Class constructor.
     */
    public function __construct(User $user, Cashier $cashier)
    {
        $this->user = $user;
        $this->cashier = $cashier;
        $this->middleware('permission:settings', ['only' => ['index', 'updateTenant', 'billingAddress']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('tenant.dashboard.index');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenant = tenant();
        if($tenant->paymentMethods('boleto')){
            $method = collect($tenant->paymentMethods('boleto'))->first();//->billing_details->address;
        }
        return view('tenant.dashboard.settings.index', compact('tenant', 'method'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function postTenantRegistration(string $token)
    {
        $tenant = tenant();

        if (! $tenant->initial_migration_complete ) {
            return view('errors.building'); // we're building your site-type view
        }

        if ($tenant->token === $token) {
            $user = $this->user->where('email', $tenant->email)->firstOrFail();
            auth()->login($user, true);
        }
        
        return redirect()->route('dashboard');
    }


    public function loginGoogle(string $code){
        $user = $this->user->where('google_id', $code)->firstOrFail();
        auth()->login($user, true);
        return redirect()->route('dashboard');
    }


    public function updateTenant(Request $request)
    {
        $tenant = tenant();
        $tenant->update($request->all());
        
        $customer = $tenant->updateStripeCustomer([
            'name'        => $request->name,
            'email'       => $request->email,
            'preferred_locales' => ['pt-BR'],
        ]);

        return redirect()->back()->with('toast_success', trans('system.tenant.updated'));
    }

    
    public function billingAddress(Request $request, $id = null)
    {
        $request['tax_id'] = preg_replace("/[^0-9]/", "", $request->tax_id);
        $tenant = tenant();
        if(!$id){
            $this->createMethodPaymentoBoleto($request->all());
        }else{
            $test = $tenant->findPaymentMethod($id);
            $test->delete();
            $this->createMethodPaymentoBoleto($request->all());
        }
        return redirect()->back()->with('toast_success', trans('system.billing_data_updated'));
    }


    public function createMethodPaymentoBoleto($request){
        $tenant = tenant();
        $paymentMethod = $this->cashier->stripe()->paymentMethods->create([
            'type' => 'boleto',
            'boleto' => [
                'tax_id' => $request['tax_id'],
            ],
            "billing_details"=> [
                "address"=> [
                    "city"           => $request['city'],
                    "country"=> 'BR',
                    "line1"          => $request['line1'],
                    "postal_code"    => $request['zipcode'],
                    "state"          => $request['state'],
                ],
                'name'        => $request['name'],
                'email'       => $request['email'],
            ],
        ]);

        $tenant->addPaymentMethod($paymentMethod); // adiciona método de pagamento ao tenant
        $tenant->updateDefaultPaymentMethod($paymentMethod); // deixe o endereço padrão
    }
}
