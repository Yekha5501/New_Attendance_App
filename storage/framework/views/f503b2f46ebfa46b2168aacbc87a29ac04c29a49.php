<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WSP ChatBot with Excel Data</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <style>
        #response { margin-top: 20px; padding: 10px; min-height: 50px; }
        #response h3 { color: #333; font-size: 1.2em; }
        #response strong { color: #d9534f; }
        #response ul { padding-left: 20px; }
        #response li { margin-bottom: 5px; }
    </style>
</head>
<body onload="storeEmbeddings()">
    <div class="container">
        <h2>ChatBot with RAG</h2>
        <div class="form-group">
            <input type="text" class="form-control" id="userInput" placeholder="Enter your question">
        </div>
        <button class="btn btn-success" onclick="sendMessage()">Ask!</button>
        <div id="response"></div>
    </div>

    <script>
        const EXCEL_URL = "http://localhost/New_Attendance_App/get-excel";
        const OPENROUTER_API_KEY = "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";

        async function fetchExcelData() {
            let response = await fetch(EXCEL_URL);
            let arrayBuffer = await response.arrayBuffer();
            let workbook = XLSX.read(new Uint8Array(arrayBuffer), { type: "array" });
            let sheet = workbook.Sheets[workbook.SheetNames[0]];
            let data = XLSX.utils.sheet_to_json(sheet);
            console.log("Excel Data:", data);
            return data;
        }

        async function generateEmbeddings(text) {
            const response = await fetch("https://openrouter.ai/api/v1/completions", {
                method: "POST",
                headers: {
                    Authorization: `Bearer ${OPENROUTER_API_KEY}`,
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ model: "deepseek/deepseek-r1:free", text }),
            });

            let result = await response.json();
            return result.embedding;
        }

        async function storeEmbeddings() {
            let data = await fetchExcelData();
            let embeddings = [];

            for (let item of data) {
                let text = Object.values(item).join(" "); // Convert row to text
                let embedding = await generateEmbeddings(text);
                embeddings.push({ text, embedding });
            }

            localStorage.setItem("embeddings", JSON.stringify(embeddings));
            console.log("Embeddings stored!");
        }

        function cosineSimilarity(vecA, vecB) {
            let dotProduct = vecA.reduce((sum, val, i) => sum + val * vecB[i], 0);
            let magA = Math.sqrt(vecA.reduce((sum, val) => sum + val * val, 0));
            let magB = Math.sqrt(vecB.reduce((sum, val) => sum + val * val, 0));
            return dotProduct / (magA * magB);
        }

        async function queryEmbedding(query) {
            let embeddings = JSON.parse(localStorage.getItem("embeddings")) || [];
            let queryVec = await generateEmbeddings(query);

            let bestMatch = embeddings
                .map((item) => ({
                    text: item.text,
                    score: cosineSimilarity(queryVec, item.embedding),
                }))
                .sort((a, b) => b.score - a.score)[0];

            return bestMatch ? bestMatch.text : "No relevant data found.";
        }

        async function sendMessage() {
            const input = document.getElementById("userInput").value;
            const responseDiv = document.getElementById("response");

            if (!input) {
                responseDiv.innerHTML = "Please enter a message.";
                return;
            }

            responseDiv.innerHTML = "Searching knowledge base...";

            let relevantData = await queryEmbedding(input);
            let fullPrompt = `User: ${input}\n\nRelevant Info: ${relevantData}`;

            try {
                const response = await fetch("https://openrouter.ai/api/v1/chat/completions", {
                    method: "POST",
                    headers: {
                        Authorization: `Bearer ${OPENROUTER_API_KEY}`,
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        model: "deepseek/deepseek-r1:free",
                        messages: [{ role: "user", content: fullPrompt }],
                    }),
                });

                const data = await response.json();
                const markdownText = data.choices?.[0]?.message?.content || "No response.";
                responseDiv.innerHTML = marked.parse(markdownText);
            } catch (error) {
                responseDiv.innerHTML = "Error: " + error.message;
            }
        }
    </script>
</body>
</html>
<?php /**PATH C:\wamp64\www\New_Attendance_App\resources\views/chatbot.blade.php ENDPATH**/ ?>