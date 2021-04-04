<?php

class Shopify extends CI_Model
{

    function shopify_call($token, $shop, $api_endpoint, $query = array(), $method = 'GET', $request_headers = array())
    {

        // Build URL
        $url = "https://" . $shop . ".myshopify.com" . $api_endpoint;
        if (!is_null($query) && in_array($method, array('GET',     'DELETE'))) $url = $url . "?" . http_build_query($query);

        // Configure cURL
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 3);
        // curl_setopt($curl, CURLOPT_SSLVERSION, 3);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Sleek Upsell v.1');
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

        // Setup headers
        $request_headers[] = "";
        if (!is_null($token)) $request_headers[] = "X-Shopify-Access-Token: " . $token;
        curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);

        if ($method != 'GET' && in_array($method, array('POST', 'PUT'))) {
            if (is_array($query)) $query = http_build_query($query);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
        }

        // Send request to Shopify and capture any errors
        $response = curl_exec($curl);
        $error_number = curl_errno($curl);
        $error_message = curl_error($curl);

        // Close cURL to be nice
        curl_close($curl);

        // Return an error is cURL has a problem
        if ($error_number) {
            return $error_message;
        } else {

            // No error, return Shopify's response by parsing out the body and the headers
            $response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);

            // Convert headers into an array
            $headers = array();
            $header_data = explode("\n", $response[0]);
            $headers['status'] = $header_data[0]; // Does not contain a key, have to explicitly set
            array_shift($header_data); // Remove status, we've already set it above
            foreach ($header_data as $part) {
                $h = explode(":", $part);
                $headers[trim($h[0])] = trim($h[1]);
            }

            // Return headers and Shopify's response
            return array('headers' => $headers, 'response' => $response[1]);
        }
    }

    function do_email($msg = NULL, $sub = NULL, $to = NULL, $from = NULL)
    {

        //Load email library
        $this->load->library('email');

        //SMTP & mail configuration
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'support@sleekupsell.com',
            'smtp_pass' => '890Berjis*()',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");

        $this->email->to($to);
        $this->email->from($from, 'Sleek Upsell');
        $this->email->subject($sub);
        $this->email->message($msg);

        //Send email
        $this->email->send();

        echo $this->email->print_debugger();
    }

    function welcome_email($to = NULL)
    {

        //Load email library
        $this->load->library('email');

        //SMTP & mail configuration
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'support@sleekupsell.com',
            'smtp_pass' => '890Berjis*()',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );

        $msg = '
        <h3>Hello!</h3>
        <p>This is Mark with Sleek Upsell. Welcome to the family! ;) </p>

        <p>Say goodbye to annoying up-sell popups on your store, and say hello to effective up-selling when customers are already purchasing your products. Here\'s to big-time SHOPIFY SUCCESS - We\'re in this thing together :) Woot!</p>

        <p>Did you know that we are the longest standing Shopify app for Sleek Upsells? Yup, that is right! With all of the data across Shopify stores just like yours, we\'re here to help you get up and running as efficiently as possible to start increasing your sales from customers that are already checking out and purchasing your products.</p>

        <p>In the next email we send, we\'ll outline the three steps for getting started in Sleek Upsell.</p>

        <p>In the meantime, I\'m only a quick email away to support your success. So glad to have you here.  </p>

        <p>Thanks again,</p>

        <p>**Mark & The Sleek Upsell Support Team**</p>

        <p>support@sleekupsell.com</p>

        <p>[Sleek Upsell Listing](https://apps.shopify.com/sleek-upsell)</p>
        ';

        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");

        $this->email->to($to);
        $this->email->from('support@sleekupsell.com', 'Sleek Upsell');
        $this->email->bcc('sleek.apps.data@gmail.com');
        $this->email->subject('Welcome to Sleek Upsell');
        $this->email->message($msg);

        //Send email
        $this->email->send();

        echo $this->email->print_debugger();
    }
}
