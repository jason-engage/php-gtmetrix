<?php


namespace LightningStudio\GTMetrixClient;

/**
 * GTMetrix SimulatedDevice object
 */
class GTMetrixSimulatedDevice {
	

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
	public function getCategory() {
		return $this->data['attributes']['category'] ?? "";
	}

	/**
	 * @return string
	 */
	public function getUserAgent() {
		return $this->data['attributes']['user_agent'] ?? "";
	}

	/**
	 * @return string
	 */
	public function getManufacturer() {
		return $this->data['attributes']['manufacturer'] ?? "";
	}

    /**
	 * @return string
	 */
	public function getHeight() {
		return $this->data['attributes']['height'] ?? 0;
	}

    /**
	 * @return string
	 */
	public function getWidth() {
		return $this->data['attributes']['width'] ?? 0;
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
