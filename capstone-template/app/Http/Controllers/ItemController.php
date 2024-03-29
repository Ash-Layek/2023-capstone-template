<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use App\Models\shopping_cart;
use Image;
use Storage;
use Session;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::orderBy('title','ASC')->paginate(10);
        return view('items.index')->with('items', $items);
    }



   public function __construct()
   {
    
    $this->middleware('auth');
   }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all()->sortBy('name');
        return view('items.create')->with('categories',$categories);
    }



    public function shoppingcart(Request $request){


       $id = $request->get('id');

        $shoppingcart = new shopping_cart();

    
        // find seee if we have session, then check if we have item_id, then update quantity by 1

        

          $session = session()->getId();


         

        $ip = request()->ip();

        session()->put('ip', $ip);

        $storedip = session('ip');

        $shoppingcart->item_id = $id;

        $shoppingcart->session_id = $session;

        $shoppingcart->IP_address = $storedip;

        $shoppingcart->quantity = 1;


        $shoppingcart->save();




       
       $itemsForUser = $shoppingcart::where('session_id', $session)->get();



       
        

       $listOfItems = [];
       $count = 0;
        foreach($itemsForUser as $item){


            $listOfItems[$count] = $item->item_id;
            $count++;

        }
       
        
        $itemsDetails = [];
        $itemsSize = count($listOfItems);

     

        
        $itemsDetails = Item::whereIn('id', $listOfItems)->get();




        Log::debug("briwa", [$itemsDetails]);

    

        
        


        return view('cart.totalcart')->with('ID', $itemsForUser)->with('listofitems', $itemsDetails);
    }

    public function productdetails(Request $request,$id){


       
       


        $items = Item::find($id);

        $session = session()->getId();

        $ip = request()->ip();

        session()->put('ip', $ip);


        $storedip = session('ip');


        Log::debug('HAIR',[$items]);


        return view('productlist.productdetails', ['items' => $items]);
    }




    
    

    public function productlist(){



        $categories = Category::all()->sortBy('name');

        $items = Item::all()->sortBy('title');

        $session = session()->getId();

        $ip = request()->ip();

        session()->put('ip', $ip);


        $storedip = session('ip');


        Log::debug("HAHOWA", [session()->getId()]);
        
        return view('productlist.products')->with('categories', $categories)->with('items', $items);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        //dd(storage_path());;
        //validate the data
        // if fails, defaults to create() passing errors
        $this->validate($request, ['title'=>'required|string|max:255',
                                   'category_id'=>'required|integer|min:0',
                                   'description'=>'required|',
                                   'price'=>'required|numeric',
                                   'quantity'=>'required|integer',
                                   'sku'=>'required|string|max:100',
                                   'picture' => 'required|image']); 

        //send to DB (use ELOQUENT)
        $item = new Item;
        $item->title = $request->title;
        $item->category_id = $request->category_id;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->quantity = $request->quantity;
        $item->sku = $request->sku;

        //save image
        if ($request->hasFile('picture')) {
            $image = $request->file('picture');

            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location ='images/items/' . $filename;

            $image = Image::make($image);
            Storage::disk('public')->put($location, (string) $image->encode());
            $item->picture = $filename;
        }

        $item->save(); //saves to DB

        Session::flash('success','The item has been added');

        //redirect
        return redirect()->route('items.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::find($id);
        $categories = Category::all()->sortBy('name');
        return view('items.edit')->with('item',$item)->with('categories',$categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate the data
        // if fails, defaults to create() passing errors
        $item = Item::find($id);
        $this->validate($request, ['title'=>'required|string|max:255',
                                   'category_id'=>'required|integer|min:0',
                                   'description'=>'required|string',
                                   'price'=>'required|numeric',
                                   'quantity'=>'required|integer',
                                   'sku'=>'required|string|max:100',
                                   'picture' => 'sometimes|image']);             

        //send to DB (use ELOQUENT)
        $item->title = $request->title;
        $item->category_id = $request->category_id;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->quantity = $request->quantity;
        $item->sku = $request->sku;

        //save image
        if ($request->hasFile('picture')) {
            $image = $request->file('picture');

            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location ='images/items/' . $filename;

            $image = Image::make($image);
            Storage::disk('public')->put($location, (string) $image->encode());

            if (isset($item->picture)) {
                $oldFilename = $item->picture;
                Storage::delete('public/images/items/'.$oldFilename);                
            }

            $item->picture = $filename;
        }

        $item->save(); //saves to DB

        Session::flash('success','The item has been updated');

        //redirect
        return redirect()->route('items.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        if (isset($item->picture)) {
            $oldFilename = $item->picture;
            Storage::delete('public/images/items/'.$oldFilename);                
        }
        $item->delete();

        Session::flash('success','The item has been deleted');

        return redirect()->route('items.index');

    }
}
