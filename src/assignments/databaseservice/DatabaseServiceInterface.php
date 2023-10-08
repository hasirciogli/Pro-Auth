<?php

namespace HProAuth\assignments\databaseservice;

interface DatabaseServiceInterface {
    public function GetClientDetailsBy_ClientId($ClientId) : null | array;
    public function GetAccountDetailBy_EmailPassword($Email, $Password) : null | array;
    public function GetAccountDetailBy_AccountId($AccountId) : null | array;
    public function GetAccountDetailBy_Token($Token) : null | array;
}