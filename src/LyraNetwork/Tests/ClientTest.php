<?php
namespace LyraNetwork\Tests;

use PHPUnit_Framework_TestCase;
use LyraNetwork\Client;
use LyraNetwork\Constants;

/**
 * ./vendor/bin/phpunit src/LyraNetwork/Tests/ClientTest.php
 */
class ClientTest extends PHPUnit_Framework_TestCase
{
    private function fakePostData()
    {
        $_POST['kr-hash'] = "33791304f1f5462b9bb14b039488166ed45b8187b217a986e11050985ffb036f";
        $_POST['kr-hash-algorithm'] = "sha256";
        $_POST['kr-answer-type'] = "V3.1\/BrowserRequest";
        $_POST['kr-answer'] = '{"shopId":"33148340","orderCycle":"CLOSED","orderStatus":"PAID","orderDetails":{"orderTotalAmount":250,"orderCurrency":"EUR","mode":"TEST","orderId":"4146ab892f9a4cc9819c9148fc714599","_type":"V3.1\/OrderDetails"},"transactions":[{"uuid":"fd18ea76127c442b8eaa8c849ce48ae0","status":"PAID","detailedStatus":"AUTHORISED","_type":"V3.1\/BrowserRequestTransaction"}],"serverDate":"2017-11-09T08:27:01+00:00","_type":"V3.1\/BrowserRequest"}';
    }

    /**
     * ./vendor/bin/phpunit --filter testClientValidCall src/LyraNetwork/Tests/ClientTest.php
     */
    public function testClientValidCall()
    {
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setPrivateKey("69876357:testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
        $client->setEndpoint("https://secure.payzen.eu");
        $response = $client->post('V3/Charge/SDKTest', $store);

        $this->assertEquals("SUCCESS", $response["status"]);
        $this->assertEquals($store["value"], $response["answer"]["value"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testClientUsernamePasswordValidCall src/LyraNetwork/Tests/ClientTest.php
     */
    public function testClientUsernamePasswordValidCall()
    {
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setUsername("69876357");
        $client->setPassword("testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
        $client->setEndpoint("https://secure.payzen.eu");
        $response = $client->post('V3/Charge/SDKTest', $store);

        $this->assertEquals("SUCCESS", $response["status"]);
        $this->assertEquals($store["value"], $response["answer"]["value"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testFileGetContentsPrivateKeyClientValidCall src/LyraNetwork/Tests/ClientTest.php
     */
    public function testFileGetContentsPrivateKeyClientValidCall()
    {
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setPrivateKey("69876357:testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
        $client->setEndpoint("https://secure.payzen.eu");
        $response = $client->postWithFileGetContents('V3/Charge/SDKTest', $store);

        $this->assertEquals("SUCCESS", $response["status"]);
        $this->assertEquals($store["value"], $response["answer"]["value"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testFileGetContentsClientValidCall src/LyraNetwork/Tests/ClientTest.php
     */
    public function testFileGetContentsClientValidCall()
    {
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setUsername("69876357");
        $client->setPassword("testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
        $client->setEndpoint("https://secure.payzen.eu");
        $response = $client->postWithFileGetContents('V3/Charge/SDKTest', $store);

        $this->assertEquals("SUCCESS", $response["status"]);
        $this->assertEquals($store["value"], $response["answer"]["value"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testDoubleSlash src/LyraNetwork/Tests/ClientTest.php
     */
    public function testDoubleSlash()
    {
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setPrivateKey("69876357:testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
        $client->setEndpoint("https://secure.payzen.eu//");
        $response = $client->post('V3/Charge/SDKTest', $store);

        $this->assertEquals("SUCCESS", $response["status"]);
        $this->assertEquals($store["value"], $response["answer"]["value"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testGetUrlFromTarget src/LyraNetwork/Tests/ClientTest.php
     */
    public function testGetUrlFromTarget()
    {
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setPrivateKey("69876357:testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");

        $client->setEndpoint("https://secure.payzen.eu");
        $this->assertEquals("https://secure.payzen.eu/api-payment/V3/Charge/Get", $client->getUrlFromTarget("V3/Charge/Get"));

        $client->setEndpoint("https://secure.payzen.eu/");
        $this->assertEquals("https://secure.payzen.eu/api-payment/V3/Charge/Get", $client->getUrlFromTarget("V3/Charge/Get"));
    }

    /**
     * ./vendor/bin/phpunit --filter testClientWrongKey src/LyraNetwork/Tests/ClientTest.php
     *
     * @expectedException LyraNetwork\Exceptions\LyraNetworkException
     */
    public function testClientWrongKey()
    {
        $client = new Client();
        $client->setPrivateKey("wrongkey");
    }

    /**
     * ./vendor/bin/phpunit --filter testNoPrivateKey src/LyraNetwork/Tests/ClientTest.php
     *
     * @expectedException LyraNetwork\Exceptions\LyraNetworkException
     */
    public function testNoPrivateKey()
    {
        $client = new Client();
        $client->post("A", array());
    }

    /**
     * ./vendor/bin/phpunit --filter testNoUsername src/LyraNetwork/Tests/ClientTest.php
     *
     * @expectedException LyraNetwork\Exceptions\LyraNetworkException
     */
    public function testNoUsername()
    {
        $client = new Client();
        $client->setPassword("testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
        $client->post("A", array());
    }

    /**
     * ./vendor/bin/phpunit --filter testNoPassword src/LyraNetwork/Tests/ClientTest.php
     *
     * @expectedException LyraNetwork\Exceptions\LyraNetworkException
     */
    public function testNoPassword()
    {
        $client = new Client();
        $client->setUsername("69876357");
        $client->post("A", array());
    }

    /**
     * ./vendor/bin/phpunit --filter testNoEndpoint src/LyraNetwork/Tests/ClientTest.php
     *
     * @expectedException LyraNetwork\Exceptions\LyraNetworkException
     */
    public function testNoEndpoint()
    {
        $client = new Client();
        $client->setPrivateKey("A:B");
        $client->post("A", array());
    }

    /**
     * ./vendor/bin/phpunit --filter testInvalidKey src/LyraNetwork/Tests/ClientTest.php
     */
    public function testInvalidKey()
    {
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setPrivateKey("69876357:testprivatekey_FAKE");
        $client->setEndpoint("https://secure.payzen.eu");
        $response = $client->post('V3/Charge/SDKTest', $store);

        $this->assertEquals("ERROR", $response["status"]);
        $this->assertEquals("INT_005", $response["answer"]["errorCode"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testFileGetContentsInvalidKey src/LyraNetwork/Tests/ClientTest.php
     */
    public function testFileGetContentsInvalidKey()
    {
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setPrivateKey("69876357:testprivatekey_FAKE");
        $client->setEndpoint("https://secure.payzen.eu");
        $response = $client->postWithFileGetContents('V3/Charge/SDKTest', $store);

        $this->assertEquals("ERROR", $response["status"]);
        $this->assertEquals("INT_005", $response["answer"]["errorCode"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testClientConfiguration src/LyraNetwork/Tests/ClientTest.php
     */
    public function testClientConfiguration()
    {
        $client = new Client("A:B");
        $client->setPrivateKey("A:B");
        $client->setPublickey("33148340:testpublickey_l83P7WpRK2hoUIcWyFVQsd4Omsz0XbCKYtNKeGbpX6CvS");
        $client->setEndpoint("https://secure.payzen.eu");

        $this->assertEquals(Constants::SDK_VERSION, $client->getVersion());
        $this->assertEquals("33148340:testpublickey_l83P7WpRK2hoUIcWyFVQsd4Omsz0XbCKYtNKeGbpX6CvS", $client->getPublicKey());
        $this->assertEquals("https://secure.payzen.eu", $client->getEndpoint());
        $this->assertEquals("https://secure.payzen.eu", $client->getClientEndpoint());

        $client->setClientEndpoint("https://client.payzen.eu");
        $this->assertEquals("https://secure.payzen.eu", $client->getEndpoint());
        $this->assertEquals("https://client.payzen.eu", $client->getClientEndpoint());
    }

    /**
     * ./vendor/bin/phpunit --filter testFakeProxy src/LyraNetwork/Tests/ClientTest.php
     *
     * @expectedException LyraNetwork\Exceptions\LyraNetworkException
     */
    public function testFakeProxy()
    {
        $client = new Client();
        $client->setPrivateKey("69876357:testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
        $client->setEndpoint("https://secure.payzen.eu");
        $client->setTimeOuts(1,1);
        $client->setProxy('fake.host', 1234);

        $store = array("value" => "sdk test string value");
        $response = $client->post('V3/Charge/SDKTest', $store);
    }

    /**
     * ./vendor/bin/phpunit --filter testInvalidAnswer src/LyraNetwork/Tests/ClientTest.php
     */
    public function testInvalidAnswer()
    {
        $client = new Client();
        $client->setPrivateKey("69876357:testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
        $client->setEndpoint("https://secure.payzen.eu");

        $store = "FAKE";
        $response = $client->post('V3/Charge/SDKTest', $store);

        $this->assertEquals("ERROR", $response["status"]);
        $this->assertEquals("INT_002", $response["answer"]["errorCode"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testGetParsedAnswer src/LyraNetwork/Tests/ClientTest.php
     */
    public function testGetParsedAnswer()
    {
        $client = new Client();
        $this->fakePostData();
        $answer = $client->getParsedAnswer();

        $this->assertEquals($_POST['kr-hash'], $answer['kr-hash']);
        $this->assertEquals($_POST['kr-hash-algorithm'], $answer['kr-hash-algorithm']);
        $this->assertEquals($_POST['kr-answer-type'], $answer['kr-answer-type']);
        $this->assertEquals($_POST['kr-answer'], json_encode($answer['kr-answer']));
    }

    /**
     * ./vendor/bin/phpunit --filter testCheckSignature src/LyraNetwork/Tests/ClientTest.php
     */
    public function testCheckSignature()
    {
        $client = new Client();
        $this->fakePostData();

        /* not yet implemented */
        $isValid = $client->checkSignature("ktM7bSeTJpclvpm4eEE9N0LIyoxUvsQ9AAYbQI1xQx7Qh");

        $this->assertTrue($isValid);
    }
}