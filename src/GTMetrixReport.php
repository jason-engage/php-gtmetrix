<?php


namespace LightningStudio\GTMetrixClient;

/**
 * GTMetrix report object
 */
class GTMetrixReport {


	/**
	 * @var array
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
	 * @return various
	 */
	public function getAttribute($name) {
		return $this->data['attributes'][$name] ?? null;
	}

    /**
	 * @return various
	 */
    public function getLink($name) {
		return $this->data['links'][$name] ?? null;
	}


    /**
	 * @return timestamp
	 */
	public function getExpires() {
		return $this->getAttribute('expires') ?? null;
	}

    /**
	 * @return int
	 */
	public function getBrowser() {
		return $this->getAttribute('browser') ?? null;
	}

    /**
	 * @return int
	 */
	public function getLocation() {
		return $this->getAttribute('location') ?? null;
	}

	/**
	 * @return int
     * lighthouse
	 */
	public function getGtmetrixGrade() {
		return $this->getAttribute('gtmetrix_grade') ?? null;
	}

	/**
	 * @return int
     * lighthouse
	 */
	public function getPerformanceScore() {
		return $this->getAttribute('performance') ?? null;
	}

    /**
	 * @return int
     * lighthouse
	 */
	public function getStructureScore() {
		return $this->getAttribute('structure') ?? null;
	}

    /**
	 * @return int
     * legacy
	 */
	public function getPagespeedScore() {
		return $this->getAttribute('pagespeed_score') ?? null;
	}

	/**
	 * @return int
     * legacy
	 */
	public function getYslowScore() {
		return $this->getAttribute('yslow_score') ?? null;
	}
    

	/**
	 * @return int
	 */
	public function getHtmlBytes() {
		return $this->getAttribute('html_bytes') ?? null;
	}

    /**
	 * @return int
	 */
	public function getPageBytes() {
		return $this->getAttribute('page_bytes') ?? null;
	}


    /**
	 * @return int
	 */
	public function getPageRequests() {
		return $this->getAttribute('page_requests') ?? null;
	}

	
    /**
     * @return int
     */
    public function getRedirectDuration() {
        return $this->getAttribute('redirect_duration') ?? null;
    }


    /**
     * @return int
     */
    public function getConnectDuration() {
        return $this->getAttribute('connect_duration') ?? null;
    }


    /**
     * @return int
     */
    public function getBackendDuration() {
        return $this->getAttribute('backend_duration') ?? null;
    }


    /**
     * @return int
     */
    public function getTimeToFirstByte() {
        return $this->getAttribute('time_to_first_byte') ?? null;
    }

    /**
     * @return int
     */
    public function getFirstPaintTime() {
        return $this->getAttribute('first_paint_time') ?? null;
    }

    /**
     * @return int
     */
    public function getFirstContentfulPaint() {
        return $this->getAttribute('first_contentful_paint') ?? null;
    }

    /**
     * @return int
     * lighthouse    
     */
    public function getLargestContentfulPaint() {
        return $this->getAttribute('largest_contentful_paint') ?? null;
    }
    
    /**
     * @return int
     * lighthouse
     */
    public function getCumulativeLayoutShift() {
        return $this->getAttribute('cumulative_layout_shift') ?? null;
    }

    /**
     * @return int
     */
    public function getDomInteractiveTime() {
        return $this->getAttribute('dom_interactive_time') ?? null;
    }

    /**
     * @return int
     */
    public function getDomContentLoadedTime() {
        return $this->getAttribute('dom_content_loaded_time') ?? null;
    }

    /**
     * @return int
     */
    public function getDomContentLoadedDuration() {
        return $this->getAttribute('dom_content_loaded_duration') ?? null;
    }

    /**
     * @return int
     */
    public function getOnloadTime() {
        return $this->getAttribute('onload_time') ?? null;
    }

    /**
     * @return int
     */
    public function getOnloadDuration() {
        return $this->getAttribute('onload_duration') ?? null;
    }

    /**
     * @return int
     */
    public function getFullyLoadedTime() {
        return $this->getAttribute('fully_loaded_time') ?? null;
    }

    /**
     * @return int
     * lighthouse
     */
    public function getTimeToInteractive() {
        return $this->getAttribute('time_to_interactive') ?? null;
    }

    /**
     * @return int
     * lighthouse
     */
    public function getTotalBlockingTime() {
        return $this->getAttribute('total_blocking_time') ?? null;
    }
    

    /**
     * @return int
     */
    public function getRumSpeedIndex() {
        return $this->getAttribute('rum_speed_index') ?? null;
    }

    /**
     * @return int
     * lighthouse
     */
    public function getSpeedIndex() {
        return $this->getAttribute('speed_index') ?? null;
    }

	/**
	 * @return string
	 */
	public function getReportUrl() {
		return $this->getLink('report_url') ?? null;
	}

    /**
	 * @return string
	 */
	public function getReportPdfUrl() {
		return $this->getLink('report_pdf') ?? null;
	}

    /**
	 * @return string
	 */
	public function getReportPdfFullUrl() {
		$url = $this->getReportPdfUrl();
        
        if ($url) {
            return $url . "?full=1";
        }

        return $url;
    }

    /**
	 * @return string
     * lighthouse
	 */
	public function getLighthouseJsonUrl() {
		return $this->getLink('lighthouse') ?? null;
	}

    /**
	 * @return string
     * legacy
	 */
	public function getPagespeedJsonUrl() {
		return $this->getLink('pagespeed') ?? null;
	}

    /**
	 * @return string
     * legacy
	 */
	public function getYslowJsonUrl() {
		return $this->getLink('yslow') ?? null;
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

    public function priorityMetrics($format = false) {
        $metrics = [
            'structure' => $this->getStructureScore(),
            'performance' => $this->getPerformanceScore(),
            'pagespeed' => $this->getPagespeedScore(),
            'yslow' => $this->getYslowScore(),
            'speed_index' => $this->getSpeedIndex(),
            'first_contentful_paint' => $this->getFirstContentfulPaint(),
            'time_to_interactive' => $this->getTimeToInteractive(),
            'total_blocking_time' => $this->getTotalBlockingTime(),
            'largest_contentful_paint' => $this->getTimeToInteractive(),
            'cumulative_layout_shift' => $this->getCumulativeLayoutShift()
        ];
    
        if ($format) {
            $metrics['structure'] = $metrics['structure'] ? ($metrics['structure'] * 100) . "%" : $metrics['structure'];
            $metrics['performance'] = $metrics['performance'] ? ($metrics['performance'] * 100) . "%" : $metrics['performance'];
            $metrics['pagespeed'] = $metrics['pagespeed'] ? ($metrics['pagespeed'] * 100) . "%" : $metrics['pagespeed'];
            $metrics['yslow'] = $metrics['yslow'] ? ($metrics['yslow'] * 100) . "%" : $metrics['yslow'];
            $metrics['speed_index'] = $metrics['speed_index'] ? $metrics['speed_index'] . "ms" : $metrics['speed_index'];
            $metrics['first_contentful_paint'] = $metrics['first_contentful_paint'] ? $metrics['first_contentful_paint'] . "ms" : $metrics['first_contentful_paint'];
            $metrics['time_to_interactive'] = $metrics['time_to_interactive'] ? $metrics['time_to_interactive'] . "ms" : $metrics['time_to_interactive'];
            $metrics['total_blocking_time'] = $metrics['total_blocking_time'] ? $metrics['total_blocking_time'] . "ms" : $metrics['total_blocking_time'];
            $metrics['largest_contentful_paint'] = $metrics['largest_contentful_paint'] ? $metrics['largest_contentful_paint'] . "ms" : $metrics['largest_contentful_paint'];
            // You can adjust the unit/format for 'cumulative_layout_shift' as needed
            $metrics['cumulative_layout_shift'] = $metrics['cumulative_layout_shift'] ? $metrics['cumulative_layout_shift'] : $metrics['cumulative_layout_shift'];
        }
    
        return $metrics;
    }
    

}

