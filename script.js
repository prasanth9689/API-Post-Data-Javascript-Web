document.getElementById('postDataForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting the traditional way

    // Get the values from the input fields
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;

    // Data to be sent to the API
    const data = {
        username: username,
        email: email
    };

    // POST request to the API
    fetch('https://jsonplaceholder.typicode.com/posts', {
        method: 'POST', // HTTP method
        headers: {
            'Content-Type': 'application/json' // Content type
        },
        body: JSON.stringify(data) // Convert the data object to a JSON string
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response data
        const responseMessage = document.getElementById('responseMessage');
        responseMessage.textContent = 'Data submitted successfully!';
        console.log('Success:', data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
});
