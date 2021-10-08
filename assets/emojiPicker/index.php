<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    
    <style>
        html, body {
            width: 100%; height: 100%;
            padding: 0; margin: 0;
            font-family: sans-serif;
        }
        
        button {
            background-color: royalblue;
            color: white; padding: 10px 17px;
            outline: none; border: none;
            border-radius: 3px; cursor: pointer;
        }
        button:hover { background-color: #5378ea;}
        button:active { background-color: royalblue;}
        
        .container {
            max-width: 1020px; margin: auto;
            padding: 20px;
        }
        
        textarea {
            width: 100%; height: 160px;
            margin-bottom: 15px; outline: none;
            border: 2px solid rgb(199, 218, 253);
            font-size: 20px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="fgEmojiPicker.js"></script>
    <script>
        $(document).ready(() => {
            let emojiPicker = new FgEmojiPicker({
                trigger: ['button'],
                removeOnSelection: false,
                closeButton: true,
                position: ['bottom', 'right'],
                preFetch: true,
                insertInto: document.querySelector('textarea'),
                emit(obj, triggerElement) {
                    console.log(obj, triggerElement);
                }
            });
        })

    </script>
</head>
<body>
    <div class="container">
        <textarea></textarea>
       
       
        <button>Pick emoji</button>
    </div>
</body>
</html>