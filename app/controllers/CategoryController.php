<?php

class CategoryController
extends BaseController
{
  public function indexAction()
  {
    return Category::with(array("products"))->get();
  }
}