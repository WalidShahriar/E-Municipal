<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Municipal Complaint Portal | Submit & Track</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles for a clean, professional look */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #eef2f6; /* Very light blue-grey background */
            min-height: 100vh;
        }

        /* Status Badge Styling for visual status tracking */
        .status-badge {
            padding: 6px 14px;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 0.875rem; 
            text-transform: uppercase;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); /* Subtle shadow added */
        }
        .pending { background-color: #ffedd5; color: #9a3412; } 
        .in-progress { background-color: #dbeafe; color: #1e40af; } 
        .resolved { background-color: #d1fae5; color: #065f46; } 
        .closed { background-color: #fee2e2; color: #991b1b; } 
        
        /* Tab Navigation Styling */
        .tab-button {
            padding: 14px 24px; /* Increased padding */
            cursor: pointer;
            border-bottom: 3px solid transparent;
            font-weight: 700; /* Bolder font */
            transition: all 0.3s ease;
            outline: none;
        }
        .tab-button.active {
            border-color: #0b50b9; /* Darker blue border */
            color: #0b50b9;
            background-color: #e0ecff; /* Light blue background for active tab */
        }

        .card {
            box-shadow: 0 6px 15px -3px rgba(0, 0, 0, 0.08);
        }

        /* Loading Spinner CSS */
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-top: 4px solid #10b981; /* Green color */
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
    </style>
</head>
<body class="p-4 md:p-8 flex justify-center items-start">

    <div class="max-w-4xl w-full">
        <header class="text-center mb-8 p-6 bg-white rounded-xl card">
            <h1 class="text-3xl md:text-4xl font-extrabold text-blue-900">
                Complaint Portal
            </h1>
            <p class="text-gray-600 mt-2">Report Your Issues and Track Their Resolution.</p>
        </header>

        <div class="flex border-b border-gray-200 bg-white rounded-t-xl overflow-hidden card">
            <button id="tabSubmitBtn" class="tab-button active text-blue-700 flex-1 text-center" onclick="showTab('submit')" aria-controls="submitTab" aria-selected="true">
                1. Submit a New Complaint
            </button>
            <button id="tabStatusBtn" class="tab-button text-gray-500 flex-1 text-center" onclick="showTab('status')" aria-controls="statusTab" aria-selected="false">
                2. View Complaint Status
            </button>
        </div>

        <div class="bg-white p-6 md:p-10 rounded-b-xl rounded-t-none card">
            
            <div id="submitTab" class="tab-content" role="tabpanel" aria-labelledby="tabSubmitBtn">
                <h2 class="text-2xl font-bold mb-6 text-blue-800 border-b pb-3">Report a Problem</h2>
                <form id="complaintForm" class="space-y-6">
                    
                    <div class="md:grid md:grid-cols-2 md:gap-6 space-y-6 md:space-y-0">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Complaint Title <span class="text-red-500">*</span></label>
                            <input type="text" id="title" name="title" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150" placeholder="e.g., Broken Streetlight on Road 10">
                        </div>
                        
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                            <select id="category" name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                                <option value="" disabled selected>Select the problem category</option>
                                <option value="Electricity">Electricity & Lighting</option>
                                <option value="Waste">Waste Management & Sanitation</option>
                                <option value="Roads">Roads & Potholes</option>
                                <option value="Water Supply">Water Supply & Leakage</option>
                                <option value="Public Space">Public Parks & Spaces</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description of the problem <span class="text-red-500">*</span></label>
                        <textarea id="description" name="description" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150" placeholder="Explain the problem and exact location details..."></textarea>
                    </div>

                    <div class="md:grid md:grid-cols-2 md:gap-6 space-y-6 md:space-y-0">
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Detailed Location (Address/Landmark)</label>
                            <input type="text" id="location" name="location" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150" placeholder="123 Main St, near the old library">
                        </div>

                        <div>
                            <label for="attachment" class="block text-sm font-medium text-gray-700 mb-1">Attachment (Photo Proof)</label>
                            <input type="file" id="attachment" name="attachment" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                            <p class="text-xs text-gray-500 mt-1">Attach a photo (Optional, Max file size 5MB)</p>
                        </div>
                    </div>

                    <button type="submit" id="submitButton" class="w-full bg-blue-600 text-white py-3 mt-6 rounded-lg font-bold hover:bg-blue-700 transition duration-200 focus:outline-none focus:ring-4 focus:ring-blue-300 transform hover:scale-[1.005]">
                        Submit Complaint
                    </button>
                </form>

                <div id="submitMessageBox" class="mt-4 p-3 rounded-lg text-center font-medium hidden" role="alert" aria-live="assertive"></div>
            </div>

            <div id="statusTab" class="tab-content hidden" role="tabpanel" aria-labelledby="tabStatusBtn">
                <h2 class="text-2xl font-bold mb-6 text-blue-800 border-b pb-3">Check Your Complaint Status</h2>
                
                <form id="statusForm" class="flex flex-col sm:flex-row gap-4 mb-6" role="search">
                    <input type="text" id="complaintIdInput" placeholder="Enter Complaint ID (e.g., COMP-2025-0001)" required 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-150 uppercase shadow-inner" aria-label="Complaint ID Input">
                    <button type="submit" id="checkStatusButton" class="bg-green-600 text-white py-2 px-6 rounded-lg font-bold hover:bg-green-700 transition duration-200 focus:outline-none focus:ring-4 focus:ring-green-300 shrink-0 flex items-center justify-center space-x-2 transform hover:scale-[1.005]">
                        <span id="statusButtonText">Check Status</span>
                        <div id="statusSpinner" class="spinner hidden"></div>
                    </button>
                </form>

                <div id="statusResult" class="p-6 border-l-4 border-green-500 rounded-lg bg-green-50 hidden" role="region" aria-live="polite">
                    <h3 class="text-xl font-bold mb-4 text-green-800">Complaint Details</h3>
                    <div class="space-y-4">
                        <div class="p-3 bg-white rounded-lg border border-gray-200 shadow-sm">
                             <p class="text-sm font-medium text-gray-500 mb-1">Complaint ID (For Reference)</p>
                            <span id="displayId" class="font-extrabold text-2xl text-blue-800 block"></span>
                        </div>
                       
                        <p><span class="font-medium text-gray-700">Title:</span> <span id="displayTitle" class="text-gray-600"></span></p>
                        <p><span class="font-medium text-gray-700">Department:</span> <span id="displayDepartment" class="text-gray-600"></span></p>
                        <p><span class="font-medium text-gray-700">Description:</span> <span id="displayDescription" class="text-gray-600 italic text-sm block mt-1 p-2 bg-white rounded-md border"></span></p>
                        
                        <div class="flex items-center pt-3">
                            <span class="font-bold text-gray-800 mr-4 text-lg">Current Status:</span> 
                            <span id="displayStatus" class="status-badge"></span>
                        </div>
                    </div>
                </div>

                <div id="statusNotFound" class="p-5 border-l-4 border-red-500 rounded-lg bg-red-50 text-red-700 hidden" role="alert">
                    <p class="font-bold">⚠️ Complaint ID Not Found</p>
                    <p id="notFoundMessage" class="text-sm mt-1"></p>
                </div>
            </div>
        </div>
    </div>

    <div id="successModal" class="modal-overlay">
        <div class="bg-white p-8 md:p-10 rounded-xl max-w-lg w-full text-center shadow-2xl transform scale-95 transition-transform duration-300 ease-out">
            <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-2xl font-bold text-green-700 mb-3">Complaint Submitted!</h3>
            <p class="text-gray-600 mb-6">Your report has been successfully filed with the municipality. Please save your unique tracking ID:</p>
            
            <div class="p-4 bg-blue-50 border-2 border-blue-200 rounded-lg mb-6">
                <p class="text-sm text-blue-600 font-semibold">Tracking ID:</p>
                <p id="modalComplaintId" class="text-4xl font-extrabold text-blue-800 mt-1 break-words"></p>
            </div>

            <button onclick="closeModal()" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition duration-200 focus:outline-none focus:ring-4 focus:ring-blue-300">
                Acknowledge & Close
            </button>
        </div>
    </div>

    <script>
        // --- DOM Elements ---
        const form = document.getElementById('complaintForm');
        const submitMessageBox = document.getElementById('submitMessageBox');
        const statusForm = document.getElementById('statusForm');
        const statusResult = document.getElementById('statusResult');
        const statusNotFound = document.getElementById('statusNotFound');
        const notFoundMessage = document.getElementById('notFoundMessage');
        const successModal = document.getElementById('successModal');
        const checkStatusButton = document.getElementById('checkStatusButton');
        const statusButtonText = document.getElementById('statusButtonText');
        const statusSpinner = document.getElementById('statusSpinner');
        const submitButton = document.getElementById('submitButton');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Get the CSRF token

        // --- Tab Management (Logic remains the same) ---

        function showTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            document.getElementById(tabName + 'Tab').classList.remove('hidden');

            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active', 'text-blue-700');
                btn.classList.add('text-gray-500');
                btn.style.backgroundColor = 'transparent';
                btn.setAttribute('aria-selected', 'false');
            });

            const activeButton = document.getElementById('tab' + tabName.charAt(0).toUpperCase() + tabName.slice(1) + 'Btn');
            if (activeButton) {
                activeButton.classList.add('active', 'text-blue-700');
                activeButton.classList.remove('text-gray-500');
                activeButton.setAttribute('aria-selected', 'true');
            }
            
            // Clear status check results
            statusResult.classList.add('hidden');
            statusNotFound.classList.add('hidden');
        }
        window.showTab = showTab; 

        // --- Modal Control (Logic remains the same) ---

        function showModal(id) {
            document.getElementById('modalComplaintId').textContent = id;
            successModal.classList.add('active');
        }

        function closeModal() {
            successModal.classList.remove('active');
            showTab('submit'); // Optionally switch back to submit tab
        }
        window.closeModal = closeModal; 

        // --- Helper Functions (Only Error remains) ---

        /**
         * Displays an error message in the submission message box.
         */
        function showSubmitError(message) {
            submitMessageBox.textContent = message;
            submitMessageBox.classList.remove('hidden', 'bg-green-100', 'text-green-700');
            submitMessageBox.classList.add('bg-red-100', 'text-red-700');
            
            setTimeout(() => {
                submitMessageBox.classList.add('hidden');
            }, 8000);
        }

        // ------------------------------------------------------------------
        // --- UPDATED: Complaint Submission Logic (Connects to Laravel) ---
        // ------------------------------------------------------------------

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Disable button and show loading state
            const originalText = submitButton.textContent;
            submitButton.disabled = true;
            submitButton.textContent = 'Submitting...';

            // 1. Collect Data
            const formData = new FormData(form);
            const attachmentFile = formData.get('attachment');
            
            // The Laravel backend expects a JSON body, not FormData, for simplicity.
            // We convert FormData to a JSON object.
            
            // Note: We only pass the file name for now, as actual file upload requires more steps
            if (attachmentFile && attachmentFile.name) {
                formData.set('attachment_name', attachmentFile.name);
            }
            formData.delete('attachment');
            
            const data = Object.fromEntries(formData.entries());

            // 2. Send Data to Laravel Backend
            fetch('/api/complaints/submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    // Pass the CSRF token in the header
                    'X-CSRF-TOKEN': csrfToken 
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                // Re-enable button
                submitButton.disabled = false;
                submitButton.textContent = originalText;
                
                if (!response.ok) {
                    // Handle validation errors or server errors
                    return response.json().then(err => { 
                         // Check for Laravel validation errors (422)
                        if (response.status === 422 && err.errors) {
                            const errorKeys = Object.keys(err.errors);
                            const firstError = err.errors[errorKeys[0]][0];
                            throw new Error(`Validation Error: ${firstError}`);
                        }
                        throw new Error(err.message || `HTTP error! Status: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // 3. Provide User Feedback (Show modal with ID from backend)
                    showModal(data.id);
                    // 4. Reset Form
                    form.reset();
                } else {
                     showSubmitError('An error occurred during submission: ' + (data.message || 'Unknown error.'));
                }
            })
            .catch(error => {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
                console.error('Submission Error:', error);
                showSubmitError('Submission failed: ' + error.message);
            });
        });


        // ------------------------------------------------------------------
        // --- UPDATED: Complaint Status Check Logic (Connects to Laravel) ---
        // ------------------------------------------------------------------

        statusForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const inputId = document.getElementById('complaintIdInput').value.trim().toUpperCase();
            
            // Reset previous results
            statusResult.classList.add('hidden');
            statusNotFound.classList.add('hidden');

            if (!inputId) {
                notFoundMessage.textContent = 'Please enter a valid Complaint ID to check its status.';
                statusNotFound.classList.remove('hidden');
                return;
            }

            // Show Loading State (Spinner)
            checkStatusButton.disabled = true;
            statusButtonText.textContent = 'Checking...';
            statusSpinner.classList.remove('hidden');

            // Send GET request to the Laravel backend
            fetch(`/api/complaints/status/${inputId}`)
            .then(response => {
                if (!response.ok) {
                    // Throw an error if 404 (Not Found) or other HTTP error
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                
                // Hide Loading State
                checkStatusButton.disabled = false;
                statusButtonText.textContent = 'Check Status';
                statusSpinner.classList.add('hidden');
                
                if (data.success) {
                    const foundComplaint = data.complaint;

                    // Update display fields using data from MySQL
                    document.getElementById('displayId').textContent = foundComplaint.complaint_id;
                    document.getElementById('displayTitle').textContent = foundComplaint.title;
                    document.getElementById('displayDepartment').textContent = foundComplaint.department;
                    document.getElementById('displayDescription').textContent = foundComplaint.description;
                    
                    // Update status badge
                    const statusBadge = document.getElementById('displayStatus');
                    const status = foundComplaint.status;
                    const badgeClass = status.toLowerCase().replace(' ', '-');
                    
                    statusBadge.className = 'status-badge'; 
                    statusBadge.classList.add(badgeClass);
                    statusBadge.textContent = status;

                    // Show the result
                    statusResult.classList.remove('hidden');

                } else {
                    // Show not found message (should be caught by the catch block below for 404)
                    notFoundMessage.textContent = `Complaint ID "${inputId}" was not found in our records. Please verify the ID and try again.`;
                    statusNotFound.classList.remove('hidden');
                }
            })
            .catch(error => {
                // Hide Loading State
                checkStatusButton.disabled = false;
                statusButtonText.textContent = 'Check Status';
                statusSpinner.classList.add('hidden');

                // Handle 404 Not Found error
                const errorMessage = error.message.includes('not found') 
                    ? `Complaint ID "${inputId}" was not found in our records. Please verify the ID and try again.`
                    : `An error occurred: ${error.message}`;
                    
                notFoundMessage.textContent = errorMessage;
                statusNotFound.classList.remove('hidden');
            });
        });

        // ------------------------------------------------------------------
        // --- CLEANUP: REMOVED ALL LOCAL STORAGE AND TEST DATA LOGIC HERE ---
        // ------------------------------------------------------------------

        // Initialize by showing the submission tab
        document.addEventListener('DOMContentLoaded', () => {
            showTab('submit');
        });
    </script>
</body>
</html>