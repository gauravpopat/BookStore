<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    use ResponseTrait;

    public function list($id)
    {
        $book = Book::with('author','customers','reviews')->whereId($id)->get();
        return $this->returnResponse(true,'Data',$book);
    }

    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'           => 'required|max:40|string',
            'price'          => 'required|numeric',
            'author_id'      => 'required|exists:authors,id'
        ]);

        if ($validation->fails())
            return $this->validationErrorsResponse($validation);

        $book = Book::create($request->only(['name', 'price', 'author_id']));
        return $this->returnResponse(true, 'Book Added Successfully', $book);
    }

    public function show()
    {
        $books = Book::all();
        if ($books)
            return $this->returnResponse(true, 'Books', $books);
        else
            return $this->returnResponse(false, 'Books not found');
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'           => 'required|max:40|string',
            'price'          => 'required|numeric',
        ]);

        if ($validation->fails())
            return $this->validationErrorsResponse($validation);

        $id = $request->id;
        $book = Book::where('id', $id)->first();
        $book->update([
            'name'              => $request->name,
            'price'             => $request->price,
        ]);

        return $this->returnResponse(true, 'Book Updated Successfully', $book);
    }

    public function delete($id)
    {
        Book::where('id', $id)->delete();
        return $this->returnResponse(true, 'Book Deleted Successfully');
    }
}
