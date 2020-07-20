<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{

    protected CustomerRepositoryInterface $customerRepository;
    protected OrderRepositoryInterface $orderRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository, OrderRepositoryInterface $orderRepository)
    {
        $this->middleware('auth');

        $this->customerRepository = $customerRepository;
        $this->orderRepository = $orderRepository;
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
        $orders = $this->orderRepository->findByCustomerId(\Auth::id());

        return view('order.customer_list', [
            'orders' => $orders,
        ]);
    }

}
