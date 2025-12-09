# 🏙️ E-Municipal: Digital City Management System

**E-Municipal** is a robust web application built with the **Laravel Framework**, designed to bridge the gap between citizens and municipal authorities. Using **Dhaka City** as its primary use case, this platform creates a seamless digital channel for civic engagement and administrative management.

In an era of "Smart Cities," E-Municipal replaces outdated manual processes with a centralized, transparent digital dashboard, empowering citizens to take an active role in their community's maintenance.

### 🚀 Key Features

**For Citizens:**
* **📢 Issue Reporting:** Easily file complaints regarding civic issues (e.g., waste management, road repairs, street lighting) with location tracking.
* **📄 Service Requests:** Apply for municipal services directly through the portal without visiting physical offices.
* **📊 Status Tracking:** Real-time updates on the progress of filed complaints and applications.

**For Administration:**
* **🛡️ Admin Control Panel:** A comprehensive dashboard to view, sort, and manage incoming citizen requests.
* **✅ Workflow Management:** Update status of tasks (Pending, In Progress, Resolved) to ensure accountability.
* **📈 Data Oversight:** centralized database of citizen activities and service history.

### 🛠️ Tech Stack
* **Backend:** PHP, Laravel Framework
* **Frontend:** Blade Templates, HTML5, CSS3, JavaScript
* **Database:** MySQL

---
*Note: While currently modeled for Dhaka, this architecture is modular and scalable for any municipal corporation.*

## Team Task Distribution:
| **Team Member Name**     | **Team Member ID**      | **Assigned Functional Requirements (FRs)**           |
|--------------------------|-------------------------|------------------------------------------------------|
| MD WALID SHAHRIAR        | 221-15-4646             | FR-1, FR-2, FR-10                                    |
| Partho Biswas            | 0242220005101012        | FR-3, FR-4                                           |
| Sumaya Akter Eva         | 0242220005101042        | FR-5, FR-6                                           |
| Sworna Sarker            | 0242220005101040        | FR-7                                                 |
| Itti Samur Tunib         | 0242220005101335        | FR-8, FR-9                                           |


## Functional Requirements (FRs)
<ul>
    <li>FR-1: User registration, authentication, and role-based access, Home page, Profile Page.</li>
    <li>FR-2: The system shall provide role-based access for Citizens, Officers, and Admins.</li>
    <li>FR-3: The system shall allow citizens to submit complaints with necessary details and 
attachments.</li>
    <li>FR-4: The system shall generate unique Complaint IDs and assign each complaint to the 
correct department. </li>
    <li>FR-5: The system shall allow citizens to submit service requests with required information.</li>
    <li>FR-6: The system shall allow officers to update the status of complaints and service requests. </li>
    <li>FR-7: The system shall provide department dashboards for viewing and managing assigned 
cases. </li>
    <li>FR-8: The system shall allow admins to manage users, categories, and departments. </li>
    <li>FR-9: The system shall securely store all data and maintain a basic audit log for important 
actions.  </li>
    <li>FR-10: Integration of AI</li>
</ul>


## ⚙️ Installation Guide

Follow these steps to set up the **E-Municipal** project on your local machine.

### 1. Prerequisites

Before you begin, ensure you have the following software installed:
* **[XAMPP](https://www.apachefriends.org/)** (Includes PHP & MySQL)
* **[Composer](https://getcomposer.org/)** (Dependency Manager for PHP)
* **Git** (For cloning the repository)

### 2. Clone the Repository

Open your terminal (or Git Bash) and run the following commands to download the project:

```bash
git clone [https://github.com/WalidShahriar/E-Municipal.git](https://github.com/WalidShahriar/E-Municipal.git)
cd E-Municipal
```

### 3. Install Backend Dependencies

Download the necessary PHP packages using Composer

```bash
composer install
```

### 4. Database Setup (Import Method)

Since this project uses a pre-configured SQL dump, follow these steps to set up the database:

1. Open the XAMPP Control Panel and start Apache and MySQL.
2. Go to localhost/phpmyadmin in your browser.
3. Click New from the sidebar and create a database named: e_municipal
4. Select the new database, go to the Import tab.
5. Click Choose File and locate the e_municipal.sql file (located in the project root directory or database/ folder).
6. Finally, Click Import (or Go) at the bottom.

### 5. Link Database to Application

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e_municipal
DB_USERNAME=root
DB_PASSWORD=root
```

### 6. Run the Application

🎉💗🥳 You are ready to go! Start the local development server: 
hit: ```bash php artisan serve ```

### 7. One more step to access the web-app 🙏 🥺👉👈

hit the url: ```bash http://127.0.0.1:8000/home ``` Generated in the **terminal**

---

## 👏 Acknowledgements

We extend our deepest gratitude to everyone who supported the inception and development of Voice of Bangladesh. This project stands as a testament to the relentless effort, synergy, and shared vision of our entire team. The final outcome is a direct reflection of the unwavering dedication and distinct contributions brought forth by each member. We are also sincerely thankful to our mentors and peers for their patience, understanding, and invaluable moral support throughout the challenging phases of development and documentation.

## ⚠️ Educational Use Disclaimer

Please note that this project is intended solely for educational and learning purposes. All images, government logos, icons, and video assets used within the application are for representative purposes to simulate a real-world environment. This is a non-profit project and is not officially affiliated with any government entity.

## 📝 Citation

**License & Attribution** This project is open-source and available for educational use. We encourage developers and students to learn from, modify, and build upon this codebase. While you are free to fork and adapt the code for your own educational projects, however, if you use any part of this project in your own work, please give appropriate **credit** to the original creators. A link back to this repository is highly appreciated.

> Source: https://github.com/WalidShahriar/E-Municipal



<div align="center">
    <br>
    <h3><strong>If you read this far, you now qualify for a virtual high-five. ✋🏻</strong></h3>
    <br>
    <h3>°❀⋆.ೃ࿔*:･__<em> The End </em>__･:*࿔.ೃ⋆❀°</h3>
    <br>
</div>








