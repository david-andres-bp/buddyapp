var App = {
    baseAPI: 'http://localhost:8090/scam-detector/public/api',
    baseAppUrl: 'http://localhost:8090/scam-detector/public'
}

const guestNav = document.getElementById('guest-nav');
const userNav = document.getElementById('user-nav');

const logoutBtn = document.getElementById('logout-btn');
const accountBtn = document.getElementById('account-btn');
const historyBtn = document.getElementById('history-btn');
const loginBtn = document.getElementById('login-btn');
const signUpBtn = document.getElementById('signUp-btn');
const scamDrBtn = document.getElementById('scamdr-btn');

        logoutBtn.addEventListener('click', () => {
            localStorage.removeItem('jwt_token');
            showAlert('You have been logged out successfully.', 'success');
            setTimeout(() => {
                window.location.href = App.baseAppUrl + '/';
            }, 500);
        });

        loginBtn.addEventListener('click', () => {
            localStorage.removeItem('jwt_token');
            setTimeout(() => {
                window.location.href = App.baseAppUrl + '/account/login';
            }, 500);
        });

        signUpBtn.addEventListener('click', () => {
            localStorage.removeItem('jwt_token');
            setTimeout(() => {
                window.location.href = App.baseAppUrl + '/account/signup';
            }, 500);
        });

        accountBtn.addEventListener('click', () => {
            setTimeout(() => {
                window.location.href = App.baseAppUrl + '/account/info';
            }, 500);
        });

        historyBtn.addEventListener('click', () => {
            setTimeout(() => {
                window.location.href = App.baseAppUrl + '/account/history';
            }, 500);
        });

         scamDrBtn.addEventListener('click', () => {
            setTimeout(() => {
                window.location.href = App.baseAppUrl + '/#detector';
            }, 500);
        });


        document.addEventListener('DOMContentLoaded', () => {
            const token = localStorage.getItem('jwt_token');
            if (token) {
                guestNav.style.display = 'none';
                userNav.style.display = 'flex';
                const logoutBtn = document.getElementById('logout-btn');
                logoutBtn.addEventListener('click', () => {
                    localStorage.removeItem('jwt_token');
                    window.location.reload();
                });
            } else {
                guestNav.style.display = 'flex';
                userNav.style.display = 'none';
            }
        });