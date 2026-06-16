@props(['screen' => 'create'])

<div class="sparkline12-list" style="margin-bottom: 20px;">
    <div class="sparkline12-graph">
        <div class="basic-login-form-ad">
            <h5 style="margin-top:0; color:#3c8dbc;">
                <i class="fa fa-lightbulb-o"></i>
                @switch($screen)
                    @case('create') How to create a notice @break
                    @case('edit') How to edit a notice @break
                    @default Notices guide
                @endswitch
            </h5>
            <ol style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom: 0;">
                @if($screen === 'create')
                    <li>Write a clear <strong>Title</strong> — parents and staff see this first in their notice list.</li>
                    <li>Enter the full announcement in <strong>Content</strong> (exam dates, holidays, fee reminders, etc.).</li>
                    <li>Pick <strong>Target Audience (Roles)</strong> — e.g. Parent + Student only. Leave all unchecked to show everyone.</li>
                    <li>Optionally restrict to specific <strong>Target Classes</strong>; leave unchecked for all classes.</li>
                    <li>Set <strong>Start Date</strong> and <strong>End Date</strong> to control when the notice is visible.</li>
                    <li>Keep <strong>Publish immediately</strong> checked to go live now — users receive an in-app notification.</li>
                    <li>Click <strong>Publish Notice</strong> to save and notify the selected audience.</li>
                @elseif($screen === 'edit')
                    <li>Update the <strong>title</strong> or <strong>content</strong> if the announcement details changed.</li>
                    <li>Adjust <strong>Target Roles</strong> or <strong>Classes</strong> to widen or narrow who can see it.</li>
                    <li>Change <strong>Start / End Date</strong> to extend or shorten the visibility window.</li>
                    <li>Uncheck <strong>Published</strong> to hide the notice without deleting it.</li>
                    <li>Re-publishing after edits may send updated notifications to the audience.</li>
                    <li>Click <strong>Update Notice</strong> to save your changes.</li>
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
                        <tr><th style="width:42%; background:#f5f5f5;">Title</th><td>Parent-Teacher Meeting — Class 5</td></tr>
                        <tr><th style="background:#f5f5f5;">Audience</th><td>Parent, Student</td></tr>
                        <tr><th style="background:#f5f5f5;">Classes</th><td>Class 5 only</td></tr>
                        <tr><th style="background:#f5f5f5;">Dates</th><td>1 Jun – 7 Jun 2026</td></tr>
                        <tr><th style="background:#f5f5f5;">Published</th><td>Yes</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="sparkline12-list" style="margin-bottom: 20px;">
        <div class="sparkline12-graph">
            <div class="basic-login-form-ad">
                <h5 style="margin-top:0; color:#3c8dbc;"><i class="fa fa-info-circle"></i> Audience guide</h5>
                <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
                    <tbody>
                        <tr><th style="width:35%; background:#f5f5f5;">No roles selected</th><td>Visible to all roles.</td></tr>
                        <tr><th style="background:#f5f5f5;">No classes selected</th><td>Visible to all classes.</td></tr>
                        <tr><th style="background:#f5f5f5;">Parent + Student</th><td>Family-facing announcements.</td></tr>
                        <tr><th style="background:#f5f5f5;">Teacher</th><td>Staff-only internal notices.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="sparkline12-list">
        <div class="sparkline12-graph">
            <div class="basic-login-form-ad">
                <h5 style="margin-top:0; color:#e08e0b;"><i class="fa fa-exclamation-triangle"></i> Things to keep in mind</h5>
                <ul style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom: 0;">
                    <li>Published notices trigger <strong>in-app notifications</strong> for the targeted audience.</li>
                    <li>After the <strong>End Date</strong>, the notice may no longer appear in user dashboards.</li>
                    <li>Notices are scoped to your <strong>branch</strong> — other branches do not see them.</li>
                    <li>Use specific class targeting for grade-level events; use all classes for school-wide news.</li>
                </ul>
            </div>
        </div>
    </div>
@endif
