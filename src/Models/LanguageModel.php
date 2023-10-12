<?php

namespace Hasirciogli\ProAuth\Models;

use Hasirciogli\ProAuth\Models\ClientModel;
use Symfony\Component\HttpFoundation\Request;

class LanguageModel
{
    private $Langs = [
        "tr" => [
            "auth_email_placeholder" => "Lütfen eposta adresinizi giriniz.",
            "auth_password_placeholder" => "Lütfen şifrenizi giriniz.",
            "auth_submit_value_1" => "Giriş Yap",
            "auth_welcome_back" => "Tekrar Hoşgeldin",
            "auth_login_with_sitename" => "HASIRCIOGLU ile giriş yap",

            "errs" => [
                "authorization_token_generation_failed" => "Yetki tokeni oluşturulamadı",
                "csrf_token_invalid" => "CsrfToken geçersiz",
                "account_not_found" => "Hesap bulunamadı",
            ]
        ],
        "en" => [
            "auth_email_placeholder" => "Please put your mail address",
            "auth_password_placeholder" => "Please put your password",
            "auth_submit_value_1" => "Log In",
            "auth_welcome_back" => "Welcome Back",
            "auth_login_with_sitename" => "Login with HASIRCIOGLU",

            "errs" => [
                "authorization_token_generation_failed" => "Authorization token generation failed.",
                "csrf_token_invalid" => "CsrfToken is invalid",
                "account_not_found" => "Account not found",
            ]
        ]
    ];

    /**
     * @param string $Lang="tr"
     * @return array
     */
    public function GetLanguagePhrases($Lang = "tr"): array
    {
        if (!$this->Langs[$Lang])
            $Lang = "tr";

        return $this->Langs[$Lang];
    }

    /**
     * @param Request $Request
     * @return array
     */
    public function GetLanguagePhrasesFromRequest(Request $Request): array
    {
        $Lang = $Request->query->get("lang") ?? "tr";
        if (!$this->Langs[$Lang])
            $Lang = "tr";

        return $this->Langs[$Lang];
    }

    /**
     * @return LanguageModel
     */
    public static function cfun(): LanguageModel
    {
        return new LanguageModel();
    }
}