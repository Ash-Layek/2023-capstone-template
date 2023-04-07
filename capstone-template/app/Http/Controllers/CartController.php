<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
USE App\Models\shopping_cart;
use App\Models\Item;
use Session;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    //


    public function update_cart(Request $request){



        $cart = shopping_cart::all();


 Log::debug('all', [session()->getId()]);
      Log::debug('itemid', [$request->get('itemID')]);

      $sessionid = session()->getId();

      


      foreach($request->all() as $key => $value){
          if(strpos($key, 'quantity_') !== false){
              $item_id = str_replace('quantity_', '', $key);
              $quantity = $value;
              // log the values to check if they are correct
              Log::debug("Item ID: " . $item_id . " Quantity: " . $quantity);
              

              $shopping_cart_item = shopping_cart::where('session_id', $sessionid)
              ->where('item_id', $item_id)
              ->first();

// Update the quantity
       $shopping_cart_item->quantity = $quantity;
          $shopping_cart_item->save();
              // do the update logic here
          }
      }


     



      
      





      return back()->with('success', 'Cart updated successfully!');



    }

    public function check_order(){





        return 'lhwa';


    }






}
