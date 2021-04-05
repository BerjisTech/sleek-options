<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Slade extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2025 05:00:00 GMT");
        date_default_timezone_set("Africa/Nairobi");
        header('Access-Control-Allow-Origin: *');
    }

    public function index()
    {
        if (!isset($_GET['shop'])) {
            $this->load->view('home');
        } else {
            if (!isset($_GET['hmac'])) {
                echo '<script>window.location.href = "https://' . $_GET['shop'] . '/admin/apps";</script>';
            }

            $this_shop = str_replace(".myshopify.com", "", $_GET['shop']);

            if (!$this->db->table_exists('shops')) {
                echo '<script>window.location.href = "' . base_url() . 'install?shop=' . $this_shop . '";</script>';
            }

            if ($this->db->where('shop', $this_shop)->get('shops')->num_rows() == 0) {
                echo '<script>window.location.href = "' . base_url() . 'install?shop=' . $this_shop . '";</script>';
            }

            $shop_data = $this->db->where('shop', $this_shop)->get('shops')->row();

            if ($shop_data->type == '') {
                echo '<script>window.location.href = "' . base_url() . 'install?' . $_SERVER['QUERY_STRING'] . '";</script>';
            }

            $requests = $_GET;
            $hmac = $_GET['hmac'];
            $serializeArray = serialize($requests);
            $requests = array_diff_key($requests, array('hmac' => ''));
            ksort($requests);

            $token = $shop_data->token;
            $shop = $shop_data->shop;


            $this_script = '/admin/api/2020-04/script_tags.json';
            $script_tags_url = "/admin/api/2020-04/script_tags.json";

            $script_exists = $this->Shopify->shopify_call($token, $shop, $this_script, array('fields' => 'id,src,event,created_at,updated_at,'), 'GET');
            $script_exists = json_decode($script_exists['response'], true);

            if (count($script_exists['script_tags']) == 0) {
                $data['do_script'] = "add";
            } else {
                $data['do_script'] = "remove";
            }

            if ($this->db->where('shop', $shop)->get('options')->num_rows() > 0) {
                $data['options'] = $this->db->where('shop', $shop)->get('options')->result_array();
            } else {
                $data['options'] = array();

                $s_mail = $this->Shopify->shopify_call($token, $shop, '/admin/api/2020-04/shop.json', array('fields' => 'email'), 'GET');
                $s_mail = json_decode($s_mail['response'], true);

                $data['email'] = $s_mail['shop']['email'];
                if ($shop_data->created_at == '') {
                }
            }


            $products = $this->Shopify->shopify_call($token, $this_shop, "/admin/api/2020-04/products.json", array('fields' => 'id,title,variants'), 'GET');
            $params['products'] = json_decode($products['response'], true);


            $data['shop'] = $shop;
            $data['token'] = $token;
            $data['products'] = $params['products']['products'];
            $data['page_name'] = 'dashboard';
            $this->load->view('index', $data);
        }
    }

    public function generate_token()
    {
        $api_key = $this->config->item('shopify_api_key');
        $shared_secret = $this->config->item('shopify_secret');
        $params = $_GET; // Retrieve all request parameters
        $hmac = $_GET['hmac']; // Retrieve HMAC request parameter

        $params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
        ksort($params); // Sort params lexographically

        $computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);

        // Use hmac data to check that the response is from Shopify or not
        if (hash_equals($hmac, $computed_hmac)) {

            // Set variables for our request
            $query = array(
                "client_id" => $api_key, // Your API key
                "client_secret" => $shared_secret, // Your app credentials (secret key)
                "code" => $params['code'], // Grab the access key from the URL
            );

            // Generate access token URL
            $access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";

            // Configure curl client and execute request
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $access_token_url);
            curl_setopt($ch, CURLOPT_POST, count($query));
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
            $result = curl_exec($ch);
            curl_close($ch);

            // Store the access token
            $result = json_decode($result, true);
            $access_token = $result['access_token'];

            // Show the access token (don't do this in production!)

            //echo $access_token;

            $shop = str_replace(".myshopify.com", "", $params['shop']);

            if ($this->db->table_exists('shops')) {
                if ($this->db->where('shop', $shop)->get('shops')->num_rows() == 0) {
                    $shop_data = array(
                        'shop_id' => ($this->db->order_by('shop_id', 'DESC')->limit('1')->get('shops')->row()->shop_id + 1),
                        'shop' => $shop,
                        'token' => $access_token,
                        'date' => time(),
                    );
                    $this->db->insert('shops', $shop_data);
                } else {
                    $shop_data = array(
                        'shop_id' => '',
                        'shop' => $shop,
                        'token' => $access_token,
                        'updated_at' => time(),
                    );
                    $this->db->where('shop', $shop)->update('shops', array('token' => $access_token, 'updated_at' => time()));
                }
            } else {
                $shop_data = array(
                    'shop_id' => ($this->db->order_by('shop_id', 'DESC')->limit('1')->get('shops')->row()->shop_id + 1),
                    'shop' => $shop,
                    'token' => $access_token,
                    'date' => time(),
                );
                $this->load->dbforge();
                $fields = array(
                    'shop_id' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => true,
                        'auto_increment' => true,
                    ),
                    'shop' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '255',
                        'unique' => true,
                    ),
                    'token' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '255',
                        'default' => '',
                    ),
                    'date' => array(
                        'type' => 'INT',
                        'constraint' => 11,
                        'null' => true,
                    ),
                );
                $this->dbforge->add_field($fields);
                $this->dbforge->add_key('shop_id', true);
                $this->dbforge->create_table('shops');

                $this->db->insert('shops', $shop_data);
            }
            echo '<script>window.location.href = "' . base_url() . 'start?t=false&' . $_SERVER['QUERY_STRING'] . '";</script>';
        } else {
            // Someone is trying to be shady!
            header("Location: https://sleekupsell.com/");
            die('This request is NOT from Shopify!');
        }
    }

    public function start()
    {

        $shop = str_replace(".myshopify.com", "", $_GET['shop']);
        $token = $this->db->where('shop', $shop)->get('shops')->row()->token;

        $s_data = $this->Shopify->shopify_call($token, $shop, '/admin/api/2020-04/shop.json', array(), 'GET');
        $s_data = json_decode($s_data['response'], true);
        $s_data = $s_data['shop'];

        $active_shop = array(
            'plan_name' => $s_data['plan_name'],
            'shop_owner' => $s_data['shop_owner'],
            'plan_display_name' => $s_data['plan_display_name'],
            'customer_email' => $s_data['customer_email'],
            'domain' => $s_data['domain'],
            'partner' => $s_data['id'],
            'type' => 'FREE',
            'name' => 'FREE',
            'price' => 0.0,
            'bill_interval' => 'FOREVER',
            'capped_amount' => 0.0,
            'terms' => 'NO_TERMS',
            'trial_days' => '30',
            'test' => $_GET['t'],
            'on_install' => 1,
            'created_at' => '',
            'updated_at' => time(),

        );
        $this->db->where('shop', str_replace(".myshopify.com", "", $_GET['shop']))->set($active_shop)->update('shops');

        // SCRIPT TAGS
        $this_script = '/admin/api/2020-04/script_tags.json';
        $script_tags_url = "/admin/api/2020-04/script_tags.json";

        $script_exists = $this->Shopify->shopify_call($token, $shop, $this_script, array('fields' => 'id,src,event,created_at,updated_at,'), 'GET');
        $script_exists = json_decode($script_exists['response'], true);

        // CREATE NEW SCRIPT TAG
        if (count($script_exists['script_tags']) == 0) {
            $script_array = array(
                'sleek_upsell' => array(
                    'event' => 'onload',
                    'src' => base_url() . 'assets/js/shopify.js',
                    'display_scope' => 'all'
                ),
            );

            $scriptTag = $this->Shopify->shopify_call($token, $shop, $script_tags_url, $script_array, 'POST');
            $scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);
        } else {
            echo '<script>console.log(' . json_encode($script_exists) . ');</script>';
        }

        // REMOVE OLD SCRIPT TAGS
        if (count($script_exists['script_tags']) > 1) {
            foreach ($script_exists['script_tags'] as $key => $fetch) {
                $delete_script = $this->Shopify->shopify_call($token, $shop, '/admin/api/2020-04/script_tags/' . $fetch['id'] . '.json', array('fields' => 'id,src,event,created_at,updated_at,'), 'DELETE');
                $delete_script = json_decode($delete_script['response'], true);
                echo '<script>console.log(' . json_encode($delete_script) . ');</script>';
            }
            $script_array = array(
                'sleek_upsell' => array(
                    'event' => 'onload',
                    'src' => base_url() . 'assets/js/shopify.js',
                    'display_scope' => 'all'
                ),
            );

            $scriptTag = $this->Shopify->shopify_call($token, $shop, $script_tags_url, $script_array, 'POST');
            $scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);

            $w_array = array(
                'webhook' => array(
                    'topic' => 'app/uninstalled',
                    'address' => 'https://sleekupsell.com/d?shop=' . $_GET['shop'],
                    'format' => 'json'
                )
            );

            $webhook = $this->Shopify->shopify_call($token, $shop, "/admin/api/2020-07/webhooks.json", $w_array, 'POST');
            $webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);
        }

        $this->Shopify->do_email(
            $s_data['shop_owner'] . ' just installed Sleek Apps on ' . $s_data['domain'] . '<br /> Email: ' . $s_data['customer_email'],
            'New User',
            'sleek.apps.data@gmail.com',
            'support@sleekupsell.com'
        );

        $this->Shopify->welcome_email($s_data['customer_email']);

        echo '<script>top.window.location="https://' . $_GET['shop'] . '/admin/apps/sleek-options?' . $_SERVER['QUERY_STRING'] . '";</script>';
    }

    public function api_call_write_products()
    {
        $shop = $this->session->userdata('shop');
        $token = $this->session->userdata('token');

        $query = array(
            "Content-type" => "application/json", // Tell Shopify that we're expecting a response in JSON format
        );

        // Run API call to get products
        $products = $this->Shopify->shopify_call($token, $shop, "/admin/products.json", array(), 'GET');

        // Convert product JSON information into an array
        $products = json_decode($products['response'], true);

        // Get the ID of the first product
        $product_id = $products['products'][0]['id'];

        // Modify product data
        $modify_data = array(
            "product" => array(
                "id" => $product_id,
                "title" => "My New Title",
            ),
        );

        // Run API call to modify the product
        $modified_product = $this->Shopify->shopify_call($token, $shop, "/admin/products/" . $product_id . ".json", $modify_data, 'PUT');

        // Storage response
        $modified_product_response = $modified_product['response'];
    }

    public function install()
    {
        if (isset($_GET['shop'])) :
            $shop = $_GET['shop'];
            $shop = str_replace(".myshopify.com", "", $shop);
            $shop = str_replace("https://", "", $shop);
            $shop = str_replace("http://", "", $shop);
            $shop = str_replace("/", "", $shop);
        elseif (isset($_POST['shop'])) :
            $shop = $_POST['shop'];
            $shop = str_replace(".myshopify.com", "", $shop);
            $shop = str_replace("https://", "", $shop);
            $shop = str_replace("http://", "", $shop);
            $shop = str_replace("/", "", $shop);
        endif;
        $api_key = $this->config->item('shopify_api_key');
        $scopes = "read_orders,read_draft_orders,read_products,read_product_listings,read_inventory,read_script_tags,write_script_tags,read_themes,write_themes,read_checkouts,read_price_rules,read_discounts";
        $redirect_uri = base_url() . "generate_token";

        // Build install/approval URL to redirect to
        $install_url = "https://" . $shop . ".myshopify.com/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);
        // Redirect
        header("Location: " . $install_url);
        die();
    }

    public function upgrade($shop, $token, $plan)
    {
        $requests = $_GET;
        $requests = array_diff_key($requests, array('hmac' => ''));
        ksort($requests);

        $shop = str_replace(".myshopify.com", "", $_GET['shop']);
        $token = $this->db->where('shop', $shop)->get('shops')->row()->token;


        $s_data = $this->Shopify->shopify_call($token, $shop, '/admin/api/2020-04/shop.json', array(), 'GET');
        $s_data = json_decode($s_data['response'], true);
        $s_data = $s_data['shop'];

        $s_array = array(
            'plan_name' => $s_data['plan_name'],
            'shop_owner' => $s_data['shop_owner'],
            'plan_display_name' => $s_data['plan_display_name'],
            'customer_email' => $s_data['customer_email'],
            'domain' => $s_data['domain'],
            'partner' => $s_data['id']
        );

        $this->db->where('shop', $shop)->set($s_array)->update('shops');

        if ($plan == 'Free') {
            $this_script = '/admin/api/2020-04/recurring_application_charges.json';

            $script_exists = $this->Shopify->shopify_call($token, $shop, $this_script, array(), 'GET');
            $script_exists = json_decode($script_exists['response'], true);

            foreach ($script_exists['recurring_application_charges'] as $key => $fetch) :
                $del_url = '/admin/api/2020-04/recurring_application_charges/' . $fetch['id'] . '.json';
                $del = $this->Shopify->shopify_call($token, $shop, $del_url, array(), 'DELETE');
                $del = json_decode($del['response'], true);
            endforeach;

            $active_shop = array(
                'type' => 'FREE',
                'name' => $plan,
                'price' => 0.00,
                'bill_interval' => 'NEVER',
                'capped_amount' => 0.00,
                'terms' => 'NO_TERMS',
                'trial_days' => '0',
                'test' => 'false',
                'on_install' => 1,
                'created_at' => '',
                'updated_at' => time(),

            );

            $this->db->where('shop', str_replace(".myshopify.com", "", $_GET['shop']))->set($active_shop)->update('shops');
            $this->db->where('shop', $shop)->set('status', 0)->update('options');

            echo '<script>top.window.location="https://' . $_GET['shop'] . '/admin/apps/sleek-options?' . $_SERVER['QUERY_STRING'] . '";</script>';
            exit();
        } else {
            if ($plan == 'Sleek') {
                $array = array(
                    'recurring_application_charge' => array(
                        'name' => 'Sleek',
                        'test' => false,
                        'price' => 19.99,
                        'trial_days' => 7,
                        'return_url' => 'https://' . $_GET['shop'] . '/admin/apps/sleek-options/activate/Sleek?t=false&hmac=' . $_GET['hmac'] . '&shop=' . $_GET['shop'],
                    ),
                );
            }
            if ($plan == 'Premium' && $shop == 'sleek-options-live') {
                $array = array(
                    'recurring_application_charge' => array(
                        'name' => 'Premium',
                        'test' => true,
                        'price' => 59.99,
                        'trial_days' => 7,
                        'return_url' => 'https://' . $_GET['shop'] . '/admin/apps/sleek-options/activate/Premium?t=false&hmac=' . $_GET['hmac'] . '&shop=' . $_GET['shop'],
                    ),
                );
            }
            if ($plan == 'Premium' && $shop != 'sleek-options-live') {
                $array = array(
                    'recurring_application_charge' => array(
                        'name' => 'Premium',
                        'test' => false,
                        'price' => 59.99,
                        'trial_days' => 7,
                        'return_url' => 'https://' . $_GET['shop'] . '/admin/apps/sleek-options/activate/Premium?t=false&hmac=' . $_GET['hmac'] . '&shop=' . $_GET['shop'],
                    ),
                );
            }

            $charge = $this->Shopify->shopify_call($token, $shop, "/admin/api/2020-04/recurring_application_charges.json", $array, 'POST');
            $charge = json_decode($charge['response'], JSON_PRETTY_PRINT);

            echo '<script>top.window.location="' . $charge['recurring_application_charge']['confirmation_url'] . '";</script>';
            exit();
        }
    }

    public function activate($plan)
    {
        $requests = $_GET;
        $requests = array_diff_key($requests, array('hmac' => ''));
        ksort($requests);

        $shop = str_replace(".myshopify.com", "", $_GET['shop']);
        $token = $this->db->where('shop', $shop)->get('shops')->row()->token;

        if (isset($_GET['charge_id']) && $_GET['charge_id'] != '') {
            $charge_id = $_GET['charge_id'];


            $array = array(
                'recurring_application_charge' => array(
                    'id' => $charge_id,
                    'name' => $plan,
                    'api_client_id' => time(),
                    'price' => '19.99',
                    'status' => 'accepted',
                    'return_url' => 'https://' . $_GET['shop'] . '/admin/apps/sleek-options',
                    'billing_on' => null,
                    'test' => $_GET['t'],
                    'activated_on' => null,
                    'trial_ends_on' => null,
                    'cancelled_on' => null,
                    'trial_days' => 30,
                    'decorated_return_url' => 'https://' . $_GET['shop'] . '/admin/apps/sleek-options?charge_id=' . $charge_id,
                ),
            );

            $activate = $this->Shopify->shopify_call($token, $shop, "/admin/api/2020-04/recurring_application_charges/" . $charge_id . "/activate.json", $array, 'POST');
            $activate = json_decode($activate['response'], JSON_PRETTY_PRINT);


            $active_shop = array(
                'type' => 'RECURRING',
                'name' => $plan,
                'price' => 19.99,
                'bill_interval' => 'EVERY_30_DAYS',
                'capped_amount' => 19.99,
                'terms' => 'NO_TERMS',
                'trial_days' => '30',
                'test' => $_GET['t'],
                'on_install' => 1,
                'created_at' => '',
                'updated_at' => time(),

            );
            $this->db->where('shop', str_replace(".myshopify.com", "", $_GET['shop']))->set($active_shop)->update('shops');

            $this_script = '/admin/api/2020-04/recurring_application_charges.json';

            $script_exists = $this->Shopify->shopify_call($token, $shop, $this_script, array(), 'GET');
            $script_exists = json_decode($script_exists['response'], true);

            foreach ($script_exists['recurring_application_charges'] as $key => $fetch) :
                if ($fetch['id'] != $charge_id) {
                    $del_url = '/admin/api/2020-04/recurring_application_charges/' . $fetch['id'] . '.json';
                    $del = $this->Shopify->shopify_call($token, $shop, $del_url, array(), 'DELETE');
                    $del = json_decode($del['response'], true);
                }

            endforeach;

            echo '<script>top.window.location="' . $array['recurring_application_charge']['decorated_return_url'] . '";</script>';
        }
    }

    public function add_tag($shop, $token)
    {
        // SCRIPT TAGS
        $this_script = '/admin/api/2020-04/script_tags.json';
        $script_tags_url = "/admin/api/2020-04/script_tags.json";

        $script_exists = $this->Shopify->shopify_call($token, $shop, $this_script, array('fields' => 'id,src,event,created_at,updated_at,'), 'GET');
        $script_exists = json_decode($script_exists['response'], true);

        foreach ($script_exists['script_tags'] as $key => $fetch) {
            $delete_script = $this->Shopify->shopify_call($token, $shop, '/admin/api/2020-04/script_tags/' . $fetch['id'] . '.json', array('fields' => 'id,src,event,created_at,updated_at,'), 'DELETE');
            $delete_script = json_decode($delete_script['response'], true);
            echo '<script>console.log(' . json_encode($delete_script) . ');</script>';
        }
        $script_array = array(
            'script_tag' => array(
                'event' => 'onload',
                'src' => base_url() . 'assets/js/shopify.js',
                'display_scope' => 'all'
            ),
        );

        $scriptTag = $this->Shopify->shopify_call($token, $shop, $script_tags_url, $script_array, 'POST');
        $scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);

        echo 'Automatic script tag succesfully added';
    }

    public function remove_tag($shop, $token)
    {
        // SCRIPT TAGS
        $this_script = '/admin/api/2020-04/script_tags.json';
        $script_tags_url = "/admin/api/2020-04/script_tags.json";

        $script_exists = $this->Shopify->shopify_call($token, $shop, $this_script, array('fields' => 'id,src,event,created_at,updated_at,'), 'GET');
        $script_exists = json_decode($script_exists['response'], true);

        // REMOVE OLD SCRIPT TAGS
        foreach ($script_exists['script_tags'] as $key => $fetch) {
            $delete_script = $this->Shopify->shopify_call($token, $shop, '/admin/api/2020-04/script_tags/' . $fetch['id'] . '.json', array('fields' => 'id,src,event,created_at,updated_at,'), 'DELETE');
            $delete_script = json_decode($delete_script['response'], true);
        }
        echo 'Automatic script tag succesfully removed';
    }

    public function get_app()
    {
        echo '<!DOCTYPE html><html lang="en"><head> <title>Sleek Upsell — Installation</title> <meta http-equiv="x-ua-compatible" content="ie=edge"> <meta name="viewport" content="width=device-width, initial-scale=1"> <style>*{-moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;}body{padding: 2.5em 0; color: #212b37; font-family: -apple-system,BlinkMacSystemFont,San Francisco,Roboto,Segoe UI,Helvetica Neue,sans-serif;}.container{width: 100%; text-align: center; margin-left: auto; margin-right: auto;}@media screen and (min-width: 510px){.container{width: 510px;}}.title{font-size: 1.5em; margin: 2em auto; display: flex; align-items: center; justify-content: center; word-break: break-all;}.subtitle{font-size: 0.8em; font-weight: 500; color: #64737f; line-height: 2em;}.error{line-height: 1em; padding: 0.5em; color: red;}input.marketing-input{width: 100%; height: 52px; padding: 0 15px; box-shadow: 0 0 0 1px #ddd; border: 0; border-radius: 5px; background-color: #fff; font-size: 1em; margin-bottom: 15px;}input.marketing-input:focus{color: #000; outline: 0; box-shadow: 0 0 0 2px #5e6ebf;}button.marketing-button{display: inline-block; width: 100%; padding: 1.0625em 1.875em; background-color: #5e6ebf; color: #fff; font-weight: 700; font-size: 1em; text-align: center; outline: none; border: 0 solid transparent; border-radius: 5px; cursor: pointer;}button.marketing-button:hover{background: linear-gradient(to bottom, #5c6ac4, #4959bd); border-color: #3f4eae;}button.marketing-button:focus{box-shadow: 0 0 0.1875em 0.1875em rgba(94,110,191,0.5); background-color: #223274; color: #fff;}</style></head><body> <main class="container" role="main"> <h3 class="title"> Sleek Upsell </h3> <p class="subtitle"> <label for="shop">Enter your shop domain to log in or install this app.</label> </p><form action="' . base_url('install') . '" accept-charset="UTF-8" method="post"><input type="hidden" name="authenticity_token" value="' . sha1(md5('nehN7kwK9YR++yH5VIG2I0C2wMNMYReLqtJAuhRimoqM3wmzPwV24KDKaOy1aGnKPBYeWoiDOuldhtvdcA73Ww==')) . '"/> <input id="shop" name="shop" type="text" autofocus="autofocus" placeholder="example.myshopify.com" class="marketing-input"> <button type="submit" class="marketing-button">Install</button></form> </main></body></html>';
    }

    public function new_options($shop, $token)
    {
        $data['token'] = $token;
        $data['shop'] = $shop;
        $data['page_name'] = "new_options";
        $this->load->view('index', $data);
    }

    public function edit_options($title, $product, $shop, $token)
    {
        $currency = $this->Shopify->shopify_call($token, $shop, "/admin/api/2020-04/shop.json", array('fields' => 'currency'), 'GET');
        $currency = json_decode($currency['response'], true);

        $data['currency'] = $currency['shop']['currency'];

        if ($this->db->where('product_id', $product)->get('options')->num_rows() == 0) {
            $data['option'] = array();
            $data['options'] = array();
            $data['choices'] = array();
        } else {
            $option = $this->db->where('shop', $shop)->where('product_id', $product)->get('options')->row();
            $options = $this->db->where('pid', $product)->get('cfs')->result_array();
            $choices = $this->db->where('pid', $product)->get('choices')->result_array();

            $data['option'] = $option;
            $data['options'] = $options;
            $data['choices'] = $choices;
        }

        $data['token'] = $token;
        $data['shop'] = $shop;
        $data['product'] = $product;
        $data['title'] = $title;
        $data['page_name'] = "edit_options";
        $this->load->view('index', $data);
    }

    public function options($shop, $product)
    {

        $shop_name = str_replace(".myshopify.com", "", $shop);

        if ($this->db->where('shop', $shop_name)->get('shops')->num_rows() == 0) {
            $options = array();
        } else {
            $token = $this->db->where('shop', $shop_name)->get('shops')->row()->token;
            $i = 0;
        }

        $options['option'] = $this->db->where('shop', $shop_name)->where('product_id', $product)->get('options')->row();
        $options['choices'] = $this->db->where('pid', $product)->get('cfs')->result_array();
        $options['fields'] = $this->db->where('pid', $product)->get('choices')->result_array();

        header('Content-Type: application/json');
        header('X-Shopify-Access-Token: ' . $token);
        echo json_encode($options);
    }

    public function variants($product, $token, $shop)
    {
        $variants = $this->Shopify->shopify_call($token, $shop, "/admin/api/2020-04/products/" . $product . "/variants.json", array('fields' => 'id'), 'GET');
        $variants = json_decode($variants['response'], JSON_PRETTY_PRINT);

        header('Content-Type: application/json');
        header('X-Shopify-Access-Token: ' . $token);
        echo json_encode($variants);
    }

    public function product_details($product, $token, $shop)
    {
        $product_url = '/admin/api/2020-04/products/' . $product . '.json';
        $product_data = $this->Shopify->shopify_call($token, $shop, $product_url, array('fields' => 'id,title,image'), 'GET');
        $product_data = json_decode($product_data['response'], JSON_PRETTY_PRINT);

        header('Content-Type: application/json');
        header('X-Shopify-Access-Token: ' . $token);
        echo json_encode($product_data);
    }

    public function search_products()
    {
        $html = '';
        $search_term = $this->input->post('term');
        $shop = $this->input->post('shop');
        $token = $this->input->post('token'); //replace with your access token

        if ($search_term == "") {
            $products = $this->Shopify->shopify_call($token, $shop, '/admin/api/2020-04/products.json', array('limit' => '10'), 'GET');
            $products = json_decode($products['response'], JSON_PRETTY_PRINT);
        } else {
            $array = array(
                'limit' => '10',
                'fields' => 'id,title,variants',
            );
            $products = $this->Shopify->shopify_call($token, $shop, "/admin/api/2020-04/products.json", $array, 'GET');
            $products = json_decode($products['response'], JSON_PRETTY_PRINT);
        }

        if (empty($products)) {
            $html = "<p>There's no product matching $search_term </p>";
        } else {
            foreach ($products as $product) {
                foreach ($product as $key => $value) {
                    if (stripos($value['title'], $search_term) !== false) {

                        $images = $this->Shopify->shopify_call($token, $shop, "/admin/api/2020-04/products/" . $value['id'] . "/images.json", array(), 'GET');
                        $images = json_decode($images['response'], JSON_PRETTY_PRINT);
                        $item_default_image = $images['images'][0]['src'];

                        $html .= '<div class="col-xs-12" style="margin-top: 10px; padding-bottom: 5px; border-bottom: 1px solid #C0C0C0;">';
                        $html .= '<div class="col-xs-12"><span class="pull-left" style="font-weight: bold; font-size: 18px; color: #333333;">' . $value['title'] . '</span> <span class="pull-right btn btn-primary btn-sm btn-icon icon-right" onclick="addAll(\'' . $value['id'] . '\')"><i style="color: #fff;" class="entypo-plus"></i> Add All variants</span></div>';
                        $html .= '<div class="col-xs-4" style="vertical-align: middle;"><img src="' . $item_default_image . '" class="img-rounded img-responsive" /></div>';
                        $html .= '<div class="col-xs-8" style="vertical-align: middle;">';

                        foreach ($value['variants'] as $variant) {
                            $html .= '
                                        <div class="col-xs-12" style="padding-top: 5px; paddign-bottom: 5px;">
                                            <div class="col-xs-10">' . $value['title'] . '-' . $variant['title'] . '</div>
                                            <div class="col-xs-2">
                                                <span class="btn btn-info btn-xs entypo-plus" style="color: #fff;" onclick="addVariant(\'' . $value['id'] . '\', \'' . $variant['id'] . '\')"></span>
                                            </div>
                                        </div>';
                        }

                        $html .= '</div>';
                        $html .= '</div>';
                        // print_r($value);

                        // foreach($value['variants'] as $variant){
                        //         $html .= '
                        //         <div class="col-xs-12" style="padding-top: 5px; paddign-bottom: 5px;">
                        //                 <div class="col-xs-10">'.$value['title'] .'-'. $variant['title'].'</div>
                        //                 <div class="col-xs-2">
                        //                         <span class="btn btn-info btn-sm entypo-plus" style="color: #fff;" onclick="addVariant('.$variant['id'].')"></span>
                        //                 </div>
                        //         </div>';
                        // }
                    }
                }
            }
        }

        echo $html;
    }

    public function search_condition()
    {
        $html = '';
        $type = $this->input->post('type');
        $search_term = $this->input->post('item');
        $shop = $this->input->post('shop');
        $token = $this->input->post('token'); //replace with your access token

        if ($search_term == "") {
        } else {
            $array = array(
                'limit' => '10',
                'fields' => 'id,title,variants',
            );
            if ($type == 'product') {
                $products = $this->Shopify->shopify_call($token, $shop, "/admin/api/2020-04/products.json", $array, 'GET');
                $products = json_decode($products['response'], JSON_PRETTY_PRINT);
                if (empty($products)) {
                    $html = "<p>There's no product matching $search_term </p>";
                } else {
                    foreach ($products as $product) {
                        foreach ($product as $key => $value) {
                            if (stripos($value['title'], $search_term) !== false) {
                                $html .= '<div onclick="$(\'.occ\').val(\'' . $value['id'] . '\');$(\'.c_i\').html(\'\');$(\'#ocContent\').val(\'' . $value['title'] . '\');" class="col-xs-12" style="cursor: pointer; margin-top: 10px; padding-bottom: 5px; border-bottom: 1px solid #C0C0C0;"><span class="pull-left" style="color: #333333;">' . $value['title'] . '</span></div>';
                            }
                        }
                    }
                }
            }
            if ($type == 'variant') {
                $products = $this->Shopify->shopify_call($token, $shop, "/admin/api/2020-04/products.json", $array, 'GET');
                $products = json_decode($products['response'], JSON_PRETTY_PRINT);
                if (empty($products)) {
                    $html = "<p>There's no variant matching $search_term </p>";
                } else {
                    foreach ($products as $product) {
                        foreach ($product as $key => $value) {
                            if (stripos($value['title'], $search_term) !== false) {
                                foreach ($value['variants'] as $variant) {
                                    $html .= '<div onclick="$(\'.occ\').val(\'' . $variant['id'] . '\');$(\'.c_i\').html(\'\');$(\'#ocContent\').val(\'' . $value['title'] . ' ' . $variant['title'] . '\');" class="col-xs-12" style="cursor: pointer; margin-top: 10px; padding-bottom: 5px; border-bottom: 1px solid #C0C0C0;"><span class="pull-left" style="color: #333333;">' . $value['title'] . ' ' . $variant['title'] . '</span></div>';
                                }
                            }
                        }
                    }
                }
            }
            if ($type == 'collection') {
                $collections = $this->Shopify->shopify_call($token, $shop, "/admin/api/2020-04/custom_collections.json", $array, 'GET');
                $collections = json_decode($collections['response'], JSON_PRETTY_PRINT);
                if (empty($collections)) {
                    $html = "<p>There's no collection matching $search_term </p>";
                } else {
                    foreach ($collections as $collection) {
                        foreach ($collection as $key => $value) {
                            if (stripos($value['title'], $search_term) !== false) {
                                $html .= '<div onclick="$(\'.occ\').val(\'' . $value['id'] . '\');$(\'.c_i\').html(\'\');$(\'#ocContent\').val(\'' . $value['title'] . '\');" class="col-xs-12" style="cursor: pointer; margin-top: 10px; padding-bottom: 5px; border-bottom: 1px solid #C0C0C0;"><span class="pull-left" style="color: #333333;">' . $value['title'] . '</span></div>';
                            }
                        }
                    }
                }
            }
        }

        echo $html;
    }

    public function create_options($product_id, $shop)
    {

        $option = $this->input->post('option');
        $options = $this->input->post('options');
        $choices = $this->input->post('choices');

        foreach ($options as $o) {
            print_r($o);
        }
        foreach ($choices as $c) {
            print_r($c);
        }


        if ($this->db->where('product_id', $product_id)->get('options')->num_rows() == 0) {
            echo $option['product_id'];
            if ($this->db->insert('options', $option)) {
                foreach ($options as $o) {
                    $this->db->set($o)->insert('cfs');
                }
                foreach ($choices as $c) {
                    $this->db->set($c)->insert('choices');
                }
                echo 'Successful created options';
            } else {
                echo 'Couldn\'t add option to db';
            }
        } else {
            if ($this->db->set($option)->where('product_id', $product_id)->update('options')) {
                $this->db->where('pid', $product_id)->delete('cfs');
                $this->db->where('pid', $product_id)->delete('choices');

                foreach ($options as $o) {
                    $this->db->set($o)->insert('cfs');
                }
                foreach ($choices as $c) {
                    $this->db->set($c)->insert('choices');
                }
                echo 'Successfully updated options';
            } else {
                echo 'Couldn\'t add option to db';
            }
        }
    }

    public function new_table()
    {
        $this->db->query('DROP TABLE IF EXISTS `options`');
        $query = '
        CREATE TABLE IF NOT EXISTS `options` (
            `option_id` int(11) NOT NULL AUTO_INCREMENT,
            `product_id` text NOT NULL,
            `product_options` longtext NOT NULL,
            `shop` text NOT NULL,
            `option_date` int(11) NOT NULL,
            PRIMARY KEY (`option_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;';

        if ($this->db->query($query)) {
            $this->db->query('TRUNCATE TABLE `options`');
            $this->db->query('COMMIT;');
            echo 'table created';
        }
    }

    public function subscription($shop, $token)
    {
        $data['token'] = $token;
        $data['shop'] = $shop;

        $data['page_name'] = 'subscription';
        $this->load->view('index', $data);
    }

    public function mf($shop)
    {
        $shop_name = str_replace(".myshopify.com", "", $shop);
        $token = $this->db->where('shop', $shop_name)->get('shops')->row()->token;

        $shop_json = '/admin/api/2020-04/shop.json';
        $shop_j = $this->Shopify->shopify_call($token, $shop_name, $shop_json, array('fields' => 'money_format'), 'GET');
        $shop_j = json_decode($shop_j['response'], true);

        header('Content-Type: application/json');
        header('X-Shopify-Access-Token: ' . $token);

        $shop_j = $shop_j['shop']['money_format'];
        $shop_j = str_replace('<span class="money">', '', $shop_j);
        $shop_j = str_replace('</span>', '', $shop_j);
        echo $shop_j;
    }
}
