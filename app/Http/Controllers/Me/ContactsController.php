<?php

namespace App\Http\Controllers\Me;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class ContactsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('me.contacts.index', [
            'user' => User::find(\Auth::id())
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/customer/edit/contacts/')
                ->withErrors($validator)
                ->withInput();
        }

        $update = [
            'address' => $request->address
        ];

        User::where('id', $id)->update($update);

        return redirect('/customer/edit/contacts/')
            ->with('success', 'Information has been changed!');
    }

}
