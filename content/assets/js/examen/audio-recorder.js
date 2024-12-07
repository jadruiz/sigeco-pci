document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('[id^="startButton_"]').forEach((startButton) => {
    const preguntaId = startButton.id.split('_')[1];
    const pauseButton = document.getElementById(`pauseButton_${preguntaId}`);
    const doneButton = document.getElementById(`doneButton_${preguntaId}`);
    const retryButton = document.getElementById(`retryButton_${preguntaId}`);
    const audioPreview = document.getElementById(`audioPreview_${preguntaId}`);
    const audioFile = document.getElementById(`audioFile_${preguntaId}`);
    const progressBar = document.getElementById(`audioProgress_${preguntaId}`);
    const statusMessage = document.getElementById(`statusMessage_${preguntaId}`);

    let mediaRecorder;
    let audioChunks = [];
    let recordingTime = 0;
    let recordingInterval;

    // Define MIME types and their corresponding extensions
    const mimeTypeToExtension = {
      "audio/webm": "webm",
      "audio/ogg": "ogg",
      "audio/mp4": "mp4",
      "audio/wav": "wav",
    };

    function getSupportedMimeType() {
      const types = Object.keys(mimeTypeToExtension);
      return types.find((type) => MediaRecorder.isTypeSupported(type)) || 'audio/webm'; // Default to 'audio/webm'
    }

    startButton.addEventListener('click', async function () {
      if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        try {
          const stream = await navigator.mediaDevices.getUserMedia({
            audio: true,
          });
          const mimeType = getSupportedMimeType();
          mediaRecorder = new MediaRecorder(stream, { mimeType: mimeType });

          mediaRecorder.onstart = function () {
            audioChunks = [];
            recordingTime = 0;
            updateProgress();
            startRecordingTimer();

            startButton.style.display = 'none';
            pauseButton.style.display = 'inline-block';
            doneButton.style.display = 'inline-block';
            statusMessage.textContent = 'Grabando...';
          };

          mediaRecorder.ondataavailable = function (event) {
            audioChunks.push(event.data);
          };

          mediaRecorder.onstop = function () {
            clearInterval(recordingInterval);
            const audioBlob = new Blob(audioChunks, { type: mimeType });
            const extension = mimeTypeToExtension[mimeType] || "mp4"; // Default to 'mp4' if extension is not found
            const audioUrl = URL.createObjectURL(audioBlob);
            audioPreview.src = audioUrl;
            audioPreview.style.display = 'block';

            const audioFileInput = new File(
              [audioBlob],
              `respuesta_audio_${preguntaId}.${extension}`, // Use the mapped extension
              { type: mimeType }
            );
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(audioFileInput);
            audioFile.files = dataTransfer.files;

            statusMessage.textContent = 'Recording ready. Use the player below to listen to it before submitting.';
            progressBar.classList.replace('bg-primary', 'bg-success');

            startButton.style.display = 'none';
            pauseButton.style.display = 'none';
            doneButton.style.display = 'none';
            retryButton.style.display = 'inline-block';
          };

          mediaRecorder.start();
        } catch (error) {
          alert('Error al intentar acceder al micrófono.');
        }
      } else {
        alert('Tu navegador no soporta grabación de audio.');
      }
    });

    pauseButton.addEventListener('click', function () {
      if (mediaRecorder) {
        if (mediaRecorder.state === 'recording') {
          mediaRecorder.pause();
          clearInterval(recordingInterval);
          pauseButton.innerHTML = '<i class="fas fa-play"></i> Continuar';
          statusMessage.textContent = 'Grabación pausada.';
        } else if (mediaRecorder.state === 'paused') {
          mediaRecorder.resume();
          startRecordingTimer();
          pauseButton.innerHTML = '<i class="fas fa-pause"></i> Pausar';
          statusMessage.textContent = 'Grabando...';
        }
      }
    });

    doneButton.addEventListener('click', function () {
      if (mediaRecorder) {
        mediaRecorder.stop();
      }
    });

    retryButton.addEventListener('click', function () {
      resetUI();
    });

    function startRecordingTimer() {
      recordingInterval = setInterval(() => {
        recordingTime++;
        updateProgress();
      }, 1000);
    }

    function updateProgress() {
      const minutes = Math.floor(recordingTime / 60)
        .toString()
        .padStart(2, '0');
      const seconds = (recordingTime % 60).toString().padStart(2, '0');
      progressBar.textContent = `${minutes}:${seconds}`;
      progressBar.style.width = `${Math.min(recordingTime % 100, 100)}%`;
    }

    function resetUI() {
      startButton.style.display = 'inline-block';
      pauseButton.style.display = 'none';
      doneButton.style.display = 'none';
      retryButton.style.display = 'none';
      audioPreview.src = '';
      audioPreview.style.display = 'none';
      audioFile.value = '';
      progressBar.style.width = '0%';
      progressBar.textContent = '0:00';
      progressBar.classList.replace('bg-success', 'bg-primary');
      pauseButton.innerHTML = '<i class="fas fa-pause"></i> Pausar';
      statusMessage.textContent = 'Listo para grabar.';
      clearInterval(recordingInterval);
      recordingTime = 0;
    }
  });
});
