        const loadingState = document.getElementById('loading-state');
        const accountContent = document.getElementById('account-content');
        const membershipEl = document.getElementById('membership');
        const subscriptionText = document.getElementById('subscription-text');
        const subscriptionButton = document.getElementById('subscription-button');

        const alertModal = document.getElementById('alert-modal');
        const alertTitle = document.getElementById('alert-title');
        const alertMessage = document.getElementById('alert-message');
        const alertHeader = document.getElementById('alert-header');
        const closeAlertBtn = document.getElementById('close-alert-btn');
        const okAlertBtn = document.getElementById('ok-alert-btn');

        document.getElementById('hero-section').style.display = 'none';
        
        function showAlert(message, type = 'info') {
            alertMessage.innerHTML = message; // Use innerHTML to allow for links
            alertHeader.classList.remove('bg-red-500', 'bg-green-500', 'text-white');
            alertTitle.classList.remove('text-white');

            if (type === 'error') {
                alertTitle.textContent = 'Error';
                alertHeader.classList.add('bg-red-500', 'text-white');
                alertTitle.classList.add('text-white');
            } else {
                alertTitle.textContent = 'Information';
            }
            alertModal.classList.remove('hidden');
        }

        function closeAlert() {
            alertModal.classList.add('hidden');
              const token = localStorage.getItem('jwt_token');
              if(!token)
              {
                setTimeout(() => {
                window.location.href = App.baseAppUrl + '/';
            }, 500);
              }
        }

        closeAlertBtn.addEventListener('click', closeAlert);
        okAlertBtn.addEventListener('click', closeAlert);

        function setupPageForUser(user) {
            const isPremium = user.tier_name.toLowerCase() === 'premium';

            document.getElementById('username').textContent = user.username;
            document.getElementById('email').textContent = user.email;
            
            membershipEl.textContent = user.tier_name;
            if (isPremium) {
                membershipEl.className = 'text-lg font-semibold text-green-500';
            } else {
                membershipEl.className = 'text-lg font-semibold text-gray-500 dark:text-gray-400';
            }

            const scansRemaining = user.daily_scan_limit === null ? 'Unlimited' : user.daily_scan_limit - user.api_calls_today;
            document.getElementById('scans-remaining').textContent = scansRemaining;

            if (isPremium) {
                subscriptionText.textContent = 'You are currently on the Premium plan. You can manage your subscription or downgrade to the free plan.';
                subscriptionButton.textContent = 'Downgrade to Free';
                subscriptionButton.className = 'w-full text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900';
            } else {
                subscriptionText.textContent = 'You are currently on the Free plan. Upgrade to unlock premium features and unlimited scans.';
                subscriptionButton.textContent = 'Upgrade to Premium';
                subscriptionButton.className = 'w-full text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900';
            }

            loadingState.style.display = 'none';
            accountContent.style.display = 'block';

            

            const consultLoggedIn = document.getElementById('consult-loggedin');
            const consultGuest = document.getElementById('consult-guest');

            consultGuest.style.display = 'none';
            consultLoggedIn.style.display = 'block';

             consultLoggedIn.addEventListener('click', (e) => {
                 setTimeout(() => {
                window.location.href = App.baseAppUrl + '/#detector';
            }, 500);
            });

        }

        document.addEventListener('DOMContentLoaded', async () => {
            const token = localStorage.getItem('jwt_token');
            if (!token) {
                loadingState.style.display = 'none';
                showAlert('You must be logged in to view this page. Please log in.', 'error');
                return;
            }

            const backendApiUrl = App.baseAPI + '/profile';

            try {
                const response = await fetch(backendApiUrl, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (response.status === 401) {
                    localStorage.removeItem('jwt_token');
                    loadingState.style.display = 'none';
                    showAlert('Your session has expired. Please log in again.', 'error');
                    return;
                }
                
                if (!response.ok) {
                    throw new Error('Failed to fetch profile data.');
                }

                const user = await response.json();
                setupPageForUser(user);

            } catch (error) {
                console.error(error);
                loadingState.style.display = 'none';
                //showAlert('Could not load your profile. Please try logging in again.', 'error');
                window.location.href = App.baseAppUrl + '/#detector';
            }
        });

  