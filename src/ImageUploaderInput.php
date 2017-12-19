<?php

namespace rogeecn\SimpleAjaxUploader;


use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\InputWidget;

abstract class ImageUploaderInput extends InputWidget
{
    /** @var array $targets */
    public  $clientOptions   = [];
    public  $dropZoneOptions = [
        'class' => 'thumbnail text-center uploader-drop-zone',
        'style' => 'line-height: 120px;',
    ];
    public  $wrapperOptions  = ['class' => 'panel panel-default uploader-wrapper'];
    public  $fileType        = "image";
    private $containerID;

    public function init()
    {
        parent::init();

        UploaderAssets::register($this->getView());

        if (!isset($this->dropZoneOptions['id'])) {
            $this->dropZoneOptions['id'] = $this->getId() . "-dropzone";
        }

        $this->containerID = sprintf("%s-image-container", $this->getId());
    }

    public function run()
    {
        $view = $this->getView();

        $options = Json::encode($this->mergeOptions($this->clientOptions));
        $script  = "new ss.SimpleUpload($options);";
        $view->registerJs($script);

        echo Html::beginTag("div", $this->wrapperOptions);
        echo $this->renderInputHtml('hidden');


        echo Html::beginTag("div", ['class' => 'panel-body uploader-image-container', 'id' => $this->containerID]);
        $this->renderImageUploader();
        echo Html::endTag("div");

        echo Html::endTag("div");
    }

    private function mergeOptions($clientOptions)
    {
        $defaultOptions = $this->defaultOptions();
        $mergeOptions   = ArrayHelper::merge($defaultOptions, $clientOptions);

        return $mergeOptions;
    }

    private function defaultOptions()
    {
        $name = "upload-" . $this->attribute;

        return [
            "button"                => $this->dropZoneOptions['id'],
            "url"                   => Url::to(['@admin/misc/upload']),
            "name"                  => $name,
            "dropzone"              => $this->dropZoneOptions['id'],
            "dragClass"             => "drag-has-file",
            "customHeaders"         => [],
            "customProgressHeaders" => [],
            "encodeHeaders"         => true,
            "cors"                  => false,
            "multiple"              => false,
            "multipleSelect"        => false,
            "maxUploads"            => 1,
            "maxSize"               => false,
            "noParams"              => true, // Set to false to append the file name to the url query string.
            "allowedExtensions"     => $this->getFileExtensionsByMIME($this->fileType),
            "data"                  => [
                'instance-name' => $name,
            ], // Additional data to be sent to the server.
            "multipart"             => true,
            "method"                => "POST",
            "responseType"          => "json",
            "debug"                 => YII_DEBUG,
            "hoverClass"            => "",
            "focusClass"            => "",
            "disabledClass"         => "",
            "form"                  => "",
            "onChange"              => new JsExpression("function (filename, extension, uploadBtn, fileSize, file){}"),
            "onSubmit"              => new JsExpression("function (filename, extension, uploadBtn, fileSize){}"),
            "onAbort"               => new JsExpression("function (filename, uploadBtn, fileSize){}"),
            "onComplete"            => new JsExpression($this->callbackComplete()),
            "onDone"                => new JsExpression("function (filename, status, statusText, response, uploadBtn, fileSize){}"),
            "onAllDone"             => new JsExpression("function (){}"),
            "onExtError"            => new JsExpression("function (filename, extension){}"),
            "onSizeError"           => new JsExpression("function (filename, size){}"),
            "onError"               => new JsExpression("function (filename, errorType, status, statusText, response, uploadBtn, fileSize){}"),
            "startXHR"              => new JsExpression("function (filename, fileSize, uploadBtn){}"),
            "endXHR"                => new JsExpression("function (filename, uploadBtn){}"),
            "startNonXHR"           => new JsExpression("function (filename, uploadBtn){}"),
            "endNonXHR"             => new JsExpression("function (filename, uploadBtn){}"),
        ];
    }

    private function getFileExtensionsByMIME($mime)
    {
        $mimeExtensions = [
            "image"    => [
                "jpg", "gif", "bmp", "jpeg", "png",
            ],
            "document" => [
                'doc', "xsl", "ppt",
            ],
        ];

        if (isset($mimeExtensions[$mime])) {
            return $mimeExtensions[$mime];
        }

        return [];
    }

    abstract protected function callbackComplete();

    abstract protected function renderImageUploader();
}
