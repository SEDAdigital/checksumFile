# checksumFile

> Create a checksum of any file in MODX and return a path with the checksum for cachebusting.


## Requirements

* MODX Revolution 2.5.0+
* PHP 7.0+


## Installation

* Download & install from package manager or directly on [modx.com](https://modx.com/extras/package/checksumFile)
* Update your template to use the snippet when referencing files like this:
```
<link href="[[checksumFile? &file=`/assets/template/dist/styles.css`]]" rel="stylesheet">
<script src="[[checksumFile? &file=`/assets/template/dist/scripts.js`]]"></script>
```
* Update your `.htaccess` with a redirect rule, to make requests with a checksum work. This one works for SVG, JS, CSS – if you need other file endings you need to add those to the `RewriteRule`:
```
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.+)\.([a-z0-9]{8})?\.(svg|js|css)$ $1.$3
```


## Bug reports

Head over <https://github.com/SEDAdigital/checksumFile/issues>


## License

[MIT license](LICENSE)
