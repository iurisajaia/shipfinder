<?php

namespace App\Repositories\Interfaces;



Interface MediaRepositoryInterface{

    public function addImagesToModel($images, $model);
    public function addSingleImageToModel($request, $model, $title);

}
