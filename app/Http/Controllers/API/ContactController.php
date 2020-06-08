<?php

namespace App\Http\Controllers\API;

use App\Entities\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    private $rules = [
        "user_id" => "required|integer",
        "name" => "required",
        "email" => "required|email",
        "phone" => "required",
    ];

    public function index()
    {
        return Contact::all();
    }

    public function contacts(Request $request)
    {
        return Contact::where('user_id', Auth::user()->id)->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        return Contact::create($request->all());
    }

    public function show(Contact $contact)
    {
        return $contact;
    }

    public function update(Request $request, Contact $contact)
    {
        $this->validate($request, $this->rules);
        return $contact->update($request->all());
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->noContent();
    }
}
