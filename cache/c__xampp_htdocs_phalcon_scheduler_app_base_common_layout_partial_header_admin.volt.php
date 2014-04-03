<!--- start of the header section -->
<div class="header">
        <div class="header-wrapper">
            <!-- start of the logo -->
            <div class="logo pull-left">
               <h3><a href="<?php echo $this->url->getBaseUri() ?>">  Scheduler </a>  </h3>
            </div>
            <!-- end of the logo-->
            <!-- start of the links-->
            <ul class="list-none header-nav nav pull-right">
                <li class="<?php echo ($menu_active == 'learn') ? 'active' : '' ?>"><a href="" >Learned</a></li>
                <li class="<?php echo ($menu_active == 'todo') ? 'active' : '' ?>"><a href="" >TODO</a></li>
                <?php if (! empty($user) ) : ?>
                <li class=""><a href="<?php echo $this->url->get('index/logout') ?>" ><?php echo $user['username'] ?></a></li>
                <?php endif ?>
            </ul>
            <!-- end of the links-->
        </div>

</div>
<!--- start of the header section -->
<!-- start of the script -->
<script>
    $(document).ready(function(e) {

        // once body load then we have to align the elements to fit to the width of it's parent.
        //alignMenuItems();

        //on resize we should call also the function to make it center.\
        $(window).resize(function() {
            //alignMenuItems();
        });

        //function on aligning menus.
        function alignMenuItems(){
            var totEltWidth = 0;
            var menuWidth = $('#header_menu_nav')[0].offsetWidth;
            var availableWidth = 0;
            var space = 0;

            var elts = $('#header_menu_nav li');
            elts.each(function(inx, elt) {
                // reset paddding to 0 to get correct offsetwidth
                $(elt).css('padding-left', '0px');
                $(elt).css('padding-right', '0px');

                totEltWidth += elt.offsetWidth;
            });

            availableWidth = menuWidth - totEltWidth;

            space = availableWidth/(elts.length);

            elts.each(function(inx, elt) {
                $(elt).css('padding-left', (space/2) + 'px');
                $(elt).css('padding-right', (space/2) + 'px');
            });
        }
    });
</script>
<!-- end of the script -->