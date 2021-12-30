<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Network;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{

    private $user;
    private $network;
    /**
     * Class constructor.
     */
    public function __construct(User $user, Network $network)
    {
        $this->user = $user;
        $this->network = $network;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('all.profile.index', compact('user'));
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


    public function revoke()
    {
        tenancy()->central(function (){
            $network = $this->network->where('code', auth()->user()->google_id)->first();
            $network->delete();
        });
        auth()->user()->update(['google_id' => null]);
        return redirect()->back()->with('toast_success', 'Conta Google desvinculada com sucesso!');
    }

    public function link()
    {
        return redirect()->route('google.redirect', ['tenant' => tenant()->id, 'user' => auth()->user()->id])->with('toast_success', 'Conta Google vinculada com sucesso!');
    }
}