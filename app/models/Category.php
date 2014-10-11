<?php

class Category
extends Eloquent
{
  protected $table = "category";

  protected $guarded = array("id");

  protected $softDelete = true;

  public function products()
  {
    return $this->hasMany("Product");
  }
}