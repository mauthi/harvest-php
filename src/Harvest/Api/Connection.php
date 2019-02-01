<?php
namespace Harvest\Api;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleRetry\GuzzleRetryMiddleware;
use Exception, InvalidArgumentException;
use Harvest\Exceptions\HarvestException;
use GuzzleHttp\Exception\ClientException;

/**
 * Class Connection
 *
 * @namespace    Harvest\Api
 * @author     Joridos <joridoss@gmail.com>
 */
class Connection
{
    /**
     * Harvest options.
     *
     * @var array
     */
    protected $_options = [
        'account_id' => '',
        'token' => '',
        'debug' => false,
    ];

    /**
     * The HTTP client to use for the requests.
     *
     * @var GuzzleClient
     */
    private $httpClient;

    /**
     * @param array $options
     */
    function __construct($options = [])
    {
        $this->setOptions($options);
    }

    /**
     * Set the http client.
     *
     * @param GuzzleClient $client
     */
    public function setHttpClient(GuzzleClient $client)
    {
        $this->httpClient = $client;
    }

    /**
     * Get a fresh instance of the http client.
     *
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient()
    {
        if (is_null($this->httpClient))
        {
            $stack = HandlerStack::create();
            $stack->push(GuzzleRetryMiddleware::factory());
            $this->httpClient = new GuzzleClient([
                'handler' => $stack,
                'base_uri' => "https://api.harvestapp.com/v2/",
                'on_retry_callback' => function($attemptNumber, $delay, $request, $options, $response) {
    
                    if ($this->getOption("debug")) {
                        echo sprintf(
                            "Retrying request to %s.  Server responded with %s.  Will wait %s seconds.  This is attempt #%s\n",
                            $request->getUri()->getPath(),
                            $response->getStatusCode(),
                            number_format($delay, 2),
                            $attemptNumber
                        );
                    }
                },
            ]);
        }

        return clone $this->httpClient;
    }

    /**
     * Builds and performs a request.
     *
     * @param  string $method
     * @param  string $url
     * @param  array  $options
     * @return array
     *
     * TODO: Should allow the user to recieve XML data also if they wish to.
     */
    public function request($method, $url, array $options = [])
    {
        $client = $this->getHttpClient();
        // Set headers to accept only json data.
        $options['headers']['User-Agent'] = 'netWERKER Management Cockpit';
        $options['headers']['Content-Type'] = 'application/json';
        $options['headers']['Accept'] = 'application/json';
        $options['headers']['Harvest-Account-Id'] = $this->_options['account_id'];
        $options['headers']['Authorization'] = 'Bearer '.$this->_options['token'];
        $response = $client->request($method, $url, $options);

        switch ($response->getStatusCode()) {
            case 200:
            case 201:
                // everything ok
                switch ($method) {
                    case "POST":
                    case "PUT":
                        return $response;
                    default:
                        return (string)$response->getBody();
                }
                break;

            default:
                // all other cases
                throw new HarvestException("Status Code of Response = ".$response->getStatusCode()."\nUrl: ".$url);
        }

        
    }

    /**
     * Set the options.
     *
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->_options = array_merge($this->_options, $options);
    }

    /**
     * Get a single option value.
     *
     * @param  ar $option
     * @throws Exception
     * @return string
     */
    public function getOption($option)
    {
        if ( !array_key_exists($option, $this->_options)) {
            throw new Exception("The requested option [$option] has not been set or is not a valid option key.");
        }

        return $this->_options[$option];
    }
}