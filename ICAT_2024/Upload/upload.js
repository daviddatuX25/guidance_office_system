document.getElementById('../uploadForm').addEventListener('submit', function(event) {
  event.preventDefault();

  var formData = new FormData();
  formData.append('excelFile', document.getElementById('excelFile').files[0]);

  fetch('upload.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('Excel file uploaded successfully!');
    } else {
      alert('Error uploading Excel file.');
    }
  })
  .catch(error => {
    console.error('Error:', error);
  });
});
