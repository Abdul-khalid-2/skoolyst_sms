@props(['mode' => 'create'])

<div class="white-box" style="margin-bottom: 20px;">
    <h5 style="margin-top:0; color:#3c8dbc;">
        <i class="fa fa-lightbulb-o"></i>
        {{ $mode === 'create' ? 'How to register a teacher' : 'How to update teacher information' }}
    </h5>
    <ol style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom: 0;">
        @if($mode === 'create')
            <li>Fill in <strong>Personal Information</strong> — fields marked with <span class="text-danger">*</span> are required.</li>
            <li>Choose a single <strong>Role</strong>: Teacher (classroom staff) or Admin (school management access).</li>
            <li>Enter <strong>Professional Information</strong> including Employee ID, qualification, and joining date.</li>
            <li>Upload a <strong>profile photo</strong> and qualification document (if available).</li>
            <li>Optionally assign the teacher as <strong>Class Teacher</strong> of a specific class.</li>
            <li>Click <strong>Register Teacher</strong> — default login password is <code>12345678</code> (change after first login).</li>
        @else
            <li>Update only the fields that changed — required fields are marked with <span class="text-danger">*</span>.</li>
            <li>Each staff member has <strong>one role</strong>: Teacher or Admin.</li>
            <li>Leave file fields empty to keep the current profile photo, signature, or documents.</li>
            <li>Salary fields are optional but help with payroll records later.</li>
            <li>Click <strong>Update Teacher</strong> to save your changes.</li>
        @endif
    </ol>
</div>

<div class="white-box" style="margin-bottom: 20px;">
    <h5 style="margin-top:0; color:#3c8dbc;">
        <i class="fa fa-money"></i> What is Salary Grade?
    </h5>
    <p style="color:#555; font-size:13px; line-height:1.8; margin-bottom:10px;">
        <strong>Salary Grade</strong> is an internal pay-scale label your school uses to group teachers by compensation level — for example <em>Grade A</em>, <em>Grade B</em>, or <em>TGT-1</em>.
    </p>
    <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
        <tbody>
            <tr>
                <th style="width:42%; background:#f5f5f5;">Example grade</th>
                <td>Grade A — Senior teachers</td>
            </tr>
            <tr>
                <th style="background:#f5f5f5;">Base Salary</th>
                <td>Starting pay for that grade when the teacher joined</td>
            </tr>
            <tr>
                <th style="background:#f5f5f5;">Current Salary</th>
                <td>Present monthly salary after increments</td>
            </tr>
            <tr>
                <th style="background:#f5f5f5;">Last Increment</th>
                <td>Date of the most recent salary increase</td>
            </tr>
        </tbody>
    </table>
    <p style="color:#777; font-size:12px; margin:10px 0 0;">
        If your school does not use pay grades, enter a simple label like <strong>Standard</strong> or leave salary fields blank.
    </p>
</div>

<div class="white-box" style="margin-bottom: 20px;">
    <h5 style="margin-top:0; color:#3c8dbc;">
        <i class="fa fa-file-text-o"></i> Example entry
    </h5>
    <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
        <tbody>
            <tr><th style="background:#f5f5f5;">Full Name</th><td>John Smith</td></tr>
            <tr><th style="background:#f5f5f5;">Employee ID</th><td>EMP-2026-014</td></tr>
            <tr><th style="background:#f5f5f5;">Role</th><td>Teacher</td></tr>
            <tr><th style="background:#f5f5f5;">Qualification</th><td>M.Ed, B.Sc Mathematics</td></tr>
            <tr><th style="background:#f5f5f5;">Specialization</th><td>Mathematics</td></tr>
            <tr><th style="background:#f5f5f5;">Experience</th><td>5 years</td></tr>
            <tr><th style="background:#f5f5f5;">Salary Grade</th><td>Grade B</td></tr>
            <tr><th style="background:#f5f5f5;">Class Teacher Of</th><td>Class 8 (optional)</td></tr>
        </tbody>
    </table>
</div>

<div class="white-box">
    <h5 style="margin-top:0; color:#e08e0b;">
        <i class="fa fa-exclamation-triangle"></i> Things to keep in mind
    </h5>
    <ul style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom: 0;">
        <li><strong>Employee ID</strong> must be unique across all teachers.</li>
        <li><strong>Email</strong> must be unique — it is used for login.</li>
        <li>Teachers are assigned to subjects separately under <em>Academic → Section Teacher Allocation</em>.</li>
        <li>Only one teacher can be class teacher of a class at a time.</li>
        @if($mode === 'create')
            <li>Profile photo is required when registering a new teacher.</li>
        @else
            <li>Changing role to Admin grants broader system access — use carefully.</li>
        @endif
    </ul>
</div>
