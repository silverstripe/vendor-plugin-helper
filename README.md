## SilverStripe Vendor Helper Utility

When installing SilverStripe modules in the vendor directory it may also be necessary
to ensure certain module assets are exposed to the webroot, as the 'vendor' url prefix
is blocked from web-access by default.

### See also: Vendor plugin

This utility allows setup of these paths if the `vendor-plugin` is disabled through
the use of `--no-plugins` in install.

See information on this plugin at the [vendor-plugin github page](https://github.com/open-sausages/vendor-plugin)

### Installation

```
composer global require silverstripe/vendor-helper
echo 'export PATH=$PATH:~/.composer/vendor/bin/'  >> ~/.bash_profile
```

### Commands

Both commands are similar: One will symlink vendor modules, the other will copy resources.
The root directory used as the public webroot is `resources` by default.

  * `vendor-helper copy /path/to/www`
  * `vendor-helper link /path/to/www`
 
Optional args:

  * `--target` Top level folder to link resources to. Defaults to `resources`
