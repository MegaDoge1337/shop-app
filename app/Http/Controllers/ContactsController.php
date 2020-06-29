<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $data['user'] = User::where('id', $request->user()->id)->get()->first();

        return view('me.contacts.index', $data);
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
            'phone_number' => 'nullable|numeric',
            'address' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return redirect('/home/edit/contacts/')
                ->withErrors($validator)
                ->withInput();
        }

        $update = [
            'phone_number' => $request->phone_number,
            'address' => $request->address
        ];

        User::where('id', $id)->update($update);

        return redirect('/home/edit/contacts/')
            ->with('scs_message', 'Information has been changed.');
    }

}
