<?php

class OrderTableSeeder
extends DatabaseSeeder
{
  public function run()
  {
    $faker = $this->getFaker();

    $accounts = User::all();

    foreach ($accounts as $account)
    {
      for ($i = 0; $i < rand(-1, 5); $i++)
      {
        Order::create(array(
          "account_id" => $account->id
        ));
      }
    }
  }
}