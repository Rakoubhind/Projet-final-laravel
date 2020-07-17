<?php

namespace App\Http\Controllers;

use App\Product;
use App\ImageUpload;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(15);
        return response()->JSON($products, 200);
    }
    public function getProduct()
    {
        $user = Auth::User();
        // dd($user);
        //  $products = Product::(); 
        $products = Product::where('user_id', $user->id)->get();
        //  dd(['user'=>$user->id , $products]);
        //  return response()->json([$products ,  'user_id' =>$user->id] , 200); 
        return response()->JSON(['user' => $user->id, 'product' => $products], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::User();
        // dd($request->all());

        // return response()->json($request->all(), 201);
        // return response()->json($user, 201);

        $fileimage1 = $request->file('image1');
        $fileimage2 = $request->file('image2');
        $fileimage3 = $request->file('image3');
        $ext1 = $fileimage1->extension();

        $ext2 = $fileimage2->extension();
        $ext3 = $fileimage3->extension();
        // return response()->json($ext3, 201)
        $name1 = Carbon::now()->format('d-m-Y') . '-' . Str::random(10) . '.' . $ext1;
        $name2 = Carbon::now()->format('d-m-Y') . '-' . Str::random(10) . '.' . $ext2;
        $name3 = Carbon::now()->format('d-m-Y') . '-' . Str::random(10) . '.' . $ext3;
        $path1 = Storage::disk('public')->putFileAs(
            'products',
            $fileimage1,
            $name1
        );
        // dd($path1);
        $path2 = Storage::disk('public')->putFileAs(
            'products',
            $fileimage2,
            $name2
        );

        $path3 = Storage::disk('public')->putFileAs(
            'products',
            $fileimage3,
            $name3
        );
        // dd($path3);

        $user = Auth::User();
        $products = Product::create([
            'user_id' => $user->id,
            'category_id' => $request->get('category_id'),
            'disponibilite' => $request->get('disponibilite'),
            'prix' => $request->get('prix'),
            'surface' => $request->get('surface'),
            'chambre' => $request->get('chambre'),
            'description' => $request->get('description'),
            'titre' => $request->get('titre'),
            'adresse' => $request->get('adresse'),
            //  'image1'=>$request->get('image1'),
            //  'image2'=>$request->get('image2'),
            //  'image3'=>$request->get('image3'),
            'image1' => $path1,
            'image2' => $path2,
            'image3' => $path3,


        ]);

        return response()->json($products, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // $product = Product::where('id', $id)->firstorFail();
    // return response()->json($product , 200);
    public function show($id)
    {
        $product = Product::where('id', $id)->firstorFail();

        $cat = $product->category->get();

        return response()->json(["product" => $product], 200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return $product;
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

        // return response()->json(["product" =>$request->all()], 200);



        if (!$request->get("image1")) {
            $fileimage1 = $request->file('image1');
            $ext1 = $fileimage1->extension();
            $name1 = Carbon::now()->format('d-m-Y') . '-' . Str::random(10) . '.' . $ext1;
            $path1 = Storage::disk('public')->putFileAs(
                'products',
                $fileimage1,
                $name1
            );
        } else
            $path1 = $request->get('image1');




        if (!$request->get("image2")) {
            $fileimage2 = $request->file('image2');
            $ext2 = $fileimage2->extension();
            $name2 = Carbon::now()->format('d-m-Y') . '-' . Str::random(10) . '.' . $ext2;
            $path2 = Storage::disk('public')->putFileAs(
                'products',
                $fileimage2,
                $name2
            );
            // return response()->json(["product" => $path2], 200);

            // dd($path2);
        } else {
            $path2 = $request->get('image2');
        }
        if (!$request->get("image3")) {
            $fileimage3 = $request->file('image3');
            $ext3 = $fileimage3->extension();
            $name3 = Carbon::now()->format('d-m-Y') . '-' . Str::random(10) . '.' . $ext3;
            $path3 = Storage::disk('public')->putFileAs(
                'products',
                $fileimage3,
                $name3
            );
        } else {
            $path3 = $request->get('image3');
        }

        // return response()->json($request->all(), 201);
        // return response()->json([$request->all(), $path1, $path2, $path3], 201);

        $user = Auth::User();
        // return response()->json($user, 201);


        $product = Product::find($id)->first();

        $product->user_id =$user->id;
        $product->category_id = $request->category_id;
        $product->disponibilite = $request->get('disponibilite');
        $product->prix = $request->prix;
        $product->surface = $request->surface;
        $product->chambre = $request->chambre;
        $product->description = $request->description;
        $product->titre = $request->titre;
        $product->adresse = $request->adresse;
        $product->image1 = $path1;
        $product->image2 = $path2;
        $product->image3 = $path3;

        // dd($product);

        $product->save();
        // if($product)
        // {
        // return Product::all();

        return response()->json(["product" => $product], 200);

        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
    }
}
