<p align="center"><a href="https://applab.qa" target="_blank"><img src="https://applab.qa/wp-content/uploads/2020/11/page-logo.svg" width="400"></a></p>

<p align="center"></p>

## Sadad Payment Paltform
Sadad is a Qatari Platform to send/receive payment via online [store / Website / portal ] and mobile [applications]

Below are a full list of features:
- Web Checkout
- API Integration
    - Transactions - List Transactions 
    - Transaction - Get Single Transaction
    - Transaction - Refund Transaction

## About Applab

[AppLab](https://applab.qa/contact-us) is a leading company specialized in online platforms development. Online Platforms include Back-end, Databases, Web Applications and Mobile

## About Sadad Platform

[Sadad](https://developer.sadad.qa/) Sadad is a Qatari Platform to send/receive payment via online.

## Installing Applab Sadad

The recommended way to install Applab Sadad is through
[Composer](https://getcomposer.org/).

```bash
composer require applab/sadad
```
Publish configuration and migrations
```bash
php artisan vendor:publish --provider="Applab\Sadad\SadadServiceProvider"
```

The service provider is loaded automatically using [package discovery](https://laravel.com/docs/5.7/packages#package-discovery).
## Usage

### Configuration
The package ships with a configuration file called applab-sadad.php which is published to the config directory during installation. Below is an outline of the settings.
```bash
sadadId 
```
Issued when creating your sadad account
```bash
secretKey
```
Issued when register your domain
```bash
domain
```
Your registered domain name
### WebCheckout 2.1
Customer is on your website’s checkout page and fills up the details and places order.
```php
  $webCheckoutOneReq = new WCORequest();     
  $webCheckoutOneReq->total_amount=100;
  $webCheckoutOneReq->order_id = $webCheckoutReq->getOrderId();
  $webCheckoutOneReq->customer_mobile = "974XXXXXXXX";
  $webCheckoutOneReq->callback_url = url('sadad-purchased/'.$webCheckoutReq->order_id);      
  $products[] = [
    'id' => 123,
    'title' => "product name",
    'quantity' => 1,
    'amount' => 1,
    'type' => 'line_item'
  ];
  $webCheckoutOneReq->setProducts($products);
  return Sadad::webCheckoutOne($webCheckoutOneReq); //default view
```
exclude your callback url in verify CSRF Token middleware to get the post response from SADAD
### Merchant Integration APIs
#### Transactions List
```php
  $filters = [];
  Sadad::getTransactions($filter)
```
#### Transaction details
```php
  Sadad::getTransaction('SD33XXXXXXXXXX8')
```
#### Transaction refund
```php
  Sadad::refundTransaction('SD33XXXXXXXXXX8')
```
#### Invoices List
```php
  $filters = [];
  Sadad::getInvoices($filter)
```
#### Create Invoice
```php
  $invoiceData = new InvoiceRequest();
  $invoiceData->countryCode = '974';
  $invoiceData->cellnumber = '66XXXXXX';
  $invoiceData->clientname = 'Client name';
  // Status for Invoice
  // 1 - Draft, 2 - Unpaid, 3 - Paid, 4 - Overdue, 5 - Cancelled
  $invoiceData->status = 2;
  $invoiceData->remarks = 'Invoice test remarks';
  $invoiceData->amount = 100; // Total amount in QR

  // Invoice can have many item
  $invoice_details[] = [
      'description' => 'Testing 123',
      'quantity' => 1,
      'amount' => 100, // Amount for each item
  ];
  $invoiceData->setInvoiceDetails($invoice_details);
  $payload = $invoiceData->preparePayload()->getPayload();

  return Sadad::createInvoice($payload);
```
#### Share Invoice
```php
  // Share using mobile
  $payload = [
    'sentvia' => 4,
    'invoicenumber' => 'SD66XXXXXXXXX8',
    'receivercellno' => '66XXXXXX',
  ];
  // Share using email
  $payload = [
    'sentvia' => 3,
    'invoicenumber' => 'SD66XXXXXXXXX8',
    'receiverEmail' => 'mail@example.com',
  ];

  return Sadad::shareInvoice($payload); 
```
## Security Vulnerabilities

If you discover a security vulnerability within this package, please send an e-mail to Manu Applab via [manu@applab.qa](mailto:manu@applab.qa). All security vulnerabilities will be promptly addressed.

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
