<?php namespace XCards\USPS;

interface DeliveryCalculatorInterface{
  public function getServiceDeliveryCalculation();
  /**
   * returns array of all routes added so far.
   * @return array
   */
  public function getPostFields();

  /**
   * @param $mail_class integer from 0 to 6 indicating the class of mail.
   *   “0” = All Mail Classes
   *   “1” = Express Mail
   *   “2” = Priority Mail
   *   “3” = First Class Mail
   *   “4” = Standard Mail
   *   “5” = Periodicals
   *   “6” = Package Services
   * @param $origin_zip 5 digit zip code.
   * @param $destination_zip 5 digit zip code.
   * @param null $accept_date string in the format dd-mmm-yyyy.
   * @param null $accept_time string in the format HHMM.
   */
  public function addRoute($mail_class, $origin_zip, $destination_zip, $accept_date = NULL, $accept_time = NULL);
}
