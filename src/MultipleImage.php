<?php

namespace rogeecn\SimpleAjaxUploader;


use yii\helpers\Html;

class MultipleImage extends ImageUploaderInput
{
    public  $dropZoneOptions = [
        'class' => 'thumbnail text-center uploader-drop-zone',
        'style' => 'line-height: 120px;',
    ];
    private $containerID;


    public function renderImageUploader()
    {
        $this->registerRemoveImage();

        $value      = $this->model->{$this->attribute};
        $uploadIcon = Html::tag("span", "", [
            'class' => 'glyphicon glyphicon-cloud-upload',
            'style' => 'font-size:52px; margin: 25px 0;',
        ]);
        if (!empty($value)) {
            $value = explode(",", $value);
            foreach ($value as $imageURL) {
                $imgHtml   = Html::img($imageURL);
                $btnRemove = Html::tag("span", "&times;", ['class' => 'remove-thumbnail']);
                echo Html::tag("span", $imgHtml . $btnRemove, ['class' => 'thumbnail']);
            }
        }
        echo Html::tag("span", $uploadIcon, $this->dropZoneOptions);
    }

    protected function registerRemoveImage()
    {
        $code = <<<_CODE
$("body").on("click",".uploader-image-container .thumbnail .remove-thumbnail",function(){
    if (!confirm("确定要删除这张图片么？")){
        return false;
    }
   $(this).closest(".thumbnail").remove();
    var imgList = [];
    $("#{$this->containerID} .thumbnail img").each(function(index,item){
         imgList.push($(item).attr("src"))
    }) 
    
    $("#{$this->options['id']}").val(imgList.join(","));
});
_CODE;

        $this->getView()->registerJs($code);
    }

    protected function callbackComplete()
    {
        $callbackOnComplete = <<<_CODE
function (filename, response, uploadBtn, fileSize){
    $("#{$this->dropZoneOptions['id']}").before('<span class="thumbnail"><img src="'+response.imageUrl+'"></span>');
    
    var imgList = [];
    $("#{$this->containerID} .thumbnail img").each(function(index,item){
         imgList.push($(item).attr("src"))
    }) 
    
    $("#{$this->options['id']}").val(imgList.join(","));
}
_CODE;

        return $callbackOnComplete;
    }
}
