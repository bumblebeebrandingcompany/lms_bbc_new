<?php

namespace App\Http\Requests;

use App\Models\Sitevisit;
use Illuminate\Foundation\Http\FormRequest;

use Gate;
use Illuminate\Foundation\Http\UpdateSiteVisitRequest;
use Illuminate\Http\Response;

class SitevisitRequest extends FormRequest
{
    public function authorize()
    {
        $user = auth()->user();
        return $user->is_superadmin || $user->is_client || $user->is_agency ||$user->is_presales || $user->is_admissionteam || $user->is_frontoffice;
    }
    public function rules()
    {

        return [
            'follow_up_date' => 'required|date',
            'follow_up_time' => 'required|date_format:H:i',
            'deleted_at' => 'date',
            'lead_id' => [
                'required',
                'integer',
            ],
            'user_id' => [

            ],
            'notes' => 'nullable|string'
        ];
    }
}
