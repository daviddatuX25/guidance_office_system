document.getElementById('../uploadForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    let formData = new FormData();
    formData.append('excelFile', document.querySelector('input[name="excelFile"]').files[0]);

    fetch('upload.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
