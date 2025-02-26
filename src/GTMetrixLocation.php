<?php


namespace LightningStudio\GTMetrixClient;

/**
 * GTMetrix location object.
 */
class GTMetrixLocation {
	
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
	public function getRegion() {
		return $this->data['attributes']['region'] ?? "";
	}

	/**
	 * @return boolean
	 */
	public function isDefault() {
		return $this->data['attributes']['default'] ?? false;
	}

	/**
	 * @return string[]
	 */
	public function getBrowserIds() {
		return $this->data['attributes']['browsers'] ?? [];
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
