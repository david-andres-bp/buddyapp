const loginForm = document.getElementById('login-form');
        const errorMessage = document.getElementById('error-message');

        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            errorMessage.textContent = '';

            const login = document.getElementById('login').value;
            const password = document.getElementById('password').value;
            
            const backendApiUrl = App.baseAPI + '/login';

            try {
                const response = await fetch(backendApiUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ login, password })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.messages?.error || 'Login failed.');
                }

                // On successful login, save the token and redirect
                localStorage.setItem('jwt_token', data.token);
                window.location.href = App.baseAppUrl + '/account'; 

            } catch (error) {
                errorMessage.textContent = error.message;
            }
        });