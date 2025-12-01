<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Department Dashboard & Task Assignment</title>
  <style>
    :root{
      --bg:#f6f8fb; --card:#ffffff; --muted:#6b7280;
      --accent:#2563eb; --danger:#ef4444; --warning:#f59e0b; --success:#10b981; --gray-100:#f3f4f6;
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    }
    *{box-sizing:border-box}
    body{margin:0;background:var(--bg);color:#0f172a}
    .container{max-width:1100px;margin:28px auto;padding:20px}
    header{display:flex;align-items:center;gap:16px;margin-bottom:18px}
    header h1{font-size:20px;margin:0}
    .top-controls{display:flex;gap:12px;flex-wrap:wrap;align-items:center}
    .card{background:var(--card);border-radius:12px;padding:16px;box-shadow:0 4px 14px rgba(2,6,23,0.06)}
    .grid{display:grid;gap:12px}
    .grid.cols-3{grid-template-columns:repeat(3,1fr)}
    .flex{display:flex;gap:12px;align-items:center}
    .btn{padding:8px 12px;border-radius:8px;border:0;cursor:pointer;background:var(--accent);color:white; transition: background 0.2s;}
    .btn:hover {background: #1e40af;}
    .btn.ghost{background:transparent;color:var(--accent);border:1px solid #dbeafe; transition: background 0.2s;}
    .btn.ghost:hover {background: #f1f5f9;}
    .select, .input, .textarea {padding:8px;border-radius:8px;border:1px solid #e6e9ef;background:white; min-height: 38px; width: 100%;}
    .filters{display:flex;gap:10px;flex-wrap:wrap}
    .list{margin-top:12px;display:grid;gap:12px}
    .item{display:flex;justify-content:space-between;gap:12px;align-items:center;padding:12px;border-radius:10px;border:1px solid #eef2ff; transition: border-color 0.2s, box-shadow 0.2s; cursor: pointer;}
    .item:hover {border-color: #c0d8ff; box-shadow: 0 2px 8px rgba(37,99,235,0.05);}
    .left{display:flex;gap:12px;align-items:flex-start;min-width:0}
    .meta{font-size:13px;color:var(--muted)}
    .title{font-weight:600;margin:0; text-overflow: ellipsis; white-space: nowrap; overflow: hidden; max-width: 100%;}
    .badge{padding:6px 8px;border-radius:999px;font-size:12px; font-weight: 500;}
    .col-right{display:flex;gap:8px;align-items:center; flex-shrink: 0;}
    .status-dot{width:12px;height:12px;border-radius:50%;display:inline-block;margin-right:6px; flex-shrink: 0;}
    .status-pending{background:var(--danger)}
    .status-inprogress{background:var(--warning)}
    .status-resolved{background:var(--success)}
    .status-closed{background: #6b7280}
    .small{font-size:13px;color:var(--muted); display: block; margin-bottom: 4px;}
    .log-panel{max-height:220px;overflow:auto;padding:10px;background:linear-gradient(180deg,#fff,#fbfdff);border-radius:8px;border:1px solid #eef2ff}
    .log-entry{font-size:13px;padding:6px;border-bottom:1px dashed #eef2ff}
    .log-entry:last-child {border-bottom: none;}
    .controls-row{display:flex;gap:8px;align-items:center}
    .assign-select{min-width:180px}
    .file-preview{max-width:120px;max-height:80px;border-radius:6px;border:1px solid #e6e9ef}
    /* modal - Set to display: flex to see it immediately */
    .modal-backdrop{position:fixed;inset:0;background:rgba(2,6,23,0.45);display:flex;align-items:center;justify-content:center;z-index:50}
    .modal{width:720px;max-width:95%;background:var(--card);padding:18px;border-radius:10px;box-shadow:0 10px 30px rgba(2,6,23,0.2)}
    .row{display:flex;gap:10px;align-items:center}
    .col{flex:1}
    footer{margin-top:22px;text-align:center;color:var(--muted);font-size:13px}
    @media (max-width:820px){ .grid.cols-3{grid-template-columns:1fr} .left{flex-direction:column;align-items:flex-start} .col-right{flex-direction:column;align-items:flex-end} .assign-select {min-width: auto;}}
  </style>
</head>
<body>
  <div class="container">
    <header>
      <h1>📊 Department Task Dashboard</h1>
      <div class="top-controls">
        <button class="btn">+ New Task</button>
      </div>
    </header>

        <div class="grid cols-3" style="margin-bottom: 20px;">
      <div class="card">
        <div class="small">Total Tasks</div>
        <h2 style="margin: 4px 0 0; font-size: 28px;">42</h2>
      </div>
      <div class="card">
        <div class="small">Pending</div>
        <h2 style="margin: 4px 0 0; font-size: 28px; color: var(--danger);">10</h2>
      </div>
      <div class="card">
        <div class="small">In Progress</div>
        <h2 style="margin: 4px 0 0; font-size: 28px; color: var(--warning);">18</h2>
      </div>
    </div>

        <div class="flex" style="margin-bottom: 12px;">
      <input type="text" placeholder="Search tasks..." class="input" style="flex-grow: 1;">
      <select class="select">
        <option>Filter by Status</option>
        <option>Pending</option>
        <option>In Progress</option>
        <option>Resolved</option>
      </select>
    </div>

        <div class="card">
         <h3 style="margin-top: 0; margin-bottom: 15px;">Open Tasks</h3>
      <div class="list">
                <div class="item">
          <div class="left">
            <span class="status-dot status-pending"></span>
            <div>
              <p class="title">Review Q3 Budget Report: Analyze spending variance and forecasting</p>
              <div class="meta">#1001 • Assigned to: Alice J. • Due: 2025-12-10</div>
            </div>
            
          </div>
          <div class="col-right">
            <span class="badge" style="background:var(--danger); color:white;">Pending</span>
            <button class="btn ghost">View</button>
          </div>
        </div>
                <div class="item">
          <div class="left">
            <span class="status-dot status-inprogress"></span>
            <div>
              <p class="title">Update CRM documentation for new user onboarding flow</p>
              <div class="meta">#1005 • Assigned to: Bob K. • Due: 2025-12-15</div>
            </div>
          </div>
          <div class="col-right">
            <span class="badge" style="background:var(--warning); color:#3c3c3c;">In Progress</span>
            <button class="btn ghost">View</button>
          </div>
        </div>
                <div class="item">
          <div class="left">
            <span class="status-dot status-resolved"></span>
            <div>
              <p class="title">Fix broken link on careers page (Internal HR Request)</p>
              <div class="meta">#0980 • Assigned to: Alice J. • Resolved: 2025-11-30</div>
            </div>
          </div>
          <div class="col-right">
            <span class="badge" style="background:var(--success); color:white;">Resolved</span>
            <button class="btn ghost">View</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  
    <div class="modal-backdrop">
    <div class="modal">
      <h2 style="margin-top: 0;">Task Details: Review Budget Report (#1001)</h2>
      <div class="grid cols-3" style="gap: 15px; margin-bottom: 15px;">
        <div class="col">
          <label class="small" for="title-modal">Title</label>
          <input id="title-modal" class="input" type="text" value="Review Q3 Budget Report">
        </div>
        <div class="col">
          <label class="small" for="assignee-modal">Assignee</label>
          <select id="assignee-modal" class="select assign-select">
            <option selected>Alice J.</option>
            <option>Bob K.</option>
          </select>
        </div>
        <div class="col">
          <label class="small" for="status-modal">Status</label>
          <select id="status-modal" class="select">
            <option selected>Pending</option>
            <option>In Progress</option>
            <option>Resolved</option>
          </select>
        </div>
      </div>

      <label class="small" for="description-modal">Description</label>
      <textarea id="description-modal" class="textarea" rows="4" style="margin-bottom: 15px;">Need to verify all line items against last quarter's spending for variance analysis.</textarea>

      <h4 style="margin-bottom: 8px;">Activity Log</h4>
      <div class="log-panel">
        <div class="log-entry small">*2025-12-01 10:30 AM* - Status changed from *Open* to *Pending* by System.</div>
        <div class="log-entry small">*2025-12-01 10:28 AM* - Assigned to *Alice J.* by Admin.</div>
        <div class="log-entry small">*2025-12-01 10:25 AM* - Task created by Admin.</div>
      </div>

      <div class="controls-row" style="justify-content: flex-end; margin-top: 15px;">
        <button class="btn ghost">Cancel</button>
        <button class="btn">Save Changes</button>
      </div>
    </div>
  </div>
  
  <footer>
    Task Dashboard Demo &copy; 2025
  </footer>
</body>
</html>
