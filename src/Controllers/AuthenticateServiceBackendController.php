<?php

namespace Hasirciogli\ProAuth\Controllers;

use Buki\Router\Router;
use Hasirciogli\ProAuth\Config\DatabaseConfig;
use Hasirciogli\ProAuth\Config\RequestsConfig;
use Hasirciogli\ProAuth\Models\AccountModel;
use Hasirciogli\ProAuth\Models\AuthenticateRateLimitter;
use Hasirciogli\ProAuth\Models\ClientModel;
use Hasirciogli\ProAuth\Models\HashModel;
use Hasirciogli\ProAuth\Models\LanguageModel;
use Hasirciogli\ProAuth\Models\TokenModel;
use Hasirciogli\SessionWrapper\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateServiceBackendController
{
    public function RegisterRoutes(Router $Router): void
    {
        $Session = new Session(DatabaseConfig::cfun());

        $Router->get('/proauth0/authenticate', function (Request $Request, Response $Response) {
            return $this->AuthenticateGet($Request, $Response);
        });

        $Router->post('/proauth0/authenticate', function (Request $Request, Response $Response) {
            $Response->headers->set("Access-Control-Allow-Origin", RequestsConfig::RC_ALLOWED_HOSTS, true);
            return $this->AuthenticatePost($Request, $Response);
        });


        $Router->get('/t', function (Request $Request, Response $Response) {
            require_once __DIR__ . "/../Pages/Auth/Test.php";
        });

        $Router->post('/t', function (Request $Request, Response $Response) {
            require_once __DIR__ . "/../Pages/Auth/Test.php";
        });

        $Router->run();
    }

    public function AuthenticateGet(Request $Request, Response $Response)
    {

        $ClientId = $Request->query->get("client_id") ?? null;
        $RedirectTo = $Request->query->get("redirect_to") ?? null;
        $Hash = $Request->query->get("hash") ?? null;

        if ((!$ClientId || !$RedirectTo || !$Hash) || !($Client = ClientModel::cfun()->GetClient($ClientId)))
            return "Please use correct client details";

        if (!HashModel::cfun()->VerifyClientHashWithRedirectUrl($ClientId, $RedirectTo, $Hash))
            return "Client details are invalid";


        $Session = new Session(DatabaseConfig::cfun());
        $Session->Set("csrf-token", sha1(time() . time() . time() . time() . time() . time()));
        $Session->Set("client_id", $ClientId);

        require_once __DIR__ . "/../Pages/Auth/Authenticate.php";
    }
    public function AuthenticatePost(Request $Request, Response $Response): mixed
    {
        $Phrases = LanguageModel::cfun()->GetLanguagePhrasesFromRequest($Request);
        $Session = new Session(DatabaseConfig::cfun());

        if (AuthenticateRateLimitter::cfun()->RunRateLimitter($_SERVER["REMOTE_ADDR"]))
            return [
                "status" => false,
                "err" => $Phrases["errs"]["account_not_found"],
            ];

        if (!($CsrfToken = ($Session->Get("csrf-token") == $Request->request->get("csrf-token") ?? null ?? null)))
            return [
                "status" => false,
                "err" => $Phrases["errs"]["csrf_token_invalid"],
            ];

        //$Session->Get("");

        $Email = $Request->request->get("email");
        $Password = $Request->request->get("password");


        if (!($Account = AccountModel::cfun()->GetAccount($Email, $Password)))
            return [
                "status" => false,
                "err" => $Phrases["errs"]["account_not_found"],
            ];

        if (!($AuthorizationToken = TokenModel::cfun()->AddAuthorizationToken($Account["id"], $Session->Get("client_id"))))
            return [
                "status" => false,
                "err" => $Phrases["errs"]["authorization_token_generation_failed"],
            ];



        return [
            "status" => true,
            "authorizationtoken" => $AuthorizationToken,
        ];
    }
    public static function cfun(): AuthenticateServiceBackendController
    {
        return new AuthenticateServiceBackendController();
    }
}