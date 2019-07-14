<?php
/*Question #2.8
The following controller action code is responsible for writing data to the DB. It handles other tasks that involve invoking remote services prior to writing to the DB. 

In a few words, describe what could go wrong with the implementation and how would you architect this better.

use SolrHelper;
use GoogleHelper;
use Response;

Class PublicationController extends Controller {
  
   public function insertDocumentToDB($json)
   {
       $updatedJson = $json;

       try {
           $updatedJson = SolrHelper::solrCreate($json);
           $updatedJson = GoogleHelper::autoTagExtract($updatedJson);
       } catch(Exception $e) {
           throw new Exception('There was an error with a third party service');
       }

       $this->getContainer()->get('mongo')->insert($updatedJson);
       return new Response('OK', 200);
   }
}
*/

?>

// Answer:
In this approach, there might be an exception when we are writing to DB.
Therefore we could have put

$this->getContainer()->get('mongo')->insert($updatedJson);
return new Response('OK', 200);

in the try catch block.

Also if possible we could have 
$mongo = $this->getContainer()->get('mongo');

Then pass the $mongo object as a dependency to the insertDocumentToDB() function

<?php

Class PublicationController extends Controller {

	public function insertDocumentToDB(MongoInterface $mongo, $json)
	{
	    try {
	        $updatedJson = $this->getUpdatedJson($json);

	        $mongo->insert($updatedJson);
	        return new Response('OK', 200);

	    } catch(Exception $e) {
	    	// Log the error into a tracking system like Sentry Error Tracker
	    	//TODO: code to log error to sentry

	        throw new Exception('Failed to insert document');
	    }
	}

	public function getUpdatedJson()
	{
		try {
			$updatedJson = SolrHelper::solrCreate($json);
			$updatedJson = GoogleHelper::autoTagExtract($updatedJson);
			
		} catch (Exception $e) {
			throw new Exception('There was an error with a third party service');
		}

		return $updatedJson;
	}
}
