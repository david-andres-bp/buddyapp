// --- DOM Elements ---
        const analyzeButton = document.getElementById('analyze-button');
        const messageInput = document.getElementById('message-input');
        const fileUpload = document.getElementById('file-upload');
        const imagePreviewContainer = document.getElementById('image-preview-container');
        const imagePreview = document.getElementById('image-preview');
        const removeImageBtn = document.getElementById('remove-image-btn');
        
        const resultsContainer = document.getElementById('results-container');
        const verdictSection = document.getElementById('verdict-section');
        const verdictTitle = document.getElementById('verdict-title');
        const analysisHeading = document.getElementById('analysis-heading');
        const analysisContent = document.getElementById('analysis-content');
        const recommendationsContent = document.getElementById('recommendations-content');
        
        const questionnaireContainer = document.getElementById('questionnaire-container');
        const questionList = document.getElementById('question-list');
        const submitAnswersBtn = document.getElementById('submit-answers-btn');
        const submitLoader = document.getElementById('submit-loader');
        const submitButtonText = document.getElementById('submit-button-text');

        const loader = document.getElementById('loader');
        const buttonText = document.getElementById('button-text');
        


        const alertModal = document.getElementById('alert-modal');
        const alertTitle = document.getElementById('alert-title');
        const alertMessage = document.getElementById('alert-message');
        const alertHeader = document.getElementById('alert-header');
        const closeAlertBtn = document.getElementById('close-alert-btn');
        const okAlertBtn = document.getElementById('ok-alert-btn');

        // --- State ---
        let uploadedFile = null;
        let currentQuestions = [];
        let originalContent = {};

        // --- Event Listeners ---


        fileUpload.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                uploadedFile = file;
                const reader = new FileReader();
                reader.onload = (e) => {
                    imagePreview.src = e.target.result;
                    imagePreviewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        removeImageBtn.addEventListener('click', () => {
            uploadedFile = null;
            fileUpload.value = '';
            imagePreviewContainer.style.display = 'none';
            imagePreview.src = '#';
        });

        analyzeButton.addEventListener('click', handleAnalysis);
        submitAnswersBtn.addEventListener('click', handleSubmitAnswers);
        
        closeAlertBtn.addEventListener('click', closeAlert);
        okAlertBtn.addEventListener('click', closeAlert);
        alertModal.addEventListener('click', (e) => {
            if (e.target === alertModal) {
                closeAlert();
            }
        });

        // --- Functions ---
        function showAlert(message, type = 'info') {
            alertMessage.textContent = message;

            // Reset colors
            alertHeader.classList.remove('bg-red-500', 'bg-green-500', 'text-white');
            alertTitle.classList.remove('text-white');

            if (type === 'error') {
                alertTitle.textContent = 'Error';
                alertHeader.classList.add('bg-red-500', 'text-white');
                alertTitle.classList.add('text-white');
            } else if (type === 'success') {
                alertTitle.textContent = 'Success';
                alertHeader.classList.add('bg-green-500', 'text-white');
                alertTitle.classList.add('text-white');
            } else {
                alertTitle.textContent = 'Information';
            }

            alertModal.classList.remove('hidden');
        }

        function closeAlert() {
            alertModal.classList.add('hidden');
        }

        async function handleAnalysis() {
            const message = messageInput.value.trim();
            if (!message && !uploadedFile) {
                showAlert('Please paste a message or upload an image to analyze.', 'error');
                return;
            }

            setLoadingState(true);
            resultsContainer.classList.add('hidden');
            questionnaireContainer.classList.add('hidden');

            try {
                let base64Image = null;
                if (uploadedFile) {
                    base64Image = await fileToBase64(uploadedFile);
                }
                originalContent = { message, base64Image };

                const payload = {
                    text_content: message,
                    image_base64: base64Image
                };

                const responseJson = await callApi(payload);

                if (responseJson.analysisType === 'questionnaire' && responseJson.questions) {
                    currentQuestions = responseJson.questions;
                    displayQuestionnaire(responseJson.questions);
                } else {
                    displayDirectAnalysis(responseJson);
                }

            } catch (error) {
                console.error('Error analyzing:', error);
                showAlert('An error occurred: ' + error.message, 'error');
            } finally {
                setLoadingState(false);
            }
        }

        async function handleSubmitAnswers() {
            setSubmitLoadingState(true);
            const userAnswers = [];
            currentQuestions.forEach((q, index) => {
                let answer;
                if (q.questionType === 'text_input') {
                    answer = document.getElementById(`question-input-${index}`).value;
                } else {
                    answer = document.querySelector(`input[name="question-${index}"]:checked`)?.value;
                }
                userAnswers.push({ question: q.questionText, answer: answer || "Not answered" });
            });

            try {
                const payload = {
                    text_content: originalContent.message,
                    image_base64: originalContent.base64Image,
                    user_answers: userAnswers
                };
                const responseJson = await callApi(payload);
                questionnaireContainer.classList.add('hidden');
                displayDirectAnalysis(responseJson);
            } catch (error) {
                console.error('Error getting final analysis:', error);
                showAlert('An error occurred while getting the final verdict.', 'error');
            } finally {
                setSubmitLoadingState(false);
            }
        }
        
        async function callApi(payload) {
            const backendApiUrl = App.baseAPI + '/analyze';
            const token = localStorage.getItem('jwt_token');
            const headers = { 'Content-Type': 'application/json' };
            if (token) {
                headers['Authorization'] = `Bearer ${token}`;
            }
            const response = await fetch(backendApiUrl, {
                method: 'POST',
                headers: headers,
                body: JSON.stringify(payload)
            });
            if (!response.ok) {
                if(response.status != 401){
                const errorData = await response.json();
                throw new Error(errorData.messages?.error || `API call failed: ${response.status}`);
                }
                else{
                    localStorage.removeItem('jwt_token');
                    showAlert('You session has expired.', 'error');
                    setTimeout(() => {
                        window.location.href = App.baseAppUrl + '/';
                    }, 500);
                }
            }
            return response.json();
        }
        
        function displayDirectAnalysis({ verdict, analysis, recommendations }) {
            verdictTitle.textContent = verdict;
            if (verdict.toLowerCase().includes('safe') || verdict.toLowerCase().includes('legitimate')) {
                analysisHeading.textContent = 'Why it might not be a scam:';
            } else {
                analysisHeading.textContent = 'Why it might be a scam:';
            }
            renderListFromArray(analysisContent, analysis);
            renderListFromArray(recommendationsContent, recommendations);
            setVerdictColor(verdict);
            resultsContainer.classList.remove('hidden');
        }

        function displayQuestionnaire(questions) {
            questionList.innerHTML = '';
            questions.forEach((q, index) => {
                const questionEl = document.createElement('div');
                questionEl.className = 'p-4 border rounded-lg dark:border-gray-600';
                let inputHtml = '';
                if (q.questionType === 'text_input') {
                    inputHtml = `<input type="text" id="question-input-${index}" class="mt-2 w-full p-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md" placeholder="Your answer...">`;
                } else {
                    inputHtml = `<div class="flex items-center space-x-4 mt-2"><label class="flex items-center"><input type="radio" name="question-${index}" value="yes" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500"><span class="ml-2 text-gray-700 dark:text-gray-300">Yes</span></label><label class="flex items-center"><input type="radio" name="question-${index}" value="no" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500"><span class="ml-2 text-gray-700 dark:text-gray-300">No</span></label></div>`;
                }
                questionEl.innerHTML = `<p class="mb-2 text-gray-800 dark:text-gray-200">${q.questionText}</p>${inputHtml}`;
                questionList.appendChild(questionEl);
            });
            questionnaireContainer.classList.remove('hidden');
        }

        function renderListFromArray(ulElement, itemsArray) {
            ulElement.innerHTML = '';
            if (Array.isArray(itemsArray)) {
                itemsArray.forEach(itemText => {
                    const cleanedText = itemText.trim();
                    if (cleanedText) {
                        const li = document.createElement('li');
                        li.textContent = cleanedText;
                        ulElement.appendChild(li);
                    }
                });
            }
        }

        function setVerdictColor(verdict) {
            verdictSection.className = 'mb-6 p-4 rounded-md';
            const lowerVerdict = verdict.toLowerCase();
            if (lowerVerdict.includes('scam')) {
                verdictSection.classList.add('bg-red-600', 'text-white');
            } else if (lowerVerdict.includes('could be') || lowerVerdict.includes('potentially')) {
                verdictSection.classList.add('bg-yellow-400', 'text-yellow-900');
            } else {
                verdictSection.classList.add('bg-green-500', 'text-white');
            }
        }

        function setLoadingState(isLoading) {
            loader.classList.toggle('hidden', !isLoading);
            buttonText.textContent = isLoading ? 'Analyzing...' : 'Analyze';
            analyzeButton.disabled = isLoading;
        }

        function setSubmitLoadingState(isLoading) {
            submitLoader.classList.toggle('hidden', !isLoading);
            submitButtonText.textContent = isLoading ? 'Getting Verdict...' : 'Get Final Verdict';
            submitAnswersBtn.disabled = isLoading;
        }

        function fileToBase64(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = () => resolve(reader.result.split(',')[1]);
                reader.onerror = error => reject(error);
            });
        }