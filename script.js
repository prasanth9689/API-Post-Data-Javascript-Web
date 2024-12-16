document.getElementById('postDataForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting the traditional way

    const acc = "cr_master_signup";
    const mobile = "8940570614"
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = "akila968";

    const data = {
        acc: acc,
        mobile: mobile,
        name: name,
        email: email,
        password: password
    };

    console.log(JSON.stringify(data));

    // POST request to the API
    fetch('https://skyblue.co.in/skyblue_main.php', {
        method: 'POST', 
        headers: {
            'Content-Type': 'application/json' 
        },
        body: JSON.stringify(data) // Convert the data object to a JSON string
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response data
        const responseMessage = document.getElementById('responseMessage');
        responseMessage.textContent = 'Data submitted successfully!' + data;
        console.log('Success:', data);

        alert(data);
    })
    .catch((error) => {
        // console.error('Error:', error);
    });
});
