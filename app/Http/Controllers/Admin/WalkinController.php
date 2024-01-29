<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Models\Walkin;
use App\Utils\Util;
use App\Models\Project;
use App\Models\Lead;
use App\Models\Source;

use App\Models\Clients;
class WalkinController extends Controller
{
    protected $util;

    /**
     * Constructor
     *
     */
    public function __construct(Util $util)
    {
        $this->util = $util;
    }
    public function index()
    {

        $walkins = Walkin::with('leads')->get();
        $projects = Project::pluck('name', 'id');
        $client=Clients::all();
        $sources=Source::all();
        $campaign=Campaign::all();
        $projects=Project::all();
        return view('admin.walkinform.index', compact('walkins','client','sources','campaign','projects'));
    }

    // public function show(Walkin $cpwalkin)
    // {
    //     return view('admin.cpwalkins.show', compact('cpwalkin'));
    // }

    public function create()
    {
        $projects=Project::all();
        $client=Clients::all();
        $sources=Source::all();
        $campaigns=Campaign::all();
        $project_ids = $this->util->getUserProjects(auth()->user());
<<<<<<< HEAD
        $projects = Project::whereIn('id', $project_ids)
            ->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
            $project_id = request()->get('project_id', null);
            $phone = request()->get('phone', null);
            $action = request()->get('action', null);
        return view('admin.walkinform.create', compact('projects', 'project_id', 'phone', 'action','client','sources','campaigns','projects'));
=======
        $projects = Project::all();
        return view('admin.walkinform.create', compact('projects', 'project_ids','client','sources','campaigns','projects'));
>>>>>>> 1434718 (live)
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',

            'phone' => 'required|string|max:255',


        ]);
        $walkin = Walkin::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
<<<<<<< HEAD
            'source_id' => $request->input('source_id')
=======
            'source_id' => $request->input('source_id'),
            'project_id' => $request->input('project_id'),
            'campaign_id' => $request->input('campaign_id')
>>>>>>> 1434718 (live)
        ]);
        $lead=Lead::create([
           'walkin_id'=>$walkin->id,
            'name' => $walkin->name,
            'email' => $walkin->email,
            'phone' => $walkin->phone,
            'source_id' => $walkin->source_id,
<<<<<<< HEAD
=======
            'project_id' => $walkin->project_id,
            'campaign_id' => $walkin->campaign_id,
>>>>>>> 1434718 (live)
            'additional_email'=>$request->input('additional_email'),
            'secondary_phone'=>$request->input('secondary_phone'),
        ]);
        $lead->ref_num = $this->util->generateLeadRefNum($lead);
        $lead->save();
<<<<<<< HEAD
        $this->util->storeUniqueWebhookFields($lead);
        if(!empty($lead->project->outgoing_apis)) {
            $this->util->sendApiWebhook($lead->id);
        }
        if(!empty($request->get('redirect_to')) && $request->get('redirect_to') == 'ceoi') {
            return redirect()->route('admin.eoi.create', ['phone' => $lead->phone]);
        }
=======
        // $this->util->storeUniqueWebhookFields($lead);
        // if(!empty($lead->project->outgoing_apis)) {
        //     $this->util->sendApiWebhook($lead->id);
        // }
        // if(!empty($request->get('redirect_to')) && $request->get('redirect_to') == 'ceoi') {
        //     return redirect()->route('admin.eoi.create', ['phone' => $lead->phone]);
        // }
>>>>>>> 1434718 (live)
        return redirect()->route('admin.walkinform.index')->with('success', 'Form created successfully');
    }
    public function edit(Walkin $walkin)


    {
        $sources=Source::all();
        $client=Clients::all();
        return view('admin.walkinform.edit', compact('walkin','sources','client'));
    }
    public function show(Walkin $walkin)
{
  
    return view('admin.walkinform.show', compact('walkin'));
}
    public function update(Request $request, Walkin $walkin)
{
    // Validate the incoming request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string',

        'phone' => 'required|string|max:255',

        'referred_by' => 'required|string|max:255',
    ]);

    // Update the CpWalkin attributes
    $walkin->update([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
    ]);

    // Retrieve the associated Lead using the relationship
    // $lead = $walkin->leads()->first();

    // $lead->update([
    //     'name' => $walkin->name,
    //     'email' => $walkin->email,

    //     'phone' => $walkin->phone,

    //     'additional_email'=>$request->input('additional_email'),
    //     'secondary_phone'=>$request->input('secondary_phone'),

    // ]);

    // $this->util->storeUniqueWebhookFields($lead);
    return redirect()->route('admin.walkinform.index')->with('success', 'Form updated successfully');
}
public function destroy($id)
{
    $walkin = Walkin::findOrFail($id);
    $walkin->delete();

    return redirect()->route('admin.walkinform.index')->with('success', 'Walkin deleted successfully');
}




}