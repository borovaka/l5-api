<?php namespace App\ApiService;

final class ApiResponse {
    /**
     * @param mixed[] $data
     * @param int $response_code
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    static function send($data,$response_code = 200) {
        if(isset($data['response_code'])) {
            return response($data['data'],$data['response_code']);
        }
        return response($data,$response_code);
    }
}