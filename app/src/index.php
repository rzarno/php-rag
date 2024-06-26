<html>
<head>
    <title>RAG PHP</title>
    <style>
        form {
            width: 280px;
            margin: 0 auto;
            background-color: #fcfcfc;
            padding: 20px 50px 40px;
            box-shadow: 1px 4px 10px 1px #aaa;
            font-family: sans-serif;
        }

        form * {
            box-sizing: border-box;
        }

        form label {
            color: #777;
            font-size: 0.8em;
            text-align: center;
        }

        form button[type=submit] {
            display: block;
            margin: 20px auto 0;
            width: 150px;
            height: 40px;
            border-radius: 25px;
            border: none;
            color: #eee;
            font-weight: 700;
            box-shadow: 1px 4px 10px 1px #aaa;

            background: #207cca; /* Old browsers */
            background: -moz-linear-gradient(left, #095516 0%, #539D6CFF 100%); /* FF3.6-15 */
            background: -webkit-linear-gradient(left, #095516FF 0%, #539d6c 100%); /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to right, #095516FF 0%,#539D6CFF 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#207cca', endColorstr='#9f58a3',GradientType=1 ); /* IE6-9 */
        }
    </style>
</head>
<body>
    <form method="post" action="processOllama.php">
        <label><h1>Find answer in websites database using ollama with Llama 3 model downloaded locally</h1></label>
        <br />
        <textarea name="prompt" cols="30" rows="5">What is specialization of programmer and lecturer Michał Żarnecki based on his website content.</textarea>
        <br /><br />
        <button type="submit">Generate text</button>
    </form>
    <form method="post" action="processGpt.php">
        <label><h1>Find answer in websites database using GPT-4o</h1></label>
        <br />
        <textarea name="prompt" cols="30" rows="5">Is Michał Żarnecki programmer the same person as Michał Żarnecki audio engineer.</textarea>
        <br /><br />
        <button type="submit">Generate text</button>
    </form>
</body>
</html>