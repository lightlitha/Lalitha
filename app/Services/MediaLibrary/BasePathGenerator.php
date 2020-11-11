<?php

namespace App\Services\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

abstract class BasePathGenerator {
  /**
   * Get Media Path Relative To The Root Folder
   * 
   * @param Spatie\MediaLibrary\MediaCollections\Models\Media;
   * 
   * @return string
   */
  public abstract function getPath(Media $media) : string;

  /**
   * Get Media Path Relative To The Root Folder
   * 
   * @param Spatie\MediaLibrary\MediaCollections\Models\Media;
   * 
   * @return string
   */
  public abstract function getPathForConversions(Media $media) : string;

  /**
   * Get Media Path Relative To The Root Folder
   * 
   * @param Spatie\MediaLibrary\MediaCollections\Models\Media;
   * 
   * @return string
   */
  public abstract function getPathForResponsiveImages(Media $media) : string;
}