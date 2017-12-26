<?php

namespace rogeecn\SimpleAjaxUploader;


use yii\helpers\Html;

class SingleImage extends ImageUploaderInput
{
    public $dropZoneOptions = ['class' => 'text-center uploader-drop-zone'];

    public function init()
    {
        parent::init();
        $this->dropZoneOptions['style'] = "min-height: 100px;" . $this->dropZoneOptions['style'];
    }

    public function renderImageUploader()
    {
        echo Html::beginTag("div", $this->dropZoneOptions);

        $value = $this->value;
        if ($this->hasModel()) {
            $value = $this->model->{$this->attribute};
        }

        if (empty($value)) {
            echo Html::tag("span", "", $this->uploadIconOptions);
        } else {
            echo Html::img($value);
        }
        echo Html::endTag("div");
    }

    protected function callbackComplete()
    {
        $callbackOnComplete = <<<_CODE
function (filename, response, uploadBtn, fileSize){
    $("#{$this->dropZoneOptions['id']}").html('<img src="'+response.imageUrl+'"  style="max-width: 100%"/>');
    $("#{$this->options['id']}").val(response.imageUrl);
}
_CODE;

        return $callbackOnComplete;
    }

}