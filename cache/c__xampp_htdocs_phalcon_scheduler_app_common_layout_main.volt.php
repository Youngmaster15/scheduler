<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="" type="image/x-icon" />
    <meta charset="utf-8" />
    <meta name="msvalidate.01" content="40860020863DFCB8D035621129A6413F" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php /*
    <title><?php echo $title; ?></title>
        <?php foreach ($css as $c) { ?>
            <?php echo $this->tag->stylesheetLink($c); ?>
        <?php } ?>

        <?php foreach ($less as $l) { ?>
            <link rel="stylesheet/less" href="<?php echo $l; ?>" type="text/css" />
        <?php } ?>

        <script src="<?php echo $this->url->get("public/js/global.js") ?>"></script>

        <!--load script -->
        <?php foreach ($js as $j) { ?>
            <?php echo $this->tag->javascriptInclude($j); ?>
        <?php } ?>

        <script>
            var base_url = "<?php echo $this->url->getBaseUri() ?>";

            <?php //hack for ie8 ?>
             document.createElement('header');
             document.createElement('nav');
             document.createElement('menu');
             document.createElement('section');
             document.createElement('article');
             document.createElement('aside');
             document.createElement('footer');
        </script>
        */?>
</head>
<body>
    <!-- start of container -->
    <div class="full-width-container">
        <!-- start of header-->
        <header id="header">
            <?php /*<?php echo $header; ?>*/ ?>
        </header>
        <!-- end of header -->

        <!-- start of body-->
        <div class ="body-content container">
           <?php echo $this->getContent(); ?>
        </div>
        <!-- end of header -->

    </div>
    <!-- end of  container -->

    <!-- start of footer -->
    <footer id="footer">
         <?php /*<?php echo $footer; ?>*/ ?>
    </footer>
    <!-- end of footer -->

    <!-- script loading for bootstrap js -->
    <script src="<?php echo $this->url->get('public/js/bootstrap/bootstrap.min.js')?>"></script>

    <!-- script loading for less -->
    <script src="<?php echo $this->url->get('public/js/less.js')?>"></script>

    <!-- personal scripting-->
    <script>
        $(document).ready(function(e) {

        });
    </script>

</body>
</html>