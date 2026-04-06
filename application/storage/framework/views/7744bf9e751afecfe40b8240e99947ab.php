
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo app('translator')->get('Deposit with Stripe'); ?></title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
<?php
    $publishable_key = $data->StripeJSAcc->publishable_key;
    $sessionId = $data->session->id;

?>

<script>
    "use strict";
    var stripe = Stripe('<?php echo e($publishable_key); ?>');
        stripe.redirectToCheckout({
        sessionId: '<?php echo e($sessionId); ?>'
    });
</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\user\payment\StripeV3.blade.php ENDPATH**/ ?>