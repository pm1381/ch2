<?php

use App\Classes\Session;

?>

<?php require_once VIEW . 'site\components\top.php' ?>
<div class="card text-center" style="width: 100%;">
    <div class="card-header h5 text-white bg-primary">Password Reset</div>
    <?php $session = new Session;?>
    <p class="text-danger text-center"><?php echo $session->getFlash('error') ?></p>
    <div class="card-body px-5">
        <p class="card-text py-2">
            Enter your email address and we'll send you an email with instructions to reset your password.
        </p>
        <div class="form-outline">
            <form action="." method="POST">
                <input type="email" id="typeEmail" name="email" class="form-control my-3" />
                <label class="form-label" for="typeEmail">Email input</label>
                <button type="submit" class="btn btn-primary w-100">Reset password</button>
            </form>
        </div>
    </div>
</div>