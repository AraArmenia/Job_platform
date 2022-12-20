<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index() {

        return view('listings.index', [
            'heading'=>'Latest Listings',
            'listings'=> Listing::latest()->filter(request(['tag', 'search']))->paginate(4)
        ]);
    }

    public function show(Listing $listing) {
       
        if($listing){
            return view('listings.show', [
                'listing'=>$listing
            ]);
        }
    }

    public function create() {
        return view('listings.create');
    }

    public function store(Request $request) {
 
        
        $inputs = $request->validate([
            
            'company' => 'required|max:255',
            'title' => 'required|max:255',
            'location' => 'required|max:255',
            'email' => 'required|email|max:255',
            'website' => 'required|max:255|url',
            'tags' => 'required|max:255',
            'description' => 'required',
            'logo' => 'mimes:jpg,jpeg,png'
            
        ]);

        if($request->hasFile('logo')){


           $inputs['logo'] =  $request->file('logo')->store('logos', 'public');
        }
        
        $inputs['user_id'] = auth()->id();
       

        Listing::create($inputs);

        return redirect()->route('listings')->with('success', 'The post was created successfully');
    }

    public function edit(Listing $listing) {

        if($listing->user_id != auth()->id()){
            abort(403, "Unathorized Action");
        }

        return view('listings.edit', [
            'listing'=> $listing
        ]);
    }

    public function update(Request $request, Listing $listing) {

        if($listing->user_id != auth()->id()){
            abort(403, "Unathorized Action");
        }


        $inputs = $request->validate([
            
            'company' => 'required|max:255',
            'title' => 'required|max:255',
            'location' => 'required|max:255',
            'email' => 'required|email|max:255',
            'website' => 'required|max:255|url',
            'tags' => 'required|max:255',
            'description' => 'required',
            'logo' => 'mimes:jpg,jpeg,png'
            
        ]);

        if($request->hasFile('logo')){

           $inputs['logo'] =  $request->file('logo')->store('logos', 'public');
        }
        

        $listing->update($inputs);

        return redirect('/')->with('success', 'The post was updated successfully');
    }


    public function destroy(Listing $listing) {

        if($listing->user_id != auth()->id()){
            abort(403, "Unathorized Action");
        }

        $listing->delete();

        return redirect('/')->with('success', 'The post was deleted successfully');
    }
}
