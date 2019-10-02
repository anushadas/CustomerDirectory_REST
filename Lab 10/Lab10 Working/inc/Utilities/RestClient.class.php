<?php

class RestClient    {


    static function call($method, $callData)  {

            //Reference: https://stackoverflow.com/questions/5647461/how-do-i-send-a-post-request-with-php

            
            //State the request header
            $requestHeader = array('requesttype' => $method);
            
            //We have to merge the two arrays so they are one array in order to have them build properly otherwise we will end up with an embeded k,v inside a k,v, the function can only process one flat k,v array.
            $data = array_merge($requestHeader,$callData);                    
            
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => $method,
                    'content' => http_build_query($data)
                )
            );

            $context  = stream_context_create($options);
            $result = file_get_contents(API_URL, false, $context);

            return $result;

        }

    }


?>