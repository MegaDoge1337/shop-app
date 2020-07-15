<?php

namespace App\Http\Controllers\Me;

use App\CustomerModel;
use App\Repositories\CustomerRepositoryInterface;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{

    protected CustomerRepositoryInterface $customerRepository;


    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->middleware('auth');

        $this->customerRepository = $customerRepository;
    }

    public function index()
    {
        $customer = $this->customerRepository->findById(\Auth::id());

        return view('me.contacts.index', [
            'customer' => $customer
        ]);
    }

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

        $customer = $this->customerRepository->findById(\Auth::id());

//        if($this->customerPolicy->allowUpdate($customer)) throw new \Exception();

        $customer->changeAddress($request->address);

        $this->customerRepository->save($customer);

        return redirect('/customer/edit/contacts/')
            ->with('success', 'Information has been changed!');
    }

    public function ordersForCustomer()
    {
        $orders = [];

        User::find(\Auth::id())
            ->order()
            ->get()
            ->each(function ($order) use (&$orders){

                $seller = CustomerModel::find($order->seller_id)->user()->first();

                $orders[$order->id]["seller"] = $seller->name;

                $orders[$order->id]["products"] = collect($order->products);

                $orders[$order->id]["address"] = $order->customer_address;

                $orders[$order->id]["date"] = $order->created_at;

                $orders[$order->id]["sum"] = $order->total_sum;

                $orders[$order->id]["status"] = $order->status;
            });

        return view('order.customer_list', [
            'orders' => $orders,
        ]);
    }

}
