## Before start
### add parameters
```yaml
parameters:
    monobank_api_base_path: 'https://api.monobank.ua'
    monobank_pub_key: '%env(MONOBANK_PUB_KEY)%'
    monobank_priv_key: '%env(MONOBANK_PRIV_KEY)%'
    monobank_personal_key: '%env(MONOBANK_PERSONAL_KEY)%'
```
### start use it for service
```yaml
bind:
    string $monobankApiBasePath: "%monobank_api_base_path%"
    string $monobankApiPublicKey: "%monobank_pub_key%"
    string $monobankApiPrivateKey: "%monobank_priv_key%"
    string $monobankApiPersonalKey: "%monobank_personal_key%"
 ```
## Docs
###main
https://api.monobank.ua/docs/
###sign
https://gist.github.com/Sominemo/64845669d6326f2f73d356f025656bdb#file-mono-corp-api-signing-ru-md
