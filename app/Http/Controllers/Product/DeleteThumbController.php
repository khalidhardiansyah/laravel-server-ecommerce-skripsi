<?php


namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseMessageResource;
use App\Message\MessageResource;
use App\Models\Thumbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DeleteThumbController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $productImg, MessageResource $messageResource)
    {
        
            $image = Thumbs::find($productImg);
            if (File::exists(public_path($image->path_thumb))) {
                File::delete(public_path($image->path_thumb));
                $image->delete();
                return $messageResource->print("success","produk berhasil dihapus",204);
            }
        
    }
}
