<?php namespace App\ApiService;

use Exception;

class ApiException extends \Exception {

    const UNAUTHORIZED = 01;
    const INVALID_METHOD= 02;

    private $messages = [
        self::UNAUTHORIZED => [ 'response_code' => 401, 'message' => 'Bad credentials!' ],
        self::INVALID_METHOD => [ 'response_code' => 405, 'message' => 'Method not allowed!' ],

    ];
    private $response;

    public function __construct($code)
    {
        $error = array_key_exists($code,$this->messages) ? $this->messages[$code] : null;
        $this->response = ['data' => ['status' => 'error','message'=> 'Unknown error!', 'code' => '00'],'response_code' =>400];
        if($error) {
            $this->response = ['data' => ['status'=>'error', 'message' => $error['message'],'code'=>$code],'response_code' => $error['response_code']];
        }
    }

    public function render() {
        return ApiResponse::send($this->response);
    }

}
