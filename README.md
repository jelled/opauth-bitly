Opauth-Bitly
================
[Opauth][1] strategy for Bitly authentication.

Implemented based on http://dev.bitly.com/api.html

Opauth is a multi-provider authentication framework for PHP.

Getting started
----------------
1. Install Opauth-Bitly:
   ```bash
   cd path_to_opauth/Strategy
   git clone git://github.com/jelled/opauth-bitly.git Bitly
   ```

2. Create a Bitly application at http://dev.bitly.com/my_apps.html and set http://[path_to_opauth]/bitly/oauth_callback as your default callback URL.

3. Configure Opauth-Bitly strategy.

4. Direct user to `http://[path_to_opauth]/bitly` to authenticate

5. Now that you have the user's token, check out https://github.com/Falicon/BitlyPHP for easy interface with the bitly api.

Strategy configuration
----------------------

Required parameters:

```php
'Bitly' => array(
  'client_id' => 'YOUR CLIENT ID',
  'client_secret' => 'YOUR CLIENT SECRET'
)
```


References
----------
- http://dev.bitly.com/api.html

License
---------
Opauth-Bitly is MIT Licensed
Copyright © 2013 Benjamin Bjurstrom ([@benbjurstrom][2])

[1]: https://github.com/opauth/opauth
[2]: http://twitter.com/benbjurstrom