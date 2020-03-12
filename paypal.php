<?php
require 'bootstrap.php';
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
include "items.php";
$payer = new Payer();
$payer->setPaymentMethod("paypal");

$item1 = new Item();
$item1->setName($order[0]['name'])
    ->setCurrency('USD')
    ->setQuantity(1)
    ->setSku($order[0]['id']) // Similar to `item_number` in Classic API
    ->setPrice($order[0]['price']);

$itemList = new ItemList();
$itemList->setItems(array($item1));

$details = new Details();

//subtal = tax + ship + price

$shipping = 0.01;
$tax = 0.01;

$details->setShipping($shipping)
    ->setTax($tax)
    ->setSubtotal($order[0]['price']);
// Total = shipping tax + subtotal.
//Total = tax + ship + price
$subtotal = $shipping + $tax + $order[0]['price'];
    $amount = new Amount();
    $amount->setCurrency("USD")
        ->setTotal($subtotal)
        ->setDetails($details);   


        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription($order[0]['detail'])
            ->setInvoiceNumber(uniqid());

        
$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl("http://localhost:8080/PaypalPHP/response.php")
    ->setCancelUrl("http://localhost:8080/PaypalPHP/error.html");

    $payment = new Payment();
    $payment->setIntent("sale")
        ->setPayer($payer)
        ->setRedirectUrls($redirectUrls)
        ->setTransactions(array($transaction));

        $request = clone $payment;

        try {
            $payment->create($apiContext);
        } catch (Exception $ex) {
           // ResultPrinter::printError("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", null, $request, $ex);
           // exit(1);
           throw new Exception('Unable to create link for payment');
        }

     //   $approvalUrl = $payment->getApprovalLink();

      //  ResultPrinter::printResult("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", "<a href='$approvalUrl' >$approvalUrl</a>", $request, $payment);

     // echo "<pre>";
//print_r($payment);
//echo "</pre>";
header('location:' . $payment->getApprovalLink());
exit(1);
?>
