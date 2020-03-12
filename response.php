<?php
require 'bootstrap.php';
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
    if (empty($_GET['paymentId']) || empty($_GET['PayerID'])) {
        throw new Exception('The response is missing the paymentId and PayerID');
    }
    $paymentId = $_GET['paymentId'];
    $payment = Payment::get($paymentId, $apiContext);
    $execution = new PaymentExecution();
    $execution->setPayerId($_GET['PayerID']);
    try {
        // Take the payment
        $payment->execute($execution, $apiContext);
        $payment = Payment::get($paymentId, $apiContext);
        if ($payment->getState() === 'approved') {
            // Payment successfully added, redirect to the payment complete page.
           // echo "<pre>";
            //print_r($execution->getTransactions());
            //echo "</pre>";
            header('location:success.php');
            exit(1);
        } else {
            header('location:error.html');
            exit(1);

        }
    } catch (Exception $e) {
        header('location:error.html');
        exit(1);
    }

?>
