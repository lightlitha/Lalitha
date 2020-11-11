<?php

namespace App\Services\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Makes Dynamic Navigation Bar Items
 */
class CustomPathGenerator extends BasePathGenerator implements \Spatie\MediaLibrary\Support\PathGenerator\PathGenerator
{
  /**
   * Get Media Path Relative To The Root Folder
   * 
   * @param Spatie\MediaLibrary\MediaCollections\Models\Media;
   * 
   * @return string
   */
  public function getPath(Media $media) : string
  {
    return md5($media->id . config('app.key')) . '/';
  }

  /**
   * Get Media Path Relative To The Root Folder
   * 
   * @param Spatie\MediaLibrary\MediaCollections\Models\Media;
   * 
   * @return string
   */
  public function getPathForConversions(Media $media) : string
  {
    return md5($media->id . config('app.key')) . '/conversions/';
  }

  /**
   * Get Media Path Relative To The Root Folder
   * 
   * @param Spatie\MediaLibrary\MediaCollections\Models\Media;
   * 
   * @return string
   */
  public function getPathForResponsiveImages(Media $media) : string
  {
    return md5($media->id . config('app.key')) . '/responsive-images//';
  }
}