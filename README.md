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


## Bug reports

Head over <https://github.com/SEDAdigital/checksumFile/issues>


## License

[MIT license](LICENSE)
