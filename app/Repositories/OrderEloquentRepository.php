<?php

namespace App\Repositories;

use App\Entities\OrderEntity;
use App\OrderModel;

class OrderEloquentRepository implements OrderRepositoryInterface
{
    public function findById(int $id)
    {
        $order = OrderModel::findOrFail($id);

        return new OrderEntity(
            $order->id,
            $order->findSeller(),
            $order->findCustomer(),
            $order->customer_address,
            collect($order->products),
            $order->total_sum,
            $order->status,
            $order->created_at
        );
    }

    public function findBySellerId(int $sellerId)
    {
        $orderModels = OrderModel::where('seller_id', $sellerId)->get();

        $orders = [];

        foreach ($orderModels as $orderModel)
        {
            $orders[] = new OrderEntity(
                $orderModel->id,
                $orderModel->findSeller(),
                $orderModel->findCustomer(),
                $orderModel->customer_address,
                collect($orderModel->products),
                $orderModel->total_sum,
                $orderModel->status,
                $orderModel->created_at
            );
        }

        return $orders;
    }

    public function findByCustomerId(int $customerId)
    {
        $orderModels = OrderModel::where('customer_id', $customerId)->get();

        $orders = [];

        foreach ($orderModels as $orderModel)
        {
            $orders[] = new OrderEntity(
                $orderModel->id,
                $orderModel->findSeller(),
                $orderModel->findCustomer(),
                $orderModel->customer_address,
                collect($orderModel->products),
                $orderModel->total_sum,
                $orderModel->status,
                $orderModel->created_at
            );
        }

        return $orders;
    }

    public function add(OrderEntity $orderEntity)
    {
        if(!OrderModel::find($orderEntity->id))
        {
            return OrderModel::create($orderEntity->toArray());
        }

        return null;
    }

    public function save(OrderEntity $orderEntity)
    {
        $order = OrderModel::findOrNew($orderEntity->id)->fill($orderEntity->toArray());

        $order->save();
    }
}
