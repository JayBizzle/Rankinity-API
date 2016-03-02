<?php

namespace Rankinity\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Mock;
use Jaybizzle\Rankinity;

class RankinityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerParamNames
     */
    public function testCamelCaseMethodsReturnSnakeCaseParams($original, $expected)
    {
        $db = new Rankinity('foo_api_key', 'bar_account_name', new \stdClass());

        $result = $db->snakeCase($original);

        $this->assertEquals($expected, $result);
    }

    // public function testGetUsersResponse()
    // {
    //     $client = new Client();

    //     $mock = new Mock();
    //     $mock->addResponse(__DIR__.'/responses/getUsersResponse.txt');

    //     $client->getEmitter()->attach($mock);

    //     $db = new Rankinity('foo_api_key', $client);

    //     $result = $db->getUsers();

    //     $this->assertEquals(3, count($result->entries));
    // }

    public function testAddingQueryParams()
    {
        $args = [2];

        $db = new Rankinity('foo_api_key', new \stdClass());

        $db->addQuery('limit', $args);

        $this->assertTrue(array_key_exists('limit', $db->query));
        $this->assertEquals(2, $db->query['limit']);
    }

    public function providerParamNames()
    {
        return [
            ['fooBar', 'foo_bar'],
            ['FooBar', 'foo_bar'],
            ['FOOBAR', 'f_o_o_b_a_r'],
        ];
    }
}
