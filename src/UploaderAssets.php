<?php

namespace rogeecn\SimpleAjaxUploader;


use yii\web\AssetBundle;

class UploaderAssets extends AssetBundle
{
    public $css     = [
        'style.css',
    ];
    public $js      = [
        "SimpleAjaxUploader.js",
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . "/assets";
    }
}