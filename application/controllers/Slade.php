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

            if ($this->db->where('shop', $shop)->get('offers')->num_rows() > 0) {
                $offers = $this->db->where('shop', $shop)->get('offers')->result_array();
                foreach ($offers as $key => $value) {
                    $oid = $value['offer_id'];
                    $data['offer'][$oid]['offer'] = $this->db->where('offer_id', $oid)->get('offers')->result_array();
                    $data['offer'][$oid]['products'] = $this->db->where('offer', $oid)->get('products')->result_array();
                    $data['offer'][$oid]['variants'] = $this->db->where('oid', $oid)->get('variants')->result_array();
                    $data['offer'][$oid]['blocks'] = $this->db->where('oid', $oid)->get('cbs')->result_array();
                    $data['offer'][$oid]['conditions'] = $this->db->where('oid', $oid)->get('ocs')->result_array();
                    $data['offer'][$oid]['fields'] = $this->db->where('oid', $oid)->get('cfs')->result_array();
                    $data['offer'][$oid]['choices'] = $this->db->where('oid', $oid)->get('choices')->result_array();
                }
            } else {
                $data['offer'] = array();

                $s_mail = $this->Shopify->shopify_call($token, $shop, '/admin/api/2020-04/shop.json', array('fields' => 'email'), 'GET');
                $s_mail = json_decode($s_mail['response'], true);

                $data['email'] = $s_mail['shop']['email'];
                if ($shop_data->created_at == '') {
                }
            }


            $products = $this->Shopify->shopify_call($token, $this_shop, "/admin/api/2020-04/products.json", array('fields' => 'id,title,variants'), 'GET');
            $params['products'] = json_decode($products['response'], true);

            $data['options'] = $this->db->where('shop', $shop)->get('options')->result_array();
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

            $shop_data = array(
                'shop' => $shop,
                'token' => $access_token,
                'date' => time(),
            );

            if ($this->db->table_exists('shops')) {
                if ($this->db->where('shop', $shop)->get('shops')->num_rows() == 0) {
                    $this->db->insert('shops', $shop_data);
                } else {
                    $this->db->where('shop', $shop)->update('shops', array('token' => $access_token, 'date' => time()));
                }
            } else {
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
            echo '<script>window.location.href = "https://' . $params['shop'] . '/admin/apps/sleek-options";</script>';
        } else {
            // Someone is trying to be shady!
            header("Location: http://ebonymgp.com");
            die('This request is NOT from Shopify!');
        }
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
            $data['options'] = array();
        } else {
            $options = $this->db->where('shop', $shop)->where('product_id', $product)->get('options')->row();
            $data['options'] = json_decode($options->product_options, true);
        }
        $data['token'] = $token;
        $data['shop'] = $shop;
        $data['product'] = $product;
        $data['title'] = $title;
        $data['page_name'] = "edit_options";
        $this->load->view('index', $data);
    }

    public function install()
    {
        $shop = $_GET['shop'];
        $api_key = $this->config->item('shopify_api_key');
        $scopes = "read_orders,write_orders,read_draft_orders,read_content,write_content,read_products,write_products,read_product_listings,read_customers,write_customers,read_inventory,write_inventory,read_locations,read_script_tags,write_script_tags,read_themes,write_themes,read_shipping,write_shipping,read_analytics,read_checkouts,write_checkouts,read_reports,write_reports,read_price_rules,write_price_rules,read_discounts,write_discounts,read_resource_feedbacks,write_resource_feedbacks,read_translations,write_translations,read_locales,write_locales";
        $redirect_uri = base_url() . "generate_token";

        // Build install/approval URL to redirect to
        $install_url = "https://" . $shop . ".myshopify.com/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);
        // Redirect
        header("Location: " . $install_url);
        die();
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

        $options = $this->db->where('shop', $shop_name)->where('product_id', $product)->get('options')->row();
        $options = $options;

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

    public function create_options()
    {

        $product_id = $_POST['product_id'];
        $product_options = $_POST['product_options'];
        $shop = $_POST['shop'];
        $option_date = $_POST['option_date'];

        $option_data = array(
            'product_id' => $product_id,
            'product_options' => $product_options,
            'shop' => $shop,
            'option_date' => $option_date
        );

        print_r($option_data);

        if ($this->db->where('product_id', $product_id)->get('options')->num_rows() == 0) {
            if ($this->db->insert('options', $option_data)) {
                echo 'Success';
            } else {
                echo 'Couldn\'t add option to db';
            }
        } else {
            if ($this->db->set($option_data)->where('product_id', $product_id)->update('options')) {
                echo 'Success';
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

    public function ole($shop, $token)
    {
        $data['token'] = $token;
        $data['shop'] = $shop;
        $data['page_name'] = "ole";
        $this->load->view('index', $data);
    }
}
