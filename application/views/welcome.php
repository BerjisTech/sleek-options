<!DOCTYPE html>
<html>

<head>
	<?php include 'header.php'; ?>

	<script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
	<script type="text/javascript">
		ShopifyApp.init({
			apiKey: '<?php echo $api_key; ?>',
			shopOrigin: '<?php echo 'https://'  . $shop; ?>' 
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
	</script>
</head>

<body class="page-body skin-blue gray" data-url="https://sleek-upsell.herokuapp.com/">
    <script type="text/javascript">
		var base_url = 'https://sleek-upsell.herokuapp.com/';
        firebase.auth().onAuthStateChanged(function(user) {
        if (user) {
            // User is signed in.
            var displayName = user.displayName;
            var email = user.email;
            var emailVerified = user.emailVerified;
            var photoURL = user.photoURL;
            var isAnonymous = user.isAnonymous;
            var uid = user.uid;
            var providerData = user.providerData;
            // ...
        } else {
            // User is signed out.
            // ...
        }
        });

	</script>
	<div class="page-container">
		<div class="main-content">
			<div class="row">
				<div class="col-md-6 col-sm-8 clearfix">
                    <ul class="user-info pull-left pull-none-xsm">
						<li class="profile-info dropdown">
							<span class="btn btn-primary btn-sm btn-icon icon-right dropdown-toggle" data-toggle="dropdown"> <i class="entypo-cog"></i>Settings</span>
                            <ul class="dropdown-menu">
                                <!-- Reverse Caret -->
                                <li class="caret"></li> <!-- Profile sub-links -->
                                <li> <a href="https://demo.neontheme.com/extra/timeline/"> <i class="entypo-user"></i>
                                        Offer settings
                                    </a> </li>
                                <li> <a href="https://demo.neontheme.com/mailbox/main/"> <i class="entypo-mail"></i>
                                        Set up wizard
                                    </a> </li>
                                <li> <a href="https://demo.neontheme.com/extra/calendar/"> <i class="entypo-calendar"></i>
                                        Subscription
                                    </a> </li>
                                <li> <a href="#"> <i class="entypo-clipboard"></i>
                                        Catalog
                                    </a> </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="user-info pull-left pull-right-xs pull-none-xsm">
                        <li> 
							<span class="btn btn-success btn-sm btn-icon icon-right"> <i class="entypo-plus"></i>New Offer</span>
                        </li>
                        <li> 
							<span class="btn btn-info btn-sm btn-icon icon-right"> <i class="entypo-chart-line"></i>Stats</span>
                        </li>
                    </ul>
                </div> <!-- Raw Links -->
                <div class="col-md-6 col-sm-4 clearfix hidden-xs">
                    <ul class="list-inline links-list pull-right">
                        <li class="dropdown language-selector">
                            Language: &nbsp;
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true"> <img src="https://demo.neontheme.com/assets/images/flags/flag-uk.png" width="16" height="16" /> </a>
                            <ul class="dropdown-menu pull-right">
                                <li> <a href="#"> <img src="https://demo.neontheme.com/assets/images/flags/flag-de.png" width="16" height="16" /> <span>Deutsch</span> </a> </li>
                                <li class="active"> <a href="#"> <img src="https://demo.neontheme.com/assets/images/flags/flag-uk.png" width="16" height="16" /> <span>English</span> </a> </li>
                                <li> <a href="#"> <img src="https://demo.neontheme.com/assets/images/flags/flag-fr.png" width="16" height="16" /> <span>François</span> </a> </li>
                                <li> <a href="#"> <img src="https://demo.neontheme.com/assets/images/flags/flag-al.png" width="16" height="16" /> <span>Shqip</span> </a> </li>
                                <li> <a href="#"> <img src="https://demo.neontheme.com/assets/images/flags/flag-es.png" width="16" height="16" /> <span>Español</span> </a> </li>
                            </ul>
                        </li>
                        <li class="sep"></li>
                        <li> <a href="#" data-toggle="chat" data-collapse-sidebar="1"> <i class="entypo-chat"></i>
                                Chat
                                <span class="badge badge-success chat-notifications-badge is-hidden">0</span> </a> </li>
                        <li class="sep"></li>
                        <li class="btn btn-primary btn-sm btn-icon icon-right"> Need help <i class="entypo-help right"></i> </a> </li>
                    </ul>
                </div>
			</div>
			<hr />
			<?php include $page_name.'.php'; ?>
		</div>
	</div>

	<?php include 'footer.php'; ?>
</body>

</html>