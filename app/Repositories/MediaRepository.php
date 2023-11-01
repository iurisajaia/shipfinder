<?php

namespace App\Repositories;

use App\Repositories\Interfaces\MediaRepositoryInterface;


class MediaRepository implements MediaRepositoryInterface
{

    public function addImagesToModel($images, $model){
        foreach ($images as $key => $image){
            $existingMedia = $model->getMedia($image['title'])->first();
            if ($existingMedia) {
                $existingMedia->delete();
            }
            $model->addMediaFromRequest("images.{$key}.uri")->toMediaCollection($image['title']);
        }
    }

    public function addSingleImageToModel($request, $model, $title){
        $existingMedia = $model->getMedia($title)->first();
        if ($existingMedia) {
            $existingMedia->delete();
        }
        $model->addMediaFromRequest($title)->toMediaCollection($title);
    }


}
