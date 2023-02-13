<?php

namespace App\Services;


use http\Message\Body;
use Illuminate\Support\Facades\Http;

class Courier
{
    const statuses = [
        'in_review' => 'In Review',
        'pending' => 'Pending',
        'hold' => 'Hold',
        'cancelled' => 'Cancelled',
        'delivered' => 'Delivered',
        'cancelled_approval_pending' => 'Cancel',
        'unknown_approval_pending' => 'Need Approval',
        'partial_delivered_approval_pending' => 'Partial Delivered',
        'delivered_approval_pending' => 'Delivered',
        'partial_delivered' => 'Partial Delivered',
        'unknown' => 'Unknown'
    ];

    public function request($credentials): \Illuminate\Http\Client\PendingRequest
    {
        return Http::baseUrl('https://portal.steadfast.com.bd/api/v1/')
            ->withHeaders($credentials)
            ->asJson();
    }


    public function createOrder($credentials, $data)
    {
        $array = [
            'invoice' => $data['order_no'],
            'recipient_name' => $data->customer['name'],
            'recipient_phone' => $data->customer['phone'],
            'recipient_address' => $data->customer['address'] ?: 'not found',
            'cod_amount' => $data['cod'],
            'note' => $data['note']
        ];
        return $this->request($credentials)->post('create_order', $array);
    }

    public function trackOrder($credentials, $url)
    {
        return $this->request($credentials)->get($url);
    }
}
