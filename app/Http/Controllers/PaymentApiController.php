<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Spreedly\Json\SpreedlyCore as Spreedly;
use App\Events\ApiRequestSucceededEvent as RequestSuccess;
use App\Log\ApiLogEntry;

class PaymentApiController extends Controller
{
    public function __construct(Spreedly $spreedly)
    {
        $this->spreedly = $spreedly;
    }

    public function void(Request $request)
    {
        $transactionToken = $request->input('transaction_token');
        $username = $request->input('username');
        if ($transactionToken && $username) {
            $result = $this->spreedly->void($transactionToken);
            if ($result['code'] == 200) {
                \Event::fire(new RequestSuccess());
            }
            $log = new ApiLogEntry();
            $log->setAction('void')
                ->setTransactionToken($transactionToken)
                ->setResultCode($result['code'])
                ->setUsername($username);
            $log->save();
            return response($result['message'], $result['code']);
        }
        return response('Bad Request HTTP Status Code: 400', 400);
    }

    public function refundFull(Request $request)
    {
        $transactionToken = $request->input('transaction_token');
        $username = $request->input('username');
        if ($transactionToken && $username) {
            $result = $this->spreedly->refundFull($transactionToken);
            if ($result['code'] == 200) {
                \Event::fire(new RequestSuccess());
            }
            $log = new ApiLogEntry();
            $log->setAction('refund_full')
                ->setTransactionToken($transactionToken)
                ->setResultCode($result['code'])
                ->setUsername($username);
            $log->save();
            return response($result['message'], $result['code']);
        }
        return response('Bad Request HTTP Status Code: 400', 400);
    }

    public function refundPartial(Request $request)
    {
        $transactionToken = $request->input('transaction_token');
        $username = $request->input('username');
        $amount = (int) $request->input('amount');

        if ($transactionToken && is_int($amount) && $username) {
            $result = $this->spreedly->refundPartial($transactionToken, $amount);
            if ($result['code'] == 200) {
                \Event::fire(new RequestSuccess());
            }
            $log = new ApiLogEntry();
            $log->setAction('refund_partial')
                ->setTransactionToken($transactionToken)
                ->setResultCode($result['code'])
                ->setUsername($username)
                ->setComment('Amount:'.$amount);
            $log->save();
            return response($result['message'], $result['code']);
        }
        return response('Bad Request HTTP Status Code: 400', 400);
    }
}
