<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Municipality Dashboard</title>

<style>
    body {
        font-family: Arial, sans-serif;
        background: #f2f2f2;
        margin: 0;
        padding: 20px;
    }

    h2 {
        text-align: center;
    }

    .dashboard {
        width: 90%;
        margin: auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }

    th {
        background: #4CAF50;
        color: white;
    }

    select {
        padding: 6px;
        border-radius: 5px;
    }
</style>
</head>

<body>

<h2>Municipality Dashboard</h2>

<div class="dashboard">
    <table>
        <thead>
            <tr>
                <th>Complaint ID</th>
                <th>Service Request ID</th>
                <th>Description</th>
                <th>Department</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody id="dataTable">
            <!-- Data will be added by JavaScript -->
        </tbody>
    </table>
</div>

<script>
    // Sample data for complaints + services
    let dashboardData = [
        {
            complaintId: "C-101",
            serviceId: "S-201",
            description: "Garbage not collected",
            department: "Sanitation",
            status: "Pending",
            statusOptions: ["Pending", "In Progress", "Resolved", "Closed"]
        },
        {
            complaintId: "C-102",
            serviceId: "S-202",
            description: "Street light not working",
            department: "Electricity",
            status: "In Progress",
            statusOptions: ["Pending", "In Progress", "Resolved", "Closed"]
        },
        {
            complaintId: "C-103",
            serviceId: "S-203",
            description: "Water leakage",
            department: "Water Supply",
            status: "Requested",
            statusOptions: ["Requested", "Reviewing/Approved", "Work in Progress", "Completed"]
        }
    ];

    function loadTable() {
        let table = document.getElementById("dataTable");
        table.innerHTML = "";

        dashboardData.forEach((item, index) => {
            let row = `
                <tr>
                    <td>${item.complaintId}</td>
                    <td>${item.serviceId}</td>
                    <td>${item.description}</td>
                    <td>${item.department}</td>
                    <td>
                        <select onchange="updateStatus(${index}, this.value)">
                            ${item.statusOptions.map(option =>
                                <option value="${option}" ${option === item.status ? "selected" : ""}>${option}</option>
                            ).join("")}
                        </select>
                    </td>
                </tr>
            `;
            table.innerHTML += row;
        });
    }

    function updateStatus(index, newStatus) {
        dashboardData[index].status = newStatus;
        alert("Status updated to: " + newStatus);
    }

    loadTable();
</script>

</body>
</html>
