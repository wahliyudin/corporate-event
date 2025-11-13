<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Corporate Event Calendar — Prototype UI</title>
    <!-- Tailwind CDN for quick styling (for prototype only) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Small custom styles for prototype look */
        .day-cell {
            min-height: 96px;
        }

        .event-pill {
            @apply text-xs rounded px-2 py-0.5 inline-block;
        }
    </style>
</head>

<body class="bg-slate-50 font-sans">
    <!-- Topbar -->
    <header class="bg-white shadow-sm sticky top-0 z-20">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="text-2xl font-semibold">Corporate Event Calendar</div>
                <div class="text-sm text-slate-500">Holding Group — Master Calendar (2025)</div>
            </div>
            <div class="flex items-center gap-3">
                <button id="btnAdd" class="bg-indigo-600 text-white px-4 py-2 rounded shadow">+ Add Event</button>
                <button id="btnExport" class="border px-3 py-2 rounded">Export CSV</button>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-12 gap-6">
        <!-- Left panel / Filters -->
        <aside class="col-span-3 bg-white rounded-lg p-4 shadow-sm">
            <h3 class="text-lg font-medium mb-3">Filters & Legend</h3>

            <div class="mb-4">
                <label class="block text-xs text-slate-600 mb-1">Company</label>
                <select id="filterCompany" class="w-full rounded border p-2 text-sm">
                    <option value="all">All Companies</option>
                    <option value="holding">Holding</option>
                    <option value="sub-a">Subsidiary A</option>
                    <option value="sub-b">Subsidiary B</option>
                    <option value="sub-c">Subsidiary C</option>
                    <option value="sub-d">Subsidiary D</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-xs text-slate-600 mb-1">Category</label>
                <select id="filterCategory" class="w-full rounded border p-2 text-sm">
                    <option value="all">All Categories</option>
                    <option value="branding">Corporate Branding</option>
                    <option value="csr">CSR & Community</option>
                    <option value="internal">Internal Engagement</option>
                    <option value="forum">Business & Innovation</option>
                    <option value="training">Training & Leadership</option>
                    <option value="religious">Religious / Holiday</option>
                </select>
            </div>

            <div class="mb-3">
                <h4 class="font-medium mb-2">Legend</h4>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center gap-2"><span class="w-4 h-4 rounded bg-blue-500"></span> Corporate
                        Branding</li>
                    <li class="flex items-center gap-2"><span class="w-4 h-4 rounded bg-green-500"></span> CSR &
                        Community</li>
                    <li class="flex items-center gap-2"><span class="w-4 h-4 rounded bg-yellow-400"></span> Internal
                        Engagement</li>
                    <li class="flex items-center gap-2"><span class="w-4 h-4 rounded bg-orange-400"></span> Business &
                        Innovation</li>
                    <li class="flex items-center gap-2"><span class="w-4 h-4 rounded bg-purple-500"></span> Training &
                        Leadership</li>
                    <li class="flex items-center gap-2"><span class="w-4 h-4 rounded bg-gray-400"></span> Religious /
                        Holiday</li>
                </ul>
            </div>

            <div class="mt-4">
                <h4 class="font-medium mb-2">Quick Actions</h4>
                <button class="w-full rounded border p-2 mb-2">Sync with Microsoft 365</button>
                <button class="w-full rounded border p-2">Sync with Google Calendar</button>
            </div>

            <div class="mt-6 text-xs text-slate-500">
                <strong>Notes:</strong>
                <ol class="list-decimal pl-4 mt-1">
                    <li>Holding approves some events via approval flow.</li>
                    <li>Color-coded categories for quick scan.</li>
                </ol>
            </div>
        </aside>

        <!-- Right / Main Calendar -->
        <section class="col-span-9">
            <div class="bg-white rounded-lg p-4 shadow-sm mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <button id="prevMonth" class="px-3 py-1 rounded border">‹</button>
                        <div class="text-lg font-semibold" id="monthYear">March 2025</div>
                        <button id="nextMonth" class="px-3 py-1 rounded border">›</button>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-slate-600">
                        <button id="btnMonth" class="px-3 py-1 rounded border">Month</button>
                        <button id="btnWeek" class="px-3 py-1 rounded border">Week</button>
                        <button id="btnList" class="px-3 py-1 rounded border">List</button>
                    </div>
                </div>

                <!-- Simple month grid mockup (static prototype) -->
                <div class="grid grid-cols-7 gap-2 text-xs">
                    <!-- Weekday headers -->
                    <div class="text-center font-medium text-slate-600">Sun</div>
                    <div class="text-center font-medium text-slate-600">Mon</div>
                    <div class="text-center font-medium text-slate-600">Tue</div>
                    <div class="text-center font-medium text-slate-600">Wed</div>
                    <div class="text-center font-medium text-slate-600">Thu</div>
                    <div class="text-center font-medium text-slate-600">Fri</div>
                    <div class="text-center font-medium text-slate-600">Sat</div>

                    <!-- Example day cells (first row) -->
                    <!-- Each cell shows date + up to 2 event pills (more shown as +n) -->
                    <div class="bg-white rounded p-2 day-cell border">
                        <div class="flex justify-between items-start">
                            <div class="text-xs text-slate-500">29</div>
                        </div>
                    </div>

                    <div class="bg-white rounded p-2 day-cell border">
                        <div class="flex justify-between items-start">
                            <div class="text-xs text-slate-500">30</div>
                        </div>
                    </div>

                    <div class="bg-white rounded p-2 day-cell border">
                        <div class="flex justify-between items-start">
                            <div class="text-xs text-slate-500">31</div>
                        </div>
                    </div>

                    <div class="bg-white rounded p-2 day-cell border">
                        <div class="flex justify-between items-start">
                            <div class="text-xs text-slate-500">1</div>
                            <div class="text-xs text-indigo-600">●</div>
                        </div>
                        <div class="mt-2">
                            <div class="event-pill bg-yellow-100 text-yellow-800">Townhall Q1 (Holding)</div>
                        </div>
                    </div>

                    <div class="bg-white rounded p-2 day-cell border">
                        <div class="flex justify-between items-start">
                            <div class="text-xs text-slate-500">2</div>
                        </div>
                    </div>

                    <div class="bg-white rounded p-2 day-cell border">
                        <div class="flex justify-between items-start">
                            <div class="text-xs text-slate-500">3</div>
                        </div>
                        <div class="mt-2">
                            <div class="event-pill bg-green-100 text-green-800">CSR Beach Cleanup (Sub A)</div>
                        </div>
                    </div>

                    <div class="bg-white rounded p-2 day-cell border">
                        <div class="flex justify-between items-start">
                            <div class="text-xs text-slate-500">4</div>
                        </div>
                    </div>

                    <!-- Row continues... (prototype shows how events appear) -->
                </div>

                <div class="mt-4 text-xs text-slate-500">Tip: Click an event to open details, or double-click a day to
                    add a new event (in production).</div>
            </div>

            <!-- List view / upcoming events -->
            <div class="bg-white rounded-lg p-4 shadow-sm">
                <h4 class="font-medium mb-3">Upcoming Events</h4>
                <ul id="eventList" class="space-y-3 text-sm">
                    <li class="flex justify-between items-start border rounded p-3">
                        <div>
                            <div class="font-medium">Annual Townhall</div>
                            <div class="text-xs text-slate-500">Mar 20, 2025 — Jakarta Convention Center — PIC: CorpCom
                                / HR</div>
                            <div class="text-xs mt-2">Townhall Q1 — company update and awards. Status: Confirmed</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs text-slate-500">Holding</div>
                            <div class="mt-2">
                                <button class="text-xs underline mr-2">Edit</button>
                                <button class="text-xs text-red-600">Delete</button>
                            </div>
                        </div>
                    </li>

                    <li class="flex justify-between items-start border rounded p-3">
                        <div>
                            <div class="font-medium">CSR Beach Cleanup</div>
                            <div class="text-xs text-slate-500">Apr 5, 2025 — Anyer Beach — PIC: Sustainability Team
                            </div>
                            <div class="text-xs mt-2">CSR activity with local community. Status: Planned</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs text-slate-500">Subsidiary A</div>
                            <div class="mt-2">
                                <button class="text-xs underline mr-2">Edit</button>
                                <button class="text-xs text-red-600">Delete</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
    </main>

    <!-- Event Modal (hidden by default) -->
    <div id="modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
        <div class="w-[720px] bg-white rounded-lg p-6 shadow-lg">
            <h3 class="text-lg font-semibold mb-3">Add / Edit Event</h3>
            <form id="eventForm" class="space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <input name="title" required placeholder="Event title" class="col-span-2 rounded border p-2" />
                    <select name="company" class="rounded border p-2">
                        <option value="holding">Holding</option>
                        <option value="sub-a">Subsidiary A</option>
                        <option value="sub-b">Subsidiary B</option>
                        <option value="sub-c">Subsidiary C</option>
                        <option value="sub-d">Subsidiary D</option>
                    </select>
                    <select name="category" class="rounded border p-2">
                        <option value="branding">Corporate Branding</option>
                        <option value="csr">CSR & Community</option>
                        <option value="internal">Internal Engagement</option>
                        <option value="forum">Business & Innovation</option>
                        <option value="training">Training & Leadership</option>
                        <option value="religious">Religious / Holiday</option>
                    </select>
                    <input name="start" type="date" class="rounded border p-2" />
                    <input name="end" type="date" class="rounded border p-2" />
                    <input name="location" placeholder="Location" class="col-span-2 rounded border p-2" />
                    <input name="pic" placeholder="PIC / Penanggung Jawab" class="rounded border p-2" />
                    <select name="status" class="rounded border p-2">
                        <option>Planned</option>
                        <option>Confirmed</option>
                        <option>Tentative</option>
                    </select>
                    <textarea name="desc" placeholder="Description" class="col-span-2 rounded border p-2 h-24"></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" id="btnCancel" class="rounded border px-4 py-2">Cancel</button>
                    <button type="submit" class="rounded bg-indigo-600 px-4 py-2 text-white">Save & Sync</button>
                </div>
            </form>
            <div class="mt-3 text-xs text-slate-500">Note: "Save & Sync" would call backend → persist event → trigger
                MS Graph/Google Calendar integration.</div>
        </div>
    </div>

    <script>
        // Minimal JS for prototype interactions (no backend)
        document.getElementById('btnAdd').addEventListener('click', () => {
            document.getElementById('modal').classList.remove('hidden');
        });
        document.getElementById('btnCancel').addEventListener('click', () => {
            document.getElementById('modal').classList.add('hidden');
        });
        document.getElementById('eventForm').addEventListener('submit', (e) => {
            e.preventDefault();
            // In prototype: just close modal and show alert
            document.getElementById('modal').classList.add('hidden');
            alert('Event saved (prototype) — next step: persist to backend & sync with Calendar APIs.');
        });
    </script>

    <!-- DESIGN NOTES (for Figma-style deliverable) -->
    <!--
    Figma Frames to create (suggested pages):
      1) Dashboard (Calendar Month view) - shows filters, legend, month grid, upcoming events.
      2) Add Event Modal / Form - fields, validation, approval option toggle.
      3) Event Detail - info, attendees, approvals, sync status, edit history.
      4) Admin / Settings - manage companies, roles, category colors, integration tokens (MS Graph / Google).
      5) Mobile responsive screens: List view and Add Event quick action.

    Design tokens / styles:
      - Primary: Indigo (#4F46E5)
      - Accent: Teal/Green for CSR, Orange for Forum, Yellow for Internal, Purple for Training, Gray for Religious
      - Font: Inter or system-ui
      - Spacing: 8px base (Tailwind default)

    Handoff notes to devs:
      - Export components: Topbar, Sidebar, Calendar grid, Event card, Modal, Form inputs
      - Provide component variants (small/large pills, single-day/multi-day event UI)
      - Provide responsive breakpoints (sm/md/lg)
  -->

    <!-- DEPLOYMENT / NEXT STEPS -->
    <!--
    1) Convert this static prototype into a React app using Create React App / Vite.
    2) Replace static month grid with FullCalendar (https://fullcalendar.io) for full drag/drop & month/week/day views.
    3) Implement backend API: Node.js (Express) or Laravel; DB: PostgreSQL.
    4) Add SSO: Microsoft Azure AD (MSAL) or Google OAuth for SSO sign-in.
    5) Implement calendar sync:
       - Microsoft: use Microsoft Graph API to create calendar events in group calendars and/or user calendars
       - Google: use Google Calendar API with service account or OAuth flows
    6) Add audit logs, approval flow, and role-based permissions.

    If you want, I can:
      - Produce a Figma file (detailed screens & components) OR
      - Convert this into a ready-to-deploy React app (with FullCalendar + sample backend endpoints)
  -->
</body>

</html>
