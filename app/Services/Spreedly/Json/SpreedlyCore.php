<?php

namespace App\Services\Spreedly\Json;

use App\Services\Curl\CurlService;
use Swagger\Annotations;

/**
 * @Swagger\Annotations\Info(title="Payment API", version="1.0")
 */

class SpreedlyCore
{

    private $apiUrl;
    private $environmentKey;
    private $accessSecret;

    public function __construct()
    {
        $this->apiUrl = config('services.spreedly.api_url');
        $this->environmentKey = config('services.spreedly.environment_key');
        $this->accessSecret = config('services.spreedly.access_secret');
    }

    /**
     *
     * @Swagger\Annotations\Post(
     *   path="/void",
     *   description="Call Spreedly API to void a transaction",
     *   consumes={"application/json"},
     *   @Swagger\Annotations\Parameter(
     *   	name="transaction_token",
     *   	description="Spreedly Transaction Token",
     *   	type="string",
     *   	required=true
     *   ),
     *   @Swagger\Annotations\Response(
     *         response=200,
     *         description="Succeeded",
     *   ),
     *   @Swagger\Annotations\Response(
     *         response=400,
     *         description="Bad Request - Missing Parameter",
     *   ),
     *   @Swagger\Annotations\Response(
     *         response=404,
     *         description="Request to Spreedly API Failed",
     *   ),
     * )
     */
    public function void($transactionToken)
    {
        $method = '/transactions/'.$transactionToken.'/void.json';

        $url = $this->apiUrl.$method;
        $mimeType = 'Content-Type: application/json';

        $ch = new CurlService();
        $ch->setUrl($url)
           ->setHttpHeader(array($mimeType))
           ->setUserPassword($this->environmentKey, $this->accessSecret)
           ->setReturnTransfer()
           ->setPostFields('')
           ->setPost(1);

        $jsonResponse = $ch->execute();
        $response = json_decode($jsonResponse);

        if(isset($response->transaction->succeeded)){
            return array('message' => 'Succeeded', 'code' => 200);
        }

        return array('message' => 'Request to Spreedly API Failed', 'code' => 400);
    }

    /**
     *
     * @Swagger\Annotations\Post(
     *   path="/refund/full",
     *   description="Call Spreedly API to full refund a transaction",
     *   consumes={"application/json"},
     *   @Swagger\Annotations\Parameter(
     *   	name="transaction_token",
     *   	description="Spreedly Transaction Token",
     *   	type="string",
     *   	required=true
     *   ),
     *   @Swagger\Annotations\Response(
     *         response=200,
     *         description="Succeeded",
     *   ),
     *   @Swagger\Annotations\Response(
     *         response=400,
     *         description="Bad Request - Missing Parameter",
     *   ),
     *   @Swagger\Annotations\Response(
     *         response=404,
     *         description="Request to Spreedly API Failed",
     *   ),
     * )
     */
    public function refundFull($transactionToken)
    {
        $method = '/transactions/'.$transactionToken.'/credit.json';

        $url = $this->apiUrl.$method;
        $mimeType = 'Content-Type: application/json';

        $ch = new CurlService();
        $ch->setUrl($url)
           ->setHttpHeader(array($mimeType))
           ->setUserPassword($this->environmentKey, $this->accessSecret)
           ->setReturnTransfer()
           ->setPostFields('')
           ->setPost(1);

        $jsonResponse = $ch->execute();
        $response = json_decode($jsonResponse);

        if(isset($response->transaction->succeeded)){
            return array('message' => 'Succeeded', 'code' => 200);
        }

        return array('message' => 'Request to Spreedly API Failed', 'code' => 400);
    }

    /**
     *
     * @Swagger\Annotations\Post(
     *   path="/refund/partial",
     *   description="Call Spreedly API to partial refund a transaction",
     *   consumes={"application/json"},
     *   @Swagger\Annotations\Parameter(
     *   	name="transaction_token",
     *   	description="Spreedly Transaction Token",
     *   	type="string",
     *   	required=true
     *   ),
     *   @Swagger\Annotations\Parameter(
     *   	name="transaction_token",
     *   	description="Amount as Integer, 1000 for $10.00",
     *   	type="integer",
     *   	required=true
     *   ),
     *   @Swagger\Annotations\Response(
     *         response=200,
     *         description="Succeeded",
     *   ),
     *   @Swagger\Annotations\Response(
     *         response=400,
     *         description="Bad Request - Missing Parameter",
     *   ),
     *   @Swagger\Annotations\Response(
     *         response=404,
     *         description="Request to Spreedly API Failed",
     *   ),
     * )
     */
    public function refundPartial($transactionToken, $amount)
    {
        $method = '/transactions/'.$transactionToken.'/credit.json';

        $url = $this->apiUrl.$method;
        $mimeType = 'Content-Type: application/json';

        $body = array('transaction' => array('amount' => $amount, 'currency_code' => 'USD'));
        $fields = json_encode($body);

        $ch = new CurlService();
        $ch->setUrl($url)
           ->setHttpHeader(array($mimeType))
           ->setUserPassword($this->environmentKey, $this->accessSecret)
           ->setReturnTransfer()
           ->setPostFields($fields)
           ->setPost(1);

        $jsonResponse = $ch->execute();
        $response = json_decode($jsonResponse);
        if(isset($response->transaction->succeeded)){
            return array('message' => 'Succeeded', 'code' => 200);
        }

        return array('message' => 'Request to Spreedly API Failed', 'code' => 400);
    }
}
