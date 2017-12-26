<?php

namespace rogeecn\SimpleAjaxUploader;


use yii\web\AssetBundle;

class UploaderAssets extends AssetBundle
{
    public $css     = [
    ];
    public $js      = [
        "SimpleAjaxUploader.js",
    ];
    public $depends = [
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . "/assets";
    }
}