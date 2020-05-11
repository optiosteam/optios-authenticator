# Optios authenticator

## Installation

Add the following to your composer.json
```
    "require": {
        "optios/authenticator": "dev-master"
    },
    "repositories": [
        {
            "type": "vcs",
            "url":  "git@github.com:optiosteam/optios-authenticator.git"
        }
    ]
```

## Usage

```
$provider = new \OptiosAuthenticator\Provider\MmeoryProvider();
$authenticator = new \OptiosAuthenticator\Authenticator();

$bearerToken = $request->headers->get('X-Auth-Token');

try {
    $token = $authenticator->authenticate($bearerToken);
} catch (\OptiosAuthenticator\AuthenticationException $exception) {
    // Handle authentication failure
}
```

Possible Providers:
* MemoryProvider for development purposes
* TODO: Add provider for production

## Run tests
```
bin/phpunit
```
