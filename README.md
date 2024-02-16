# AcyMailer PHP Library

## Development

## Installing locally the library

In the composer.json file of the local project, add the following line in the require section:

```json
{
    //...
    "repositories": [
        {
            "type": "path",
            "url": "/path/to/acymailer/library"
        }
    ]
    //...
    "require": {
        "acymailing/sending-service": "@dev"
    }
    //...
}
```

Then, in the terminal, execute the following command:

```bash
composer install
```
