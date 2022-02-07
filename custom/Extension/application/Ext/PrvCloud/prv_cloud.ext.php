<?php
use GuzzleHttp\Client as GuzzleClient;
use Guzzle\Http\Exception\ClientErrorResponseException;
use GuzzleHttp\HandlerStack;
class PrvCloudMethods
{
    /********Set variables*********/
    public function setClient()
    {
        global $sugar_config;

        $stack = HandlerStack::create();
        $this->host = $sugar_config['PVT_HOST'];
        $this->client = new GuzzleClient(['base_uri' => $this->host, 'timeout' => 15, 'connect_timeout' => 15, 'handler' => $stack, 'debug' => true, 'http_errors' => false, ]);

        $this->authTok = $sugar_config['PVT_AUTH'];
        $this->record_type_id = $sugar_config['PVT_record_type_id'];
        $this->workspace_id = $sugar_config['PVT_workspace_id'];
        $this->container_guid = $sugar_config['PVT_container_guid'];
        $GLOBALS["log"]->fatal("RSR Working...." . $sugar_config['PVT_HOST']);
    }
    /********Generate Token********/
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
    /*******create record*********/
    public function createRecord($data, $depth = 0)
    {
        $this->setClient();
        /*start httpclient*/
        $this->makeAuth();
        $data_t = ["record_type_id" => $this->record_type_id, "workspace_id" => $this->workspace_id, "container_guid" => $this->container_guid];
        $data_f = array_merge($data, $data_t);

        if ($this->token)
        {

            try
            {

                $res = $this
                    ->client
                    ->post("/api/record", [

                'headers' => ['Content-Type' => 'application/json', 'Authorization' => "Bearer " . $this->token], 'body' => json_encode($data_f) ]);

                $response = (array)json_decode($res->getBody()->getContents());

                /**check if authentication fail try to recreate token****/
                if (trim($response['code']) == 401)
                {
                    if ($depth <= 3)
                    {
                        unset($_SESSION["PVT_TOKEN"]);
                        $GLOBALS["log"]->fatal("Token(" . $this->token . ") not authorized" . var_export($response, true));
                        $this->createRecord($data_f, ++$depth);
                    }
                    else
                    {
                        $this->RedirectBack($response['message']);
                    }

                }
                elseif (isset($response['record']) && !empty($response['record']))
                {
                    #"Record added";
                    $this->RedirectBack("Record added successfully guid - " . $response['guid'], 1);

                }
                else
                {
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
    function RedirectBack($msg, $type = 0)
    {
        $queryParams = ["module" => 'Contacts', "action" => "ListView", ];
        if ($type == 0)
        {
            SugarApplication::appendErrorMessage($msg);
        }
        else
        {
            SugarApplication::appendSuccessMessage($msg);
        }

        SugarApplication::redirect("index.php?" . http_build_query($queryParams));

    }

}
?>
