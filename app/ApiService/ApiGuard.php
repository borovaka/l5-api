<?php namespace App\ApiService;

use App\ApiService\Validators\AlgorithmOne;
use App\ApiService\Validators\AlgorithmTwo;
use App\User;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class ApiGuard implements Guard, AuthValidation
{

    use GuardHelpers;
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The name of the query string item from the request containing the API token.
     *
     * @var string
     */
    protected $inputKey;


    /**
     * Create a new authentication guard.
     *
     * @param  \Illuminate\Contracts\Auth\UserProvider $provider
     * @param  \Illuminate\Http\Request $request
     */
    public function __construct(UserProvider $provider, Request $request)
    {
        $this->request = $request;
        $this->provider = $provider;
        $this->inputKey = 'api_token';
    }

    /**
     * Get the currently authenticated user.
     * @return Authenticatable|null
     * @throws ApiException
     */
    public function user()
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        $token = $this->getTokenForRequest();

        if (!empty($token)) {
           $user_id = $this->decoder($token);
           $user = User::find($user_id);
        }


        return $this->user = $user;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        if (empty($credentials[$this->inputKey])) {
            return false;
        }
        return !empty($this->decoder($credentials[$this->inputKey])) ? true : false;
    }

    /**
     * @param $token
     * @return int
     * @throws ApiException
     */
    protected function decoder($token)
    {
        $validator = null;
        switch ($this->request->getMethod()) {
            case 'PUT':
                $validator = new AlgorithmOne();
                break;
            case 'GET':
                $validator = new AlgorithmTwo();
                break;
            default:
                throw new ApiException(ApiException::INVALID_METHOD);
        }
        return $validator->decode($token);
    }

    /**
     * Get the token for the current request.
     *
     * @return string
     */
    public function getTokenForRequest()
    {
        $token = $this->request->query($this->inputKey);

        if (empty($token)) {
            $token = $this->request->bearerToken();
        }

        return $token;
    }
}