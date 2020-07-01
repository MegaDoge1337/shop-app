<?php

namespace App\Http\Controllers\Me;

use App\Product;
use App\Seller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

class SellerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $seller = User::find(\Auth::id())
            ->seller()
            ->first();

        return view('seller.list',[
            'products' => Seller::find($seller->id)
                ->product()
                ->orderBy('created_at', 'desc')
                ->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('seller.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
            'image_url' => 'required',
        ]);

        $data = [
            'seller_id' => Seller::firstWhere('user_id', \Auth::id())->id,
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
            'image_url' => $request->image_url,
        ];

        Product::create($data);

        return Redirect::to('seller')
            ->with('success','Product created successfully!');
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
        $data['product'] = Product::firstWhere('id', $id);

        $seller_id = Seller::firstWhere('user_id', \Auth::id())->id;

        if($data['product']->seller_id != $seller_id)
        {
            return \redirect('seller');
        }

        return view('seller.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
            'image_url' => 'required',
        ]);

        $update = [
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
            'image_url' => $request->image_url,
        ];

        Product::where('id', $id)->update($update);

        return Redirect::to('seller')
            ->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Seller::firstWhere('user_id', \Auth::id())
            ->product()
            ->where('id', $id)
            ->delete();

        return Redirect::to('seller')
            ->with('success','Product deleted successfully!');
    }
}
