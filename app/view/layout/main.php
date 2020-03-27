<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $this->title; ?></title>
    <meta name="description" content="<?php echo $this->description; ?>">

    <link rel=icon href="/app/view/assets/img/favicon.svg" sizes="any" type="image/svg+xml">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">
    <link rel="stylesheet" href="/app/view/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/app/view/assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="/app/view/assets/css/style.css"/>
    <link rel="stylesheet" href="/app/view/assets/css/templatemo-style.css">

    <script type="text/javascript" src="/app/view/assets/js/modernizr.custom.86080.js"></script>
	<?php echo $this->topAssets ?>
</head>
<body>

<?php echo $this->content ?>

<script type="text/javascript" src="/app/view/assets/js/particles.js"></script>
<script type="text/javascript" src="/app/view/assets/js/app.js"></script>
<?php echo $this->bottomAssets ?>
</body>
</html>
