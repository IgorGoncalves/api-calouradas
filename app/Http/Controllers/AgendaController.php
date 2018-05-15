<?php

namespace App\Http\Controllers;

use App\Calourada;
use App\ApiResponse;

use Illuminate\Http\Request;
use Validator;

class AgendaController extends Controller
{
    protected $client;
    public function __construct()
    {
      $this->client = $this->getClient();
      $this->service = new \Google_Service_Calendar($this->client);   
    }

    function index(){                         
      // Print the next 10 events on the user's calendar.
      $calendarId = 'primary';
      $optParams = array(
        'maxResults' => 10,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c'),
      );
      
      $results = $this->service->events->listEvents($calendarId, $optParams);
      
      $events = array();
      if (!empty($results->getItems())) {
          foreach ($results->getItems() as $event) {
              $start = $event->start->dateTime;
              $end = $event->end->dateTime;
              if (empty($start)) {
                  $start = $event->start->date;
              }
              $novo = new Calourada(
                $event->getSummary(),
                $event->getDescription(),
                $start,
                $end,
                $event->getLocation());
              array_push($events, $novo);
          }
      }

      $response = new ApiResponse($events);
      return json_encode($response);
    }

    function store(Request $request){
        $response = new ApiResponse();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'date' => 'required',
            'location' => 'required',            
        ]);
        
        if ($validator->fails()) {
            $response->errors = $validator->errors()->all();
            return json_encode($response);
        }

        $event = new \Google_Service_Calendar_Event(array(
            'summary' => $request->input('name'),
            'location' => $request->input('location'),
            'description' => $request->input('description'),
            'start' => array(
                'dateTime' => $request->input('date'),
                'timeZone' => 'America/Fortaleza',
            ),
            'end' => array(
                'dateTime' => $request->input('date'),
                'timeZone' => 'America/Fortaleza',
            ),            
            'attendees' => array(
              array('email' => 'igor.gonc19@gmail.com'),
            //   array('email' => $request->input('email')),
            ),
            'reminders' => array(
              'useDefault' => FALSE,
              'overrides' => array(
                array('method' => 'email', 'minutes' => 24 * 60),
                array('method' => 'popup', 'minutes' => 10),
              ),
            ),
          ));
          
          $calendarId = 'primary';
          $event = $this->service->events->insert($calendarId, $event);
          $response->data = $event;

        return json_encode($response);
    }

    protected function getClient()
    {
        $client = new \Google_Client();
        $client->setApplicationName('Google Calendar API PHP Quickstart');
        $client->setScopes(\Google_Service_Calendar::CALENDAR);
        $client->setAuthConfig('client_secret.json');
        $client->setAccessType('offline');
        // Load previously authorized credentials from a file.
        $credentialsPath = getEnv("HOMEPATH").'credentials.json';

        if (file_exists($credentialsPath)) {
            $accessToken = json_decode(file_get_contents($credentialsPath), true);            
        } else {
            // Request authorization from the user.            
            $authUrl = $client->createAuthUrl();            
            $authCode = getEnv("AUTHCODE");
                            
            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

            // Store the credentials to disk.
            if (!file_exists(dirname($credentialsPath))) {
                mkdir(dirname($credentialsPath), 0700, true);
            }
            file_put_contents($credentialsPath, json_encode($accessToken));
            printf("Credentials saved to %s\n", $credentialsPath);
        }
        $client->setAccessToken($accessToken);
        
        // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
        }        
        return $client;
    }

    /**
     * Expands the home directory alias '~' to the full path.
     * @param string $path the path to expand.
     * @return string the expanded path.
     */
    protected function getHomeDirectory($path)
    {
        $homeDirectory = getenv('HOME');
        if (empty($homeDirectory)) {
            $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
        }
        return str_replace('~', realpath($homeDirectory), $path);
    }



}
