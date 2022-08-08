<?php

namespace InformUnity\RestAuth;

use GuzzleHttp\Client as Guzzle;

class Client
{
  private $token = "";
  private $baseUrl = "";
  private $guzzle = null;

  private $instance = null;

  public function __construct(?array $params = [])
  {
    if ($params["token"]) {
      $this->token = $params["token"];
    }
    if ($params["baseUrl"]) {
      $this->baseUrl = $params["baseUrl"];
    }

    $this->guzzle = new Guzzle([
      "base_uri" => $this->baseUrl,
      "timeout" => 10,
      "headers" => [
        "Authorization" => "Bearer $this->token",
        "Accept" => "application/json",
      ],
    ]);
  }

  private static function getEnv(string $param = "")
  {
    if (empty($param)) {
      return "";
    }
  }

  function getAccessToken(array $params = []): ?string
  {
    if (!$params["appCode"]) {
      throw new \Error("missing_app_code");
    }

    if (!$params["memberId"]) {
      throw new \Error("missing_member_id");
    }

    $response = $this->guzzle->request("GET", "token", [
      "query" => [
        "app_code" => $params["appCode"],
        "member_id" => $params["memberId"],
      ],
    ]);

    $responseText = $response->getBody()->getContents();

    $responseDecoded = [];
    try {
      $responseDecoded = json_decode($responseText, true);
    } catch (\Throwable $e) {
      throw new \Error($responseText);
    }

    if (!$responseDecoded["success"]) {
      throw new \Error($responseDecoded["error"]["code"]);
    }

    return $responseDecoded["data"]["access_token"];
  }

  function saveTokens(array $params = []): ?bool
  {
    if (!$params["appCode"]) {
      throw new \Error("missing_app_code");
    }

    if (!$params["memberId"]) {
      throw new \Error("missing_member_id");
    }

    if (!$params["accessToken"]) {
      throw new \Error("missing_access_token");
    }

    if (!$params["refreshToken"]) {
      throw new \Error("missing_refresh_token");
    }

    $response = $this->guzzle->request("POST", "token", [
      "form_params" => [
        "app_code" => $params["appCode"],
        "member_id" => $params["memberId"],
        "access_token" => $params["accessToken"],
        "refresh_token" => $params["refreshToken"],
      ],
    ]);

    $responseText = $response->getBody()->getContents();
    $responseDecoded = [];
    try {
      $responseDecoded = json_decode($responseText, true);
    } catch (\Throwable $e) {
      throw new \Error($responseText);
    }

    if (!$responseDecoded["success"]) {
      throw new \Error($responseDecoded["error"]["code"]);
    }

    return true;
  }
}
