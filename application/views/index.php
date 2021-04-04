<!DOCTYPE html>
<html>

<head>
    <?php include 'header.php';?>

    <!--script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
	<script type="text/javascript">
		ShopifyApp.init({
			apiKey: '<?php #echo $api_key; ?>',
			shopOrigin: '<?php #echo 'https://'  . $_COOKIE['shop']. '.myshopify.com'; ?>'
            });
	</script>
	<script type="text/javascript">
		ShopifyApp.ready(function () {
			ShopifyApp.Bar.initialize({
				buttons: {
					primary: {
						label: 'Save',
						message: 'unicorn_form_submit',
						loading: true
					}
				}
			});
		});
	</script-->
</head>

<body class="page-body skin-blue gray" data-url="<?php echo base_url(); ?>"
    data-shop-url="https://<?php echo $shop; ?>.myshopify.com/">
    <script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
    var shop_url = 'https://<?php echo $shop; ?>.myshopify.com';
    </script>
    <div class="page-container">
        <div class="main-content">
            <!-- <div class="row">
                <?php if ($page_name == 'dashboard'): ?>
                
                <?php endif;?>
                <?php if ($page_name == 'new_options' || $page_name == 'edit_options'): ?>
                    <div class="col-md-6 col-sm-8 clearfix">
                        <ul class="user-info pull-left pull-right-xs pull-none-xsm">
                            <li>
                                <span class="btn btn-success btn-sm btn-icon icon-right" onclick="window.history.back();"> <i class="entypo-home"></i>HOME</span>
                            </li>
                        </ul>
                    </div>
                <?php endif;?>
            </div>
            <hr /> -->
            <?php include $page_name . '.php';?>
            <div style="height: 100px;"></div>
        </div>
    </div>

    <style>
    .footer {
        position: fixed;
        bottom: 0px;
        background-color: white;
        width: 100%;
        border-top: 1px solid #ECECEC;
        padding-top: 15px;
        padding-bottom: 15px;
    }
    </style>

    <?php include 'footer.php';?>
</body>

</html>