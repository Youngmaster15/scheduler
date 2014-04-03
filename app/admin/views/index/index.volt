<!-- start of the home content -->
<div id="home" class="row-fluid">
    <?php if (isset($success)) : ?>
    <div class="alert <?php echo  ($success) ? 'alert-success' : 'alert-danger' ?>">
        <?php echo $message ?>
    </div>
    <?php endif ?>
    <div class="col-md-12">
        <h1>Congratulations!</h1>

        <p>You're now flying with Phalcon. Great things are about to happen!</p>
		
		<p> We have something new here! </p>
		
		<span> revision started here </span>
    </div>
</div>
<!-- end of the home content -->

