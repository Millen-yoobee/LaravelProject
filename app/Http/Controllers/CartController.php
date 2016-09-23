<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Cart;            
use App\Products;
use App\User;
use Session;

class CartController extends Controller
{
    public function index() {
    	$UserID = \Auth::user()->id;
    	$user = User::where("id", "=", $UserID)->firstOrFail();
    	$Cart = $user->cart;
    	$Grandtotal = $user->cart->sum("subtotal");

    	return view("cart.index", compact("Cart","Grandtotal"));
 }

 	public function add(Request $request, $id) {
 		$this->validate($request, [
 			"size" => "required",
 			"quantity" => "required|numeric",
 			]);

 		if ( isset($_POST["addtocart"]) ) {
 			$product = Products::findOrFail($id);

 			// Check to see if there is enough stock for this product
 			if ( $request->quantity > $product["quantity"] ) {
 				Session::flash("LowStock", "Sorry, there is not enough stock to process your order");
 				return redirect("/Shop/$id");
 			}
 			// Checking to see if product is found in db
 			$productFound = false;
 			//Get the user ID
 			$UserID = \Auth::user()->id;
 			//Get the Subtotal
 			$Subtotal = $request->quantity * $product["price"];

 			// Check to see if product is already in cart?/database?
 			$cart = Cart::where("user_id", "=", $UserID)->get();
 			foreach($cart as $cartItem) {
 				if ( ($cartItem["product_id"] == $id) & ($cartItem["size"] == $request->size) ) {
 					$productFound = true;
 				}

 			}

			// Change the stock level of the product
			$product->quantity = $product["quantity"] - $request->quantity;
 			$product->save();

 			if ($productFound == true) {
 				//Product already exists in the cart
 				//Update the quantity of the car item
	 			foreach($cart as $cartItem) {
 					if ( ($cartItem["product_id"] == $id) & ($cartItem["size"] == $request->size) ) {
 						$cartItem->quantity = $cartItem["quantity"] + $request->quantity;
 						$cartItem->subtotal = $cartItem["subtotal"] + $Subtotal;
 						$cartItem->save();
 						break;
 					}

	 			}


 			} else {

 				// IF A new product is being added to the cart
 				// Change the stock level of the product
	 			$product->quantity = $product["quantity"] - $request->quantity;
 				$product->save();

 				//
 				$Cart = new Cart();
	 			$Cart->user_id = $UserID;
 				$Cart->product_id = $id;
				$Cart->size = $request->size;
	 			$Cart->quantity = $request->quantity;
	 			$Cart->subtotal = $Subtotal;
 				$Cart->save();

 			}
	
 			return redirect("/Cart");

 		};

 	}

 	public function remove($id) {
 		$cartItem = Cart::where("id", "=", $id)->firstOrFail();
 		$product = Products::where("id", "=", $cartItem["product_id"])->firstOrFail();
		$product->quantity = $product["quantity"] + $cartItem["quantity"];
		$product->save();
		$cartItem->delete();

		Session::flash("RemoveCart", "Item was successfully removed from your cart");
 		return redirect("/Cart");

 	}

}




