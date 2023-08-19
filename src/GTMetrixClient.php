<?php

namespace LightningStudio\GTMetrixClient;

/**
 * The basic GTMetrix client class.
 *
 * Usage:
 *
 *     $client = new GTMetrixClient();
 *     $client->setAPIKey('your-gtmetrix-api-key');
 *     
 *     try {
 *         $test = $client->startTest($url);
 *         echo $test;
 *     } catch (Exception $e) {
 *         echo 'Error: ' . $e->getMessage();
 *     }
 * 
*/


class GTMetrixClient
{
    /**
     * API endpoint. Normally you don't need to change this.
     *
     * @var string
     */
    protected $endpoint = 'https://gtmetrix.com/api/2.0';

    /**
     * GTMetrix API key.
     *
     * @var string
     *
     * @see http://gtmetrix.com/api/
     */
    protected $apiKey = '';


    /**
     * @return string
     */
    public function getAPIKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setAPIKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }


    /**
     * @param string $url
     * @param array $data
     *
     * @return array
     *
     * @throws GTMetrixConfigurationException
     * @throws GTMetrixException
     */
    protected function apiCall($url, $data = array(), $method = null)
    {
        if (!$this->apiKey) {
            throw new GTMetrixConfigurationException('API key must be set up before using API calls!' .
                'See setAPIKey() for details.');
        }

        $ch = curl_init($this->endpoint . $url);

        if ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        if ( !empty($data) ) {
            curl_setopt($ch, CURLOPT_POST, count($data));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

			$headers = [
				'Content-Type: application/vnd.api+json', // The specific content type required
			];
			
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);			
        }

        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErrNo = curl_errno($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if (!\preg_match('/^(2|3)/', $statusCode)) {
            if ($statusCode == 0) {
                throw new GTMetrixException('cURL error ' . $curlErrNo . ': ' . $curlError);
            }
            throw new GTMetrixException('API error ' . $statusCode . ': ' . $result);
        }

        $data = json_decode($result, true)['data'] ?? [];
        
        if (json_last_error()) {
            throw new GTMetrixException('Invalid JSON received: ' . json_last_error_msg());
        }
        
        return $data;
    }
    
    /**
     * @param string $url
     *
     * @return array || string
     */
    public function fetchUrlData($url) {

        if (!$this->apiKey) {
            throw new GTMetrixConfigurationException('API key must be set up before using API calls!' .
                'See setAPIKey() for details.');
        }

        // Initialize cURL session
        $ch = curl_init($url);
    
        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Execute cURL session
        $response = curl_exec($ch);
    
        // Get the content type from the response
        $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    
        // Separate the header and the body
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
    
        // Close cURL session
        curl_close($ch);
    
        // Check if the content type is JSON
        if ( stripos($content_type, 'application/json') !== false ) {
            return json_decode($body, true);
        }
    
        return $body;
    }




    /**
     * Start a GTMetrix test
     *
     * @param string $url
     * @param array		$xParams
     *
     * @return GTMetrixTest
     * @throws GTMetrixConfigurationException
     * @throws GTMetrixException
     */

     
    public function startTest($url, array $xParams = [], $wait_for_completion = true)
    {

        $test = new GTMetrixTest();

        $params = $test->buildParams($url, $xParams);
        
        $result = $this->apiCall('/tests', ['data'=>$params]);

        $test->setData($result);
        
        if ($wait_for_completion) { 
            error_log("Waiting for test to complete");
            sleep(2);
            $test = $this->waitForTest( $test );
        }

        return $test;
    }

	public function getTests() {
		return $this->apiCall('/tests');
	}

    public function getTest($id) {
        
        $data = [];
        
        if ($id) {
            $data = $this->apiCall('/tests/' . $id);
        }

        return new GTMetrixTest($data);

    }

    public function deleteTest($id) {
        return $this->apiCall( '/tests/' . $id, [], "DELETE" );
    }

    //INCLUDES LOOP FOR WAITING UNTIL COMPLETE
    public function waitForTest($test) {

        $maxRetries = 15; // You can set an appropriate value for max retries
        $retryCount = 0;
    
        // Wait for result
        while ($test->getState() !== GTMetrixTest::STATE_COMPLETED && $retryCount < $maxRetries) {
            $test = $this->getTest($test->getId()); // Assuming this function fetches the test data
            
            if ( empty($test->getData()) ) {                
                error_log("Test data is empty?");
                break;
            }

            if ($test->getState() === GTMetrixTest::STATE_COMPLETED) {
                error_log("Test is ready");
                continue;
            }

            error_log("Still waiting");
            sleep(5);
            $retryCount++;
        }
    
        if ($retryCount >= $maxRetries) {
            error_log("Max retries reached");
            return $test;
        }
    
        return $test;
    }
    

    /**
     * GTMetrix reports
    */

    public function getReport($id) {
        
        $data = [];

        if ($id) {
            $data = $this->apiCall('/reports/' . $id);
        }

        return new GTMetrixReport($data);
    }

    public function deleteReport($id) {
        return $this->apiCall( '/reports/' . $id, [], "DELETE" );
    }


    public function getSimulatedDevices() {
		return $this->apiCall('/simulated-devices');
	}

    
    public function getSimulatedDevice($id) {
        $data = [];

        if ($id) {
            $data = $this->apiCall('/simulated-devices/' . $id);
        }

        return new GTMetrixLocation($data);

	}
    



    /**
     * @return GTMetrixBrowser[]
     *
     * @throws GTMetrixConfigurationException
     */
    public function getBrowsers()
    {
        return $this->apiCall('/browsers');

    }

    /**
     * @param string $id
     *
     * @return GTMetrixBrowser
     * @throws GTMetrixConfigurationException
     * @throws GTMetrixException
     */
    public function getBrowser($id)
    {
        $data = [];

        if ($id) {
            $data = $this->apiCall('/browsers/' . $id);
        }

        return new GTMetrixBrowser($data);
    }


        /**
     * @return GTMetrixLocation[]
     *
     * @throws GTMetrixConfigurationException
     */
    public function getLocations()
    {
        return $this->apiCall('/locations');
    }

    public function getLocation($id)
    {
        $data = [];

        if ($id) {
            $data = $this->apiCall('/locations/' . $id);
        }

        return new GTMetrixLocation($data);
    }
}
