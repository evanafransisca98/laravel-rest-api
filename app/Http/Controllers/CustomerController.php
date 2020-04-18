<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Customer;

class CustomerController extends controller { 
    
    public function index(Request $request) {
        
        $customer = Customer::query();

        if ($request->id) {
            $customer->where('id', $request->id);
        }
       
        if ($request->nama) {
            $customer->where('nama', $request->nama);
        }

        if ($request->alamat) {
            $customer->where('alamat', $request->alamat);
        }

        if ($request->telepon) {
            $customer->where('no_telp', $request->telepon);
        }

        return response()->json([
			'status' 	=> true,
			'results' 	=> $customer->get(),
		], 200);
    }

    public function created(Request $request) {
       
        $validator = Validator::make($request->all(), [
			'nama'			=> 'required|min:5',
            'alamat'		=> 'required',
		]);

		if ($validator->fails()) {
			return response()->json([
				'status'	=> false,
				'message'	=> $validator->errors()->first()
			], 400);
		}

        $customer = new Customer;
        $customer->nama = $request->nama;
        $customer->alamat = $request->alamat;
        $customer->no_telp = $request->telepon;
        $customer->save();

        if ($customer) {
            
            return response()->json([
                'status' 	=> true,
                'message' 	=> 'Data Berhasil disave',
                'data'      => $customer
            ], 200);

        } else {
            
            return response()->json([
                'status' 	=> false,
                'message' 	=> 'Data Gagal disave',
            ], 400);

        }
        
    }

    public function updated(Request $request) {

        $validator = Validator::make($request->all(), [
            'id'	    	=> 'required',
            'nama'			=> 'required|min:5',
            'alamat'		=> 'required',
		]);

		if ($validator->fails()) {
			return response()->json([
				'status'	=> false,
				'message'	=> $validator->errors()->first()
			], 400);
		}

        $customer = Customer::find($request->id);
        $customer->nama        = $request->nama;
        $customer->alamat      = $request->alamat;
        $customer->no_telp     = $request->telepon;
        $customer->save();

        if ($customer) {
            
            return response()->json([
                'status' 	=> true,
                'message' 	=> 'Data Berhasil di update',
                'data'      => $customer
            ], 200);

        } else {
            
            return response()->json([
                'status' 	=> false,
                'message' 	=> 'Data Gagal di update',
            ], 400);

        }
    }

    public function deleted(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'id'	    	=> 'required',
        ]);
        
        if ($validator->fails()) {
			return response()->json([
				'status'	=> false,
				'message'	=> $validator->errors()->first()
			], 400);
        }
        
        $customer = Customer::find($request->id);
        $customer->delete();
        if ($customer) {
            
            return response()->json([
                'status' 	=> true,
                'message' 	=> 'Data Berhasil di hapus',
                'data'      => $customer
            ], 200);

        } else {
            
            return response()->json([
                'status' 	=> false,
                'message' 	=> 'Data Gagal di hapus',
            ], 400);

        }
    }

}