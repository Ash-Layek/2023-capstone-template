<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use Session;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   

    

    public function index()
    {
        $categories = Category::orderBy('name','ASC')->paginate(10);
        return view('categories.index')->with('categories',$categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');

       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the data
        // if fails, defaults to create() passing errors
        $this->validate($request, ['name'=>'required|max:100|unique:categories,name']); 

        //send to DB (use ELOQUENT)
        $category = new Category;
        $category->name = $request->name;
        $category->save(); //saves to DB

        Session::flash('success','The category has been added');

        //redirect
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        $item = Item::all();


        forEach($item as $i){

            if ($i->category_id != $id){

                $category = Category::find($id);

                $category->delete();
                
            } else {


                return "Category already used by an item";
            }


        }

        


       

    
        return redirect()->route('categories.index');
    }

    
      /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
       

     return  "ntaya zaml";

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        $category = Category::find($id);
        return view('categories.edit')->with('category',$category);
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
        $category = Category::find($id);
        $this->validate($request, ['name'=>"required|max:100|unique:categories,name,$id"]);             

        //send to DB (use ELOQUENT)
        $category->name = $request->name;

        $category->save(); //saves to DB

        Session::flash('success','The category has been updated');

        //redirect
        return redirect()->route('categories.index');
        
    }

    
    public function chosenCategory($id){




        $Categories = Category::all();

        $listRelatedToCategory = Item::where('category_id', $id)->get();


    
        return view('productlist.products')->with('categories', $Categories)->with('items', $listRelatedToCategory);
    }


    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   



    
    
}
