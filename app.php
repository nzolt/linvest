#!/usr/bin/php
<?php
require __DIR__ . '/vendor/autoload.php';

use App\Exceptions;
use App\Data\Tranches\Tranch;
use App\Data\Loan\Loan;
use App\Data\Wallet\VirtualWalletFactory;

$vW1 = VirtualWalletFactory::createVirtualValet('InvestorOne', 1000);
$vW2 = VirtualWalletFactory::createVirtualValet('InvestorTwo', 1000);
$vW3 = VirtualWalletFactory::createVirtualValet('InvestorTree', 1000);
$vW4 = VirtualWalletFactory::createVirtualValet('InvestorFour', 1000);
$trA = new Tranch('A', 1000, 3.2);

$trB = new Tranch('B', 1000, 6.1);

$loan = new Loan('2020-10-01', '2020-11-15', [$trA->getTranchId() => $trA, $trB->getTranchId() => $trB]);
$loan->invest('A', $vW1, 1000, '2020-10-03');
$loan->invest('B', $vW3, 500, '2020-10-10');
$res = $loan->getInterests('2020-10-31');
// var_dump($res);
foreach($res as $vW) {
    echo 'Investor: ' . $vW->getInvestor() . PHP_EOL;
    echo 'Interest: £' . $vW->getAmount() . PHP_EOL;
    echo PHP_EOL;
}
// Throws App\Exceptions\InvalidInvestException
try {
    $loan->invest('A', $vW2, 1, '2020-10-03');
} catch (Exceptions\InvalidInvestException $e) {
    echo 'Investor: ' . $vW2->getInvestor() . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
    echo PHP_EOL;
}

$loan = new Loan('2020-10-01 00:00:00', '2020-11-15', ['A' => $trA, 'B' => $trB]);
// Throws App\Exceptions\InvalidAmountException
try {
    $loan->invest('A', $vW4, 1100, '2020-10-03');
} catch (Exceptions\InvalidAmountException $e) {
    echo 'Investor: ' . $vW4->getInvestor() . ': ' . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
    echo PHP_EOL;
}

// Tranch ended
$i = $loan->invest('A', $vW4, 100, '2020-11-23');
echo 'Investor: ' . $vW4->getInvestor() . PHP_EOL;
echo 'Successful investment: ' . ($i ? 'TRUE' : 'FALSE') . PHP_EOL;
echo PHP_EOL;