<?php

namespace App\Http\Controllers\Central;
use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

class TenantController extends Controller
{
    private $tenant;
    /**
     * Class constructor.
     */
    public function __construct(Tenant $tenant, Cashier $cashier)
    {
        $this->tenant = $tenant;
        $this->cashier = $cashier;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('central.dashboard.index');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenants = $this->tenant->with('domains')->paginate(10);
        return view('central.dashboard.tenants.index', compact('tenants'));
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
        $request->merge(['initial_migration_complete' => false]);
        $tenant = $this->tenant->create($request->all());
        if($request->google_id)
            $tenant->networks()->create(['service'  => 'google', 'code'  => $request->google_id]);
        $tenant->domains()->create(['domain' => $request->domain.'.'.env('APP_DOMAIN')]);
        return redirect()->route('_post_tenant_registration', ['token' => $request->token])->domain($request->domain.'.'.env('APP_DOMAIN'));
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
        if(!$tenant = $this->tenant->find($id))
            return redirect()->route('dashboard');
        $this->cashier->stripe()->customers->delete($tenant->stripe_id, []);
        $tenant->delete();
        return redirect()->back()->with('toast_success', trans('system.tenant_deleted'));
    }


    /**
     * Impersonate tenant
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function impersonate($id)
    {
        if(!$tenant = $this->tenant->find($id))
            return redirect()->route('dashboard');
        $domain = $tenant->domains->first()->domain;
        $impersonate = tenancy()->impersonate($tenant, 1, 'dashboard');
        return redirect()->route('impersonate', ['token' => $impersonate->token])->domain($domain);
    }
}
