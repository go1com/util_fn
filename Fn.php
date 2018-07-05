<?php

namespace go1\util_fn;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * @property-read string       $appName
 * @property-read string       $callType     sync/async
 * @property-read string       $callMethod
 * @property-read string       $callUrl
 * @property-read string       $callId
 * @property-read null|Request $request
 */
class Fn
{
    private function __construct()
    {
        $this->appName = getenv('FN_APP_NAME');
        $this->callType = getenv('FN_TYPE');
        $this->callMethod = getenv('FN_METHOD');
        $this->callUrl = getenv('FN_REQUEST_URL');
        $this->callId = getenv('FN_CALL_ID');

        if ($this->callMethod && $this->callUrl) {
            $this->request = Request::create($this->callUrl, $this->callMethod);
            $this->request->headers->set('Authorization', getenv('FN_HEADER_AUTHORIZATION'));
        }
    }

    public static function run(callable $callback, callable $paramResolver = null)
    {
        try {
            stream_set_blocking(STDIN, 0);
            $params = call_user_func($paramResolver ?: self::defaultParamResolver(), $me = new Fn);
            $response = call_user_func_array($callback, $params);
        }
        catch (UnauthorizedHttpException $e) {
            $response = [
                'error' => [
                    'status'  => $e->getStatusCode(),
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage(),
                ],
            ];
        }

        fwrite(STDOUT, is_scalar($response) ? $response : json_encode($response));
    }

    private static function defaultParamResolver()
    {
        return function (Fn $fn) {
            return [$fn, json_decode(file_get_contents("php://stdin"))];
        };
    }
}
