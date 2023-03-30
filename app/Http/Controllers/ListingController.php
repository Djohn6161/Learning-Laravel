<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //show all listings
    public function index(){
        // dd(request('tag'));
        // dd(Listing::latest()->filter(request(['tag', 'search']))->paginate(2));
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }

    // Single Listing
    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing
        ]);
    }
    // Show create form
    public function create(){
        return view('listings.create');
    }
    // Store Listing Data
    public function store(Request $request){
        // dd($request->file('logo'))->store();
        // dd($request->all());
        $formFields = $request->validate([
            'title' => 'required',
            // 'company' => 'required|unique:listings,company',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $formFields['user_id'] = auth()->id();
        Listing::create($formFields);

        // Session::Flash('message', 'Listing Created');

        return redirect('/')->with('message', 'Listing Created Successfully!');
    }
    // Show Edit Form
    public function edit(Listing $listing){
        // dd($listing->title);
        return view('listings.edit', ['listing' => $listing]);
    }
    public function update(Request $request, Listing $listing){
        // dd($request->file('logo'))->store();
        // dd($request->all());
        // Make sure login user is owner
        if($listing->user_id != auth()->id()){
            abort(403, 'Unauthorized Action');
        }
        $formFields = $request->validate([
            'title' => 'required',
            // 'company' => 'required|unique:listings,company',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $listing->update($formFields);

        // Session::Flash('message', 'Listing Created');

        return back()->with('message', 'Listing Updated Successfully!');
    }
    // Delete Listing
    public function destroy(Listing $listing){
        // Make sure login user is owner
        if($listing->user_id != auth()->id()){
            abort(403, 'Unauthorized Action');
        }
        
        $listing->delete();
        return redirect('/')->with('message', 'Listing Deleted successfully');

    }

    //manage Listings
    public function manage(){
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
