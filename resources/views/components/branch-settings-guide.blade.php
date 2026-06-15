@props(['screen' => 'edit'])

@push('css')
<style>
    .branch-guide-sidebar {
        margin-top: 0;
    }
    @media (min-width: 992px) {
        .branch-guide-sidebar {
            position: sticky;
            top: 20px;
        }
    }
    .branch-guide-box {
        margin-bottom: 20px;
    }
    .branch-guide-box:last-child {
        margin-bottom: 0;
    }
    .branch-guide-title {
        margin-top: 0;
        margin-bottom: 12px;
        color: #3c8dbc;
        font-size: 15px;
        font-weight: 600;
    }
    .branch-guide-title-warn {
        color: #e08e0b;
    }
    .branch-guide-list {
        padding-left: 18px;
        line-height: 1.9;
        color: #555;
        font-size: 13px;
        margin-bottom: 0;
    }
    .branch-guide-table {
        font-size: 12px;
        margin-bottom: 0;
    }
    .branch-guide-table th {
        width: 38%;
        background: #f5f5f5;
    }
</style>
@endpush

<div class="branch-guide-sidebar">
    <div class="white-box branch-guide-box">
        <h5 class="branch-guide-title">
            <i class="fa fa-lightbulb-o"></i> How to manage branch settings
        </h5>
        <ol class="branch-guide-list">
            <li>Enter the <strong>Branch Name</strong> for this campus or location (e.g. Main Campus, North Branch).</li>
            <li>Add the branch <strong>Address</strong> — used on reports and local communications for this site.</li>
            <li>Set <strong>Phone</strong> and <strong>Email</strong> contact details specific to this branch.</li>
            <li>Click <strong>Save Settings</strong> to update — changes apply to this branch only.</li>
            <li>For school-wide identity (logo, type, principal), use <strong>School Profile</strong> instead.</li>
        </ol>
    </div>

    <div class="white-box branch-guide-box">
        <h5 class="branch-guide-title"><i class="fa fa-file-text-o"></i> Example</h5>
        <table class="table table-condensed table-bordered branch-guide-table">
            <tbody>
                <tr><th>Branch Name</th><td>Skoolyst Academy — Gulshan Campus</td></tr>
                <tr><th>Address</th><td>Plot 12, Gulshan-e-Iqbal, Karachi</td></tr>
                <tr><th>Phone</th><td>0334-0673401</td></tr>
                <tr><th>Email</th><td>gulshan@skoolyst.com</td></tr>
            </tbody>
        </table>
    </div>

    <div class="white-box branch-guide-box">
        <h5 class="branch-guide-title"><i class="fa fa-info-circle"></i> Branch vs School Profile</h5>
        <table class="table table-condensed table-bordered branch-guide-table">
            <tbody>
                <tr><th>Branch Settings</th><td>This campus — name, address, phone, email</td></tr>
                <tr><th>School Profile</th><td>Whole school — logo, type, affiliation, about</td></tr>
            </tbody>
        </table>
    </div>

    <div class="white-box branch-guide-box">
        <h5 class="branch-guide-title branch-guide-title-warn"><i class="fa fa-exclamation-triangle"></i> Things to keep in mind</h5>
        <ul class="branch-guide-list">
            <li>Each branch admin manages settings for their own branch only.</li>
            <li>Keep phone and email current — they may appear on fee receipts and notices.</li>
            <li>Academic and fee rules are configured under <strong>School Settings</strong>, not here.</li>
        </ul>
    </div>
</div>
