<?php 

namespace App\services;
use App\assignments\accountservice\AccountServiceInterface;

class AccountService implements AccountServiceInterface {
    public static function cfun() : AccountService {
        return new AccountService();
    }
}