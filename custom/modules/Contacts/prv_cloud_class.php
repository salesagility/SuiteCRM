<?php
use GuzzleHttp\Client as GuzzleClient;
use Guzzle\Http\Exception\ClientErrorResponseException;
use GuzzleHttp\HandlerStack;

if (!defined("sugarEntry") || !sugarEntry)
{
    die("Not A Valid Entry Point");
}
ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);

class PrvCloud
{
    function PrvSave($bean, $event, $arguments)
    {

        

        $this->setClient();
        $data = ["frozen" => "false", "record" => ["first_name" => $bean->first_name, "last_name" => $bean->last_name, "phone_home" => $bean->phone_mobile, "email" => $bean->email1, ], "record_type_id" => $this->record_type_id, "workspace_id" => $this->workspace_id, "container_guid" => $this->container_guid, ];

        $this->createRecord($data);
        
    }
    private function setClient()
    {
    	global $sugar_config;

        $stack = HandlerStack::create();
        $this->host = $sugar_config['PVT_HOST'];
        $this->client = new GuzzleClient(['base_uri' => $this->host, 'timeout' => 15, 'connect_timeout' => 15, 'handler' => $stack, 'debug' => true, 'http_errors' => false, ]);

        $this->authTok = $sugar_config['PVT_AUTH'];
        $this->record_type_id = $sugar_config['PVT_record_type_id'];
        $this->workspace_id = $sugar_config['PVT_workspace_id'];
        $this->container_guid = $sugar_config['PVT_container_guid'];
    }
    private function makeAuth()
    {
        if (session_id() == "")
        {
            session_start();
        }
        $this->token = $_SESSION["PVT_TOKEN"];

        if (empty($this->token))
        {
            $res = $this
                ->client
                ->request("POST", $this->host . "/api/refresh_token", ["headers" => ["Accept" => "application/json", "Authorization" => "Bearer " . $this->authTok, ], ]);
            $response = (array)json_decode($res->getBody()
                ->getContents());
           
            if (isset($response["access_token"]) && !empty($response["access_token"]))
            {
                $_SESSION["PVT_TOKEN"] = $response["access_token"];
                $this->token = $response["access_token"];
            }
            else
            {
            	$this->RedirectBack("There some error in API authentication. Try again");
                #$response['code'] $response['message']
                
            }
        }
    }
    private function createRecord($data, $depth = 0)
    {
        /*start httpclient*/
        $this->makeAuth();

        if ($this->token)
        {

            try
            {

                $res = $this
                    ->client
                    ->post("/api/record", [

                'headers' => ['Content-Type' => 'application/json', 'Authorization' => "Bearer " . $this->token], 'body' => json_encode($data) ]);
                
                $response = (array)json_decode($res->getBody()
                    ->getContents());

                /**check if authentication fail try to recreate token****/
                if (trim($response['code']) == 401)
                {
                    if ($depth <= 3)
                    {
                        unset($_SESSION["PVT_TOKEN"]);
                        $GLOBALS["log"]->fatal("Token(" . $this->token . ") not authorized" . var_export($response, true));
                        $this->createRecord($data, ++$depth);
                    }
                    else
                    {
                       $this->RedirectBack($response['message']);
                    }

                }
                elseif(isset($response['record']) && !empty($response['record']))
                {
                    #"Record added";
                    $this->RedirectBack("Record added successfully guid - ".$response['guid'],1);

                }else{
                	$this->RedirectBack($response['message']);

                }

            }
            catch(RequestException $e)
            {
                if ($e->hasResponse())
                {
                    $exception = (string)$e->getResponse()
                        ->getBody();
                    $exception = json_decode($exception);
                    $GLOBALS["log"]->fatal("PVT - error " . var_export($exception, true));
                    return new JsonResponse($exception, $e->getCode());
                }
                else
                {
                    $GLOBALS["log"]->fatal("PVT = error" . var_export($e, true));
                    return new JsonResponse($e->getMessage() , 503);
                }

            }
        }
    }
    function RedirectBack($msg,$type=0)
    {
    	$queryParams = ["module" => 'Contacts', "action" => "ListView", ];
    	if($type==0){
    		SugarApplication::appendErrorMessage($msg);
    	}else{
    		SugarApplication::appendSuccessMessage($msg);	
    	}
        
        
        SugarApplication::redirect("index.php?" . http_build_query($queryParams));
		
    }
}

?>
