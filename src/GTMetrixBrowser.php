<?php


namespace LightningStudio\GTMetrixClient;

/**
 * GTMetrix browser object
 */
class GTMetrixBrowser {
	

	/**
	 * @var data
	 */
	protected $data;

	/**
	 * @param array $data
	 */
    public function setData($data) {
		return $this->data = $data;
	}

	/**
	 * @param string $id
	 */
	public function setId($id) {
		$this->data['id'] = $id;
	}
    

	/**
	 * @return array
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * @return string
	 */
	public function getId() {
		return $this->data['id'] ?? null;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->data['attributes']['name'] ?? "";
	}


	/**
	 * @return string
	 */
	public function getPlatform() {
		return $this->data['attributes']['platform'] ?? "";
	}

	/**
	 * @return string
	 */
	public function getDevice() {
		return $this->data['attributes']['device'] ?? "";
	}

	/**
	 * @return string
	 */
	public function getBrowser() {
		return $this->data['attributes']['browser'] ?? "";
	}

	/**
	 * @param string $feature
	 *
	 * @return bool
	 */
	public function hasFeature($feature) {
		return !empty($this->data['attributes'][$feature]);
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return json_encode( $this->getData(), JSON_PRETTY_PRINT );
	}

	public function __construct($data = []) {
		$this->setData($data);
	}

}
