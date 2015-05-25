<?php

namespace J;

/**
 * Class ServerIntegrationTest
 *
 * @package J
 */
class ServerIntegrationTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Server
     */
    private $server;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->server = Server::create();
        $controller = include 'Assets/ServerIntegrationTestController.php';
        $this->server->setControllerContainer($controller);
    }

    public function requestDataProvider()
    {
        return [
            ['{"jsonrpc": "2.0", "method": "subtract", "params": [42, 23], "id": 1}', '{"jsonrpc": "2.0", "result": 19, "id": 1}'],
            ['{"jsonrpc": "2.0", "method": "subtract", "params": [23, 42], "id": 1}', '{"jsonrpc": "2.0", "result": -19, "id": 1}'],
            ['{"jsonrpc": "2.0", "method": "subtract", "params": {"subtrahend": 23, "minuend": 42},"id": 3}', '{"jsonrpc": "2.0", "result": 19, "id": 3}'],
            ['{"jsonrpc": "2.0", "method": "update", "params": [1,2,3,4,5]}', ''],
            ['{"jsonrpc": "2.0", "method": "foobar", "id": "1"}', '{"jsonrpc": "2.0", "error": {"code": -32601, "message": "Method not found"}, "id": "1"}'],
            ['{"jsonrpc": "2.0", "method": "foobar, "params": "bar", "baz]', '{"jsonrpc": "2.0", "error": {"code": -32700, "message": "Parse error"}, "id": null}'],
            ['{"jsonrpc": "2.0", "method": 1, "params": "bar"}', '{"jsonrpc": "2.0", "error": {"code": -32600, "message": "Invalid Request"}, "id": null}'],
            ['[]', '{"jsonrpc": "2.0", "error": {"code": -32600, "message": "Invalid Request"}, "id": null}'],
            ['[1]', '[{"jsonrpc": "2.0", "error": {"code": -32600, "message": "Invalid Request"}, "id": null}]'],
            ['[1,2,3]', '[{"jsonrpc": "2.0", "error": {"code": -32600, "message": "Invalid Request"}, "id": null},{"jsonrpc": "2.0", "error": {"code": -32600, "message": "Invalid Request"}, "id": null},{"jsonrpc": "2.0", "error": {"code": -32600, "message": "Invalid Request"}, "id": null}]'],
            [
                    '[{"jsonrpc": "2.0", "method": "sum", "params": [1,2,4], "id": "1"},{"jsonrpc": "2.0", "method": "notify_hello", "params": [7]},{"jsonrpc": "2.0", "method": "subtract", "params": [42,23], "id": "2"},{"foo": "boo"},{"jsonrpc": "2.0", "method": "foo.get", "params": {"name": "myself"}, "id": "5"},{"jsonrpc": "2.0", "method": "get_data", "id": "9"}]',
                    '[{"jsonrpc": "2.0", "result": 7, "id": "1"},{"jsonrpc": "2.0", "result": 19, "id": "2"},{"jsonrpc": "2.0", "error": {"code": -32600, "message": "Invalid Request"}, "id":null},{"jsonrpc": "2.0", "error": {"code": -32601, "message": "Method not found"}, "id": "5"},{"jsonrpc": "2.0", "result": ["hello", 5], "id": "9"}]'
            ],
            ['[{"jsonrpc": "2.0", "method": "notify_sum", "params": [1,2,4]},{"jsonrpc": "2.0", "method": "notify_hello", "params": [7]}]', ''],
            ['"foo"', '{"id":null,"jsonrpc":"2.0","error":{"code":-32600,"message":"Invalid Request"}}'],
        ];
    }

    /**
     * @test
     * @test the server acts in compliance to @see http://www.jsonrpc.org/specification
     *
     * @dataProvider requestDataProvider
     * @param string $request
     * @param string $response
     */
    public function specificationCompliance($request, $response)
    {
        $result = $this->server->handle($request);
        $this->assertJsonStringEqualsJsonString($response, $result);
    }
}
