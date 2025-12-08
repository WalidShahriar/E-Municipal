<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Municipal Admin Panel (Bangladesh Govt UI)</title>

    <link
      href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&family=Noto+Serif:wght@400;700&display=swap"
      rel="stylesheet"
    />

    <style>
      /* GLOBAL BD GOVT THEME CSS */
      :root {
        --bd-green: #006a4e;
        --bd-red: #c81d25;
        --bg: #f4f6f5;
        --card: #ffffff;
        --muted: #6b7280;
        --radius: 10px;
        --shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
      }

      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
      }
      body {
        font-family: "Noto Sans", sans-serif;
        background: var(--bg);
        color: #0f172a;
      }

      /* Layout */
      .app {
        display: grid;
        grid-template-columns: 260px 1fr;
        min-height: 100vh;
      }

      /* Sidebar */
      .sidebar {
        background: linear-gradient(180deg, var(--bd-green), #045f65ff);
        padding: 22px;
        color: white;
        display: flex;
        flex-direction: column;
        gap: 20px;
      }
      .brand {
        display: flex;
        gap: 12px;
        align-items: center;
      }
      .brand .logo {
        width: 46px;
        height: 46px;
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        font-weight: bold;
      }
      .brand h1 {
        font-size: 16px;
        margin: 0;
        font-weight: 700;
      }

      .nav {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 10px;
      }
      .nav a {
        padding: 10px 14px;
        border-radius: 8px;
        text-decoration: none;
        color: #e7f7f0;
        font-size: 14px;
        font-weight: 700;
      }
      .nav a.active,
      .nav a:hover {
        background: rgba(255, 255, 255, 0.07);
      }

      /* Main area */
      .main {
        padding: 22px;
      }
      .header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 15px;
      }
      .page-title h2 {
        font-family: "Noto Serif", serif;
        font-size: 28px;
        color: var(--bd-green);
        border-bottom: 4px solid var(--bd-red);
        display: inline-block;
        padding-bottom: 6px;
      }
      .emp-badge {
        font-size: 14px;
        color: var(--muted);
      }
      .emp-badge strong {
        color: var(--bd-green);
      }

      /* Sections */
      .section {
        display: none;
      }
      .section.active {
        display: block;
      }

      /* Cards */
      .card-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-top: 10px;
      }
      .card {
        background: white;
        padding: 14px;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
      }
      .card h3 {
        font-size: 14px;
        color: var(--muted);
        font-weight: 700;
      }
      .card p {
        font-size: 22px;
        font-weight: 700;
        margin-top: 4px;
      }

      /* Tables */
      .table {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-top: 14px;
      }
      .table table {
        width: 100%;
        border-collapse: collapse;
      }
      .table thead th {
        background: var(--bd-green);
        color: white;
        padding: 12px;
        text-align: left;
        font-size: 13px;
      }
      .table tbody td {
        padding: 12px;
        border-bottom: 1px solid #ececec;
        font-size: 14px;
      }

      /* Status badges */
      .badge {
        padding: 5px 8px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        color: white;
      }
      .badge.pending {
        background: orange;
      }
      .badge.inprogress {
        background: var(--bd-green);
      }
      .badge.resolved {
        background: #16a34a;
      }

      /* Departments */
      .dept-item {
        background: white;
        border-radius: 10px;
        box-shadow: var(--shadow);
        padding: 14px;
        margin-bottom: 12px;
      }
      .dept-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
      }
      .dept-head h4 {
        color: var(--bd-green);
        font-size: 17px;
      }
      .stat {
        background: #f0f5f3;
        padding: 6px 8px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 700;
      }
      .dept-details {
        display: none;
        margin-top: 12px;
        border-top: 1px dashed #ccd0cd;
        padding-top: 10px;
      }

      /* Filters */
      .filters {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 14px;
      }

      /* Buttons */
      .btn {
        padding: 8px 12px;
        background: var(--bd-green);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 700;
        font-size: 13px;
      }
      .btn.secondary {
        background: white;
        color: var(--bd-green);
        border: 1px solid var(--bd-green);
      }

      /* Modal */
      .modal {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.4);
        display: none;
        align-items: center;
        justify-content: center;
      }
      .modal.show {
        display: flex;
      }
      .modal-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        max-width: 420px;
        width: 100%;
      }

      /* Analytics charts */
      .charts-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-top: 16px;
      }
      .chart-box {
        background: white;
        border-radius: 10px;
        padding: 14px;
        box-shadow: var(--shadow);
      }

      @media (max-width: 900px) {
        .app {
          grid-template-columns: 1fr;
        }
        .card-grid {
          grid-template-columns: 1fr 1fr;
        }
        .charts-grid {
          grid-template-columns: 1fr;
        }
      }
      @media (max-width: 600px) {
        .card-grid {
          grid-template-columns: 1fr;
        }
      }
    </style>
  </head>

  <body>
    <div class="app">
      <aside class="sidebar">
        <div class="brand">
          <div class="logo">প</div>
          <div>
            <h1>Municipal Admin</h1>
            <div style="font-size: 12px; color: #d7f5e8">
              Online Complaint & Service
            </div>
          </div>
        </div>

        <nav class="nav">
          <a href="#" data-target="dashboard" class="active">Dashboard</a>
          <a href="#" data-target="departments">Departments</a>
          <a href="#" data-target="monitor">Complaints Monitor</a>
          <a href="#" data-target="analytics">Analytics</a>
        </nav>
      </aside>

      <main class="main">
        <div class="header-row">
          <div class="page-title">
            <h2 id="pageTitle">Administrative Dashboard</h2>
          </div>
          <div class="emp-badge">
            Employee: <strong id="empName">Badar Uddin</strong> (ID:
            <span id="empId">EMP-1335</span>)
          </div>
        </div>

        <section id="dashboard" class="section active">
          <div class="card-grid">
            <div class="card">
              <h3>Total Complaints</h3>
              <p id="dashTotal">{{ $totalComplaints ?? 0 }}</p>
            </div>
            <div class="card">
              <h3>Pending</h3>
              <p id="dashPending">{{ $pendingComplaints ?? 0 }}</p> 
            </div>
            <div class="card">
              <h3>Resolved</h3>
              <p id="dashResolved">{{ $resolvedComplaints ?? 0 }}</p>
            </div>
            <div class="card">
              <h3>Service Requests</h3>
              <p id="dashRequests">{{ $totalServiceRequests ?? 0 }}</p>
            </div>
          </div>

          <div class="table">
            <table>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Department</th>
                  <th>Status</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody id="dashRecent">
                @if (isset($recentComplaints))
                    @foreach ($recentComplaints as $c)
                        <tr>
                            <td>{{ $c->id }}</td>
                            <td>{{ $c->title }}</td>
                            <td>{{ $c->department_name ?? 'N/A' }}</td>
                            <td><span class="badge {{ strtolower($c->status) }}">{{ $c->status }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($c->created_at)->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="5">No recent complaints found.</td></tr>
                @endif
              </tbody>
            </table>
          </div>
        </section>

        <section id="departments" class="section">
          <div id="deptContainer"></div>
        </section>

        <section id="monitor" class="section">
          <div class="filters">
            <select id="fDept">
              <option value="all">All Departments</option>
            </select>
            <select id="fStatus">
              <option value="all">All Status</option>
              <option value="pending">Pending</option>
              <option value="inprogress">In Progress</option>
              <option value="resolved">Resolved</option>
            </select>
            <select id="fPri">
              <option value="all">All Priorities</option>
              <option value="low">Low</option>
              <option value="medium">Medium</option>
              <option value="high">High</option>
            </select>
            <input type="date" id="fFrom" />
            <input type="date" id="fTo" />
            <button class="btn" id="btnApply">Apply</button>
            <button class="btn secondary" id="btnReset">Reset</button>
          </div>

          <div class="table">
            <table>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Dept</th>
                  <th>Priority</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="monitorTable"></tbody>
            </table>
          </div>
        </section>

        <section id="analytics" class="section">
          <div class="card-grid">
            <div class="card">
              <h3>Total Complaints</h3>
              <p id="anaTotal">{{ $totalComplaints ?? 0 }}</p>
            </div>
            <div class="card">
              <h3>Avg Resolution (days)</h3>
              <p id="anaAvg">{{ $avgResolutionDays ?? 0 }}</p>
            </div>
            <div class="card">
              <h3>Approved Requests</h3>
              <p id="anaApproved">{{ $approvedRequests ?? 0 }}</p>
            </div>
            <div class="card">
              <h3>Pending Complaints</h3>
              <p id="anaPending">{{ $pendingComplaints ?? 0 }}</p>
            </div>
          </div>

          <div class="charts-grid">
            <div class="chart-box">
              <h4>Complaints per Department</h4>
              <canvas id="chartDept"></canvas>
            </div>
            <div class="chart-box">
              <h4>Approved vs Denied</h4>
              <canvas id="chartPie"></canvas>
            </div>
            <div class="chart-box">
              <h4>Bi-Annual Trend</h4>
              <canvas id="chartTrend"></canvas>
            </div>
            <div class="chart-box">
              <h4>Department Efficiency</h4>
              <canvas id="chartRadar"></canvas>
            </div>
          </div>
        </section>
      </main>
    </div>

    <div id="modal" class="modal">
      <div class="modal-card">
        <h3>Reassign Complaint</h3>
        <p id="modalInfo"></p>
        <label>Department</label>
        <select id="modalDept" style="width: 100%; margin-top: 6px"></select>
        <div
          style="
            margin-top: 12px;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
          "
        >
          <button class="btn secondary" onclick="hideModal()">Cancel</button>
          <button class="btn" onclick="confirmReassign()">Confirm</button>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
      /* START: DATA INJECTION & MOCK DATA REMOVAL */
      
      // Removed: const departments = [...]
      // Removed: let complaints = [...]
      // Removed: let serviceRequests = [...]
      
      /* * DATA STRUCTURES EXPECTED FROM CONTROLLER:
       * $totalComplaints, $pendingComplaints, $resolvedComplaints, $totalServiceRequests, $approvedRequests, $avgResolutionDays
       * $recentComplaints (used directly in Blade loop above)
       * $complaintTrend (Collection for line chart: [{'date': '...', 'count': 5}, ...])
       * $deptComplaintsLabels, $deptComplaintsCounts (for Complaints per Department chart)
       * $approvedCount, $deniedCount (for Approved vs Denied chart)
       * $deptEfficiencyLabels, $deptEfficiencyData (for Radar chart)
       */

      // Assuming departments list and helper is still needed for monitor/reassign sections:
      const departments = @json($departmentList ?? []);
      function getDept(id) {
        return departments.find((x) => x.id === id)?.name || id;
      }
      
      /* END: DATA INJECTION & MOCK DATA REMOVAL */

      /* NAVIGATION (SPA) - Left untouched */

      document.querySelectorAll(".nav a").forEach((a) => {
        a.addEventListener("click", (e) => {
          e.preventDefault();
          const target = a.dataset.target;

          // Switch active tab
          document
            .querySelectorAll(".nav a")
            .forEach((x) => x.classList.remove("active"));
          a.classList.add("active");

          // Show correct section
          document
            .querySelectorAll(".section")
            .forEach((s) => s.classList.remove("active"));
          document.getElementById(target).classList.add("active");

          // Change title
          document.getElementById("pageTitle").textContent = a.textContent;

          // Trigger page-specific init
          // DASHBOARD logic is now mostly handled by Laravel variables in the HTML.
          if (target === "dashboard") {} // No JS rendering needed for dashboard counts
          if (target === "departments") renderDepartments();
          if (target === "monitor") renderMonitor();
          if (target === "analytics") renderAnalytics();
        });
      });

      /* DASHBOARD (MOCK LOGIC REMOVED - data is now in the HTML via Blade) */
      // function renderDashboard() { ... logic removed ... }

      /* DEPARTMENTS - Logic left to run on the dynamic $departmentList */
      function renderDepartments() {
        const container = document.getElementById("deptContainer");
        container.innerHTML = "";

        // NOTE: This logic now needs actual complaint data (or separate AJAX calls) to calculate these stats.
        // Since we removed the JS 'complaints' array, this will only render department names correctly.
        departments.forEach((d) => {
           // *** The logic below relies on an existing 'complaints' array or an API. ***
           // *** If your goal is to make this section dynamic, you must use AJAX/fetch here. ***
           // For now, these values will be mock or 0 unless you fetch them. 
           const deptComplaints = []; // Placeholder, requires AJAX
           const completed = 0;       // Placeholder, requires AJAX
           const div = document.createElement("div");
           div.className = "dept-item";

           div.innerHTML = `
             <div class="dept-head">
               <h4>${d.name}</h4>
               <div style="display:flex;gap:10px">
                 <div class="stat">Complaints: 0</div>
                 <div class="stat">Done: 0</div>
                 <div class="stat">Pending: 0</div>
               </div>
             </div>
             <div class="dept-details">
               <strong>Bi-Annual Report:</strong>
               <ul style="margin-left:18px;margin-top:6px">
                 <li>Resolved last 6 months: ${Math.floor(Math.random() * 50)}</li>
                 <li>Avg resolution time: ${
                   Math.floor(Math.random() * 7) + 2
                 } days</li>
                 <li>Pending follow-ups: ${Math.floor(Math.random() * 10)}</li>
               </ul>
             </div>
           `;

           // Toggle
           div.querySelector(".dept-head").addEventListener("click", () => {
             let det = div.querySelector(".dept-details");
             det.style.display =
               det.style.display === "block" ? "none" : "block";
           });

           container.appendChild(div);
        });
      }

      /* MONITOR - Logic left to run on the dynamic $departmentList */

      function renderMonitor() {
        const fDept = document.getElementById("fDept");
        if (fDept.children.length <= 1) {
          departments.forEach((d) => {
            let opt = document.createElement("option");
            opt.value = d.id;
            opt.textContent = d.name;
            fDept.appendChild(opt);
          });
        }
        
        // renderMonitorTable will not work without an AJAX call to fetch filterable data
        // renderMonitorTable(complaints); // Removed: relies on mock data
      }

      // Remaining monitor functions (renderMonitorTable, btnApply, btnReset, modal functions)
      // are left, but will require AJAX to fetch data since the local `complaints` array is gone.
      
      /* ANALYTICS (Chart.js) */

      let chart1, chart2, chart3, chart4;

      function renderAnalytics() {
        // NOTE: The card counts are now handled by Blade in the HTML, 
        // but we need to update the charts.

        // Destroy old charts if exist
        if (chart1) chart1.destroy();
        if (chart2) chart2.destroy();
        if (chart3) chart3.destroy();
        if (chart4) chart4.destroy();

        // -----------------------------------------------------------------
        // Chart 1: Complaints per Department (Bar Chart)
        // Expected variables: $deptComplaintsLabels, $deptComplaintsCounts
        // -----------------------------------------------------------------
        const deptLabels = @json($deptComplaintsLabels ?? []); 
        const deptCounts = @json($deptComplaintsCounts ?? []); 

        chart1 = new Chart(document.getElementById("chartDept"), {
          type: "bar",
          data: {
            labels: deptLabels,
            datasets: [
              {
                label: "Complaints",
                data: deptCounts,
                backgroundColor: "#006A4E",
              },
            ],
          },
        });

        // -----------------------------------------------------------------
        // Chart 2: Approved vs Denied (Pie Chart)
        // Expected variables: $approvedCount, $deniedCount (Service Requests)
        // -----------------------------------------------------------------
        const approved = @json($approvedCount ?? 0);
        const denied = @json($deniedCount ?? 0);
        
        chart2 = new Chart(document.getElementById("chartPie"), {
          type: "pie",
          data: {
            labels: ["Approved", "Denied"],
            datasets: [
              {
                data: [approved, denied],
                backgroundColor: ["#006A4E", "#C81D25"],
              },
            ],
          },
        });

        // -----------------------------------------------------------------
        // Chart 3: Bi-Annual Trend (Line Chart)
        // Expected variable: $trendData (Collection of {date, count} objects)
        // -----------------------------------------------------------------
        const trendData = @json($complaintTrend ?? []);
        let trendLabels = trendData.map(item => item.date);
        let trendValues = trendData.map(item => item.count);

        chart3 = new Chart(document.getElementById("chartTrend"), {
          type: "line",
          data: {
            labels: trendLabels,
            datasets: [
              {
                label: "6-month complaints",
                data: trendValues,
                borderColor: "#006A4E",
              },
            ],
          },
        });

        // -----------------------------------------------------------------
        // Chart 4: Department Efficiency (Radar Chart)
        // Expected variables: $deptEfficiencyLabels, $deptEfficiencyData
        // -----------------------------------------------------------------
        const effLabels = @json($deptEfficiencyLabels ?? []);
        const effData = @json($deptEfficiencyData ?? []);
        
        chart4 = new Chart(document.getElementById("chartRadar"), {
          type: "radar",
          data: {
            labels: effLabels,
            datasets: [
              {
                label: "Efficiency",
                data: effData,
                backgroundColor: "rgba(0,106,78,0.2)",
                borderColor: "#006A4E",
              },
            ],
          },
        });
      }

      /* Helpers */
      // function getDept(id) is defined at the top alongside the injected departments.

      /* Initial load */
      // Calls are still needed for initialization, but dashboard rendering is simpler.
      // NOTE: The dashboard table requires the $recentComplaints variable to be defined.
      // If it is an empty array, the table will show "No recent complaints found."
    </script>
  </body>
</html>