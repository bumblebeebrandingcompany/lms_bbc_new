@if (auth()->user()->is_superadmin || auth()->user()->is_presales)
    <h3 class="card-title"> Lead ID: {{ $lead->id }}</h3>
    <br>
    <div class="table-responsive">

        <table class="table">
            <thead>
                <tr>
                    <th>Campaign Name</th>
                    <th>Follow-Up Time</th>
                    <th>Follow-Up Date</th>

                    <th>Notes</th>
                    <th>Created at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($followUps->where('parent_stage_id', 9) as $followUp)
                    <tr>
                        <td>{{ $lead->campaign->campaign_name }}</td>
                        <td>{{ $followUp->follow_up_time }}</td>
                        <td>{{ $followUp->follow_up_date }}</td>


                        <td>{{ $followUp->notes }}</td>
                        <td>{{ $followUp->created_at }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end">
        {{ $followUps->links('pagination::bootstrap-4') }}
    </div>
@endif
@if (auth()->user()->is_admissionteam)
    <h3 class="card-title"> Lead ID: {{ $lead->id }}</h3>
    <br>
    <div class="table-responsive">

        <table class="table">
            <thead>
                <tr>
                    <th>Campaign Name</th>
                    <th>Follow-Up Time</th>
                    <th>Follow-Up Date</th>

                    <th>Notes</th>
                    <th>Created at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($followUps->where('parent_stage_id', 28) as $followUp)
                    <tr>
                        <td>{{ $lead->campaign->campaign_name }}</td>
                        <td>{{ $followUp->follow_up_time }}</td>
                        <td>{{ $followUp->follow_up_date }}</td>


                        <td>{{ $followUp->notes }}</td>
                        <td>{{ $followUp->created_at }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end">
        {{ $followUps->links('pagination::bootstrap-4') }}
    </div>
@endif
