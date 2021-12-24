<?php

namespace App\Http\Controllers;

use App\Models\Network;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;


class GoogleController extends Controller
{
    private $network;

    public function __construct(Network $network)
    {
        $this->network = $network;
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirect()
    {
        $reference = parse_url(url()->previous());
        session(['host' => $reference['host'], 'path' => $reference['path']]);
        return Socialite::driver('google')->redirect();
    }
    

    public function callback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $network = $this->network->where('code', $user->id)->first();
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
}