<?php

namespace App\Data\Wallet;

/**
 * Factory class for create Virtual wallet
 */
class VirtualWalletFactory
{
    /**
     * @param string $investor
     * @param int $amount
     * @return VirtualWallet
     */
    public static function createVirtualValet(string $investor, int $amount = 0): VirtualWallet
    {
        /**
         * TODO: Load ValetData from DB by Investor [Id/Name].
         */
        return new VirtualWallet($investor, $amount);
    }
}