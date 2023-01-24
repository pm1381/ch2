<?php
use App\Classes\Session;
?>

<?php require_once VIEW . 'site\components\top.php'; ?>

<form method="post" action=".">
    <div class="card">
        <article class="card-body">
            <h4 class="card-title text-center mb-4 mt-1">login</h4>
            <hr>
            <?php $session = new Session();?>
            <p class="text-danger text-center"><?php echo $session->getFlash('error') ?></p>
            <form>
            <div class="form-group ">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                </div>
                <input name="email" class="form-control" placeholder="Email..." type="email" >
            </div>
            </div>
            <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                </div>
                <input name="password" class="form-control" placeholder="password" type="password">
            </div>
            </div>
            <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block"> login  </button>
            </div>
            <p class="text-center"><a href="<?php echo ORIGIN . '/password/reset/' ?>" class="btn">Forgot password?</a></p>
            </form>
        </article>
    </div>
</div>
</div>
</form>
<?php require_once VIEW . 'site\components\footer.php'; ?>
