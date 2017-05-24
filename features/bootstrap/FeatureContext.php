<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinxExtension\Context\MinxContext;
use GuzzleHttp\Client;

require __DIR__ . '/../../vendor/autoload.php';

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    const HOST_NAME = 'http://localhost:8080';
    protected $client;
    protected $resource;
    protected $requestPayLoad;
    protected $response;
    protected $responseBody;
    protected $token;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => FeatureContext::HOST_NAME,
            'headers' => [
                'Content-type' => 'application/json',
            ]
        ]);
    }

    /**
     * @Given I set token :token
     */
    public function iSetToken($token)
    {
        $this->token = $token;
    }

    /**
     * @Given I some data
     */
    public function iSomeData(TableNode $table)
    {
        foreach ($table as $row) {
            $this->resource = $row;
        }
    }

    /**
     * @When I get url :url
     */
    public function iGetUrl($url)
    {
        $request = $this->client->get($url, [
            'headers' => [
                'Authorization' => $this->token,
            ]
        ])->getBody();

        $responseBody = json_decode($request->getContents());

        $this->response['status_code'] = $responseBody->status;
    }

    /**
     * @Then I get response code :status_code
     */
    public function iGetResponseCode($status_code)
    {   
        if (!($this->response->getStatusCode() == $status_code)) {
            echo "Invalid Response Code (" . $status_code . ")"; 
            exit();
        }
    }

    /**
     * @When I post request url :url
     */
    public function iPostRequestUrl($url)
    {
        $this->response = $this->client->post($url, ['json' => $this->resource]);

        $this->responseBody = json_decode($this->response->getBody()->getContents(), true);

        print_r($this->responseBody);
        die();
    }
}