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
                <li class=""><a href="" id="login" data-toggle="modal" data-target=".login">Login</a></li>
            </ul>
            <!-- end of the links-->
        </div>
        <!-- start of the login modal -->
        <div class="modal fade login not-overflow" id="" tabindex="-1" role="dialog" aria-labelledby="LoginModal" aria-hidden="true">
            <form action="<?php echo $this->url->get('index/index/') ?>" method="POST">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Scheduler Login</h4>
                  </div>
                  <div class="modal-body">
                    <ul class="list-none">
                    <input type="hidden" name="<?php echo $this->security->getTokenKey() ?>" value="<?php echo $this->security->getToken() ?>"/>
                        <li class="row-fluid">
                            <label for="username">
                                <p class="">Username : </p>
                                <input type="text" maxlength="50" placeholder="Username" class="form-control" name="username" />
                            </label>
                        </li>
                        <li class="row-fluid">
                            <label for="password">
                                <p class=""> Password : </p>
                                <input type="password" maxlength="50" class="form-control" placeholder="Password" name="password" />
                            </label>
                        </li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Login</button>
                  </div>
                </div>
              </div>
            </form>
        </div>
        <!-- end of the login modal -->
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