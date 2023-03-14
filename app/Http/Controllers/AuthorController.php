<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Http\Traits\ResponseTrait;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    use ResponseTrait;

    public function list($id)
    {
        
        $author = Author::with('books','customers','reviews')->where('id',$id)->get();
        return $this->returnResponse(true,'Data',$author);
    }



    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|max:40|string'
        ]);

        if ($validation->fails())
            return $this->validationErrorsResponse($validation);

        $author = Author::create($request->only(['name']));
        return $this->returnResponse(true, 'Author Added Successfully', $author);
    }

    public function show()
    {
        $authors = Author::all();
        if ($authors)
            return $this->returnResponse(true, 'Authors', $authors);
        else
            return $this->returnResponse(false, 'Authors not found');
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id'            => 'required|numeric|exists:authors,id',
            'name'          => 'required|max:40|string'
        ]);

        if ($validation->fails())
            return $this->validationErrorsResponse($validation);

        $id = $request->id;
        $author = Author::where('id', $id)->first();
        $author->update([
            'name'              => $request->name
        ]);

        return $this->returnResponse(true, 'Author Updated Successfully', $author);
    }

    public function delete($id)
    {
        Author::where('id', $id)->delete();
        return $this->returnResponse(true, 'Author Deleted Successfully');
    }
}
