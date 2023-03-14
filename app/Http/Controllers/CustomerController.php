<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Traits\ResponseTrait;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    use ResponseTrait;

    public function list($id)
    {
        $customer = Customer::with('books')->whereId($id)->get();
        return $this->returnResponse(true,'Data',$customer);
    }

    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'              => 'required|max:40|string',
            'email'             => 'required|email|max:40|unique:customers,email',
            'city'              => 'required|string|max:40',
            'purchased_book_id' => 'required|numeric|exists:books,id'
        ]);

        if ($validation->fails())
            return $this->validationErrorsResponse($validation);

        $customer = Customer::create($request->only(['name','email','city','purchased_book_id']));
        return $this->returnResponse(true, 'Customer Added Successfully', $customer);
    }

    public function show()
    {
        $customers = Customer::all();
        if ($customers)
            return $this->returnResponse(true, 'Customers', $customers);
        else
            return $this->returnResponse(false, 'Customers not found');
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id'                => 'required|numeric|exists:customers,id',
            'name'              => 'required|max:40|string',
            'email'             => 'required|email|max:40|unique:customers,email',
            'city'              => 'required|string|max:40',
            'purchased_book_id' => 'required|numeric|exists:books,id'
        ]);

        if ($validation->fails())
            return $this->validationErrorsResponse($validation);

        $id = $request->id;
        $customer = Customer::where('id', $id)->first();
        $customer->update([
            'name'              => $request->name
        ]);

        return $this->returnResponse(true, 'Customer Updated Successfully', $customer);
    }

    public function delete($id)
    {
        $customer = Customer::where('id', $id)->first();
        if($customer){
            $customer->delete();
            return $this->returnResponse(true, 'Customer Deleted Successfully');
        }
        else{
            return $this->returnResponse(false,'User not found');
        }
    }
}
