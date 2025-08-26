 const loadingState = document.getElementById('loading-state');
        const historyContent = document.getElementById('history-content');
        const premiumMessage = document.getElementById('premium-feature-message');
        const scanList = document.getElementById('scan-list');
        const emptyHistoryMessage = document.getElementById('empty-history-message');
        const modal = document.getElementById('details-modal');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const authErrorMessage = document.getElementById('auth-error-message');

        let scanHistoryData = []; // To store the fetched history

        document.getElementById('hero-section').style.display = 'none';
        
        async function fetchScanHistory(token) {
            // !!! IMPORTANT !!! REPLACE THIS URL
            const apiUrl = App.baseAPI + '/history';
            const response = await fetch(apiUrl, {
                headers: { 'Authorization': `Bearer ${token}` }
            });
            if (!response.ok) {
                throw new Error('Could not fetch scan history.');
            }
            return response.json();
        }

        function renderScanHistory(scans) {
            scanList.innerHTML = '';
            if (scans.length === 0) {
                emptyHistoryMessage.style.display = 'block';
                return;
            }
            emptyHistoryMessage.style.display = 'none';

            scans.forEach(scan => {
                const item = document.createElement('div');
                item.className = 'bg-white dark:bg-gray-800 rounded-lg shadow p-4 flex items-center justify-between';
                
                let verdictColorClass = '';
                if (scan.verdict.toLowerCase().includes('scam')) {
                    verdictColorClass = 'bg-red-600 text-white';
                } else if (scan.verdict.toLowerCase().includes('could be')) {
                    verdictColorClass = 'bg-yellow-400 text-yellow-900';
                } else {
                    verdictColorClass = 'bg-green-500 text-white';
                }
                
                const scanDate = new Date(scan.scan_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

                item.innerHTML = `
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">${scanDate}</p>
                        <p class="text-gray-800 dark:text-gray-200 mt-1 truncate">${scan.content_text || 'Image Scan'}</p>
                    </div>
                    <div class="text-right ml-4 flex-shrink-0">
                         <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full ${verdictColorClass}">${scan.verdict}</span>
                         <a href="#" data-scan-id="${scan.id}" class="view-details-link mt-2 block text-sm text-blue-600 dark:text-blue-500 hover:underline">View Details</a>
                    </div>
                `;
                scanList.appendChild(item);
            });

            document.querySelectorAll('.view-details-link').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const scanId = e.target.dataset.scanId;
                    openModal(scanId);
                });
            });
        }

        function openModal(scanId) {
            const data = scanHistoryData.find(s => s.id == scanId);
            if (!data) return;

            document.getElementById('modal-original-content').textContent = data.content_text || "No text content was provided for this image scan.";
            document.getElementById('modal-verdict-title').textContent = data.verdict;
            
            const analysisHeading = document.getElementById('modal-analysis-heading');
            analysisHeading.textContent = data.verdict.toLowerCase().includes('safe') ? 'Why it might not be a scam:' : 'Why it might be a scam:';

            const analysisList = document.getElementById('modal-analysis-content');
            analysisList.innerHTML = '';
            data.analysis.forEach(point => {
                const li = document.createElement('li');
                li.textContent = point;
                analysisList.appendChild(li);
            });

            const recommendationsList = document.getElementById('modal-recommendations-content');
            recommendationsList.innerHTML = '';
            data.recommendations.forEach(point => {
                const li = document.createElement('li');
                li.textContent = point;
                recommendationsList.appendChild(li);
            });
            
            const verdictSection = document.getElementById('modal-verdict-section');
            verdictSection.className = 'mb-6 p-4 rounded-md';
            const lowerVerdict = data.verdict.toLowerCase();
            if (lowerVerdict.includes('scam')) verdictSection.classList.add('bg-red-600', 'text-white');
            else if (lowerVerdict.includes('could be')) verdictSection.classList.add('bg-yellow-400', 'text-yellow-900');
            else verdictSection.classList.add('bg-green-500', 'text-white');

            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', async () => {
            const token = localStorage.getItem('jwt_token');
            if (!token) {
                loadingState.style.display = 'none';
                authErrorMessage.style.display = 'block';
                return;
            }

            const consultLoggedIn = document.getElementById('consult-loggedin');
            const consultGuest = document.getElementById('consult-guest');

            consultGuest.style.display = 'none';
            consultLoggedIn.style.display = 'block';

             consultLoggedIn.addEventListener('click', (e) => {
                 setTimeout(() => {
                window.location.href = App.baseAppUrl + '/#detector';
            }, 500);
            });

            // !!! IMPORTANT !!! REPLACE THIS URL
            const profileApiUrl = App.baseAPI + '/profile';

            try {
                const response = await fetch(profileApiUrl, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                
                if (!response.ok) {
                    localStorage.removeItem('jwt_token');
                    loadingState.style.display = 'none';
                    authErrorMessage.style.display = 'block';
                    return;
                }

                const user = await response.json();
                
                if (user.tier_name.toLowerCase() !== 'premium') {
                    scanList.style.display = 'none';
                    premiumMessage.style.display = 'block';
                } else {
                    scanHistoryData = await fetchScanHistory(token);
                    renderScanHistory(scanHistoryData);
                }

                loadingState.style.display = 'none';
                historyContent.style.display = 'block';

            } catch (error) {
                console.error(error);
                loadingState.textContent = 'Could not load your history. Please try logging in again.';
            }
        });

       

        closeModalBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });