<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/14/18
 * Time: 12:02 PM
 */

namespace PhpRestfulApiResponse\Tests\unit;

use PhpRestfulApiResponse\Response;
use PhpRestfulApiResponse\Tests\unit\Lib\Book;
use ReflectionClass;
use InvalidArgumentException;
use Zend\Diactoros\Response\ArraySerializer;

class ResponseTest extends Base
{
    /**
     * @var Response
     */
    private $response;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->response = new Response();
    }

    public function test_withArray()
    {
        /** @var Response $response */
        $response = $this->response->withArray(['status' => 'success'], 200);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('{"status":"success"}', ArraySerializer::toArray($response)['body']);
        $this->assertEquals('{"status":"success"}', $response->getBody()->__toString());
    }

    public function test_withItem()
    {
        /** @var Response $response */
        $response = $this->response->withItem(
            new Book('harry', 'harryosmarsitohang', 'how to be a ninja', 100000, 2017),
            new \PhpRestfulApiResponse\Tests\unit\Lib\Transformer\Book,
            200
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('{"data":{"title":"how to be a ninja","author":{"name":"harry","email":"harryosmarsitohang"},"year":2017,"price":100000}}', $response->getBody()->__toString());
    }

    public function test_withCollection()
    {
        /** @var Response $response */
        $response = $this->response->withCollection(
            [
                new Book('harry', 'harryosmarsitohang', 'how to be a ninja', 100000, 2017),
                new Book('harry', 'harryosmarsitohang', 'how to be a mage', 500000, 2016),
                new Book('harry', 'harryosmarsitohang', 'how to be a samurai', 25000, 2000),
            ],
            new \PhpRestfulApiResponse\Tests\unit\Lib\Transformer\Book,
            200
        );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('{"data":[{"title":"how to be a ninja","author":{"name":"harry","email":"harryosmarsitohang"},"year":2017,"price":100000},{"title":"how to be a mage","author":{"name":"harry","email":"harryosmarsitohang"},"year":2016,"price":500000},{"title":"how to be a samurai","author":{"name":"harry","email":"harryosmarsitohang"},"year":2000,"price":25000}]}', $response->getBody()->__toString());
    }

    public function test_withError()
    {
        $code = 400;
        $message = 'error occured';
        $this->withError(
            $this->response->withError($message, $code),
            $code,
            $message
        );
    }

    public function test_withError_with_param_errorCode()
    {
        $code = 400;
        $message = 'error occured';
        $errorCode = 'ERROR-CODE';
        $this->withError(
            $this->response->withError($message, $code, $errorCode),
            $code,
            $message,
            $errorCode
        );
    }

    public function test_errorNotFound()
    {
        $code = 404;
        $message = '';
        $this->withError(
            $this->response->errorNotFound($message),
            $code,
            $message
        );
    }

    public function test_errorNotFound_with_message()
    {
        $code = 404;
        $message = 'go back to home page';
        $this->withError(
            $this->response->errorNotFound($message),
            $code,
            $message
        );
    }

    public function test_errorForbidden()
    {
        $code = 403;
        $message = '';
        $this->withError(
            $this->response->errorForbidden($message),
            $code,
            $message
        );
    }

    public function test_errorForbidden_with_message()
    {
        $code = 403;
        $message = 'forbid to access this';
        $this->withError(
            $this->response->errorForbidden($message),
            $code,
            $message
        );
    }

    public function test_errorInternalError()
    {
        $code = 500;
        $message = '';
        $this->withError(
            $this->response->errorInternalError($message),
            $code,
            $message
        );
    }

    public function test_errorInternalError_with_message()
    {
        $code = 500;
        $message = 'something wrong';
        $this->withError(
            $this->response->errorInternalError($message),
            $code,
            $message
        );
    }

    public function test_errorUnauthorized()
    {
        $code = 401;
        $message = '';
        $this->withError(
            $this->response->errorUnauthorized($message),
            $code,
            $message
        );
    }

    public function test_errorUnauthorized_with_message()
    {
        $code = 401;
        $message = 'access token required';
        $this->withError(
            $this->response->errorUnauthorized($message),
            $code,
            $message
        );
    }

    public function test_errorWrongArgs()
    {
        $code = 400;
        $message = [
            'username' => 'required',
            'password' => 'required'
        ];
        $this->withError(
            $this->response->errorWrongArgs($message),
            $code,
            $message
        );
    }

    public function test_errorGone()
    {
        $code = 410;
        $message = '';
        $this->withError(
            $this->response->errorGone($message),
            $code,
            $message
        );
    }

    public function test_errorGone_with_message()
    {
        $code = 410;
        $message = 'mysql gone away';
        $this->withError(
            $this->response->errorGone($message),
            $code,
            $message
        );
    }

    public function test_errorMethodNotAllowed()
    {
        $code = 405;
        $message = '';
        $this->withError(
            $this->response->errorMethodNotAllowed($message),
            $code,
            $message
        );
    }

    public function test_errorMethodNotAllowed_with_message()
    {
        $code = 405;
        $message = 'GET method is not allowed for this endpoint';
        $this->withError(
            $this->response->errorMethodNotAllowed($message),
            $code,
            $message
        );
    }

    public function test_errorUnwillingToProcess()
    {
        $code = 431;
        $message = '';
        $this->withError(
            $this->response->errorUnwillingToProcess($message),
            $code,
            $message
        );
    }

    public function test_errorUnwillingToProcess_with_message()
    {
        $code = 431;
        $message = 'Request size is too big';
        $this->withError(
            $this->response->errorUnwillingToProcess($message),
            $code,
            $message
        );
    }

    public function test_errorUnprocessable()
    {
        $code = 422;
        $message = '';
        $this->withError(
            $this->response->errorUnprocessable($message),
            $code,
            $message
        );
    }

    public function test_errorUnprocessable_with_message()
    {
        $code = 422;
        $message = 'Your request cannot be processed';
        $this->withError(
            $this->response->errorUnprocessable($message),
            $code,
            $message
        );
    }

    public function test_withStatus()
    {
        $this->response->withStatus(200);
        $this->assertEquals(200, $this->response->getStatusCode());
    }

    public function test_setStatusCode_less_than_min_status_code()
    {
        $this->run_setStatusCode($this->getMethodSetStatusCode(), 99);
    }

    public function test_setStatusCode_greater_than_max_status_code()
    {
        $this->run_setStatusCode($this->getMethodSetStatusCode(), 600);
    }

    public function test_setStatusCode()
    {
        $this->run_setStatusCode($this->getMethodSetStatusCode(), 200);
    }

    public function test_setErrorCode()
    {
        $this->run_setErrorCode($this->getMethodSetErrorCode(), "ERROR-CODE");
    }

    private function run_setStatusCode(\ReflectionMethod $method, $code)
    {
        try {
            $method->invokeArgs($this->response, [$code]);
            $this->assertEquals($code, $this->response->getStatusCode());
        } catch (InvalidArgumentException $exception) {
            $this->assertEquals(
                sprintf('Invalid status code "%s"; must be an integer between %d and %d, inclusive', $code, Response::MIN_STATUS_CODE_VALUE, Response::MAX_STATUS_CODE_VALUE),
                $exception->getMessage()
            );
        }
    }

    private function run_setErrorCode(\ReflectionMethod $method, $code)
    {
        $method->invokeArgs($this->response, [$code]);
        $this->assertEquals($code, $this->response->getErrorCode());
    }

    private function getMethodSetErrorCode()
    {
        $responseReflect = new ReflectionClass(Response::class);
        $method = $responseReflect->getMethod('setErrorCode');
        $method->setAccessible(true);
        return $method;
    }

    private function getMethodSetStatusCode()
    {
        $responseReflect = new ReflectionClass(Response::class);
        $method = $responseReflect->getMethod('setStatusCode');
        $method->setAccessible(true);
        return $method;
    }


    private function withError(Response $response, $code, $message = null, $errorCode = null)
    {
        $this->assertEquals($code, $response->getStatusCode());
        $this->assertEquals($errorCode, $response->getErrorCode());

        $this->assertEquals(json_encode([
            'error' => array_filter([
                'http_code' => $response->getStatusCode(),
                'code' => $response->getErrorCode(),
                'phrase' => $response->getReasonPhrase(),
                'message' => $message
            ])
        ]), $response->getBody()->__toString());

    }
}