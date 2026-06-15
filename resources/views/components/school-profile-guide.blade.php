@props(['screen' => 'edit-profile'])

@push('css')
<style>
    .school-guide-sidebar {
        margin-top: 0;
    }
    @media (min-width: 992px) {
        .school-guide-sidebar {
            position: sticky;
            top: 20px;
        }
    }
    .school-guide-box {
        margin-bottom: 20px;
    }
    .school-guide-box:last-child {
        margin-bottom: 0;
    }
    .school-guide-title {
        margin-top: 0;
        margin-bottom: 12px;
        color: #3c8dbc;
        font-size: 15px;
        font-weight: 600;
    }
    .school-guide-title-warn {
        color: #e08e0b;
    }
    .school-guide-list {
        padding-left: 18px;
        line-height: 1.9;
        color: #555;
        font-size: 13px;
        margin-bottom: 0;
    }
    .school-guide-text {
        color: #555;
        font-size: 13px;
        line-height: 1.7;
        margin-bottom: 0;
    }
    .school-guide-table {
        font-size: 12px;
        margin-bottom: 0;
    }
    .school-guide-table th {
        width: 38%;
        background: #f5f5f5;
    }
</style>
@endpush

<div class="school-guide-sidebar">
    <div class="white-box school-guide-box">
        <h5 class="school-guide-title">
            <i class="fa fa-lightbulb-o"></i>
            @switch($screen)
                @case('edit-profile') How to edit school profile @break
                @case('settings') How to use school settings @break
                @default School profile guide
            @endswitch
        </h5>
        <ol class="school-guide-list">
            @if($screen === 'edit-profile')
                <li>Update your <strong>School Name</strong>, <strong>Logo</strong>, <strong>Type</strong>, and <strong>Affiliation Number</strong> here — this is the main identity page.</li>
                <li>Set the current <strong>Academic Session</strong> (e.g. 2025–2026).</li>
                <li>Fill in <strong>Contact Information</strong>: address, phone, email, website, and principal name.</li>
                <li>Add <strong>Social Media Links</strong> for Facebook, Twitter, Instagram, and YouTube.</li>
                <li>Enter <strong>Established Year</strong> and a short <strong>About School</strong> description.</li>
                <li>Click <strong>Update Profile</strong> to save. Use <strong>Settings</strong> for system rules.</li>
            @elseif($screen === 'settings')
                <li><strong>Edit Profile</strong> handles school name, logo, type, affiliation, contact, and about text.</li>
                <li><strong>Academic Section</strong> tab sets Primary / Secondary / Both for this branch.</li>
                <li><strong>Contact Details</strong> adds structured address, alt phone, school hours, and social links.</li>
                <li><strong>Academic Structure</strong> sets education system, terms, and available grades/subjects.</li>
                <li>Other tabs configure attendance, fees, notifications, and security.</li>
                <li>Each tab saves independently — click <strong>Save Changes</strong> on the tab you edited.</li>
            @endif
        </ol>
    </div>

    @if($screen === 'edit-profile')
        <div class="white-box school-guide-box">
            <h5 class="school-guide-title"><i class="fa fa-info-circle"></i> Edit Profile vs Settings</h5>
            <table class="table table-condensed table-bordered school-guide-table">
                <tbody>
                    <tr><th>Edit Profile</th><td>Name, logo, contact, about, social links</td></tr>
                    <tr><th>Settings</th><td>Academic section, system rules, fees, security</td></tr>
                </tbody>
            </table>
        </div>

        <div class="white-box school-guide-box">
            <h5 class="school-guide-title school-guide-title-warn"><i class="fa fa-exclamation-triangle"></i> Things to keep in mind</h5>
            <ul class="school-guide-list">
                <li>Logo recommended size: 300×300 px (PNG or JPG).</li>
                <li>Phone and email appear on reports and parent communications.</li>
                <li>Changes here update the school profile visible to staff.</li>
            </ul>
        </div>
    @endif

    @if($screen === 'settings')
        <div class="white-box school-guide-box">
            <h5 class="school-guide-title school-guide-title-warn"><i class="fa fa-exclamation-triangle"></i> Avoid duplication</h5>
            <p class="school-guide-text">
                Do not re-enter school name, type, or affiliation here — update them on
                <a href="{{ route('schools.edit') }}"><strong>Edit Profile</strong></a> instead.
            </p>
        </div>
    @endif
</div>
