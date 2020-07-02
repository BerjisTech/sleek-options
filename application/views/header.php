<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="Sleek options" />
<meta name="author" content="Berjis Technologies" />
<link rel="icon" href="<?php echo base_url(); ?>assets/images/logo.png">
<title>Sleek options | <?php echo $shop; ?> | <?php echo date('d M, Y'); ?></title>
<link rel="stylesheet"
    href="<?php echo base_url(); ?>assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css"
    id="style-resource-1">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-icons/entypo/css/entypo.css"
    id="style-resource-2">
<link rel="stylesheet"
    href="<?php echo base_url(); ?>assets/css/font-icons/font-awesome/css/font-awesome.min.css"
    id="style-resource-1">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic" id="style-resource-3">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css" id="style-resource-4">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-core.css" id="style-resource-5">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-theme.css" id="style-resource-6">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-forms.css" id="style-resource-7">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" id="style-resource-8">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/skins/blue.css" id="style-resource-9">
<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>
<!--[if lt IE 9]><script src="<?php echo base_url(); ?>/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]> <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script> <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> <![endif]-->
<style>
    .switch {
        position: relative;
        display: table;
        width: 100px;
        height: 34px;
		margin: 10px auto;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slidr {
        border-radius: 30px;
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slidr:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slidr {
        background-color: #2196F3;
    }

    input:focus+.slidr {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slidr:before {
        -webkit-transform: translateX(66px);
        -ms-transform: translateX(66px);
        transform: translateX(66px);
    }

    .slidr.round:before {
        border-radius: 50%;
    }
</style>