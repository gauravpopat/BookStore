<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Http\Traits\ResponseTrait;
use Illuminate\Support\Facades\Validator;
class ReviewController extends Controller
{
    use ResponseTrait;

    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'book_id'       => 'required|numeric|exists:books,id',
            'customer_id'   => 'required|numeric|exists:customers,id',
            'ratings'       => 'required|in:1,2,3,4,5',
            'review'        => 'required'
        ],[
            'ratings.in'    => 'The selected ratings is invalid, please provide the ratings between 1 and 5.'
        ]);

        if ($validation->fails())
            return $this->validationErrorsResponse($validation);

        $review = Review::create($request->only(['book_id','customer_id','ratings','review']));
        return $this->returnResponse(true, 'Review Added Successfully', $review);
    }

    public function show()
    {
        $reviews = Review::all();
        if ($reviews)
            return $this->returnResponse(true, 'Reviews', $reviews);
        else
            return $this->returnResponse(false, 'Reviews not found');
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id'                => 'required|numeric|exists:reviews,id',
            'ratings'           => 'required|digits_between:1,5',
            'review'            => 'required'
        ]);

        if ($validation->fails())
            return $this->validationErrorsResponse($validation);

        $id = $request->id;
        $review = Review::where('id', $id)->first();
        $review->update([
            'ratings'              => $request->ratings,
            'review'               => $request->review
        ]);

        return $this->returnResponse(true, 'Review Updated Successfully', $review);
    }

    public function delete($id)
    {
        $review = Review::where('id', $id)->first();
        if($review){
            $review->delete();
            return $this->returnResponse(true, 'Review Deleted Successfully');
        }
        else{
            return $this->returnResponse(false,'Review not found');
        }
    }
}
