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
    static $paramsResolver = null;

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
            $params = is_null(self::$paramsResolver) ? ($paramResolver ?: self::defaultParamResolver()) : self::$paramsResolver;
            $params = call_user_func($params, new Fn);
            $response = call_user_func_array($callback, $params);
        } catch (RetriableException $e) {
            $response = [
                'type'    => 'error',
                'code'    => $e->getCode(),
                'message' => $e->getMessage(),
                'trace'   => $e->getTrace(),
            ];
        } catch (NonretriableException $e) {
            $response = [
                'type'    => 'error',
                'code'    => $e->getCode(),
                'message' => $e->getMessage(),
                'trace'   => $e->getTrace(),
            ];
        } catch (UnauthorizedHttpException $e) {
            $response = [
                'type'       => 'http.error',
                'code'       => $e->getCode(),
                'statusCode' => $e->getStatusCode(),
                'message'    => $e->getMessage(),
                # 'trace'      => $e->getTrace(),
            ];
        }

        return is_null(self::$paramsResolver)
            ? fwrite(STDOUT, is_scalar($response) ? $response : json_encode($response))
            : $response;
    }

    private static function defaultParamResolver()
    {
        return function (Fn $fn) {
            return [$fn, json_decode(file_get_contents("php://stdin"))];
        };
    }
}
