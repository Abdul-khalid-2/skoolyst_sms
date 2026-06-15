@props(['screen' => 'create'])

<div class="sparkline12-list" style="margin-bottom: 20px;">
    <div class="sparkline12-graph">
        <div class="basic-login-form-ad">
            <h5 style="margin-top:0; color:#3c8dbc;">
                <i class="fa fa-lightbulb-o"></i>
                @switch($screen)
                    @case('create') How to add a holiday @break
                    @case('edit') How to edit a holiday @break
                    @default Holidays guide
                @endswitch
            </h5>
            <ol style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom: 0;">
                @if($screen === 'create')
                    <li>Enter a clear <strong>Holiday Title</strong> — e.g. Eid-ul-Fitr, Summer Vacation, Independence Day.</li>
                    <li>Set <strong>Start Date</strong> and <strong>End Date</strong> for the full holiday period (use the same date for a single-day holiday).</li>
                    <li>Check <strong>This holiday repeats</strong> for events that happen every year, month, or week.</li>
                    <li>Pick a <strong>Recurring Pattern</strong> when repeating — most public holidays use <em>Yearly</em>.</li>
                    <li>Add an optional <strong>Description</strong> with notes for staff (half-day, office closed, etc.).</li>
                    <li>Click <strong>Save Holiday</strong> — it appears on the school calendar and attendance views.</li>
                @elseif($screen === 'edit')
                    <li>Update the <strong>title</strong> or <strong>dates</strong> if the holiday schedule changed.</li>
                    <li>For a single-day holiday, set start and end date to the same day.</li>
                    <li>Toggle <strong>Recurring</strong> off if this is a one-time closure only.</li>
                    <li>Changing dates affects future calendar displays — past attendance records are not altered.</li>
                    <li>Click <strong>Update Holiday</strong> to save, or Cancel to go back without changes.</li>
                @endif
            </ol>
        </div>
    </div>
</div>

@if(in_array($screen, ['create', 'edit']))
    <div class="sparkline12-list" style="margin-bottom: 20px;">
        <div class="sparkline12-graph">
            <div class="basic-login-form-ad">
                <h5 style="margin-top:0; color:#3c8dbc;"><i class="fa fa-file-text-o"></i> Example</h5>
                <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
                    <tbody>
                        <tr><th style="width:42%; background:#f5f5f5;">Title</th><td>Eid-ul-Fitr</td></tr>
                        <tr><th style="background:#f5f5f5;">Start Date</th><td>10 Apr 2026</td></tr>
                        <tr><th style="background:#f5f5f5;">End Date</th><td>12 Apr 2026</td></tr>
                        <tr><th style="background:#f5f5f5;">Recurring</th><td>Yes — Yearly</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="sparkline12-list">
        <div class="sparkline12-graph">
            <div class="basic-login-form-ad">
                <h5 style="margin-top:0; color:#3c8dbc;"><i class="fa fa-info-circle"></i> Recurring patterns</h5>
                <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
                    <tbody>
                        <tr><th style="width:35%; background:#f5f5f5;">Yearly</th><td>Public holidays, annual breaks.</td></tr>
                        <tr><th style="background:#f5f5f5;">Monthly</th><td>Regular monthly off days.</td></tr>
                        <tr><th style="background:#f5f5f5;">Weekly</th><td>Repeats every week on the same days.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
