<?php

class StoreController
extends BaseController
{
  public function indexAction()
  {
  	return View::make("store.index");
  }
}