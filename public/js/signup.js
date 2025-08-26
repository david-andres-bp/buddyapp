        const signupForm = document.getElementById('signup-form');
        const errorMessage = document.getElementById('error-message');
        const successMessage = document.getElementById('success-message');

        signupForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            errorMessage.textContent = '';
            successMessage.textContent = '';

            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            const backendApiUrl = App.baseAPI + '/register';

            try {
                const response = await fetch(backendApiUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ username, email, password })
                });

                const data = await response.json();

                if (!response.ok) {
                    // Combine multiple error messages if they exist
                    const errorString = Object.values(data.messages).join(' ');
                    throw new Error(errorString || 'Registration failed.');
                }

                successMessage.textContent = 'Registration successful! You can now log in.';
                signupForm.reset();

            } catch (error) {
                errorMessage.textContent = error.message;
            }
        });