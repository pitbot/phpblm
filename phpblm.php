<?php

/**
 * Parser for Rightmove's lovely BLM files.
 */

class phpblm {
	private $blm;
	private $header = array();
	private $def = array();
	private $data = array();
	
	public function __construct($file) {
		$this->blm = file_get_contents($file);
		$this->splitPieces();
	}
	
	// Return specific field from row
	public function getData($data, $row) {
		return $this->data[$row][$data];
	}
	
	// Return header info
	public function getHeader($hdr) {
		return $this->header[$hdr];
	}
	
	// This will return the actual number of properties, regardless of what the
	// header might say. To retrieve the header value (if present), use:
	// $blm->getHeader('Property Count');
	public function propCount() {
		return count($this->data);
	}
	
	public function properties() {
		return $this->data;
	}
	
	// Splits the BLM data into constituent parts
	private function splitPieces() {
		$pieces = explode("#", $this->blm);
		
		// Get the header (includes EOF/EOR stuff)
		$header = explode("\n", trim($pieces[2]));
		foreach ($header as $h) {
			$h = preg_replace("/\'/", "", $h);	// Remove quotes on EOF/EOR
			$h_pieces = explode(" : ", $h);
			$this->header[trim($h_pieces[0])] = trim($h_pieces[1]);
		}
		
		// Get the definitions
		$def = explode($this->header['EOF'], trim($pieces[4]));
		foreach ($def as $d) {
			$this->def[] = $d;
		}
		
		// Get the data
		$data = explode($this->header['EOR'], trim($pieces[6]));
		$datac = count($data);

		for ($i=0; $i<$datac; $i++) {
			$row = explode($this->header['EOF'], trim($data[$i]));
			for ($j=0; $j<count($row); $j++) {
				$row_arr[$this->def[$j]] = $row[$j];
			}
			$this->data[] = $row_arr;
		}
	}
}