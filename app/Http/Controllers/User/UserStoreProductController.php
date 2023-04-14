<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductColors;
use App\Models\ProductOtherImages;
use App\Models\ProductSizes;
use App\Models\StoreCategories;
use App\Models\StoreColors;
use App\Models\StoreSizes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserStoreProductController extends Controller
{
    public function AddProduct()
    {
        $categories = StoreCategories::where(['user_id' => Auth::user()->id, 'status' => 1])->get();
        $colors = StoreColors::where(['user_id' => Auth::user()->id, 'status' => 1])->get();
        $sizes = StoreSizes::where(['user_id' => Auth::user()->id, 'status' => 1])->get();
        return view('dashboard.add_product', compact('categories', 'colors', 'sizes'));
    }
    
    public function SaveProduct(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'main_image' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
        ]);
        
        $product = new Product();
        $product->user_id = Auth::user()->id;
        $product->price = $request->price;
        $product->status = 1;
        $product->title = $request->title;
        $product->category_id = $request->category_id;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->save();

        if ($request->hasFile('main_image')) {
            $main_image = $request->file('main_image');
            $filename = $main_image->getClientOriginalName();
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $random_filename = time() . uniqid() . "." . $ext;
            $main_image->storeAs('public/store/' . $product->id, $random_filename);
            Product::where(['id' => $product->id])->update([
                'main_image' => $random_filename
            ]);
        } else {
            Product::where(['id' => $product->id])->delete();
            return redirect()->back();
        }

        if ($request->file('other_image') && $request->file('other_image') !== null) {
            foreach ($request->file('other_image') as $imagefile) {

                $filename = $imagefile->getClientOriginalName();
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $random_filename = time() . uniqid() . "." . $ext;
                $imagefile->storeAs('public/store/' . $product->id, $random_filename);

                $product_other_image = new ProductOtherImages();
                $product_other_image->image = $random_filename;
                $product_other_image->product_id = $product->id;
                $product_other_image->save();
            }
        }
        if ($request->color && $request->color !== null) {
            foreach ($request->color as $color) {
                $product_color = new ProductColors();
                $product_color->color_id = $color;
                $product_color->product_id = $product->id;
                $product_color->save();
            }
        }
        if ($request->size && $request->size !== null) {
            foreach ($request->size as $size) {
                $product_size = new ProductSizes();
                $product_size->size_id = $size;
                $product_size->product_id = $product->id;
                $product_size->save();
            }
        }

        return redirect('/users/store/all_products');
    }
    
    public function UpdateProduct(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
        ]);
         
        $product = Product::where(['id' => $request->id, 'user_id' => Auth::user()->id])->first();
        if(!$product) {
            Session::flash('message', 'Invalid Product!');
            Session::flash('alert-type', 'error');
            return redirect('/store/all_products');
        }

        $product->price = $request->price;
        $product->title = $request->title;
        $product->category_id = $request->category_id;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;

        if ($request->hasFile('main_image')) {
            $file_path = storage_path('app/public/store/' . $request->id . '/' . $product->main_image);
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $main_image = $request->file('main_image');
            $filename = $main_image->getClientOriginalName();
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $random_filename = time() . uniqid() . "." . $ext;
            $main_image->storeAs('public/store/' . $product->id, $random_filename);
            $product->main_image = $random_filename;
        }
        $product->save();

        if($request->file('other_image')) {
            foreach ($request->file('other_image') as $imagefile) {
                $filename = $imagefile->getClientOriginalName();
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $random_filename = time() . uniqid() . "." . $ext;
                $imagefile->storeAs('public/store/' . $product->id, $random_filename);
    
                $product_other_image = new ProductOtherImages();
                $product_other_image->image = $random_filename;
                $product_other_image->product_id = $product->id;
                $product_other_image->save();
            }
        }

        ProductColors::where(['product_id' => $request->id])->delete();
        if ($request->color && $request->color !== null) {
            foreach ($request->color as $color) {
                $product_color = new ProductColors();
                $product_color->color_id = $color;
                $product_color->product_id = $product->id;
                $product_color->save();
            }
        }

        ProductSizes::where(['product_id' => $request->id])->delete();
        if ($request->size && $request->size !== null) {
            foreach ($request->size as $size) {
                $product_size = new ProductSizes();
                $product_size->size_id = $size;
                $product_size->product_id = $product->id;
                $product_size->save();
            }
        }

        return redirect('/users/store/all_products');
    }

    public function ProductDetail($id)
    {
        $product = Product::where(['id' => $id, 'user_id' => Auth::user()->id])->with(['ProductColors', 'ProductSizes', 'ProductOtherImages'])->first();
        if($product) {
            $productColorsArray = [];
            if (count($product->ProductColors) > 0) {
                foreach($product->ProductColors as $color) {
                    array_push($productColorsArray, $color->color_id);
                }
            }
            $productSizesArray = [];
            if (count($product->ProductSizes) > 0) {
                foreach ($product->ProductSizes as $size) {
                    array_push($productSizesArray, $size->size_id);
                }
            }
            
            $categories = StoreCategories::where(['user_id' => Auth::user()->id, 'status' => 1])->get();
            $colors = StoreColors::where(['user_id' => Auth::user()->id, 'status' => 1])->get();
            $sizes = StoreSizes::where(['user_id' => Auth::user()->id, 'status' => 1])->get();
            return view('dashboard.product_detail', compact('product', 'categories', 'colors', 'sizes', 'productColorsArray', 'productSizesArray'));
        } else {
            return redirect()->back();
        }
    }
    public function AllProducts()
    {
        $products = Product::where(['user_id' => Auth::user()->id])->with('category')->get();
        return view('dashboard.all_products', compact('products'));
    }

    public function InactiveProduct($id)
    {
        Product::where(['id' => $id, 'user_id' => Auth::user()->id])->update(['status'   =>  0]);
        return redirect()->back();
    }

    public function ActiveProduct($id)
    {
        Product::where(['id' => $id, 'user_id' => Auth::user()->id])->update(['status'   => 1]);
        return redirect()->back();
    }

    public function DeleteOtherImage($id)
    {
        $other_image = ProductOtherImages::where(['id' => $id])->first();
        if($other_image) {
            $product = Product::where(['id' => $other_image->product_id, 'user_id' => Auth::user()->id])->first();
            if($product) {
                $file_path = storage_path('app/public/store/' . $product->id . '/' . $other_image->image);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
                ProductOtherImages::where(['id' => $id])->delete();
            }
        }
        return redirect()->back();
    }

    public function ProductDelete($id)
    {
        $product = Product::where(['id' => $id, 'user_id' => Auth::user()->id])->first();
        if($product) {
            ProductColors::where(['product_id' => $product->id])->delete();
            ProductSizes::where(['product_id' => $product->id])->delete();

            $product_other_image = ProductOtherImages::where(['product_id' => $product->id])->get();
            foreach($product_other_image as $other_image) {
                $file_path = storage_path('app/public/store/' . $product->id . '/' . $other_image->image);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            ProductOtherImages::where(['product_id' => $product->id])->delete();

            $file_path = storage_path('app/public/store/' . $product->id . '/' . $product->main_image);
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            $file_path = storage_path('app/public/store/' . $product->id);
            if (file_exists($file_path)) {
                $this->delTree($file_path);
            }
            Product::where(['id' => $id])->delete();
        }
        return redirect()->back();
    }

    public function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    
}
