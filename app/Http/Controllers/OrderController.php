<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use App\Models\Order;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    use ResponseTrait;

    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id'        => 'required|numeric|exists:users,id',
            'book_id'        => 'required|numeric|exists:books,id',
        ]);

        if ($validation->fails())
            return $this->validationErrorsResponse($validation);

        $price = Book::where('id',$request->book_id)->first();
        $price = $price->price;

        $order = Order::create($request->only(['user_id', 'book_id'])+[
            'price' => $price
        ]);
        return $this->returnResponse(true, 'Book Ordered Successfully', $order);
    }

    public function show($id)
    {
        $order = Order::with('user','book')->where('id',$id)->get();
        return $this->returnResponse(true,'Order Detail',$order);
    }
    
}
