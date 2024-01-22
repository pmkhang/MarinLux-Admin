<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::orderBy('status', 'ASC')->orderBy('created_at', 'DESC')->paginate(10);
        $index = ($contacts->currentPage() - 1) * $contacts->perPage() + 1;
        $select = $request->select;
        if ($select) {
            $contacts = Contact::orderBy('status', 'ASC')->orderBy('created_at', 'DESC')->paginate(10);
            $index = ($contacts->currentPage() - 1) * $contacts->perPage() + 1;
            return view('admin.modules.contact.index', [
                'contacts' => $contacts,
                'index' => $index,
                'select' => $select
            ]);
        }
        return view('admin.modules.contact.index', [
            'contacts' => $contacts,
            'index' => $index,
            'select' => $select
        ]);
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        if ($contact->status == 1) {
            $contact->update([
                'status' => 2
            ]);
        }
        return view('admin.modules.contact.show', [
            'contact' => $contact
        ]);
    }
}
