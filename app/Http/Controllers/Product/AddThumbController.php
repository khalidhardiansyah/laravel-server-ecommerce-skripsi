<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreThumbRequest;
use App\Message\MessageResource;
use App\Models\Thumbs;
use Illuminate\Http\Request;

class AddThumbController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreThumbRequest $request , MessageResource $messageResource, $id)
    {
        
        $request->validated();
        if ($request->has('images')) {
            $path = 'public/product/';
            $i = 1;
            foreach ($request->file('images') as $image) {
                $ext = $image->getClientOriginalExtension();
                $filename = time().$i++.'.'.$ext;
                $image->move($path, $filename);
                $filenamefinal = $path.$filename;
                $pt =Thumbs::create(
                    [
                        'path_thumb' =>$filenamefinal,
                        'products_id' =>$id
                    ]
                );

            };
            return $messageResource->print("success","produk berhasil dibuat",201);
        }
    }
}
