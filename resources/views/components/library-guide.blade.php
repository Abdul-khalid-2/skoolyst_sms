@props(['screen' => 'books-index'])

<div class="sparkline12-list" style="margin-bottom: 20px;">
    <div class="sparkline12-graph">
        <div class="basic-login-form-ad">
            <h5 style="margin-top:0; color:#3c8dbc;">
                <i class="fa fa-lightbulb-o"></i>
                @switch($screen)
                    @case('books-create') How to add a book @break
                    @case('books-edit') How to edit a book @break
                    @case('books-show') Understanding book details @break
                    @case('issues-create') How to issue a book @break
                    @default Library guide
                @endswitch
            </h5>
            <ol style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom: 0;">
                @if($screen === 'books-create')
                    <li>Enter the book <strong>Title</strong> exactly as it appears on the cover or catalog.</li>
                    <li>Add <strong>ISBN</strong>, <strong>Author</strong>, and <strong>Publisher</strong> for easy searching later.</li>
                    <li>Pick a <strong>Category</strong> from the list, type a new one, or click <strong>+</strong> to add a custom category.</li>
                    <li>Set <strong>Shelf / Location</strong> (e.g. A-12) so staff can find the book on the rack.</li>
                    <li>Enter <strong>Total Quantity</strong> (copies owned) and <strong>Available Copies</strong> (currently on shelf).</li>
                    <li>Click <strong>Save Book</strong> — you can issue copies to students from the Library Issues page.</li>
                @elseif($screen === 'books-edit')
                    <li>Update title, author, category, or shelf location as needed.</li>
                    <li>Adjust quantities only when doing a stock correction — use <strong>Issue / Return</strong> for normal lending.</li>
                @elseif($screen === 'books-show')
                    <li>View current stock, issue history, and book metadata.</li>
                    <li>Use <strong>Issue Book</strong> to lend a copy to a student.</li>
                @elseif($screen === 'issues-create')
                    <li>Pick a <strong>Book</strong> from the list — only titles with available copies can be issued.</li>
                    <li>Check <strong>Available Copies</strong> before issuing; the count updates when you select a book.</li>
                    <li>Filter by <strong>Class</strong> to narrow student members, or leave as <em>All Members</em>.</li>
                    <li>Select the <strong>Issue To</strong> student or teacher who will borrow the book.</li>
                    <li>Set <strong>Issue Date</strong> (today by default) and <strong>Due Date</strong> (default 14 days).</li>
                    <li>Add optional <strong>Notes</strong>, then click <strong>Issue Book</strong> — available stock decreases by one.</li>
                @endif
            </ol>
        </div>
    </div>
</div>

@if($screen === 'issues-create')
    <div class="sparkline12-list" style="margin-bottom: 20px;">
        <div class="sparkline12-graph">
            <div class="basic-login-form-ad">
                <h5 style="margin-top:0; color:#3c8dbc;"><i class="fa fa-file-text-o"></i> Example</h5>
                <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
                    <tbody>
                        <tr><th style="width:42%; background:#f5f5f5;">Book</th><td>English Grammar — Class 6</td></tr>
                        <tr><th style="background:#f5f5f5;">Issue To</th><td>Ahmed Ali (Class 6)</td></tr>
                        <tr><th style="background:#f5f5f5;">Issue Date</th><td>14 Jun 2026</td></tr>
                        <tr><th style="background:#f5f5f5;">Due Date</th><td>28 Jun 2026</td></tr>
                        <tr><th style="background:#f5f5f5;">Available</th><td>8 → 7 after issue</td></tr>
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
                    <li>You cannot issue a book when <strong>Available Copies</strong> is zero — return an existing copy first.</li>
                    <li>Record returns from the <strong>Library Issues</strong> list to restore available stock.</li>
                    <li>Students and parents can view issued books from their library portal after lending is recorded.</li>
                </ul>
            </div>
        </div>
    </div>
@endif

@if(in_array($screen, ['books-create', 'books-edit']))
    <div class="sparkline12-list" style="margin-bottom: 20px;">
        <div class="sparkline12-graph">
            <div class="basic-login-form-ad">
                <h5 style="margin-top:0; color:#3c8dbc;"><i class="fa fa-file-text-o"></i> Example</h5>
                <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
                    <tbody>
                        <tr><th style="width:42%; background:#f5f5f5;">Title</th><td>Mathematics for Class 8</td></tr>
                        <tr><th style="background:#f5f5f5;">ISBN</th><td>978-9693527890</td></tr>
                        <tr><th style="background:#f5f5f5;">Author</th><td>Dr. Ahmed Khan</td></tr>
                        <tr><th style="background:#f5f5f5;">Category</th><td>Mathematics</td></tr>
                        <tr><th style="background:#f5f5f5;">Shelf</th><td>B-04</td></tr>
                        <tr><th style="background:#f5f5f5;">Quantity</th><td>25 total / 22 available</td></tr>
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
                    <li><strong>Available Copies</strong> must be less than or equal to <strong>Total Quantity</strong>.</li>
                    <li>When adding new stock of an existing title, consider editing quantity instead of creating a duplicate entry.</li>
                    <li>Parents and students can view issued books from their library portal after lending is recorded.</li>
                </ul>
            </div>
        </div>
    </div>
@endif
