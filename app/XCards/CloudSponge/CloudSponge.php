<?php 
namespace XCards\Billing;

use CSimport;
use Config;
use Exception;

  class CloudSponge extends CSImport
  {
 
    /**
     * Constructor
     *
     * @access  public
     *
     */
    public function __construct()
    {
 
    }
 
    /**
    * requestContacts
    * Starts the process of gathering contacts from cloudsponge
    *
    * @param string $service The service to use(gmail/yahoo/windowslive/aol/plaxo/outlook/addressbook)
    * @param string $username The username to use, only needed for aol/plaxo
    * @param string $password The password to use, only needed for aol/plaxo
    *
    * @return array Response from cloudsponge, containing an import-id, consent_url applet tag and/or error message
    **/
    public function requestContacts($service, $username, $password)
    {
      $output = $this->begin_import($service, $username, $password, NULL);
      if (isset($output['import_id']))
      {
        $result['import'] = $output['import_id'];
        if (!is_null($output['consent_url'])) {
          $result['url'] = $output['consent_url'];
        } else if (!is_null($output['applet_tag'])) {
          $result['applet'] = htmlspecialchars($output['applet_tag']);
        }
      }
      return $result;
    }
 
    /**
    * importContacts
    * Attempts to get contacts from cloudsponge
    *
    * @param int $import_id the import id to use to request contacts from cloudsponge
    *
    * @return mixed Returns an array of contacts, or an error message
    **/
    public function importContacts($import_id) {
      if(empty($import_id))
      {
        return 'Invalid import id';
      }
 
      $status = $this->get_events($import_id);
      foreach ($status as $state)
      {
        if($state['status']=='ERROR')
        {
          return $state['description'];
        }
 
        if($state['event_type'] == "COMPLETE" && $state['status'] == "COMPLETED" && $state['value'] == 0)
        {
          return $this->get_contacts($import_id);
        }
      }
 
      return 'An error has occured.';
 
    }
 
  }
