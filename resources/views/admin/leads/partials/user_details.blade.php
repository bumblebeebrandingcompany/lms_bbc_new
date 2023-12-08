<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://unpkg.com/pdfmake@0.1.18/build/pdfmake.min.js"></script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Stages Popup</title>
<style>
    /* Styles for the popup */
    .popup {
        display: none;
        position: fixed;
        top: 30%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        z-index: 1000;
        width: 400px;
        /* Adjust the width as needed */
        height: 300px;
        /* Adjust the height as needed */
    }
</style>
<style>
    .popup {
        display: none;
    }

    .show {
        display: block;
    }
</style>
<style>
    .edit-field.error {
        background-color: #ffcccc;
        /* Change this to the desired shade of red */
    }
</style>
<div class="card card-primary card-outline">
    <div class="card-body box-profile">



        <div style="text-align: right;">
            <input type="hidden" name="lead_id" value="{{ $lead->id }}">
            {{-- <button type="submit" class="btn btn-primary" id="initiateCallButton">
                    <i class="fas fa-phone fa-flip-horizontal"></i>
                </button> --}}
            <div class="lead-item">
                <a href="{{ route('admin.leads.initiateCall', [$lead->id]) }}" class="btn btn-primary"> <i
                        class="fas fa-phone fa-flip-horizontal"></i></a>
            </div>
        </div>
        <br>
        <button type="button" class="float-right edit-button">Edit</button>

        <div class="text-center">
            @php
                $avatar = 'https://ui-avatars.com/api/?background=random&font-size=0.7&name=' . $lead->name;
            @endphp
            <img class="profile-user-img img-fluid img-circle" src="{{ $avatar }}" alt="{{ $lead->name ?? '' }}">
        </div>
        <form method="POST" action="{{ route('admin.leads.update', [$lead->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <button type="submit" class="float-right save-button" style="display:none;">Save</button>
            <h3 class="profile-username text-center">
                {{ $lead->name ?? '' }}
            </h3>
            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>{{ trans('messages.ref_num') }}</b>
                    <a class="float-right">{{ $lead->ref_num }}</a>
                </li>
                <!-- <li class="list-group-item">
                <b>@lang('messages.sell_do_lead_id')</b>
                <a class="float-right">
                    {!! $lead->sell_do_lead_id ?? '' !!}
                </a>
            </li> -->
                <li class="list-group-item">
                    <b> @lang('messages.email')</b>
                    <a class="float-right">
                        @if (auth()->user()->is_channel_partner_manager && !empty($lead->email))
                            {{ maskEmail($lead->email) }}
                        @else
                            {{ $lead->email ?? '' }}
                        @endif
                    </a>
                </li>
                {{-- <li class="list-group-item">
                <b>@lang('messages.additional_email_key')</b>
                <a class="float-right">
                    @if (auth()->user()->is_channel_partner_manager && !empty($lead->additional_email))
                        {{ maskEmail($lead->additional_email) }}
                    @else
                        {{ $lead->additional_email ?? '' }}
                    @endif
                </a>
            </li> --}}
                <li class="list-group-item">
                    <b>{{ trans('messages.additional_email_key') }}</b>
                    <a class="float-right">
                        <span class="value-container">
                            @if (!$errors->has('additional_email'))
                                <span class="display-value">
                                    {{ $lead->additional_email }}
                                </span>
                            @endif
                            <input type="email" name="additional_email" class="edit-field"
                                placeholder="Enter additional mail"
                                style="{{ $errors->has('additional_email') ? '' : 'display:none;' }}"
                                value="{{ old('additional_email') }}">
                        </span>
                        @error('additional_email')
                            <div class="text-danger">{{ $message }}</div>
                            <script>
                                // Show save button when there is an error
                                $(document).ready(function() {
                                    $('.save-button').show();
                                });
                            </script>
                        @enderror
                    </a>
                </li>
                <li class="list-group-item">
                    <b>@lang('messages.phone')</b>
                    <a class="float-right">
                        @if (auth()->user()->is_channel_partner_manager && !empty($lead->phone))
                            {{ maskNumber($lead->phone) }}
                        @else
                            {{ $lead->phone ?? '' }}
                        @endif
                    </a>
                </li>
                <li class="list-group-item">
                    <b>{{ trans('messages.secondary_phone_key') }}</b>
                    <a class="float-right">
                        <span class="value-container">
                            <span class="display-value"
                                style="{{ $errors->has('secondary_phone') ? 'display:none;' : '' }}">
                                {{ $lead->secondary_phone }}
                            </span>
                            <input type="phone" name="secondary_phone" class="edit-field"
                                placeholder="Enter Alternative Number"
                                style="{{ $errors->has('secondary_phone') ? '' : 'display:none;' }}"
                                value="{{ old('secondary_phone') }}">
                            @error('secondary_phone')
                                <div class="text-danger">{{ $message }}</div>
                                <script>
                                    // Show save button when there is an error
                                    $(document).ready(function() {
                                        $('.save-button').show();
                                    });
                                </script>
                            @enderror
                        </span>
                    </a>
                </li>
                {{-- <li class="list-group-item">
                <b>@lang('messages.secondary_phone_key')</b>
                <a class="float-right">
                    @if (auth()->user()->is_channel_partner_manager && !empty($lead->secondary_phone))
                        {{ maskNumber($lead->secondary_phone) }}
                    @else
                        {{ $lead->secondary_phone ?? '' }}
                    @endif
                </a>
            </li> --}}
                <li class="list-group-item">
                    <b>{{ trans('cruds.lead.fields.project') }}</b>
                    <a class="float-right">
                        {{ $lead->project->name ?? '' }}
                    </a>
                </li>
                <li class="list-group-item">
                    <b>{{ trans('cruds.lead.fields.campaign') }}</b>
                    <a class="float-right">
                        {{ $lead->campaign->campaign_name ?? '' }}
                    </a>
                </li>
                <li class="list-group-item">
                    <b>{{ trans('messages.source') }}</b>
                    <a class="float-right">
                        {{ $lead->source->name ?? '' }}
                    </a>
                </li>

                <li class="list-group-item">
                    <b>Intake Year</b>
                    <a class="float-right">
                        <span class="value-container">
                            <span class="display-value">{{ $lead->intake_year }}</span>

                            <select name="intake_year" class="edit-field"
                                style="{{ $errors->has('intake_year') ? '' : 'display:none;' }}"
                                value="{{ old('intake_year') }}">
                                @if ($lead->intake_year)
                                    <option value="{{ $lead->intake_year }}" selected>{{ $lead->intake_year }}
                                    </option>
                                @else
                                    <option value="" selected> Select Year</option>
                                @endif
                                @for ($startYear = date('Y'); $startYear >= 2000; $startYear--)
                                    @php
                                        $endYear = $startYear + 1;
                                        $yearRange = $startYear . '-' . $endYear;
                                    @endphp
                                    <option value="{{ $yearRange }}">{{ $yearRange }}</option>
                                @endfor
                            </select>

                            @error('intake_year')
                                <div class="text-danger">{{ $message }}</div>
                                {{-- Show the save button when there is an error --}}
                                <script>
                                    $(document).ready(function() {
                                        $('.save-button').show();
                                    });
                                </script>
                            @enderror

                            {{-- Check if there are no errors related to 'intake_year' --}}
                        </span>
                    </a>
                </li>
                <li class="list-group-item">
                    <b>Grade Enquired</b>
                    <a class="float-right">
                        <span class="value-container">
                            <span class="display-value">{{ $lead->grade_enquired }}</span>

                            <select name="grade_enquired" class="edit-field select2"
                                style="{{ $errors->has('grade_enquired') ? '' : 'display:none;' }} ">

                                @if ($lead->grade_enquired)
                                    <option value="{{ $lead->grade_enquired }}" selected>{{ $lead->grade_enquired }}
                                    </option>
                                @else
                                    <option value="" selected> Select Grade</option>
                                @endif

                                @for ($i = -2; $i <= 12; $i++)
                                    @php
                                        if ($i == -2) {
                                            $grade = 'Pre-KG';
                                        } elseif ($i == -1) {
                                            $grade = 'LKG';
                                        } elseif ($i == 0) {
                                            $grade = 'UKG';
                                        } else {
                                            $grade = $i;
                                        }
                                    @endphp
                                    <option value="{{ $grade }}"
                                        @if (old('grade_enquired', $lead->grade_enquired) == $grade) selected @endif>
                                        {{ $grade }}
                                    </option>
                                @endfor
                            </select>
                            @error('grade_enquired')
                                <div class="text-danger">{{ $message }}</div>
                                <script>
                                    $(document).ready(function() {
                                        $('.save-button').show();
                                    });
                                </script>
                            @enderror
                        </span>
                    </a>
                </li>
                </li>


                <li class="list-group-item">
                    <b>Current School</b>
                    <a class="float-right">
                        <span class="value-container">
                            <span class="display-value"
                                style="{{ $errors->has('current_school') ? 'display:none;' : '' }}">
                                {{ $lead->current_school }}
                            </span>
                            <input type="text" name="current_school" class="edit-field"
                                placeholder="Enter Current School"
                                style="{{ $errors->has('current_school') ? '' : 'display:none;' }}"
                                value="{{ old('current_school') }}">
                            @error('current_school')
                                <div class="text-danger">{{ $message }}</div>
                                {{-- Show the save button when there is an error --}}
                                <script>
                                    $(document).ready(function() {
                                        $('.save-button').show();
                                    });
                                </script>
                            @enderror
                        </span>
                    </a>
                </li>
                <li class="list-group-item">
                    <b>Stage</b>
                    <a class="float-right">{{ $lead->parentStage->name ?? '' }}</a>
                </li>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#stageModal">
                    View Stages
                </button>

                <div class="modal fade" id="stageModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Child Stages</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('admin.leads.update', [$lead->id]) }}"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="modal-body">
                                    <p><b>Parent Stage:</b> {{ $lead->parentStage->name ?? ' ' }}</p>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="tag_id">Select Tag:</label>
                                            <select name="tag_id" id="tag_id" class="form-control">
                                                <option value="" selected disabled>Please Select</option>
                                                @foreach ($tags as $tag)
                                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="hidden" name="parent_stage_id" id="selected_stage_id"
                                            value="{{ $lead->parentstage->id ?? '' }}">

                                        <div class="form-group">
                                            <label for="child_stage_id">Select Child Stage:</label>
                                            <select name="parent_stage_id" id="child_stage_id" class="form-control" onchange="checkParentStageId(this)">
                                                <option value="" selected disabled>Please Select</option>
                                                {{-- Options will be dynamically populated based on the selected tag and lead's stage --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div> --}}
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary float-right" type="submit">
                                        {{ trans('global.save') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <form id="ResheduleFormId" method="POST" action="{{ route('admin.sitevisit.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div id="rescheduleContent" style="display: none;">
                                <!-- Your follow-up content goes here -->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="followUpModalLabel">Reschedule</h5>

                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                                        <div class="form-group">
                                            <label type="select" for="user_id">clients</label>
                                            <select name="user_id" id="user_id"
                                                class="form-control{{ $errors->has('user_id') ? ' is-invalid' : '' }}"
                                                rows="3" required>{{ old('user_id') }}
                                                >
                                                <option value="" selected disabled>Please Select</option>
                                                @foreach ($client as $id => $clients)
                                                    @foreach ($clients->clientUsers as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                            {{ $user->representative_name }}
                                                        </option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="Date">Select Date </label>
                                            <input type="date"
                                                class="form-control datepicker {{ $errors->has('form-control datepicker') ? 'is-invalid' : '' }}"
                                                name="follow_up_date" id="follow_up_date" rows="3"
                                                required>{{ old('follow_up_date') }}
                                        </div>

                                        <div class="form-group">
                                            <label for="Time">select time </label>
                                            <input
                                                class="form-control timepicker {{ $errors->has('form-control timepicker') ? 'is-invalid' : '' }}"
                                                name="follow_up_time" id="follow_up_time" rows="3"
                                                required>{{ old('follow_up_time') }}
                                        </div>
                                        <div class="form-group">
                                            <label for="noteContent">Note Content</label>
                                            <textarea class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" id="notes"
                                                rows="4" required>{{ old('notes') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" onclick="togglePopup()">Close</button>
                                        <button class="btn btn-danger" type="submit">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form id="FollowupFormId" method="POST" action="{{ route('admin.followups.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div id="followUpContent" style="display: none;">
                                <!-- Your follow-up content goes here -->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="followUpModalLabel">Follow Up</h5>

                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                                        <div class="form-group">
                                            <label type="select" for="user_id">clients</label>
                                            <select name="user_id" id="user_id"
                                                class="form-control{{ $errors->has('user_id') ? ' is-invalid' : '' }}"
                                                rows="3" required>{{ old('user_id') }}
                                                >
                                                <option value="" selected disabled>Please Select</option>
                                                @foreach ($agencies as $id => $agency)
                                                    @foreach ($agency->agencyUsers as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                            {{ $user->representative_name }}
                                                        </option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="Date">Select Date </label>
                                            <input type="date"
                                                class="form-control datepicker {{ $errors->has('form-control datepicker') ? 'is-invalid' : '' }}"
                                                name="follow_up_date" id="follow_up_date" rows="3"
                                                required>{{ old('follow_up_date') }}
                                        </div>

                                        <div class="form-group">
                                            <label for="Time">select time </label>
                                            <input
                                                class="form-control timepicker {{ $errors->has('form-control timepicker') ? 'is-invalid' : '' }}"
                                                name="follow_up_time" id="follow_up_time" rows="3"
                                                required>{{ old('follow_up_time') }}
                                        </div>
                                        <div class="form-group">
                                            <label for="noteContent">Note Content</label>
                                            <textarea class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" id="notes"
                                                rows="4" required>{{ old('notes') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" onclick="togglePopup()">Close</button>
                                        <button class="btn btn-danger" type="submit">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form id="SitevisitFormId" method="POST" action="{{ route('admin.sitevisit.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div id="siteVisitContent" style="display: none;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="followUpModalLabel">Site Visit</h5>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                                        <div class="form-group">
                                            <label type="select" for="user_id">clients</label>
                                            <select name="user_id" id="user_id"
                                                class="form-control{{ $errors->has('user_id') ? ' is-invalid' : '' }}"
                                                rows="3" required>{{ old('user_id') }}
                                                >
                                                <option value="" selected disabled>Please Select</option>
                                                @foreach ($client as $id => $clients)
                                                    @foreach ($clients->clientUsers as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                            {{ $user->representative_name }}
                                                        </option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            <div class="form-group">
                                                <label for="Date">Select Date </label>
                                                <input type="date"
                                                    class="form-control datepicker {{ $errors->has('form-control datepicker') ? 'is-invalid' : '' }}"
                                                    name="follow_up_date" id="follow_up_date" rows="3"
                                                    required>{{ old('follow_up_date') }}
                                            </div>

                                            <div class="form-group">
                                                <label for="Time">select time </label>
                                                <input
                                                    class="form-control timepicker {{ $errors->has('form-control timepicker') ? 'is-invalid' : '' }}"
                                                    name="follow_up_time" id="follow_up_time" rows="3"
                                                    required>{{ old('follow_up_time') }}
                                            </div>
                                            <div class="form-group">
                                                <label for="noteContent">Note Content</label>
                                                <textarea class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" id="notes"
                                                    rows="4" required>{{ old('notes') }}</textarea>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" onclick="togglePopup()">Close</button>
                                                <button class="btn btn-danger" type="submit">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                    @php
                        $lead_info = $lead->lead_info;
                        if (!empty($lead->source) && !empty($lead->source->name_key) && isset($lead_info[$lead->source->name_key]) && !empty($lead_info[$lead->source->name_key])) {
                            unset($lead_info[$lead->source->name_key]);
                        }

                        if (!empty($lead->source) && !empty($lead->source->email_key) && isset($lead_info[$lead->source->email_key]) && !empty($lead_info[$lead->source->email_key])) {
                            unset($lead_info[$lead->source->email_key]);
                        }

                        if (!empty($lead->source) && !empty($lead->source->phone_key) && isset($lead_info[$lead->source->phone_key]) && !empty($lead_info[$lead->source->phone_key])) {
                            unset($lead_info[$lead->source->phone_key]);
                        }

                        if (!empty($lead->source) && !empty($lead->source->additional_email_key) && isset($lead_info[$lead->source->additional_email_key]) && !empty($lead_info[$lead->source->additional_email_key])) {
                            unset($lead_info[$lead->source->additional_email_key]);
                        }

                        if (!empty($lead->source) && !empty($lead->source->secondary_phone_key) && isset($lead_info[$lead->source->secondary_phone_key]) && !empty($lead_info[$lead->source->secondary_phone_key])) {
                            unset($lead_info[$lead->source->secondary_phone_key]);
                        }
                    @endphp
                    @foreach ($lead_info as $key => $value)
                        <li class="list-group-item">
                            <b>{!! $key !!}</b>
                            <a class="float-right">
                                {!! $value !!}
                            </a>
                        </li>
                    @endforeach
                    <!-- <li class="list-group-item">
                <b>@lang('messages.sell_do_created_date')</b>
                <a class="float-right">
                    @if (!empty($lead->sell_do_lead_created_at))
{{ @format_datetime($lead->sell_do_lead_created_at) }}
@endif
                </a>
            </li> -->
                    <!-- <li class="list-group-item">
                <b>@lang('messages.sell_do_status')</b>
                <a class="float-right">
                    {!! $lead->sell_do_status ?? '' !!}
                </a>
            </li> -->
                    <!-- <li class="list-group-item">
                <b>@lang('messages.sell_do_stage')</b>
                <a class="float-right">
                    {!! $lead->sell_do_stage ?? '' !!}
                </a>
            </li> -->
                    <li class="list-group-item">
                        <b>@lang('messages.customer_comments')</b>
                        <a class="float-right">
                            {!! $lead->comments ?? '' !!}
                        </a>
                    </li>
                    <li class="list-group-item">
                        <b>@lang('messages.cp_comments')</b>
                        <a class="float-right">
                            {!! $lead->cp_comments ?? '' !!}
                        </a>
                    </li>
                    <li class="list-group-item">
                        <b>@lang('messages.added_by')</b>
                        <a class="float-right">
                            {{ $lead->createdBy ? $lead->createdBy->name : '' }}
                        </a>
                    </li>
        </form>
        </ul>
        {{-- <li class="list-group-item">
            <b>{{ trans('messages.stages') }}</b>
            <a href="#" class="float-right" onclick="togglePopup()">View Stages</a>

            <div id="stagesPopup" class="popup">
                <h3>Stages</h3>
                <select id="mainDropdown" onchange="showSubOptions()">

                    <option value="interested">Interested</option>
                    <option value="notInterested">Not Interested</option>
                    <option value="rnr">RNR</option>
                </select>
                <br>
                <br>
                <select id="SecondDropdown">
                    <!-- Options will be dynamically populated using JavaScript -->
                </select>

        </li> --}}
    </div>
</div>
@section('scripts')
    <script>
        $(document).ready(function() {
            datetimeElement.datetimepicker({
                format: 'DD-MM-YYYY HH:mm:ss',
                locale: 'en',
                sideBySide: true,
                icons: {
                    up: 'fas fa-chevron-up',
                    down: 'fas fa-chevron-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right'
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.edit-button').on('click', function() {
                // Show the edit fields and set border color to red
                $('.edit-field').show().css('border-color', 'red');
                $('.display-value').hide();
                $('.save-button').show();
                $('.edit-field').each(function() {
                    var fieldName = $(this).attr('name');
                    var displayValue = $(this).siblings('.display-value').text();
                    $(this).val(displayValue);
                });
                // Clear any previous error messages
                $('.error-message').text('');
            });

            $('.save-button').on('click', function() {
                // Create an object to store the updated values
                var updatedValues = {};
                var isValid = true;
                // Update the display values with the entered values and store in the object
                $('.display-value').each(function() {
                    var fieldName = $(this).attr('name');
                    var updatedValue = $(this).siblings('.edit-field').val();

                    // Perform validation for each field
                    switch (fieldName) {
                        case 'additional_email':
                            if (!isValidEmail(updatedValue)) {
                                isValid = false;
                                $('.error-message').text('Invalid email address.');
                            }
                            break;
                        case 'secondary_phone':
                            if (!isValidPhoneNumber(updatedValue)) {
                                isValid = false;
                                $('.error-message').text(
                                    'Invalid phone number (10 digits required).');
                            }
                            break;
                        case 'intake_year':
                            // Add validation logic if needed
                            break;
                        case 'grade_enquired':
                            // Add validation logic if needed
                            break;

                        case 'current_school':
                            // Add validation logic if needed
                            break;
                            // Add more cases for other fields as needed
                    }

                    updatedValues[fieldName] = updatedValue;
                });
                if (updatedValue.trim() === '') {
                    $(this).siblings('.edit-field').css('border-color', 'red');
                } else {
                    $(this).siblings('.edit-field').css('border-color', 'blue');
                }

                // Add the _method field for Laravel to recognize it as a PUT request
                updatedValues['_method'] = 'PUT';
                // Check if all fields are valid before making the AJAX request
                if (isValid) {
                    $.ajax({
                        method: 'POST',
                        url: '{{ route('admin.leads.update', [$lead->id]) }}',
                        data: updatedValues,
                        success: function(response) {
                            // Handle success if needed
                            console.log(response);
                            // Hide the text fields and show the display values
                            $('.edit-field').hide();
                            $('.display-value').show();
                        },
                        error: function(error) {
                            // Log the error response
                            console.error(error.responseJSON);
                            // Show the text fields and hide the display values
                            $('.edit-field').show();
                            $('.display-value').hide();
                        }
                    });
                }
            });
        });
    </script>


    {{-- <script>
        function showSubOptions() {
            var mainDropdown = document.getElementById("mainDropdown");
            var secondDropdown = document.getElementById("SecondDropdown");

            // Reset second dropdown options
            secondDropdown.innerHTML = '';

            // Add a default option to the second dropdown
            addOption(secondDropdown, "default", "Please Select");

            // Add options to the second dropdown based on the selected value
            var selectedValueMain = mainDropdown.value;
            if (selectedValueMain === "interested") {
                addOption(secondDropdown, "subOption1", "SiteVisit");
                addOption(secondDropdown, "subOption2", "FollowUp");
                addOption(secondDropdown, "subOption3", "Reschedule");
                addOption(secondDropdown, "subOption4", "Site Visit Conducted");
                addOption(secondDropdown, "subOption5", "Application Purchase");
                addOption(secondDropdown, "subOption6", "Admitted");
            } else if (selectedValueMain === "notInterested") {
                addOption(secondDropdown, "subOption7", "Spam");
                addOption(secondDropdown, "subOption8", "Not Qualified");
                addOption(secondDropdown, "cancel");
            } else if (selectedValueMain === "rnr") {
                addOption(secondDropdown, "subOption5", "RNR");
            }
            // Toggle the follow-up content based on the selected value
            showFollowUpContent();
            // Toggle the SiteVisitContent based on the selected value
            showSiteVisitContent();
            // Toggle the RescheduleContent based on the selected value
            showRescheduleContent();
            showSitevisitConducedContent();

        }

        function addOption(selectElement, value, text) {
            var option = document.createElement("option");
            option.value = value;
            option.text = text;
            selectElement.add(option);
        }

        function togglePopup() {
            var popup = document.getElementById("stagesPopup");
            popup.classList.toggle("show");
        }

        function saveForm(formId) {
            // Add logic to submit the form
            document.getElementById(formId).submit();
        }


        function showFollowUpContent() {
            var mainDropdown = document.getElementById("mainDropdown");
            var secondDropdown = document.getElementById("SecondDropdown");
            var followUpContent = document.getElementById("followUpContent");

            // Check the selected value from the main dropdown and second dropdown
            var selectedValueMain = mainDropdown.value;
            var selectedValueSecond = secondDropdown.value;

            // Show or hide the follow-up content based on the selected values
            if (selectedValueMain === "interested" && selectedValueSecond === "subOption2") {
                followUpContent.style.display = "block";
            } else {
                followUpContent.style.display = "none";
            }
        }

        function showSiteVisitContent() {
            var mainDropdown = document.getElementById("mainDropdown");
            var secondDropdown = document.getElementById("SecondDropdown");
            var siteVisitContent = document.getElementById("siteVisitContent");

            // Check the selected value from the main dropdown and second dropdown
            var selectedValueMain = mainDropdown.value;
            var selectedValueSecond = secondDropdown.value;

            // Show or hide SiteVisitContent based on the selected values
            if (selectedValueMain === "interested" && selectedValueSecond === "subOption1") {
                siteVisitContent.style.display = "block";
            } else {
                siteVisitContent.style.display = "none";
            }
        }

        function showRescheduleContent() {
            var mainDropdown = document.getElementById("mainDropdown");
            var secondDropdown = document.getElementById("SecondDropdown");
            var rescheduleContent = document.getElementById("rescheduleContent");

            // Check the selected value from the main dropdown and second dropdown
            var selectedValueMain = mainDropdown.value;
            var selectedValueSecond = secondDropdown.value;

            // Show or hide the reschedule content based on the selected values
            if (selectedValueMain === "interested" && selectedValueSecond === "subOption3") {
                rescheduleContent.style.display = "block";
            } else {
                rescheduleContent.style.display = "none";
            }
        }

        function showSitevisitConducedContent() {
            var mainDropdown = document.getElementById("mainDropdown");
            var secondDropdown = document.getElementById("SecondDropdown");
            var rescheduleContent = document.getElementById("sitevisitconductedContent");

            // Check the selected value from the main dropdown and second dropdown
            var selectedValueMain = mainDropdown.value;
            var selectedValueSecond = secondDropdown.value;

            // Show or hide the reschedule content based on the selected values
            if (selectedValueMain === "interested" && selectedValueSecond === "subOption4") {
                rescheduleContent.style.display = "block";
            } else {
                rescheduleContent.style.display = "none";
            }
        }
        // Attach the showSubOptions function to the change event of the main dropdown
        // Attach the showFollowUpContent, showSiteVisitContent, and showRescheduleContent functions to the change event of the second dropdown
        document.getElementById("mainDropdown").addEventListener("change", function() {
            showSubOptions();
        });
        document.getElementById("SecondDropdown").addEventListener("change", function() {
            showFollowUpContent();
            showSiteVisitContent();
            showRescheduleContent();
            showSitevisitConducedContent();

        });

        // Execute showSubOptions once on page load to handle the initial state
        showSubOptions();
    </script> --}}
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>
     function checkParentStageId(selectElement) {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var selectedName = selectedOption.text; // Get the name of the selected option

        // Check if the selected name is 'FollowUp'
        if (selectedName.trim().toLowerCase() === 'followup') {
            // If the selected name is 'FollowUp', display the modal
            document.getElementById('followupContent').style.display = 'block';
        } else {
            // If not, hide the modal
            document.getElementById('followupContent').style.display = 'none';
        }
    }

    function togglePopup() {
        // Add any additional logic for closing the popup if needed
        document.getElementById('followupContent').style.display = 'none';
    }

    // Initially check the value on page load
    document.addEventListener('DOMContentLoaded', function () {
        checkParentStageId(document.getElementById('parent_stage_id'));
    });

    $(document).ready(function() {
        $('#tag_id').change(function() {
            var selectedTagId = $('#tag_id option:selected').val();

            // Check if childStages is not null
            var childStages = {!! json_encode($lead->parentStage->childStages ?? null) !!};
            console.log("Child Stages:", childStages);

            var selectedChildStages = [];

            // Check if childStages is not null and has the selected_child_stages property
            if (childStages && childStages.length > 0 && childStages[0].selected_child_stages) {
                selectedChildStages = JSON.parse(childStages[0].selected_child_stages);
            }

            console.log("Selected Child Stages:", selectedChildStages);

            $('#child_stage_id').html(
                '<option value="" selected disabled>Please Select a Tag First</option>');

            if (selectedTagId && selectedChildStages) {
                // Filter child stages based on the selected tag and lead's selected_child_stages
                @foreach ($parentStages as $stage)
                    if ("{{ $stage->tag_id }}" == selectedTagId && selectedChildStages.includes(
                            "{{ $stage->id }}")) {
                        $('#child_stage_id').append(
                            '<option value="{{ $stage->id }}" data-tag="{{ $stage->tag_id }}">{{ $stage->name }}</option>'
                        );
                    }
                @endforeach
            }
        });
    });

</script>
