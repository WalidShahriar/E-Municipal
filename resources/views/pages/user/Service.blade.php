<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Municipal Service Request Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js";
        import { getAuth, signInAnonymously, signInWithCustomToken, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-auth.js";
        import { getFirestore, doc, addDoc, onSnapshot, collection, query, serverTimestamp, setLogLevel } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-firestore.js";
        setLogLevel('Debug')
        const appId = typeof __app_id !== 'undefined' ? __app_id : 'default-app-id';
        const firebaseConfig = JSON.parse(typeof __firebase_config !== 'undefined' ? __firebase_config : '{}');
        const initialAuthToken = typeof __initial_auth_token !== 'undefined' ? __initial_auth_token : null;
        let db = null;
        let auth = null;
        let userId = null;
        let requestsCollectionRef = null;
        let isAuthReady = false;
        window.showView = showView;
        window.closeModal = closeModal;
        window.renderServiceRequirements = renderServiceRequirements;
        const departmentMap = {
            'NewLightingInstall': 'Electrical Planning',
            'Sidewalk': 'Public Infrastructure',
            'NewParkInfra': 'Parks & Recreation Planning',
            'TreeRemoval': 'Forestry Department',
            'Default': 'Central Administration'
        };

        const SERVICE_REQUIREMENTS = {
            'NewLightingInstall': { fee: 'Tk 1,500.00 (Permit & Inspection Fee)', documents: ['Proposed site map/sketch', 'Written justification'] },
            'Sidewalk': { fee: 'Tk 3,000.00 - Tk 10,000.00 (Construction Permit Fee)', documents: ['Property survey map', 'Proposed modification drawing'] },
            'NewParkInfra': { fee: 'Tk 750.00 (Request Processing Fee)', documents: ['Detailed proposal', 'Citizen petition (optional)'] },
            'TreeRemoval': { fee: 'Tk 1,500.00 (Inspection Fee, Non-refundable)', documents: ['Arborist report (if available)', 'Photo of the tree/area'] },
            '': { fee: 'Please select a service above', documents: ['Service requirements and fee structure will appear here.'] },
            'Default': { fee: 'Tk 500.00 (Initial Processing Fee)', documents: ['General application form'] }
        };

        const STATUS_TIMELINE = [
            { step: 1, name: 'Requested', statuses: ['Requested'], icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' },
            { step: 2, name: 'Reviewing/Approved', statuses: ['Awaiting payment/fee verification', 'Pending Quote', 'Scheduled'], icon: 'M5 13l4 4L19 7' },
            { step: 3, name: 'Work in Progress', statuses: ['Work in Progress'], icon: 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-2.414-2.414A1 1 0 0015.586 6H7a2 2 0 00-2 2v11a2 2 0 002 2z' },
            { step: 4, name: 'Completed', statuses: ['Complete'], icon: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' }
        ];


        async function initFirebase() {
            if (!firebaseConfig.apiKey) {
                console.warn("Firebase configuration not found. Running in non-persistent simulation mode.");
                isAuthReady = true;
                userId = crypto.randomUUID();

                let allRequests = [
                    { id: 'SIR-25-00001', title: 'Pothole Repair', department: 'Public Infrastructure', status: 'Requested', description: 'Large pothole at city hall entrance.', location: 'Main and 1st', managerRemarks: 'Initial review complete. Awaiting scheduling.' },
                    { id: 'SIR-25-00002', title: 'New Stop Sign', department: 'Central Administration', status: 'Pending Quote', description: 'Need a stop sign at school zone.', location: 'School Rd', managerRemarks: 'Quote issued. Awaiting payment from requestor.' },
                    { id: 'SIR-25-00003', title: 'Park Bench Installation', department: 'Parks & Recreation Planning', status: 'Work in Progress', description: 'Installing three new benches in Central Park.', location: 'Central Park', managerRemarks: 'Installation started on Monday.' },
                    { id: 'SIR-25-00004', title: 'Tree Removal Permit', department: 'Forestry Department', status: 'Complete', description: 'Removal of dead oak tree.', location: '10 Downing St', managerRemarks: 'Permit issued. Tree removal confirmed.' },
                    { id: 'SIR-25-00005', title: 'Sidewalk Permit', department: 'Public Infrastructure', status: 'Rejected', description: 'Requested sidewalk extension.', location: '123 Fake St', managerRemarks: 'Request rejected due to zoning restrictions.' }
                ];
                window.currentRequestCount = 5;
                window.allRequests = allRequests;
            }

            try {
                const app = initializeApp(firebaseConfig);
                db = getFirestore(app);
                auth = getAuth(app);

                onAuthStateChanged(auth, (user) => {
                    if (user) {
                        userId = user.uid;
                        const collectionPath = `/artifacts/${appId}/public/data/serviceRequests`;
                        requestsCollectionRef = collection(db, collectionPath);
                        isAuthReady = true;
                        setupRequestListener();
                    } else {
                        userId = crypto.randomUUID();
                        isAuthReady = true;
                    }
                });

                if (initialAuthToken) {
                    await signInWithCustomToken(auth, initialAuthToken).catch(() => signInAnonymously(auth));
                } else {
                    await signInAnonymously(auth);
                }

            } catch (e) {
                console.error("Firebase initialization failed:", e);
                isAuthReady = true;
            }
        }
        function setupRequestListener() {

            if (!firebaseConfig.apiKey) {
                window.allRequests = window.allRequests || [];
                return;
            }

            if (!db || !requestsCollectionRef) return;
            const q = query(requestsCollectionRef);
            onSnapshot(q, (snapshot) => {
                let localRequests = [];
                let maxCount = 0;
                snapshot.forEach(doc => {
                    const data = { ...doc.data(), docId: doc.id };
                    localRequests.push(data);
                    const idParts = data.id.split('-');
                    const idNumber = parseInt(idParts[idParts.length - 1]);
                    if (!isNaN(idNumber)) {
                        maxCount = Math.max(maxCount, idNumber);
                    }
                });
                window.currentRequestCount = maxCount;
                window.allRequests = localRequests;
                console.log(`Firestore Update: Loaded ${window.allRequests.length} requests.`);
            }, (error) => {
                console.error("Error listening to service requests:", error);
            });
        }

        function renderServiceRequirements() {
            const category = document.getElementById('category').value;
            const requirementBox = document.getElementById('requirementBox');
            const requiredDocList = document.getElementById('requiredDocList');
            const feeDisplay = document.getElementById('feeDisplay');

            const requirements = SERVICE_REQUIREMENTS[category] || SERVICE_REQUIREMENTS['Default'];
            feeDisplay.textContent = requirements.fee;
            requiredDocList.innerHTML = '';
            requirements.documents.forEach(doc => {
                const listItem = document.createElement('li');
                listItem.className = 'flex items-start space-x-2 text-sm text-gray-700';
                listItem.innerHTML = `<svg class="w-4 h-4 text-teal-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><span class="flex-1">${doc}</span>`;
                requiredDocList.appendChild(listItem);
            });

            if (category === '') {
                requirementBox.classList.add('hidden');
            } else {
                requirementBox.classList.remove('hidden');
            }
        }
        function showModal(id) {
            document.getElementById('modalRequestId').textContent = id;
            document.getElementById('successModal').classList.add('active');
        }
        function closeModal() {
            document.getElementById('successModal').classList.remove('active');
        }

        function showView(viewName) {
            document.querySelectorAll('.view-content').forEach(view => { view.classList.add('hidden'); });

            document.getElementById(viewName + 'View').classList.remove('hidden');

            if (viewName !== 'mainNav') {
                document.getElementById('mainNavContainer').classList.add('hidden');
            } else {
                document.getElementById('mainNavContainer').classList.remove('hidden');
            }

            document.getElementById('statusResult').classList.add('hidden');
            document.getElementById('statusNotFound').classList.add('hidden');

            const backBtn = document.getElementById('backToNavBtn');
            if (viewName === 'mainNav') {
                backBtn.classList.add('hidden');
            } else {
                backBtn.classList.remove('hidden');
            }
        }

        function showSubmitError(message) {
            const submitMessageBox = document.getElementById('submitMessageBox');
            submitMessageBox.textContent = message;
            submitMessageBox.classList.remove('hidden', 'bg-green-100', 'text-green-700');
            submitMessageBox.classList.add('bg-red-100', 'text-red-700');
            setTimeout(() => { submitMessageBox.classList.add('hidden'); }, 8000);
        }
        const generateRequestID = (count) => {
            const year = new Date().getFullYear().toString().slice(2);
            return `SIR-${year}-${(count + 1).toString().padStart(5, '0')}`;
        };

        function renderStatusTimeline(currentStatus) {
            const timelineContainer = document.getElementById('statusTimeline');
            timelineContainer.innerHTML = '';

            let activeStepIndex = 0;
            STATUS_TIMELINE.forEach((item, index) => {
                if (item.statuses.includes(currentStatus)) {
                    activeStepIndex = item.step;
                }
            });

            STATUS_TIMELINE.forEach((item, index) => {
                const stepElement = document.createElement('div');
                stepElement.className = 'flex-1 relative';

                const isCompleted = item.step < activeStepIndex;
                const isActive = item.step === activeStepIndex;
                const isFinal = index === STATUS_TIMELINE.length - 1;

                const circleColor = isCompleted || isActive ? 'bg-teal-600 text-white' : 'bg-gray-200 text-gray-500';
                const textColor = isCompleted || isActive ? 'text-teal-800 font-bold' : 'text-gray-500';
                const lineColor = isCompleted ? 'bg-teal-600' : 'bg-gray-300';

                if (!isFinal) {
                    stepElement.innerHTML += `<div class="absolute inset-y-0 left-1/2 -ml-0.5 top-6 bottom-6 hidden sm:block ${lineColor}" style="width: 2px;"></div>`;
                }

                stepElement.innerHTML += `
                    <div class="flex flex-col items-center text-center">
                        <!-- Circle Indicator -->
                        <div class="z-10 w-12 h-12 rounded-full flex items-center justify-center shadow-lg ${circleColor} transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${item.icon}"></path></svg>
                        </div>
                        
                        <!-- Text Label -->
                        <div class="mt-2 text-xs md:text-sm ${textColor} w-full">
                            ${item.name}
                        </div>
                    </div>
                `;

                timelineContainer.appendChild(stepElement);
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            initFirebase();
            showView('mainNav');
            renderServiceRequirements();

            const form = document.getElementById('requestForm');

            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                if (!isAuthReady) {
                    showSubmitError('System initializing. Please wait a moment and try again.');
                    return;
                }

                const title = document.getElementById('title').value.trim();
                const category = document.getElementById('category').value;
                const description = document.getElementById('description').value.trim();
                const location = document.getElementById('location').value.trim();
                const attachmentFileName = document.getElementById('attachment').files.length > 0 ? document.getElementById('attachment').files[0].name : 'N/A';


                if (!title || !category || !description) {
                    showSubmitError('Please fill out all required fields (Title, Category, Description) marked with an asterisk (*).');
                    return;
                }
                const department = departmentMap[category] || departmentMap['Default'];
                const newRequestCount = (window.currentRequestCount || 0) + 1;
                const requestId = generateRequestID(newRequestCount);

                const newRequestData = {
                    id: requestId,
                    title: title,
                    category: category,
                    description: description,
                    location: location || 'Not Provided',
                    attachmentName: attachmentFileName,
                    department: department,
                    status: 'Requested',
                    managerRemarks: 'Awaiting payment/fee verification and initial review.',
                    submittedBy: userId,
                    timestamp: firebaseConfig.apiKey ? serverTimestamp() : new Date().toISOString()
                };

                try {
                    if (firebaseConfig.apiKey) {
                        await addDoc(requestsCollectionRef, newRequestData);
                    } else {
                        window.allRequests.push(newRequestData);
                        window.currentRequestCount = newRequestCount;
                        console.log("SIMULATION: Request submitted to local memory:", newRequestData);
                    }

                    showModal(requestId);
                    form.reset();
                    renderServiceRequirements();
                } catch (e) {
                    console.error("Error submitting service request to Firestore:", e);
                    showSubmitError('Failed to submit request. Check console for details. (Did you wait for initialization?)');
                }
            });

            const statusForm = document.getElementById('statusForm');
            const statusResult = document.getElementById('statusResult');
            const statusNotFound = document.getElementById('statusNotFound');
            const notFoundMessage = document.getElementById('notFoundMessage');
            const checkStatusButton = document.getElementById('checkStatusButton');
            const statusButtonText = document.getElementById('statusButtonText');
            const statusSpinner = document.getElementById('statusSpinner');
            const rejectedNotice = document.getElementById('rejectedNotice');


            statusForm.addEventListener('submit', function (e) {
                e.preventDefault();

                checkStatusButton.disabled = true;
                statusButtonText.textContent = 'Checking...';
                statusSpinner.classList.remove('hidden');

                statusResult.classList.add('hidden');
                statusNotFound.classList.add('hidden');
                rejectedNotice.classList.add('hidden');

                const inputId = document.getElementById('requestIdInput').value.trim().toUpperCase();

                if (!isAuthReady || !inputId) {
                    checkStatusButton.disabled = false;
                    statusButtonText.textContent = 'Track Status';
                    statusSpinner.classList.add('hidden');

                    notFoundMessage.textContent = !isAuthReady
                        ? 'System initialization in progress. Please wait a few seconds before tracking status.'
                        : 'Please enter a valid Service Request ID to check its status.';
                    statusNotFound.classList.remove('hidden');
                    return;
                }

                setTimeout(() => {
                    checkStatusButton.disabled = false;
                    statusButtonText.textContent = 'Track Status';
                    statusSpinner.classList.add('hidden');

                    const foundRequest = window.allRequests.find(c => c.id === inputId);

                    if (foundRequest) {
                        const status = foundRequest.status || 'Requested';

                        document.getElementById('displayId').textContent = foundRequest.id;
                        document.getElementById('displayTitle').textContent = foundRequest.title;
                        document.getElementById('displayDepartment').textContent = foundRequest.department;
                        document.getElementById('displayDescription').textContent = foundRequest.description;
                        document.getElementById('displayLocation').textContent = foundRequest.location;
                        document.getElementById('displayRemarks').textContent = foundRequest.managerRemarks || 'Awaiting initial review by department.';

                        const statusBadge = document.getElementById('displayStatus');
                        const badgeClass = status.toLowerCase().replace(/ /g, '-');
                        statusBadge.className = 'status-badge';
                        statusBadge.classList.add(badgeClass);
                        statusBadge.textContent = status;
                        if (status === 'Rejected') {
                            rejectedNotice.classList.remove('hidden');
                            statusResult.classList.remove('hidden');
                            document.getElementById('statusTimelineContainer').classList.add('hidden'); // Hide timeline
                        } else {
                            renderStatusTimeline(status);
                            document.getElementById('statusTimelineContainer').classList.remove('hidden'); // Show timeline
                            statusResult.classList.remove('hidden');
                        }

                    } else {
                        notFoundMessage.textContent = `Service Request ID "${inputId}" was not found in our records. Please verify the ID (e.g., SIR-25-00001) and try again.`;
                        statusNotFound.classList.remove('hidden');
                    }
                }, 800);
            });
        });
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0fdf4;
            min-height: 100vh;
        }

        .primary-card {
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.1);
        }

        .nav-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .nav-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px -5px rgba(4, 120, 87, 0.2);
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .requested {
            background-color: #fef9c3;
            color: #a16207;
        }

        .pending-quote,
        .awaiting-payment\/fee-verification,
        .scheduled {
            background-color: #d1fae5;
            color: #065f46;
        }

        .work-in-progress {
            background-color: #bfdbfe;
            color: #1e40af;
        }

        .complete {
            background-color: #a7f3d0;
            color: #047857;
        }

        .rejected {
            background-color: #fecaca;
            color: #b91c1c;
        }

        .spinner {
            border: 3px solid rgba(0, 0, 0, 0.1);
            border-top: 3px solid #0d9488;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: transform: rotate(360deg);
            }
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
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
    <div class="max-w-5xl w-full">
        <header class="text-center mb-8 p-8 bg-white rounded-2xl primary-card border-t-4 border-teal-600">
            <h1 class="text-3xl md:text-5xl font-extrabold text-teal-900">
                Service Request Portal
            </h1>
            <p class="text-gray-600 mt-2 text-lg">Request Your Service.</p>
        </header>
        <button id="backToNavBtn" onclick="showView('mainNav')"
            class="hidden mb-6 flex items-center space-x-2 text-teal-700 hover:text-teal-900 font-semibold transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            <span>Back to Main Options</span>
        </button>
        <div class="bg-white rounded-2xl primary-card overflow-hidden p-6 md:p-10">
            <div id="mainNavView" class="view-content" role="region" aria-labelledby="mainOptionsTitle">
                <h2 id="mainOptionsTitle" class="text-2xl font-bold mb-8 text-teal-800 border-b pb-3 text-center">What
                    would you like to do?</h2>

                <div id="mainNavContainer" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div id="submitCard" onclick="showView('submit')"
                        class="nav-card cursor-pointer p-8 bg-teal-50 border-2 border-teal-300 rounded-3xl text-center shadow-lg hover:shadow-xl transition duration-300">
                        <svg class="w-16 h-16 text-teal-600 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <h3 class="text-2xl font-extrabold text-teal-900 mb-2">Submit a New Request</h3>
                        <p class="text-gray-700">Initiate a formal request for infrastructure installation,
                            modification, or permit applications (fees may apply).</p>
                    </div>
                    <div id="statusCard" onclick="showView('status')"
                        class="nav-card cursor-pointer p-8 bg-gray-50 border-2 border-gray-300 rounded-3xl text-center shadow-lg hover:shadow-xl transition duration-300">
                        <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-2xl font-extrabold text-gray-900 mb-2">Track Request Status</h3>
                        <p class="text-gray-700">Check the real-time progress, department assignment, and remarks for a
                            submitted Service Request ID.</p>
                    </div>
                </div>
            </div>
            <div id="submitView" class="view-content hidden" role="region" aria-labelledby="submitTitle">
                <h2 id="submitTitle" class="text-2xl font-bold mb-6 text-teal-800 border-b pb-3">Detail Your Service
                    Need</h2>
                <form id="requestForm" class="space-y-6">
                    <div class="md:grid md:grid-cols-2 md:gap-8 space-y-6 md:space-y-0">
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Service Category
                                <span class="text-red-500">*</span></label>
                            <select id="category" name="category" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-teal-500 focus:border-teal-500 transition duration-150 bg-white shadow-inner text-sm"
                                onchange="renderServiceRequirements()">
                                <option value="" disabled selected>Select the type of service requested</option>
                                <optgroup label="New Services & Permits (Fees Apply)">
                                    <option value="NewLightingInstall">New Streetlight Installation</option>
                                    <option value="Sidewalk">Sidewalk Repair / New Construction Permit</option>
                                    <option value="NewParkInfra">New Park Infrastructure Request (e.g., bench, sign)
                                    </option>
                                    <option value="TreeRemoval">Tree Trimming / Removal (Requires Inspection)</option>
                                </optgroup>
                            </select>
                        </div>
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Brief Title <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="title" name="title" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-teal-500 focus:border-teal-500 transition duration-150 shadow-inner text-sm"
                                placeholder="e.g., New light needed near Mosque Road">
                        </div>
                    </div>
                    <div id="requirementBox" class="p-4 bg-teal-50 border border-teal-200 rounded-xl hidden">
                        <h3 class="text-lg font-bold text-teal-800 mb-3">Service Requirements</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="font-semibold text-gray-700 mb-1">Estimated Fee (BDT - Bangladesh Taka):</p>
                                <p id="feeDisplay" class="text-xl font-extrabold text-teal-600">Please select a service
                                    above</p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-700 mb-2">Required Documents:</p>
                                <ul id="requiredDocList" class="space-y-2 pl-0 list-none"></ul>
                            </div>
                        </div>
                    </div>
                    <div class="md:grid md:grid-cols-2 md:gap-8 space-y-6 md:space-y-0">
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Detailed
                                Description <span class="text-red-500">*</span></label>
                            <textarea id="description" name="description" rows="4" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-teal-500 focus:border-teal-500 transition duration-150 shadow-inner"
                                placeholder="Describe the service needed, why it's necessary, and provide exact dimensions or specifications..."></textarea>
                        </div>
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Exact Location /
                                Address</label>
                            <textarea id="location" name="location" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-teal-500 focus:border-teal-500 transition duration-150 shadow-inner"
                                placeholder="e.g., Corner of 1st Ave and Main St, opposite the library; or plot number..."></textarea>
                        </div>
                    </div>
                    <div>
                        <label for="attachment" class="block text-sm font-medium text-gray-700 mb-1">Attach Required
                            Documents / Photos</label>
                        <input type="file" id="attachment" name="attachment" accept="image/*, .pdf" multiple
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-teal-100 file:text-teal-700 hover:file:bg-teal-200 cursor-pointer">
                        <p class="text-xs text-gray-500 mt-1">Please ensure you submit the documents listed in the
                            'Service Requirements' box above.</p>
                    </div>

                    <button type="submit" id="submitButton"
                        class="w-full bg-teal-600 text-white py-4 mt-6 rounded-xl font-extrabold text-lg hover:bg-teal-700 transition duration-200 focus:outline-none focus:ring-4 focus:ring-teal-300 transform hover:scale-[1.005]">
                        SUBMIT NEW SERVICE REQUEST
                    </button>
                </form>

                <div id="submitMessageBox" class="mt-4 p-3 rounded-lg text-center font-medium hidden" role="alert"
                    aria-live="assertive"></div>
            </div>
            <div id="statusView" class="view-content hidden" role="region" aria-labelledby="statusTitle">
                <h2 id="statusTitle" class="text-2xl font-bold mb-6 text-teal-800 border-b pb-3">Track Your Request</h2>

                <form id="statusForm" class="flex flex-col sm:flex-row gap-4 mb-8">
                    <input type="text" id="requestIdInput" placeholder="Enter Request ID (e.g., SIR-25-00001)" required
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-teal-500 focus:border-teal-500 transition duration-150 uppercase shadow-inner"
                        aria-label="Request ID Input">
                    <button type="submit" id="checkStatusButton"
                        class="bg-gray-700 text-white py-3 px-8 rounded-xl font-bold hover:bg-gray-800 transition duration-200 focus:outline-none focus:ring-4 focus:ring-gray-300 shrink-0 flex items-center justify-center space-x-2">
                        <span id="statusButtonText">Track Status</span>
                        <div id="statusSpinner" class="spinner hidden ml-2"></div>
                    </button>
                </form>
                <div id="statusNotFound"
                    class="p-5 border-l-4 border-red-500 rounded-lg bg-red-50 text-red-700 hidden mb-8" role="alert">
                    <p class="font-bold">Request ID Not Found</p>
                    <p id="notFoundMessage" class="text-sm mt-1"></p>
                </div>
                <div id="statusResult" class="p-6 border-l-4 border-teal-500 rounded-lg bg-teal-50 hidden" role="region"
                    aria-live="polite">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm font-medium text-teal-600">Service Request ID</p>
                            <span id="displayId" class="font-extrabold text-3xl text-teal-800 block"></span>
                        </div>
                        <span id="displayStatus" class="status-badge"></span>
                    </div>
                    <h3 class="text-xl font-bold mb-6 text-teal-800 border-t pt-4">Progress Timeline</h3>
                    <div id="statusTimelineContainer" class="mb-8">
                        <div id="rejectedNotice"
                            class="p-4 bg-red-100 border border-red-300 rounded-lg text-red-800 font-semibold hidden text-center">
                            This request was unfortunately rejected. Please review the Department Update below for
                            details.
                        </div>
                        <div id="statusTimeline" class="flex justify-between space-x-2 sm:space-x-4">
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-teal-800 border-t pt-4">Request Summary</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white p-3 rounded-lg border border-gray-200">
                            <p class="font-medium text-gray-700">Title:</p>
                            <span id="displayTitle" class="text-gray-600 font-semibold"></span>
                        </div>
                        <div class="bg-white p-3 rounded-lg border border-gray-200">
                            <p class="font-medium text-gray-700">Assigned Department:</p>
                            <span id="displayDepartment" class="text-gray-600"></span>
                        </div>
                    </div>
                    <div class="mt-4 p-3 bg-white rounded-lg border border-gray-200">
                        <p class="font-medium text-gray-700">Description:</p>
                        <span id="displayDescription" class="text-gray-600 italic text-sm block mt-1"></span>
                    </div>
                    <div class="mt-4 p-3 bg-white rounded-lg border border-gray-200">
                        <p class="font-medium text-gray-700">Location:</p>
                        <span id="displayLocation" class="text-gray-600 italic text-sm block mt-1"></span>
                    </div>
                    <div class="mt-4 p-3 bg-white rounded-lg border border-gray-200">
                        <p class="font-medium text-gray-700">Department Update:</p>
                        <span id="displayRemarks" class="text-gray-600 italic text-sm block mt-1"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="successModal" class="modal-overlay">
        <div
            class="bg-white p-8 md:p-10 rounded-xl max-w-lg w-full text-center shadow-2xl transform scale-95 transition-transform duration-300 ease-out">
            <svg class="w-16 h-16 text-teal-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-2xl font-bold text-teal-700 mb-3">Service Request Filed!</h3>
            <p class="text-gray-600 mb-6">Your service/permit request has been successfully submitted. Please use this
                unique ID to track its progress:</p>

            <div class="p-4 bg-teal-50 border-2 border-teal-200 rounded-lg mb-6">
                <p class="text-sm text-teal-600 font-semibold">Tracking ID:</p>
                <p id="modalRequestId" class="text-4xl font-extrabold text-teal-800 mt-1 break-words"></p>
            </div>

            <button onclick="closeModal()"
                class="w-full bg-teal-600 text-white py-3 rounded-lg font-bold hover:bg-teal-700 transition duration-200 focus:outline-none focus:ring-4 focus:ring-teal-300">
                Acknowledge & Close
            </button>
        </div>
    </div>
</body>

</html>