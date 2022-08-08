# Либа по работе с микросервисом rest авторизации

### Установка
```bash 
composer require informunity/rest-auth-service-php-lib
```
### Использование

инстанцировать клиент, токен и урл берем в keyrights
```php
$restAuthClient = new \InformUnity\RestAuth\Client([
  "token" => "lQ461D4FXn2WxiuWECIzzCjaedKBz3sH2S22GgKk",
  "baseUrl" => "https://7f63f29a1b5063.lhrtunnel.link/api/",
]);
```

сохранить авторизационные rest данные
```php
$restAuthClient->saveTokens([
  "appCode" => "informunity.my_great_app",
  "memberId" => "1d3629bea8b123we2ss365ae1e16e6e1",
  "accessToken" => "123123123123123123123123123123",
  "refreshToken" => "23452345345345345345345345345",
]);  // true
```

получить access_token
```php
$restAuthClient->getAccessToken([
  "appCode" => "informunity.my_great_app",
  "memberId" => "1d3629bea8b123we2ss365ae1e16e6e1",
]);  // "123123123123123123123123123123"
```

#### Прочее
+ настроен repository mirroring в корпоративный gitlab
