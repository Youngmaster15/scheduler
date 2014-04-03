<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="" type="image/x-icon" />
    <meta charset="utf-8" />
    <meta name="msvalidate.01" content="40860020863DFCB8D035621129A6413F" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ title }}</title>
        {% for c in css %}
            {{ stylesheet_link(c) }}
        {% endfor %}

        {% for l in less %}
            <link rel="stylesheet/less" href="{{ l }}" type="text/css" />
        {% endfor %}

        <!-- load jQuery -->
        {{ javascript_include("public/js/global1.10.js") }}

        <!--load script -->
        {% for j in js %}
            {{ javascript_include(j) }}
        {% endfor %}

         <!-- script loading for less -->
        {{ javascript_include("public/js/less/less.js") }}

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
</head>
<body>
    <!-- start of container -->
    <div class="full-width-container container-fluid">
        <!--start of the 700px container -->
        <div class="container-700px main-container">
             <!-- start of header-->
            <header id="header">
                {{ header }}
            </header>
            <!-- end of header -->

            <!-- start of body-->
            <div class="body-content">
               {{ content() }}
            </div>
            <!-- end of body -->

        </div>
        <!--end of the 700px container -->
       <!-- start of footer -->
        <footer id="footer">
                {{ footer }}
        </footer>
        <!-- end of footer -->
    </div>
    <!-- end of  container -->

    <!-- script loading for bootstrap js -->
    {{ javascript_include("public/js/bootstrap/bootstrap.min.js") }}
    <!-- personal scripting-->
    <script>
        $(document).ready(function(e) {

        });
    </script>

</body>
</html>