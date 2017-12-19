SimpleAjaxUploader For Yii2.x
=============================
SimpleAjaxUploader wraper of yii2 input extension

single image upload or multiple image upload

thks for [LPology/Simple-Ajax-Uploader](https://github.com/LPology/Simple-Ajax-Uploader)

screenshot

![](https://gith)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist rogeecn/yii2-simple-ajax-uploader "~1.0.1"
```

or add

```
"rogeecn/yii2-simple-ajax-uploader": "~1.0.1"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
// single image upload
<?= $form->field($model,"xxx")->widget(\rogeecn\SimpleAjaxUploader\SingleImage::className(),[
    // configuration..
]); ?>

// multiple image upload
<?= $form->field($model,"xxx")->widget(\rogeecn\SimpleAjaxUploader\MultipleImage::className(),[
    // configuration..
]); ?>
```