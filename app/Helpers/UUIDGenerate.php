<?php
namespace App\Helpers;

use App\Models\Transaction;
use App\Models\Wallet;

class UUIDGenerate
{
  public static function accountNumber()
  {
    $number = mt_rand(1000000000000000, 9999999999999999);
    if (Wallet::where('account_number', $number)->exists()) {
      self::accountNumber();
    }
    return $number;
  }

  public static function refNo()
  {
    $number = mt_rand(1000000000000000, 9999999999999999);
    if (Transaction::where('ref_no', $number)->exists()) {
      self::refNo();
    }
    return $number;
  }

  public static function trxId()
  {
    $number = mt_rand(1000000000000000, 9999999999999999);
    if (Transaction::where('trx_id', $number)->exists()) {
      self::trxId();
    }
    return $number;
  }
}
