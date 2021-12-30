<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;


class GoogleController extends Controller
{
    private $network;
    private $tenant;
    private $user;

    public function __construct(Network $network, Tenant $tenant, User $user)
    {
        $this->network = $network;
        $this->tenant = $tenant;
        $this->user = $user;
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirect(Request $request)
    {
        $request->session()->flush();

        if($request->tenant && $request->user){
            session(['tenant' => $request->tenant, 'user' => $request->user]);
        }else{
            $reference = parse_url(url()->previous());
            session(['host' => $reference['host'], 'path' => $reference['path']]);
        }
        return Socialite::driver('google')->redirect();
    }
    

    public function callback()
    {
        try {
        
            $user = Socialite::driver('google')->user();
            $tenant = session('tenant');
            $network = $this->network->where('code', $user->id)->first();

            if(session('tenant') && session('user')){
                return $this->link($user, $tenant);
            }

            if($network){
                return redirect(tenant_route($network->tenant->domains->first()->domain, 'login.google', $user->id));
            }
            elseif(!$network && !session('path') === '/criar-conta'){
                //alert()->html('Ops!'," Não conseguimos identificar conta associada ao usuário fornecido, tendo dúvidas entre em contato com o suporte. ",'warning');
                return redirect()->route('contact'); 
            }
            elseif(session('path') === '/criar-conta'){
                return view('central.website.create', compact('user'));
            }else{
                //alert()->html('Ops!'," Não conseguimos identificar conta associada ao usuário fornecido, tendo dúvidas entre em contato com o suporte. ",'warning');
                return redirect()->route('contact'); 
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->route('website.index'); 
        }
    }

    public function link($user, $tenant){
        $tenant = $this->tenant->find($tenant);
        $tenant->networks()->create(['service'  => 'google', 'code'  => $user->id]);
        session(['token' => $user->id, 'email' => $user->email]);
        $tenant->run(function ($tenant) {
            $user = $this->user->find(session('user'));
            $user->update(['email' => session('email'), 'google_id' => session('token')]);
        });
        return redirect(tenant_route($tenant->domains->first()->domain, 'profile.index'))->with('toast_success', 'Conta Google desvinculada com sucesso!');
    }
}