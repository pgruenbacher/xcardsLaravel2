<?php namespace XCards\USPS;

interface TrackingInterface{
	public function getEndpoint();
  /**
   * Perform the API call
   * @return string
   */
  public function getTracking();
  /**
   * returns array of all packages added so far
   * @return array
   */
  public function getPostFields();

  /**
   * Add Package to the stack
   * @param string $id the address unique id
   * @return void
   */
  public function addPackage($id);
  
}
