<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
    <h1>Cadastrar nova senha</h1>
    <form  id="reset-password-form">
        <input type="hidden" name="email">
        <input type="hidden" name="password">
        <input type="password" name="password" placeholder="Nova senha" value="password">
        <button type="submit">Atualizar Senha</button>
    </form>
    <script>
        const urlString = window.location.href;
        const email = new URL(urlString).href.split('/')[4];
        const token = new URL(urlString).href.split('/')[5];
        let password = '';
        document.querySelector('input[name="password"]').addEventListener('input', function(event) {
            password = event.target.value;
            console.log(password);
        });
        console.log(JSON.stringify({ email, token, password }))
        document.getElementById('reset-password-form').addEventListener('submit', function(event) {
            event.preventDefault();
        console.log(password);
         fetch('{{ route('reset-password') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email, token, password })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
        return response.text(); // Use text() instead of json()
    })
    .then(text => {
        if (text) {
            return JSON.parse(text); // Parse the text to JSON if not empty
        }
        return {}; // Return an empty object if the response body is empty
    })
    .then(data => {
        console.log(data);
        // Handle success or error response
    })
    .catch(error => {
        console.error('Error:', error);
    });
        });

    </script>
</body>
</html>
